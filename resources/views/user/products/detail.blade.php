<x-app-layout>

    <div class="mt-4 bg-white shadow overflow-hidden">
        <div class="flex">
            <!-- Phần ảnh (40%) -->
            <div class="w-3/5 p-4">
                @if ($product->category_id == 11)
                    <img src="{{ asset('storage/products/airpod.png') }}" alt="Tên sản phẩm"
                        class="w-80 h-auto object-cover">
                @else
                    <img src="{{ Storage::url($product->image) }}" alt="Tên sản phẩm"
                        class="w-80 h-auto object-cover mx-auto">
                @endif
            </div>

            <!-- Phần thông tin (60%) -->
            <div class="w-2/5 p-4">
                <h2 class="text-xl font-bold mb-2">{{ $product->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                <div class="mb-4">
                    @if ($product->is_sale)
                        <span class="text-gray-500 line-through text-lg mr-2">
                            {{ number_format($product->price, 0, '', '.') }}đ
                        </span>
                        <span class="text-red-500 text-lg font-bold">
                            {{ number_format($product->price - ($product->price * $product->sale_price) / 100, 0, '', '.') }}đ
                        </span>
                    @else
                        <span class="text-lg font-bold text-dark-600">
                            {{ number_format($product->price, 0, '', '.') }}đ
                        </span>
                    @endif
                </div>

                <form action="{{ route('orders.create') }}" method="POST">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @csrf
                    @if ($product->variants->count() > 1)
                        <div class="flex flex-col gap-2 mt-4 pb-2">
                            @foreach ($product->variants as $variant)
                                <label
                                    class="flex items-center border rounded-lg p-2 hover:shadow-md transition-all cursor-pointer">
                                    <input type="radio" name="variant_id" value="{{ $variant->id }}" class="mr-2">

                                    <div class="w-16 h-16 flex-shrink-0 mr-3">
                                        <img src="{{ Storage::url($product->image) }}" alt=""
                                            class="w-full h-full object-contain">
                                    </div>

                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <p class="text-sm font-medium text-gray-700">
                                                {{ $product->name }}-{{ $variant->color->color }}
                                            </p>
                                            <p class="text-sm font-bold text-red-600 ml-2">
                                                {{ number_format($variant->price) }}đ
                                            </p>
                                        </div>

                                        <p class="text-xs text-gray-500 mt-1">{{ $variant->storage->storage }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                    @endif

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Số lượng</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                            Mua ngay
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-white shadow overflow-hidden p-6">
        <h2 class="text-xl font-bold mb-4">Bình luận</h2>
        @if ($comments)
            <div class="space-y-4">
                @foreach ($comments as $comment)
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                    <span class="text-gray-600">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium">{{ $comment->user->name }}</p>
                                    <div class="flex items-center text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $comment->rating)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-2 text-gray-700">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Chưa có đánh giá nào cho sản phẩm này.</p>
        @endif
    </div>

    <h1 class="text-2xl pt-4">Các sản phẩm liên quan</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 pt-4">
        @foreach ($relatedProducts as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 relative">
                @if ($product->is_sale)
                    <div class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
                        SALE {{ $product->sale_price }}%
                    </div>
                @else
                    <div class="absolute top-0 left-0 bg-gray-800 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
                        SALE 0%
                    </div>
                @endif

                <div class="p-4 flex items-center justify-center overflow-hidden h-48">
                    @if ($product->category_id == 11)
                        <img src="{{ asset('storage/products/airpod.png') }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain">
                    @else
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain">
                    @endif
                </div>

                <div class="p-4 border-t border-gray-100">
                    <h5 class="text-sm font-bold mb-1 truncate">{{ $product->name }}</h5>

                    @if ($product->variants->count() > 1)
                        <div class="text-xs text-gray-500 mb-2">
                            @foreach ($product->variants->groupBy('storage.storage') as $storage => $variants)
                                <span class="inline-block mr-2">({{ $storage }})</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center mb-2">
                        @if ($product->is_sale)
                            <span class="text-gray-500 line-through text-xs mr-2">
                                {{ number_format($product->price, 0, '', '.') }}đ
                            </span>
                        @endif
                        <span class="text-sm font-bold text-dark-600">
                            {{ number_format($product->price - ($product->price * $product->sale_price) / 100, 0, '', '.') }}đ
                        </span>
                    </div>

                    <div class="flex justify-between items-center mt-3">
                        @auth
                            <button class="like-btn text-gray-400 hover:text-red-500 transition-colors"
                                data-product-id="{{ $product->id }}">
                                <i
                                    class="far fa-heart text-lg {{ $product->isFavoritedBy(auth()->user()) ? 'fas text-red-500' : '' }}"></i>
                            </button>
                        @endauth

                        <a href="{{ route('user.products.detail', $product->id) }}"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="far fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach



    </div>
    @if ($relatedProducts->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="flex items-center justify-between" aria-label="Pagination">
                {{ $relatedProducts->onEachSide(1)->links() }}
            </nav>
        </div>
    @endif
</x-app-layout>
