<x-layout title="Add service">
    <h1 class="h3 mb-3">Add service</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.store') }}" method="POST" novalidate>
                @csrf
                @include('services.form')
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('services.index') }}" class="btn btn-link">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>