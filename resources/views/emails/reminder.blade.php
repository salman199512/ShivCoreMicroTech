<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Invoice Reminder</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            min-width: 100%;
            background-color: #f1f5f9;
            font-family: 'Poppins', Helvetica, Arial, sans-serif;
        }
        table {
            border-spacing: 0;
            font-family: 'Poppins', Helvetica, Arial, sans-serif;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;
        }
        .content {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table class="content" border="0" cellspacing="0" cellpadding="0" style="width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 32px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 30px 40px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" style="color: #ffffff; font-size: 20px; font-weight: 800; text-transform: uppercase; letter-spacing: -0.02em;">
                                        {{ $settings['company_name'] ?? 'ShivCore Micro Tech' }}
                                    </td>
                                    <td align="right" style="color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">
                                        {{ date('M d, Y') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: -0.02em;">Hello {{ $customer->name }},</h2>
                                        <p style="margin: 8px 0 0 0; font-size: 14px; color: #64748b;">Friendly reminder regarding your outstanding invoices.</p>
                                    </td>
                                </tr>
                                <!-- Invoices Box -->
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 24px; padding: 30px; border: 1px solid #f1f5f9;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="padding-bottom: 20px; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em;">
                                                    Summary of Due Invoices
                                                </td>
                                            </tr>
                                            @php $totalDue = 0; @endphp
                                            @foreach($invoices as $invoice)
                                                @php $totalDue += $invoice->amount; @endphp
                                                <tr>
                                                    <td style="padding: 15px 0; border-top: 1px solid #e2e8f0;">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="left">
                                                                    <div style="font-size: 15px; font-weight: 700; color: #334155;">{{ $invoice->invoice_no }}</div>
                                                                    <div style="font-size: 12px; color: #94a3b8;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</div>
                                                                </td>
                                                                <td align="right">
                                                                    <div style="font-size: 16px; font-weight: 800; color: #4f46e5;">Rs. {{ number_format($invoice->amount, 2) }}</div>
                                                                    <div style="margin-top: 4px;">
                                                                        <span style="display: inline-block; font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 10px; text-transform: uppercase; {{ $invoice->status == 'Partial' ? 'background-color: #fffbeb; color: #f59e0b;' : 'background-color: #fef2f2; color: #ef4444;' }}">
                                                                            {{ $invoice->status }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <!-- Total -->
                                            <tr>
                                                <td style="padding-top: 25px; border-top: 2px dashed #e2e8f0;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left" style="font-size: 14px; font-weight: 800; color: #1e293b;">
                                                                Total Amount Due
                                                            </td>
                                                            <td align="right" style="font-size: 22px; font-weight: 900; color: #1e293b;">
                                                                Rs. {{ number_format($totalDue, 2) }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Footer Note -->
                                <tr>
                                    <td style="padding-top: 40px; font-size: 14px; color: #64748b; line-height: 1.6;">
                                        Please process the payment at your earliest convenience. If you have any questions or have already made the payment, please let us know.
                                    </td>
                                </tr>
                                <!-- Signature -->
                                <tr>
                                    <td align="center" style="padding-top: 40px; border-top: 1px solid #f1f5f9; color: #94a3b8; font-size: 12px;">
                                        <strong style="color: #64748b;">{{ $settings['company_name'] ?? 'ShivCore Micro Tech' }}</strong><br/>
                                        {{ $settings['company_email'] ?? '' }} | {{ $settings['company_phone'] ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
