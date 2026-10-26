<div class="row">
    <div class="col-md-6 mb-3">
        <label for="client_id" class="form-label">Client</label>
        <select id="client_id" name="client_id" class="form-select @error('client_id') is-invalid @enderror">
            <option value="">Choose a client…</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" @selected(old('client_id', $invoice->client_id) == $client->id)>
                    {{ $client->company_name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="service_id" class="form-label">Service</label>
        <select id="service_id" name="service_id" class="form-select @error('service_id') is-invalid @enderror">
            <option value="">Choose a service…</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected(old('service_id', $invoice->service_id) == $service->id)>
                    {{ $service->name }} ({{ number_format($service->price, 2) }})
                </option>
            @endforeach
        </select>
        @error('service_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <x-input name="invoice_number" label="Invoice number" :value="$invoice->invoice_number" />
    </div>
    <div class="col-md-4">
        <x-input name="issue_date" label="Issue date" type="date" :value="$invoice->issue_date?->format('Y-m-d')" />
    </div>
    <div class="col-md-4">
        <x-input name="due_date" label="Due date" type="date" :value="$invoice->due_date?->format('Y-m-d')" />
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <x-input name="amount" label="Amount" type="number" step="0.01" min="0" :value="$invoice->amount" />
    </div>
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach (['unpaid', 'partial', 'paid'] as $status)
                <option value="{{ $status }}" @selected(old('status', $invoice->status) === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>