@extends('layouts.app')

@section('content')
<main class="container col-6 mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    <div id="cart-items" class="mb-5">
        @foreach ($cart as $item)
            <div class="cart-item mb-3">
                <p><strong>{{ $item['name'] }}</strong></p>
                <p>Price: ${{ number_format($item['price'], 2) }}</p>
                <p>Quantity: {{ $item['quantity'] }}</p>
                <p>Total: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
            </div>
        @endforeach
    </div>

    <form id="payment-form" action="{{ route('complete_payment') }}" method="POST">
        @csrf
        <div id="card-element" class="mb-3">
        </div>
        
        <div id="card-errors" role="alert"></div>
        <input type="hidden" name="stripe_payment_intent" id="stripe-intent-id">
        
        <button type="submit" class="btn btn-success w-100">Pay Now</button>
    </form>
</main>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('pk_test_51QoHrmGhojwUnUCAtXU5TUSCsdU4Q9w2fvNUO3KxCaFRBLimP2a0RhTbOkmxEb0pTgbH5HHzMOGyJB87R42hh6jy00Wgx1OJJQ'); 
    const elements = stripe.elements();

    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const response = await fetch('{{ route('create_payment_intent') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                amount: calculateAmountFromCart() 
            })
        });

        const { clientSecret } = await response.json();

        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
            },
        });

        if (error) {
            console.log(error);
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else if (paymentIntent.status == 'succeeded') {
            document.getElementById('stripe-intent-id').value = paymentIntent.id;
            form.submit();
        }
    });

    function calculateAmountFromCart() {
         const cartItems = @json($cart);
        const amount = cartItems.reduce((total, item) => total + (item.price * item.quantity * 100), 0);
        console.log("Amount calculated: " + amount);
        return amount;
    }

</script>
@endsection
