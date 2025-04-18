<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Vui lòng đăng nhập để thực hiện chức năng này'
            ], 401);
        }

        $user = Auth::user();

        try {
            if ($user->favorites()->where('product_id', $product->id)->exists()) {
                $user->favorites()->detach($product);
                return response()->json([
                    'liked' => false,
                    'message' => 'Đã xóa khỏi danh sách yêu thích'
                ]);
            } else {
                $user->favorites()->attach($product);
                return response()->json([
                    'liked' => true,
                    'message' => 'Đã thêm vào danh sách yêu thích'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
