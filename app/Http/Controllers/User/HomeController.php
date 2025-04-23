<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;


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
            ->paginate(15);
        $categories = Category::get();
        return view('user.products.index', compact('products', 'categories'));
    }

    public function detail($id)
    {

        $product = Product::with([
            'variants.color',
            'variants.storage',
            'category'
        ])->findOrFail($id);

        $comments = Comment::where('product_id', $id)
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                }
            ])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'comments_page');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['variants.color', 'variants.storage'])
            ->select('id', 'name', 'image', 'price', 'is_sale', 'sale_price')
            ->paginate(10);

        return view('user.products.detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'comments' => $comments,
            'totalReviews' => $comments->total()
        ]);
    }

    public function orderIndex(Request $request)
    {
        $query = $request->input('q');
        $products = Product::query()
            ->withCount('favoritedBy')
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->price, function ($q) use ($request) {
                $range = explode('-', $request->price);
                if (count($range) == 2) {
                    $q->whereBetween('price', [$range[0], $range[1]]);
                } else {
                    $q->where('price', '>', str_replace('-', '', $range[0]));
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
                        return $q->orderByDesc('orders_count');
                    case 'most_favorite':
                        return $q->orderByDesc('favorites_count');
                    default:
                        return $q->latest();
                }
            }, function ($q) {
                return $q->latest();
            })
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })

            ->paginate(15)->withQueryString();

        $categories = Category::get();
        $storages = Storage::get();

        return view('user.products.index', compact('products', 'categories', 'storages'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $categories = Category::get();
        $storages = Storage::get();


        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->with(['variants.color', 'variants.storage'])
            ->paginate(12)
            ->appends(['q' => $query]);

        return view('user.products.search', [
            'products' => $products,
            'searchQuery' => $query,
            'categories' => $categories,
            'storages' => $storages
        ]);
    }


}
