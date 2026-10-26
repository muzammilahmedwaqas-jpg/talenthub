<x-layout :title="$client->company_name">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $client->company_name }}</h1>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline-secondary">Edit</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-1"><strong>Contact:</strong> {{ $client->contact_name }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $client->email }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $client->phone ?? '—' }}</p>
            <p class="mb-0"><strong>Address:</strong> {{ $client->address ?? '—' }}</p>
        </div>
    </div>

    <h2 class="h5">Invoices</h2>
    <ul class="list-group">
        @forelse ($client->invoices as $invoice)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $invoice->invoice_number }}</span>
                <span>{{ number_format($invoice->amount, 2) }} · {{ ucfirst($invoice->status) }}</span>
            </li>
        @empty
            <li class="list-group-item text-muted">No invoices yet.</li>
        @endforelse
    </ul>

    <a href="{{ route('clients.index') }}" class="btn btn-link mt-3 px-0">← Back to clients</a>
</x-layout>