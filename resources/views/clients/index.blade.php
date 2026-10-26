<x-layout title="Clients">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Add client</a>
    </div>

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td><a href="{{ route('clients.show', $client) }}">{{ $client->company_name }}</a></td>
                        <td>{{ $client->contact_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone }}</td>
                        <td class="text-end">
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No clients yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $clients->links() }}
    </div>
</x-layout>