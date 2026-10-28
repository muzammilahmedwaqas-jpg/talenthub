<x-layout :title="$invoice->invoice_number">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            {{ $invoice->invoice_number }}
            <x-status-badge :status="$invoice->status" />
        </h1>
        <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-primary">Download PDF</a>
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

    <div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Invoice total</div>
                <div class="h5 mb-0">{{ number_format($invoice->amount, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Total paid</div>
                <div class="h5 mb-0 text-success">{{ number_format($invoice->total_paid, 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Remaining balance</div>
                <div class="h5 mb-0 text-danger">{{ number_format($invoice->balance, 2) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <h2 class="h5">Payments</h2>
        <ul class="list-group">
            @forelse ($invoice->payments as $payment)
                <li class="list-group-item d-flex justify-content-between">
                    <span>
                        {{ $payment->payment_date->format('d M Y') }} · {{ $payment->method }}
                        @if ($payment->reference)
                            <span class="text-muted small">({{ $payment->reference }})</span>
                        @endif
                    </span>
                    <span>{{ number_format($payment->amount, 2) }}</span>
                </li>
            @empty
                <li class="list-group-item text-muted">No payments yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="col-md-5">
        <h2 class="h5">Record a payment</h2>

        @if ($invoice->balance > 0)
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.payments.store', $invoice) }}" method="POST" novalidate>
                        @csrf
                        <x-input name="amount" label="Amount" type="number" step="0.01" min="0.01" :max="$invoice->balance" />
                        <x-input name="payment_date" label="Payment date" type="date" :value="now()->format('Y-m-d')" />

                        <div class="mb-3">
                            <label for="method" class="form-label">Method</label>
                            <select id="method" name="method" class="form-select @error('method') is-invalid @enderror">
                                @foreach (['Bank Transfer', 'Cheque', 'Cash', 'Online'] as $method)
                                    <option value="{{ $method }}" @selected(old('method') === $method)>{{ $method }}</option>
                                @endforeach
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-input name="reference" label="Reference (optional)" />

                        <button type="submit" class="btn btn-primary w-100">Record payment</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-success mb-0">This invoice is fully paid.</div>
        @endif
    </div>
</div>

    <a href="{{ route('invoices.index') }}" class="btn btn-link mt-3 px-0">← Back to invoices</a>
</x-layout>