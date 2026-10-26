<x-input name="name" label="Service name" :value="$service->name ?? null" />
<x-input name="price" label="Price" type="number" step="0.01" min="0" :value="$service->price ?? null" />

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="3"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description ?? null) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>