<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\EmailLog;
use App\Mail\ReminderEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendInvoiceReminders extends Command
{
    protected $signature = 'app:send-invoice-reminders';
    protected $description = 'Send automated invoice follow-up emails grouped by customer';

    public function handle()
    {
        $settings = Setting::all()->pluck('value', 'key');

        $invoices = Invoice::whereIn('status', ['Pending', 'Partial'])
            ->with('customer', 'emailLogs')
            ->get();

        $groupedInvoices = $invoices->groupBy('customer_id');

        foreach ($groupedInvoices as $customerId => $customerInvoices) {
            $customer = $customerInvoices->first()->customer;

            // ✅ FIX #1: Moved customer-specific days OUTSIDE the invoice loop
            //    (they're per-customer, not per-invoice)
            // ✅ FIX #2: Use ?? (null coalescing) instead of ?: (Elvis operator)
            //    ?: treats 0 as falsy — if team1_days=0, it wrongly fell back to global default.
            //    ?? only falls back when value is strictly null.
            $t1Days = $customer->team1_days ?? ($settings['team1_days'] ?? 60);
            $t2Days = $customer->team2_days ?? ($settings['team2_days'] ?? 5);

            $eligibleInvoices = [];
            $now = Carbon::now();

            foreach ($customerInvoices as $invoice) {
                $invoiceDate = Carbon::parse($invoice->invoice_date);

                $t1Date = $invoiceDate->copy()->addDays($t1Days);
                $t2Date = $t1Date->copy()->addDays($t2Days);

                $t1Log = $invoice->emailLogs->where('type', 'team1')->first();
                $t2Log = $invoice->emailLogs->where('type', 'team2')->first();

                $type = null;

                if (!$t1Log && $now->greaterThanOrEqualTo($t1Date)) {
                    $type = 'team1';
                } elseif ($t1Log && !$t2Log && $now->greaterThanOrEqualTo($t2Date)) {
                    $type = 'team2';
                } elseif ($t2Log) {
                    $lastLog = $invoice->emailLogs->sortByDesc('sent_at')->first();
                    $lastSent = Carbon::parse($lastLog->sent_at);
                    if ($now->diffInDays($lastSent) >= 2) {
                        $type = 'recurring';
                    }
                }

                if ($type) {
                    $eligibleInvoices[] = [
                        'invoice' => $invoice,
                        'type'    => $type,
                    ];
                }
            }

            if (!empty($eligibleInvoices)) {
                $this->sendAggregatedEmail($customer, $eligibleInvoices, $settings);
            }
        }
    }

    private function sendAggregatedEmail($customer, $eligibleInvoices, $settings)
    {
        $recipients = $customer->emailRecipients ?? [];

        if (empty($recipients)) {
            $this->error("Skipping customer ID {$customer->id}: no valid recipient emails on record.");
            return;
        }

        $invoices = collect($eligibleInvoices)->pluck('invoice');

        $types = collect($eligibleInvoices)->pluck('type')->unique();
        $primaryType = 'team1';
        if ($types->contains('recurring')) {
            $primaryType = 'recurring';
        } elseif ($types->contains('team2')) {
            $primaryType = 'team2';
        }

        try {
            Mail::to($recipients)->send(
                new ReminderEmail($customer, $invoices, $primaryType, $settings)
            );

            foreach ($eligibleInvoices as $item) {
                EmailLog::create([
                    'invoice_id' => $item['invoice']->id,
                    'type'       => $item['type'],
                    'sent_at'    => now(),
                ]);
                $this->info("Logged {$item['type']} reminder for Invoice {$item['invoice']->invoice_no}");
            }

            $this->info("Sent aggregated email to " . implode(', ', $recipients) . " with " . count($invoices) . " invoices.");

        } catch (\Exception $e) {
            $this->error("Failed to send email to " . implode(', ', $recipients) . ": " . $e->getMessage());
        }
    }
}
