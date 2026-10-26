<x-layout title="Edit service">
    <h1 class="h3 mb-3">Edit {{ $service->name }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.update', $service) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                @include('services.form')
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('services.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>