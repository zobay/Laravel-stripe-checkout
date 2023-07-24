<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class OrderController extends Controller
{
    public function create(Request $request)
    {
        $product = Product::query()->findOrFail($request->input('productId'));

        $user = User::firstOrCreate([
            'email' => $request->input('email')
        ],
            [
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => Str::random(10)
            ]);

        auth()->login($user);

        $user->orders()->create([
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        return to_route('checkout');
    }

    public function pay(Request $request)
    {
        $order = Order::query()->findOrFail($request->input('order_id'));
        $paymentMethod = $request->input('payment_method');
        $user = auth()->user();

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->invoiceFor($order->product->name, $order->product->price);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return to_route('success');
    }
}
