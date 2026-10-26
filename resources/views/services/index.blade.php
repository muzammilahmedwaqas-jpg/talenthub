<x-layout title="Services">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Services</h1>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Add service</a>
    </div>

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td><a href="{{ route('services.show', $service) }}">{{ $service->name }}</a></td>
                        <td class="text-muted">{{ Str::limit($service->description, 50) }}</td>
                        <td class="text-end">{{ number_format($service->price, 2) }}</td>
                        <td class="text-end">
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No services yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $services->links() }}
    </div>
</x-layout>