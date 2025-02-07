@extends('layouts.app')

@section('content')
<main class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Products</h1>

    <!-- Category Filter -->
    <div class="mb-6 d-flex flex-wrap gap-2 mb-5">
        <a href="{{ route('products.index') }}" 
           class="btn {{ request('category') ? 'btn-outline-primary' : 'btn-primary' }}">
            All
        </a>
        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <div class="row mb-5 pb-4">
        @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('images/products/' . $product->image) }}" 
                     class="card-img-top" 
                     alt="{{ $product->name }}" 
                     style="width: 100%; height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted">{{ $product->category->name }}</p>
                    <p class="text-success font-weight-bold">${{ number_format($product->price, 2) }}</p>
                    <p class="text-muted">{{ $product->stock }} in stock</p>

                    <div id="cart-controls-{{ $product->id }}">
                        <button class="btn btn-primary w-100 add-to-cart" 
                                data-id="{{ $product->id }}" 
                                data-name="{{ $product->name }}" 
                                data-price="{{ $product->price }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-muted">No products found.</p>
        </div>
        @endforelse
    </div>

    <!-- Cart Section -->
    <div id="cart-section" class="fixed-bottom bg-white p-3 shadow d-none text-center">
        <button id="proceed-to-payment" class="btn btn-success w-50">Proceed to Payment</button>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function updateCartDisplay() {
        if (cart.length > 0) {
            document.getElementById('cart-section').classList.remove('d-none');
        } else {
            document.getElementById('cart-section').classList.add('d-none');
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            let productId = button.dataset.id;
            let cartItem = cart.find(item => item.id === productId);

            if (cartItem) {
                document.getElementById(`cart-controls-${productId}`).innerHTML = `
                    <div class="cart-controls d-flex align-items-center">
                        <button class="btn btn-outline-secondary decrement" data-id="${productId}">-</button>
                        <span class="mx-2" id="quantity-${productId}">${cartItem.quantity}</span>
                        <button class="btn btn-outline-secondary increment" data-id="${productId}">+</button>
                    </div>
                `;
            } else {
                document.getElementById(`cart-controls-${productId}`).innerHTML = `
                    <button class="btn btn-primary w-100 add-to-cart" 
                            data-id="${productId}" 
                            data-name="${button.dataset.name}" 
                            data-price="${button.dataset.price}">
                        Add to Cart
                    </button>
                `;
            }
        });

        attachEventListeners();
        saveCart();
    }

    function attachEventListeners() {
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.dataset.id;
                let cartItem = cart.find(item => item.id === productId);
                if (cartItem) {
                    cartItem.quantity += 1;
                    document.getElementById(`quantity-${productId}`).textContent = cartItem.quantity;
                }
                updateCartDisplay();
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.dataset.id;
                let cartItemIndex = cart.findIndex(item => item.id === productId);

                if (cartItemIndex !== -1) {
                    cart[cartItemIndex].quantity -= 1;
                    if (cart[cartItemIndex].quantity <= 0) {
                        cart.splice(cartItemIndex, 1);
                    }
                    updateCartDisplay();
                }
            });
        });

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                let productId = this.dataset.id;
                let productName = this.dataset.name;
                let productPrice = parseFloat(this.dataset.price);

                let cartItem = cart.find(item => item.id === productId);
                if (cartItem) {
                    cartItem.quantity += 1;
                } else {
                    cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
                }
                updateCartDisplay();
            });
        });
    }

    document.getElementById('proceed-to-payment').addEventListener('click', function () {
        fetch("{{ route('store_cart') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ cart: cart })
        })
        .then(response => response.json())
        .then(data => {
            localStorage.removeItem('cart'); // Clear cart on successful checkout
            window.location.href = "{{ route('checkout') }}";
        })
        .catch(error => console.error('Error:', error));
    });

    updateCartDisplay();
});
</script>
@endsection
