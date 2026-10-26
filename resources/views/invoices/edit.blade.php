<x-layout title="Edit invoice">
    <h1 class="h3 mb-3">Edit {{ $invoice->invoice_number }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('invoices.form')
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>