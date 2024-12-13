<?php

namespace App\Http\Controllers;  

use App\Models\Order;  
use Illuminate\Http\Request;  

class OrderController extends Controller  
{  
    public function updateStatus(Request $request, $orderId)  
    {  
        $request->validate([  
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUSES))  
        ]);  

        $order = Order::where('order_id', $orderId)->firstOrFail();  

        $order->update([  
            'status' => $request->status  
        ]);  

        return back()->with('success', 'Status pesanan berhasil diperbarui');  
    }  
}