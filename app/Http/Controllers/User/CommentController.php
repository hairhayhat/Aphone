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
        $order = Order::findOrFail($id)->with('items')->first();
        return view('user.comments.create', compact('order'));
    }
    public function store(Request $request)
    {
        $userId = auth()->id();
        $productId = $request->input('product_id');

        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
        ]);

        $comment = Comment::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'content' => $validatedData['content'],
            'rating' => $validatedData['rating'],
            'status' => 'pending', // Set the status to 'pending' by default
        ]);

        return redirect()->route('home')->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!. Bình luận của bạn sẽ được xem xét và phê duyệt trong thời gian sớm nhất.');
    }

}
