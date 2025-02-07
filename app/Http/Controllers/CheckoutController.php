<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
         $this->stripe = new \Stripe\StripeClient([
            "api_key" => "sk_test_51QoHrmGhojwUnUCAQy5s02njz4G67wav6mLZQZCb6HOuaUYhDqPTtoUKZQggANFpAdCwk8oj3KXxrEhCyuK1MjDs00MpOoJfOp",
        ]);
    }

     public function checkout(Request $request)
    {
        $cart = session('cart');
        return view('checkout',compact('cart'));
    }

    public function storeCart(Request $request)
    {
        session(['cart' => $request->cart]);
        return response()->json(['message' => 'Cart stored successfully']);
    }

    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey("sk_test_51QoHrmGhojwUnUCAQy5s02njz4G67wav6mLZQZCb6HOuaUYhDqPTtoUKZQggANFpAdCwk8oj3KXxrEhCyuK1MjDs00MpOoJfOp"); 

        $amount = $request->amount; 

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'inr',
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart');
        if($request->filled("stripe_payment_intent")) {
            $payment_intent = $this->getPayment($request->stripe_payment_intent);
            if($payment_intent["error"]) {
                flashMessage('danger',Lang::get('messages.failed'),$payment_intent["error_message"]);
                return back();
            }
            if($this->checkPaymentCompleted($payment_intent["data"])) {

                $order = new Order();
                $order->user_id = Auth::id();
                $order->total_price = array_sum(array_column($cart, 'price'));
                $order->payment_method = 'Stripe';
                $order->transaction_id = $payment_intent["data"]->id;
                $order->status = 'pending';
                $order->save();

                foreach ($cart as $id => $item) {
                    $order_item = new OrderItem();
                    $order_item->order_id = $order->id;
                    $order_item->order_id = $id;
                    $order_item->order_id = $item['quantity'] ?? 1;
                    $order_item->order_id = $item['price'];
                }
                return redirect()->route('products.index')->with('success', 'Order placed successfully!');
            } else{
                return redirect()->route('products.index')->with('danger', 'payment failed');
            }
        }
        session()->flush();
        return redirect()->route('products.index')->with('danger', 'payment failed');
    }

    protected function getPayment(string $intent_id = '')
    {
        $payment_intent = [];
        if($intent_id != '') {
            $intent = $this->getPaymentIntent($intent_id);
            
            if($intent["error"]) {
                return $intent;
            }
            $payment_intent = $intent['data'];
        }
        
        if($payment_intent != '') {
            return array(
                "error" => false,
                "data" => $payment_intent,
            );
        }
        return array(
            "error" => true,
            "data" => "Invalid Payment",
        );        
    }

     protected function getPaymentIntent($intent_id)
    {
        try {
            $intent = $this->stripe->paymentIntents->retrieve(
                $intent_id
            );
            return ['error' => false,'data' => $intent];
        }
        catch(\Exception $exception) {
            return ['error' => true,'error_message' => $exception->getMessage()];
        }
    }

    protected function checkPaymentCompleted($payment_intent)
    {
        return ($payment_intent->status == 'succeeded');
    }
}
