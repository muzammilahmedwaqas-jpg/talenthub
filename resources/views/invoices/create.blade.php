<x-layout title="New invoice">
    <h1 class="h3 mb-3">New invoice</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST" novalidate>
                @csrf
                @include('invoices.form')
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>