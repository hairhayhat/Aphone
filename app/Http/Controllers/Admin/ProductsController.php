<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Variant;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')
            ->withCount('variants')
            ->paginate(10)->appends(request()->query());
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::all();
        $storages = Storage::all();
        $categories = Category::all();
        return view('admin.products.create', compact('colors', 'storages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_showhome' => 'nullable|boolean',
            'is_sale' => 'nullable|boolean',
            'sale_price' => 'nullable|numeric',
            'description' => 'required|string',
            'variants' => 'required|array|min:1',
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|integer|min:0',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.storage_id' => 'nullable|exists:storages,id'
        ]);
        try {

            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('products', 'public')
                : null;

            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'image' => $imagePath,
                'description' => $validated['description'],
                'is_showhome' => $validated['is_showhome'] ?? 0,
                'is_sale' => $validated['is_sale'] ?? 0,
                'sale_price' => $validated['sale_price'] ?? null,
            ]);

            foreach ($validated['variants'] as $variant) {
                $product->variants()->create($variant);
            }

            return redirect()->route('products.index')
                ->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $colors = Color::all();
        $storages = Storage::all();
        $categories = Category::all();
        $product = Product::with('variants')
            ->findOrFail($id);
        return view('admin.products.edit', compact('colors', 'storages', 'categories', 'product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        $product = Product::findOrFail($id);
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|max:2048',
                'description' => 'required|string',
                'variants' => 'required|array|min:1',
                'variants.*.price' => 'required|numeric',
                'variants.*.quantity' => 'required|integer|min:0',
                'variants.*.color_id' => 'nullable|exists:colors,id',
                'variants.*.storage_id' => 'nullable|exists:storages,id'
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            } else {
                $imagePath = $product->image;
            }

            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
                'image' => $imagePath,
                'description' => $validated['description'],
                'is_showhome' => $request->has('is_showhome') ? 1 : 0,
            ]);

            foreach ($product->variants as $variant) {
                if (!in_array($variant->id, array_column($validated['variants'], 'id'))) {
                    $variant->delete();
                }
            }

            foreach ($validated['variants'] as $variantData) {
                if (isset($variantData['id'])) {
                    $variant = Variant::findOrFail($variantData['id']);
                    $variant->update($variantData);
                } else {
                    $product->variants()->create($variantData);
                }
            }

            return redirect()->back()
                ->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->to(url()->previous())->with('success', 'Product deleted successfully.');
    }

    public function orderBy(Request $request)
    {
        $data = $request->query('data');
        $by = $request->query('by');
        $products = Product::with('category')
            ->orderBy("$data", "$by")
            ->withCount('variants')
            ->paginate(20)->appends($request->query());
        return view('admin.products.index', compact('products'));

    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::
            with('category')
            ->withCount('variants')
            ->where('name', 'like', "%$query%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->get();
        return response()->json($products);
    }

    public function destroy_variant($id)
    {
        try {
            $variant = Variant::findOrFail($id);
            $variant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Biến thể đã được xóa thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xóa biến thể thất bại: ' . $e->getMessage()
            ], 500); // Status code 500 cho lỗi server
        }
    }
}
