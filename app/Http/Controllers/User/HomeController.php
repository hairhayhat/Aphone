<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;



class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->with([
                    'variants' => function ($query) {
                        $query->with(['color', 'storage']);
                    }
                ]);
            }
        ])->get();

        $products = Product::where('Is_showHome', 1)
            ->with([
                'variants' => function ($query) {
                    $query->with(['color', 'storage']);
                }
            ])
            ->get();

        return view('welcome', compact('categories', 'products'));
    }

}
