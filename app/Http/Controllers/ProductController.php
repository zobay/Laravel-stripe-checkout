<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

final class ProductController extends Controller
{
    public function index()
    {
        return view('product.list', [
            'products' => Product::all()
        ]);
    }

    public function confirmPurchase()
    {
        return view('order');
    }

    public function checkout()
    {
        $order = Order::query()
            ->with('product')
            ->where('user_id', auth()->user()->id)
            ->whereNull('paid_at')
            ->latest()
            ->first();

        return view('checkout', [
            'order' => $order,
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }
}
