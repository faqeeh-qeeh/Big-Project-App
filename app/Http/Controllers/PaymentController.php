<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    
        $clientId = auth()->guard('client')->id();
        $cartItems = Cart::where('client_id', $clientId)->with('product')->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
    
        $totalPrice = $cartItems->sum(fn($cart) => $cart->product->selling_price * $cart->quantity);
        $orderId = uniqid('ORDER-');
    
        // Simpan data order ke database
        $order = Order::create([
            'client_id' => $clientId,
            'order_id' => $orderId,
            'amount' => $totalPrice,
            'status' => 'pending',
        ]);
    
        // Data pembayaran untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->guard('client')->user()->full_name,
                'email' => auth()->guard('client')->user()->email,
                'phone' => auth()->guard('client')->user()->phone,
            ],
            'item_details' => $cartItems->map(fn($cart) => [
                'id' => $cart->product->id,
                'price' => $cart->product->selling_price,
                'quantity' => $cart->quantity,
                'name' => $cart->product->name,
            ])->toArray(),
        ];
    
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            $order->delete();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);
    
        $order = Order::where('order_id', $notification->order_id)->first();
    
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        switch ($notification->transaction_status) {
            case 'settlement':
                $order->update(['status' => 'settlement']);
                break;
    
            case 'pending':
                $order->update(['status' => 'pending']);
                break;
    
            case 'cancel':
            case 'expire':
            case 'deny':
                $order->update(['status' => 'failure']);
                break;
        }
    
        return response()->json(['message' => 'Notification handled']);
    }
    
}
