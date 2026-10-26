<x-layout :title="$invoice->invoice_number">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            {{ $invoice->invoice_number }}
            <x-status-badge :status="$invoice->status" />
        </h1>
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-secondary">Edit</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-1"><strong>Client:</strong>
                <a href="{{ route('clients.show', $invoice->client) }}">{{ $invoice->client->company_name }}</a>
            </p>
            <p class="mb-1"><strong>Service:</strong> {{ $invoice->service->name }}</p>
            <p class="mb-1"><strong>Issued:</strong> {{ $invoice->issue_date->format('d M Y') }}</p>
            <p class="mb-1"><strong>Due:</strong> {{ $invoice->due_date->format('d M Y') }}</p>
            <p class="mb-0"><strong>Amount:</strong> {{ number_format($invoice->amount, 2) }}</p>
        </div>
    </div>

    <h2 class="h5">Payments</h2>
    <ul class="list-group">
        @forelse ($invoice->payments as $payment)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $payment->payment_date->format('d M Y') }} · {{ $payment->method }}</span>
                <span>{{ number_format($payment->amount, 2) }}</span>
            </li>
        @empty
            <li class="list-group-item text-muted">No payments yet.</li>
        @endforelse
    </ul>

    <a href="{{ route('invoices.index') }}" class="btn btn-link mt-3 px-0">← Back to invoices</a>
</x-layout>