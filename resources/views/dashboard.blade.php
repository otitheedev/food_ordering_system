<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 m-0">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @auth
                @if (auth()->user()->is_admin)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ __('Add New Food') }}</h5>
                            <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="price" class="form-label">{{ __('Price') }}</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea class="form-control" id="description" name="description" rows="2" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="image" class="form-label">{{ __('Upload Image') }}</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="image_url" class="form-label">{{ __('Or Image URL') }}</label>
                                    <input type="url" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}">
                                    @error('image_url')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth

            <div class="row g-4">
                @forelse ($foods as $food)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            @if ($food->image_url)
                                <img src="{{ $food->image_url }}" class="card-img-top" alt="{{ $food->name }}" style="height: 180px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">{{ $food->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1">{{ $food->description }}</p>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <span class="fw-semibold">${{ number_format($food->price, 2) }}</span>
                                    @auth
                                        @if (auth()->user()->is_admin)
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('foods.edit', $food) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                                <form action="{{ route('foods.destroy', $food) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">{{ __('No foods found.') }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
