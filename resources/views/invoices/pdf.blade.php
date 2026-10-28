<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 22px; margin: 0; }
        .muted { color: #777; }
        .right { text-align: right; }
        .header td { vertical-align: top; }
        table { width: 100%; border-collapse: collapse; }
        .items th { background: #f1f3f5; text-align: left; padding: 8px; border-bottom: 2px solid #dee2e6; }
        .items td { padding: 8px; border-bottom: 1px solid #dee2e6; }
        .totals td { padding: 4px 8px; }
        .totals .grand td { font-weight: bold; font-size: 14px; border-top: 2px solid #222; }
        .badge { padding: 3px 8px; border-radius: 4px; color: #fff; font-size: 11px; }
        .paid { background: #198754; }
        .partial { background: #ffc107; color: #222; }
        .unpaid { background: #6c757d; }
        .section { margin-top: 24px; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <h1>TalentHub Recruiters</h1>
                <div class="muted">Invoice</div>
            </td>
            <td class="right">
                <h1>{{ $invoice->invoice_number }}</h1>
                <span class="badge {{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
            </td>
        </tr>
    </table>

    <table class="header section">
        <tr>
            <td>
                <strong>Bill to</strong><br>
                {{ $invoice->client->company_name }}<br>
                {{ $invoice->client->contact_name }}<br>
                {{ $invoice->client->email }}<br>
                @if ($invoice->client->address)
                    {{ $invoice->client->address }}
                @endif
            </td>
            <td class="right">
                <strong>Issued:</strong> {{ $invoice->issue_date->format('d M Y') }}<br>
                <strong>Due:</strong> {{ $invoice->due_date->format('d M Y') }}
            </td>
        </tr>
    </table>

    <table class="items section">
        <thead>
            <tr>
                <th>Service</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $invoice->service->name }}
                    @if ($invoice->service->description)
                        <br><span class="muted">{{ $invoice->service->description }}</span>
                    @endif
                </td>
                <td class="right">{{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totals section" style="width: 45%; margin-left: 55%;">
        <tr>
            <td>Invoice total</td>
            <td class="right">{{ number_format($invoice->amount, 2) }}</td>
        </tr>
        <tr>
            <td>Total paid</td>
            <td class="right">{{ number_format($invoice->total_paid, 2) }}</td>
        </tr>
        <tr class="grand">
            <td>Remaining balance</td>
            <td class="right">{{ number_format($invoice->balance, 2) }}</td>
        </tr>
    </table>

    @if ($invoice->payments->isNotEmpty())
        <div class="section">
            <strong>Payments received</strong>
            <table class="items" style="margin-top: 8px;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th class="right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->reference ?? '—' }}</td>
                            <td class="right">{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</body>
</html>