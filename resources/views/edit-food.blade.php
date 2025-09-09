<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Food</h1>
        <form action="{{ route('foods.update', $food) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $food->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $food->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $food->price }}" required>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="image" class="form-label">Upload New Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Leave empty to keep current image.</div>
                </div>
                <div class="col-md-6">
                    <label for="image_url" class="form-label">Or Image URL</label>
                    <input type="url" class="form-control" id="image_url" name="image_url" value="{{ $food->image_url }}">
                </div>
            </div>
            <div class="my-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $food->image_url }}" alt="Current image" style="height: 80px; width: 120px; object-fit: cover;" class="border rounded">
                    <span class="text-muted">Current image preview</span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Food</button>
            <a href="{{ url('/') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
