<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: linear-gradient(180deg, #f0f4f8 0%, #ffffff 100%);
        }
        .card {
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 14px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
        .order-btn {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }
        .order-btn:hover {
            background-color: #0284c7;
            border-color: #0284c7;
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .brand {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .form-hint {
            font-size: 0.85rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand brand" href="#">Food Corner</a>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFoodModal">
                            Add New Food
                        </button>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="h3 m-0">Our Menu</h1>
                </div>
                <div class="row">
                    @forelse($foods as $food)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <img src="{{ $food->image_url }}" class="card-img-top" alt="{{ $food->name }}" style="height: 220px; object-fit: cover; border-top-left-radius: 14px; border-top-right-radius: 14px;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $food->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $food->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="card-text m-0"><strong>Price:</strong> ৳{{ number_format($food->price, 2) }}</p>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary order-btn" data-food-id="{{ $food->id }}" data-bs-toggle="modal" data-bs-target="#orderModal">Order</button>
                                            @auth
                                                @if(auth()->user()->is_admin)
                                                    <a href="{{ route('foods.edit', $food) }}" class="btn btn-outline-secondary">Edit</a>
                                                    <form action="{{ route('foods.destroy', $food) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="alert alert-light text-center border">No food items available at the moment.</div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-4">
                <h2 class="h4 mb-3">Recent Orders</h2>
                <div class="card">
                    <div class="card-body">
                        @forelse($orders as $order)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>{{ $order->customer_name }} <span class="text-muted">({{ $order->phone_number }})</span></strong> ordered {{ $order->quantity }}x {{ $order->food->name }}
                                </li>
                            </ul>
                        @empty
                            <p class="text-muted">No orders yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Food Modal -->
    <div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="addFoodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFoodModalLabel">Add New Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-hint">JPEG, PNG up to 2MB.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="image_url" class="form-label">Or Image URL</label>
                                <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://...">
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Food</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Place Your Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm">
                        <input type="hidden" id="food_id" name="food_id">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="quantity" value="1" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderModal = document.getElementById('orderModal');
            orderModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const foodId = button.getAttribute('data-food-id');
                const foodIdInput = orderModal.querySelector('#food_id');
                foodIdInput.value = foodId;
            });

            const orderForm = document.getElementById('orderForm');
            orderForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(orderForm);
                const data = Object.fromEntries(formData.entries());

                fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    const modal = bootstrap.Modal.getInstance(orderModal);
                    modal.hide();
                    orderForm.reset();
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error placing your order.');
                });
            });
        });
    </script>
</body>
</html>
