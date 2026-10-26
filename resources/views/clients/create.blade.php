<x-layout title="Add client">
    <h1 class="h3 mb-3">Add client</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST" novalidate>
                @csrf
                @include('clients.form')
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('clients.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>