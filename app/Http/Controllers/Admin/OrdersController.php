<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;


class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items')->where(function ($query) {
            $query->where('status', 'pending');
        })->paginate(10);

        $totalPendingOrders = Order::where('status', 'pending')->count();
        $totalProcessingOrders = Order::where('status', 'processing')->count();
        $totalShippedOrders = Order::where('status', 'shipped')->count();
        $totalDeliveredOrders = Order::where('status', 'delivered')->count();
        $totalCancelledOrders = Order::where('status', 'cancelled')->count();

        return view(
            'admin.orders.index',
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
        $orders = Order::query()
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

        $totalPendingOrders = Order::where('status', 'pending')->count();
        $totalProcessingOrders = Order::where('status', 'processing')->count();
        $totalShippedOrders = Order::where('status', 'shipped')->count();
        $totalDeliveredOrders = Order::where('status', 'delivered')->count();
        $totalCancelledOrders = Order::where('status', 'cancelled')->count();

        return view(
            'admin.orders.index',
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

    public function changeStatus($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'pending') {
            $order->status = 'processing';
        } elseif ($order->status == 'processing') {
            $order->status = 'shipped';
        } elseif ($order->status == 'shipped') {
            $order->status = 'delivered';
        } elseif ($order->status == 'delivered') {
            $order->status = 'completed';
        } else {
            $order->status = 'cancelled';
        }
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');

    }

    public function showComment($id)
    {
        $order = Order::findOrFail($id);

        $userId = $order->user_id;

        $items = $order->items;

        $productIds = $order->items->pluck('product_id');
        $comment = Comment::where('user_id', $userId)
            ->whereIn('product_id', $productIds)
            ->first();

        return view('admin.orders.show-comment', compact('order', 'comment'));
    }

    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 'approved';
        $comment->save();

        return redirect()->route('orders.index')->with('success', 'Comment approved successfully.');
    }
    public function rejectComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 'rejected';
        $comment->save();

        return redirect()->route('orders.index')->with('success', 'Comment rejected successfully.');
    }
}
