<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Storage;
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

        $productsIsSale = Product::where('is_sale', 1)
            ->with([
                'variants' => function ($query) {
                    $query->with(['color', 'storage']);
                }
            ])
            ->take(10)
            ->get();

        $productsPopular = Product::withCount('favoritedBy')
            ->where('category_id', '!=', 11)
            ->orderBy('favorited_by_count', 'desc')
            ->take(10)
            ->get();

        return view('user.welcome', compact('categories', 'products', 'productsIsSale', 'productsPopular'));
    }

    public function categories()
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

        return view('user.categories.index', compact('categories'));
    }

    public function products()
    {
        $products = Product::with([
            'variants' => function ($query) {
                $query->with(['color', 'storage']);
            }
        ])
            ->get();
        $categories = Category::get();
        return view('user.products.index', compact('products', 'categories'));
    }

    public function orderIndex(Request $request)
    {
        $products = Product::query()
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->price, function ($q) use ($request) {
                $range = explode('-', $request->price);
                if (count($range) == 2) {
                    $q->whereBetween('price', [$range[0], $range[1]]);
                } else {
                    $q->where('price', '>=', str_replace('-', '', $range[0]));
                }
            })
            ->when($request->sale, fn($q) => $q->where('is_sale', true))
            ->when($request->storage, function ($q) use ($request) {
                $q->whereHas('variants', function ($q) use ($request) {
                    $q->where('storage_id', $request->storage);
                });
            })
            ->when($request->sort, function ($q, $sort) {
                switch ($sort) {
                    case 'price_asc':
                        return $q->orderBy('price');
                    case 'price_desc':
                        return $q->orderByDesc('price');
                    case 'newest':
                        return $q->latest();
                    case 'popular':
                        return $q->withCount('orders')->orderByDesc('orders_count');
                }
            })
            ->paginate(12);
        $categories = Category::get();
        $storages = Storage::all();

        return view('user.products.index', compact('products', 'categories', 'storages'));
    }

}
