<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\EmailLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendInvoiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-invoice-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated invoice follow-up emails based on team settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $invoices = Invoice::whereIn('status', ['Pending', 'Partial'])->with('customer', 'emailLogs')->get();

        foreach ($invoices as $invoice) {
            $customer = $invoice->customer;
            $invoiceDate = Carbon::parse($invoice->invoice_date);
            
            // Use customer specific days if exists, else global
            $t1Days = $customer->team1_days ?: ($settings['team1_days'] ?? 60);
            $t2Days = $customer->team2_days ?: ($settings['team2_days'] ?? 5);

            $t1Date = $invoiceDate->copy()->addDays($t1Days);
            $t2Date = $t1Date->copy()->addDays($t2Days);
            
            $now = Carbon::now();

            // Check if Team 1 email sent
            $t1Log = $invoice->emailLogs->where('type', 'team1')->first();
            if (!$t1Log && $now->greaterThanOrEqualTo($t1Date)) {
                $this->sendEmail($invoice, 'team1', $settings['team1_template']);
                continue; // Move to next invoice
            }

            // Check if Team 2 email sent
            $t2Log = $invoice->emailLogs->where('type', 'team2')->first();
            if ($t1Log && !$t2Log && $now->greaterThanOrEqualTo($t2Date)) {
                $this->sendEmail($invoice, 'team2', $settings['team2_template']);
                continue;
            }

            // Recurring follow-up (Every 2 days after Team 2)
            if ($t2Log) {
                $lastLog = $invoice->emailLogs->sortByDesc('sent_at')->first();
                $lastSent = Carbon::parse($lastLog->sent_at);
                
                if ($now->diffInDays($lastSent) >= 2) {
                    $this->sendEmail($invoice, 'recurring', $settings['recurring_template']);
                }
            }
        }
    }

    private function sendEmail($invoice, $type, $template)
    {
        $customer = $invoice->customer;
        $settings = Setting::all()->pluck('value', 'key');

        $content = str_replace(
            ['{customer_name}', '{invoice_no}', '{amount}', '{company_name}'],
            [$customer->name, $invoice->invoice_no, number_format($invoice->amount, 2), $settings['company_name'] ?? 'Our Company'],
            $template
        );

        // In a real app, use a Mailable. Here we use Mail::raw for simplicity.
        try {
            Mail::raw($content, function ($message) use ($customer, $type) {
                $message->to($customer->email)
                    ->subject("Invoice Reminder - " . ucfirst($type));
            });

            EmailLog::create([
                'invoice_id' => $invoice->id,
                'type' => $type,
                'sent_at' => now(),
            ]);

            $this->info("Sent {$type} email to {$customer->email} for Invoice {$invoice->invoice_no}");
        } catch (\Exception $e) {
            $this->error("Failed to send email: " . $e->getMessage());
        }
    }
}
