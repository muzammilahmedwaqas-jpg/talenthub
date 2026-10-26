<x-layout title="Invoices">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">New invoice</a>
    </div>

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Issued</th>
                    <th>Due</th>
                    <th class="text-end">Amount</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td><a href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                        <td>{{ $invoice->client->company_name }}</td>
                        <td>{{ $invoice->service->name }}</td>
                        <td>{{ $invoice->issue_date->format('d M Y') }}</td>
                        <td>{{ $invoice->due_date->format('d M Y') }}</td>
                        <td class="text-end">{{ number_format($invoice->amount, 2) }}</td>
                        <td><x-status-badge :status="$invoice->status" /></td>
                        <td class="text-end">
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this invoice?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No invoices yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $invoices->links() }}
    </div>
</x-layout>