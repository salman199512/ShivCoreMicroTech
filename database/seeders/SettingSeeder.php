<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'company_name' => 'InvoicePro Solutions',
            'company_logo' => '',
            'company_email' => 'contact@invoicepro.com',
            'company_phone' => '+1 234 567 890',
            'team1_days' => '60',
            'team2_days' => '5',
            'team1_template' => "Dear {customer_name},\n\n This is a reminder that invoice {invoice_no} for Rs. {amount} is now due (Team 1 Follow-up).\n\nPlease process the payment at your earliest convenience.",
            'team2_template' => "Dear {customer_name},\n\n This is a second reminder for invoice {invoice_no} (Rs. {amount}). Your payment is now overdue (Team 2 Follow-up).",
            'recurring_template' => "Dear {customer_name},\n\n Your invoice {invoice_no} (Rs. {amount}) is still pending. This is a recurring reminder.",
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
