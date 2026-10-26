<x-layout title="Edit client">
    <h1 class="h3 mb-3">Edit {{ $client->company_name }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clients.update', $client) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('clients.form')
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('clients.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>