<x-input name="company_name" label="Company name" :value="$client->company_name ?? null" />
<x-input name="contact_name" label="Contact person" :value="$client->contact_name ?? null" />
<x-input name="email" label="Email" type="email" :value="$client->email ?? null" />
<x-input name="phone" label="Phone" :value="$client->phone ?? null" />

<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <textarea id="address" name="address" rows="3"
              class="form-control @error('address') is-invalid @enderror">{{ old('address', $client->address ?? null) }}</textarea>
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>