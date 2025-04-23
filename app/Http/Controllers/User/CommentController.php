<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CommentController extends Controller
{
    public function create($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        if ($order->items->isEmpty()) {
            abort(404, 'Đơn hàng không có sản phẩm');
        }

        return view('user.comments.create', [
            'order' => $order,
            'products' => $order->items->pluck('product')
        ]);
    }
    public function store(Request $request)
    {
        // Bỏ tham số $orderId nếu không cần thiết
        $userId = auth()->id();
        $productId = $request->input('product_id');

        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
            'product_id' => 'required|exists:products,id' // Thêm validation cho product_id
        ]);

        $comment = Comment::create([
            'user_id' => $userId,
            'product_id' => $validatedData['product_id'],
            'content' => $validatedData['content'],
            'rating' => $validatedData['rating'],
            'status' => 'pending',
        ]);

        return redirect()->route('user.orders.index')->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
