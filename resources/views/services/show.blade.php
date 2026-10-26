<x-layout :title="$service->name">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $service->name }}</h1>
        <a href="{{ route('services.edit', $service) }}" class="btn btn-outline-secondary">Edit</a>
    </div>

    <div class="card">
        <div class="card-body">
            <p class="mb-1"><strong>Price:</strong> {{ number_format($service->price, 2) }}</p>
            <p class="mb-0"><strong>Description:</strong> {{ $service->description ?? '—' }}</p>
        </div>
    </div>

    <a href="{{ route('services.index') }}" class="btn btn-link mt-3 px-0">← Back to services</a>
</x-layout>