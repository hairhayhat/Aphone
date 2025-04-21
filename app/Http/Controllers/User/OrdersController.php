<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrdersController extends Controller
{

    public function index()
    {

    }

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with(['variants.color', 'variants.storage'])
            ->findOrFail($request->product_id);

        $selectedVariant = $product->variants
            ->where('id', $request->variant_id)
            ->first();

        return view('user.orders.create', [
            'product' => $product,
            'variant' => $selectedVariant,
            'quantity' => $request->quantity,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:variants,id',
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $order = null;

        DB::transaction(function () use ($validated, &$order) {
            $order = Order::create([
                'order_code' => 'ORD-' . time() . '-' . Str::random(4),
                'user_id' => $validated['user_id'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
                'note' => $validated['note'],
                'total' => $validated['total'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            $variant = Variant::with(['color', 'storage', 'product'])
                ->findOrFail($validated['variant_id']);

            $order->items()->create([
                'product_id' => $variant->product_id,
                'variant_id' => $variant->id,
                'product_name' => $variant->product->name,
                'color' => $variant->color->color,
                'storage' => $variant->storage->storage,
                'price' => $validated['price'],
                'quantity' => $validated['quantity'],
                'total' => $validated['total'],
            ]);

        });

        $order = Order::latest()->first();
        if ($order) {
            return redirect()->route('orders.success')
                ->with('success', 'Đặt hàng thành công!')
                ->with('order_code', $order->order_code);
        }



        return back()->with('error', 'Có lỗi xảy ra khi đặt hàng');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
