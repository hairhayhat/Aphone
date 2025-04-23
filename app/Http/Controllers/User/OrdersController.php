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
        $userId = auth()->id();

        $orders = Order::with('user', 'items')
            ->where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'pending');
            })
            ->paginate(10);

        $totalPendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $totalProcessingOrders = Order::where('user_id', $userId)->where('status', 'processing')->count();
        $totalShippedOrders = Order::where('user_id', $userId)->where('status', 'shipped')->count();
        $totalDeliveredOrders = Order::where('user_id', $userId)->where('status', 'delivered')->count();
        $totalCancelledOrders = Order::where('user_id', $userId)->where('status', 'cancelled')->count();

        return view(
            'user.orders.index',
            compact(
                'orders',
                'totalPendingOrders',
                'totalProcessingOrders',
                'totalShippedOrders',
                'totalDeliveredOrders',
                'totalCancelledOrders',
            )
        );
    }

    public function orderIndex(Request $request)
    {
        $userId = auth()->id();
        $orders = Order::query()
            ->where('user_id', $userId)
            ->when($request->has('status'), function ($q) use ($request) {
                $q->where('status', $request->input('status'));
            })
            ->when($request->has('sort'), function ($q) use ($request) {
                switch ($request->input('sort')) {
                    case 'newest':
                        return $q->latest();
                    case 'oldest':
                        return $q->oldest();
                    default:
                        return $q->latest();
                }
            }, function ($q) {
                return $q->latest();
            })
            ->paginate(10);

        $totalPendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $totalProcessingOrders = Order::where('user_id', $userId)->where('status', 'processing')->count();
        $totalShippedOrders = Order::where('user_id', $userId)->where('status', 'shipped')->count();
        $totalDeliveredOrders = Order::where('user_id', $userId)->where('status', 'delivered')->count();
        $totalCancelledOrders = Order::where('user_id', $userId)->where('status', 'cancelled')->count();


        return view(
            'user.orders.index',
            compact(
                'orders',
                'totalPendingOrders',
                'totalProcessingOrders',
                'totalShippedOrders',
                'totalDeliveredOrders',
                'totalCancelledOrders',
            )
        );
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

    public function cancelOrder(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'cancelled') {
            return redirect()->route('user.orders.index')
                ->with('error', 'Đơn hàng đã được hủy trước đó.');
        }

        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);

        return redirect()->route('user.orders.index')
            ->with('success', 'Hủy đơn hàng thành công!');
    }

    public function confirmOrder(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'delivered') {
            return redirect()->route('user.orders.index')
                ->with('error', 'Đơn hàng đã được xác nhận trước đó.');
        }

        $order->update([
            'status' => 'delivered',
            'payment_status' => 'paid',
            'delivered_at' => now(), // Thêm trường này nếu có
        ]);

        return redirect()->route('user.orders.success-confirm', ['order' => $order->id]);
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
