<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Reminder</title>
    <style>
        body {
            font-family: 'Poppins', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            padding: 40px 20px;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 30px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .logo-text {
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }
        .header .date-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            margin-bottom: 24px;
        }
        .greeting h2 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin: 0 0 8px 0;
            letter-spacing: -0.02em;
        }
        .greeting p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        .stats-box {
            background-color: #f8fafc;
            border-radius: 24px;
            padding: 24px;
            margin: 32px 0;
            border: 1px solid #f1f5f9;
        }
        .stats-box h3 {
            font-size: 12px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0 0 16px 0;
        }
        .invoice-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .invoice-item:last-child {
            border-bottom: none;
        }
        .invoice-info {
            display: flex;
            flex-direction: column;
        }
        .inv-no {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
        }
        .inv-date {
            font-size: 12px;
            color: #94a3b8;
        }
        .inv-amount {
            text-align: right;
        }
        .amt-val {
            font-size: 15px;
            font-weight: 800;
            color: #4f46e5;
        }
        .status-badge {
            font-size: 9px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 10px;
            text-transform: uppercase;
            margin-top: 4px;
            display: inline-block;
        }
        .status-pending { background-color: #fef2f2; color: #ef4444; }
        .status-partial { background-color: #fffbeb; color: #f59e0b; }
        
        .total-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;
        }
        .total-val {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
        }
        .footer-note {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 32px;
        }
        .signature {
            margin-top: 32px;
            border-top: 1px solid #f1f5f9;
            padding-top: 24px;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="logo-text">{{ $settings['company_name'] ?? 'ShivCore Micro Tech' }}</div>
                <div class="date-text">{{ date('M d, Y') }}</div>
            </div>
            <div class="content">
                <div class="greeting">
                    <h2>Hello {{ $customer->name }},</h2>
                    <p>Friendly reminder regarding your outstanding invoices.</p>
                </div>

                <div class="stats-box">
                    <h3>Summary of Due Invoices</h3>
                    @php $totalDue = 0; @endphp
                    @foreach($invoices as $invoice)
                        @php $totalDue += $invoice->amount; @endphp
                        <div class="invoice-item">
                            <div class="invoice-info">
                                <span class="inv-no">{{ $invoice->invoice_no }}</span>
                                <span class="inv-date">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="inv-amount">
                                <div class="amt-val">Rs. {{ number_format($invoice->amount, 2) }}</div>
                                <span class="status-badge {{ $invoice->status == 'Partial' ? 'status-partial' : 'status-pending' }}">
                                    {{ $invoice->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <div class="total-section">
                        <span class="total-label">Total Amount Due</span>
                        <span class="total-val">Rs. {{ number_format($totalDue, 2) }}</span>
                    </div>
                </div>

                <p class="footer-note">Please process the payment at your earliest convenience. If you have any questions or have already made the payment, please let us know.</p>

                <div class="signature">
                    <strong>{{ $settings['company_name'] ?? 'ShivCore Micro Tech' }}</strong><br>
                    {{ $settings['company_email'] ?? '' }} | {{ $settings['company_phone'] ?? '' }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
