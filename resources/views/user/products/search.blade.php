<x-app-layout>
    <div
        class="simple-banner bg-black text-white h-40 md:h-48 flex items-center justify-center overflow-hidden relative">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="animate-pulse opacity-5">
                <div class="grid grid-cols-5 gap-8">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="w-8 h-8 border border-white rounded-full"></div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="relative text-center px-4">
            <h2 class="text-2xl md:text-4xl font-bold mb-2 tracking-wider">Sản phẩm của chúng tôi</h2>
            <p class="text-sm md:text-base opacity-80">Đảm bảo - Uy tín - Chất lượng</p>
        </div>

        <div
            class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white to-transparent animate-marquee">
        </div>
    </div>

    <div x-data="filter">
        <div class="mx-auto px-4 pt-4">

            <h1 class="text-2xl font-bold mb-6">Chọn theo tiêu chí</h1>
            <div class="flex items-center justify-between mb-4">

                <div class="mb-6">
                    <button @click="filterOpen = !filterOpen" class="btn btn-dark flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        Bộ lọc
                    </button>
                    @if (request('category') || request('price') || request('storage'))
                        <p class="px-4 py-2">Đang lọc theo:
                            @if (request('category'))
                                <span>|</span>
                                <span class="text-sm text-gray-500">Danh mục:
                                    {{ $categories->find(request('category'))->name }}
                                </span>
                            @endif

                            @if (request('price'))
                                <span>|</span>
                                <span class="text-sm text-gray-500">Mức giá: {{ request('price') }}</span>
                            @endif

                            @if (request('storage'))
                                <span>|</span>
                                <span class="text-sm text-gray-500">Dung lượng:
                                    {{ $storages->find(request('storage'))->storage }}</span>
                            @endif
                        </p>
                        <a href="{{ route('user.products.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 ml-4 px-4 py-2">
                            <i class="fas fa-times"></i> Xóa bộ lọc
                        </a>
                    @endif
                </div>

                <div class="mb-6">
                    <form action="{{ route('user.products.index') }}" method="GET" class="flex items-center gap-2">
                        <!-- Giữ lại các tham số filter hiện có -->
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="price" value="{{ request('price') }}">

                        <label for="sort" class="text-sm font-medium text-gray-700 whitespace-nowrap">Sắp xếp
                            theo:</label>
                        <select name="sort" id="sort" onchange="this.form.submit()"
                            class="filter-select w-full sm:w-auto">
                            <option value="">Mặc định</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Giá: Thấp
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Giá: Cao
                            </option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                Mới nhất
                            </option>
                            <option value="most_favorite" {{ request('sort') == 'most_favorite' ? 'selected' : '' }}>
                                Yêu thích nhất
                            </option>
                        </select>
                    </form>
                </div>

            </div>

        </div>


        <div x-show="filterOpen" x-transition class="bg-white p-4 rounded-lg shadow mb-8">
            <form action="{{ route('user.products.index') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if (request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <div class="flex flex-wrap items-end gap-4">
                    <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select name="category" id="category" class="filter-select w-full">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $cate)
                                <option value="{{ $cate->id }}"
                                    {{ request('category') == $cate->id ? 'selected' : '' }}>
                                    {{ $cate->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                        <label for="storage" class="block text-sm font-medium text-gray-700 mb-1">Dung lượng</label>
                        <select name="storage" id="storage" class="filter-select w-full">
                            <option value="">Tất cả dung lượng</option>
                            <option value="1" {{ request('storage') == '1' ? 'selected' : '' }}>64GB</option>
                            <option value="2" {{ request('storage') == '2' ? 'selected' : '' }}>128GB</option>
                            <option value="3" {{ request('storage') == '3' ? 'selected' : '' }}>256GB</option>
                            <option value="4" {{ request('storage') == '4' ? 'selected' : '' }}>512GB</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto flex-1 min-w-[150px]">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Mức giá</label>
                        <select name="price" id="price" class="filter-select w-full">
                            <option value="">Tất cả mức giá</option>
                            <option value="0-5000000" {{ request('price') == '0-5000000' ? 'selected' : '' }}>Dưới 5
                                triệu</option>
                            <option value="5000000-10000000"
                                {{ request('price') == '5000000-10000000' ? 'selected' : '' }}>5 - 10 triệu</option>
                            <option value="10000000-20000000"
                                {{ request('price') == '10000000-20000000' ? 'selected' : '' }}>10 - 20 triệu
                            </option>
                            <option value="20000000" {{ request('price') == '20000000' ? 'selected' : '' }}>Trên
                                20 triệu</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <button type="submit" class="btn btn-dark w-full sm:w-auto">
                            <i class="fas fa-check mr-2"></i> Áp dụng
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Danh sách sản phẩm -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 pt-4">
        @foreach ($products as $product)
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

        @if ($products->isEmpty())
            <div class="col-span-2 sm:col-span-3 md:col-span-4 lg:col-span-5 text-center py-8">
                <p class="text-1xl text-gray-500">Không có sản phẩm nào phù hợp với tiêu chí của bạn.</p>
            </div>
        @endif
    </div>
    @if ($products->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="flex items-center justify-between" aria-label="Pagination">
                {{ $products->onEachSide(1)->links() }}
            </nav>
        </div>
    @endif


    <style>
        .animate-marquee {
            animation: marquee 3s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .filter-select {
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            background-color: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .filter-select:focus {
            outline: none;
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.5);
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({
                filterOpen: false
            }))
        })
    </script>
</x-app-layout>
