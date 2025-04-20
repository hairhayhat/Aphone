<x-app-layout>
    <div class="categories-slider">
        @foreach ($categories as $category)
            <div class="slider-item relative" tabindex="-1">
                <img src="{{ Storage::url($category->thumbnail) }}" alt="{{ $category->name }}"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 flex flex-col justify-between p-5">
                    <div class="text-center">
                        <h1 class="text-white text-3xl font-bold">{{ $category->name }}</h1>
                    </div>
                    <div class="self-start max-w-[80%]">
                        <p class="text-white text-left break-words">{{ $category->overview }}</p>
                        <button class="btn btn-dark mt-2">Truy cập</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 p-4 sm:p-8 bg-white shadow overflow-hidden">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="card flex-1">
                <div class="card-body">
                    <h5 class="card-title text-center text-1xl font-bold">Chúng tôi là ai?</h5>
                    <p class="card-text text-center">Chúng tôi là một cửa hàng chuyên cung cấp các sản phẩm công nghệ
                        chính
                        hãng, đặc biệt là iPhone. Với cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất,
                        chúng
                        tôi luôn nỗ lực để đáp ứng mọi nhu cầu của bạn.</p>
                    <a href="#" class="btn btn-dark flex justify-center">Tìm hiểu thêm</a>
                </div>
            </div>
            <div class="card flex-1">
                <div class="card-body">
                    <h5 class="card-title text-center text-1xl font-bold">Chúng tôi là ai?</h5>
                    <p class="card-text text-center">Chúng tôi là một cửa hàng chuyên cung cấp các sản phẩm công nghệ
                        chính
                        hãng, đặc biệt là iPhone. Với cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất,
                        chúng
                        tôi luôn nỗ lực để đáp ứng mọi nhu cầu của bạn.</p>
                    <a href="#" class="btn btn-dark flex justify-center">Tìm hiểu thêm</a>
                </div>
            </div>
            <div class="card flex-1">
                <div class="card-body">
                    <h5 class="card-title text-center text-1xl font-bold">Chúng tôi là ai?</h5>
                    <p class="card-text text-center">Chúng tôi là một cửa hàng chuyên cung cấp các sản phẩm công nghệ
                        chính
                        hãng, đặc biệt là iPhone. Với cam kết mang đến cho khách hàng những sản phẩm chất lượng nhất,
                        chúng
                        tôi luôn nỗ lực để đáp ứng mọi nhu cầu của bạn.</p>
                    <a href="#" class="btn btn-dark flex justify-center">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 p-1 sm:p-8 bg-gray-100 overflow-hidden">
        <div class="flex justify-between items-center space-x-4">
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-mobile text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">iPhone</span>
            </div>
            <div class="h-16 border-l border-gray-300"></div>
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-laptop text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">MacBook</span>
            </div>
            <div class="h-16 border-l border-gray-300"></div>
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-tablet text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">iPad</span>
            </div>
            <div class="h-16 border-l border-gray-300"></div>
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-headphones text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">AirPods</span>
            </div>
            <div class="h-16 border-l border-gray-300"></div>
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-clock text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">Apple Watch</span>
            </div>
            <div class="h-16 border-l border-gray-300"></div>
            <div class="flex flex-col items-center space-y-2">
                <a href="#"
                    class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-lg shadow hover:shadow-md transition-all">
                    <i class="fa fa-television text-dark text-3xl" aria-hidden="true"></i>
                </a>
                <span class="text-sm font-medium text-dark">Apple TV</span>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white shadow overflow-hidden">
        <div class="flex flex-col sm:flex-row">
            <div class="iphone_slick w-[70%]">
                <img src="{{ asset('images/iphone1.jpg') }}" alt="iPhone" class="w-full h-full object-cover">
                <img src="{{ asset('images/iphone2.jpg') }}" alt="iPhone" class="w-full h-full object-cover">
            </div>

            <div class="w-[30%] p-4 pb-2 sm:p-8">
                <p class="text-gray-600 mb-4">Cửa hàng chúng tôi chuyên cung cấp các dòng iPhone chính hãng với cam kết
                    về chất lượng và uy tín. Các sản phẩm iPhone tại đây đều đảm bảo hiệu suất mạnh mẽ, được trang bị
                    chip xử lý tiên tiến cho tốc độ mượt mà, đáp ứng mọi nhu cầu từ công việc đến giải trí. Thiết kế bền
                    bỉ với khung nhôm và kính cường lực giúp iPhone trở thành một lựa chọn an toàn và lâu dài. Ngoài ra,
                    iPhone còn nổi bật với màn hình Retina sắc nét, âm thanh sống động, và thời lượng pin ấn tượng. Tất
                    cả sản phẩm đều được bảo hành chính hãng và hỗ trợ cập nhật iOS lâu dài, mang đến trải nghiệm tốt
                    nhất cho khách hàng. Hãy đến với chúng tôi để sở hữu ngay chiếc iPhone chính hãng đáng tin cậy!</p>
                <div class="btn btn-dark">Ghé trang sản phẩm </div>
            </div>
        </div>
    </div>

    <div class="mt-4 bg-white shadow overflow-hidden">
        <div class="banner relative w-full h-[100px]">
            <img src="{{ asset('images/banner.jpg') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 flex justify-start items-center pl-8 space-x-24">
                <h3 class="text-white text-2xl  italic">Uy tín </h3>
                <h3 class="text-white text-2xl font-bold">-</h3>
                <h3 class="text-white text-2xl  italic">An toàn</h3>
                <h3 class="text-white text-2xl font-bold">-</h3>
                <h3 class="text-white text-2xl  italic">Giá rẻ</h3>
            </div>
        </div>
    </div>

    <div class="mt-4 bg-white shadow overflow-hidden">
        <h1 class="text-2xl text-center mb-4 pt-4">Sản phẩm nổi bật</h1>
        <hr>
        <div class="flex flex-col md:flex-row">
            <!-- Phần 1 -->
            <div class="w-full md:w-[50%] p-2 bg-white border-r border-gray-200">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-[50%] p-4">
                        <h1 class="text-black text-1xl font-bold">{{ $products[0]->name }}</h1>
                        <p class="italic">{{ $products[0]->description }}</p>
                        <div class="price-and-storage">
                            <p class="text-black text-xl font-bold mb-3">
                                {{ number_format($products[0]->price, 0, '', '.') }}đ
                            </p>
                            <div class="space-y-3">
                                @foreach ($products[0]->variants->groupBy('storage.storage') as $storage => $variants)
                                    <div class="storage-group">
                                        <p class="font-medium text-gray-800">{{ $storage }}</p>
                                        <div class="flex flex-wrap items-center gap-2 mt-1">
                                            @foreach ($variants->groupBy('color.code') as $colorCode => $colorVariants)
                                                <div class="flex items-center gap-1">
                                                    <div class="w-4 h-4 border border-gray-300 rounded-sm"
                                                        style="background-color: {{ $colorCode }}"
                                                        title="{{ $colorVariants->first()->color->name ?? 'Màu' }}">
                                                    </div>
                                                    @if ($colorVariants->first()->color->name)
                                                        <span class="text-xs text-gray-600">
                                                            {{ $colorVariants->first()->color->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-dark">Mua ngay</button>
                            <button class="btn btn-light">Xem thêm</button>
                        </div>
                    </div>
                    <div class="w-full md:w-[50%] p-4">
                        <img src="{{ Storage::url($products[0]->image) }}" alt="{{ $products[0]->name }}"
                            class="w-full h-auto">
                    </div>
                </div>
            </div>

            <!-- Phần 2 -->
            <div class="w-full md:w-[50%] p-2 bg-white">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-[50%] p-4">
                        <h1 class="text-black text-1xl font-bold">{{ $products[1]->name }}</h1>
                        <p class="italic">{{ $products[1]->description }}</p>
                        <div class="price-and-storage">
                            <p class="text-black text-xl font-bold mb-3">
                                {{ number_format($products[1]->price, 0, '', '.') }}đ
                            </p>
                            <div class="space-y-3">
                                @foreach ($products[1]->variants->groupBy('storage.storage') as $storage => $variants)
                                    <div class="storage-group">
                                        <p class="font-medium text-gray-800">{{ $storage }}</p>
                                        <div class="flex flex-wrap items-center gap-2 mt-1">
                                            @foreach ($variants->groupBy('color.code') as $colorCode => $colorVariants)
                                                <div class="flex items-center gap-1">
                                                    <div class="w-4 h-4 border border-gray-300 rounded-sm"
                                                        style="background-color: {{ $colorCode }}"
                                                        title="{{ $colorVariants->first()->color->name ?? 'Màu' }}">
                                                    </div>
                                                    @if ($colorVariants->first()->color->name)
                                                        <span class="text-xs text-gray-600">
                                                            {{ $colorVariants->first()->color->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-dark">Mua ngay</button>
                            <button class="btn btn-light">Xem thêm</button>
                        </div>
                    </div>
                    <div class="w-full md:w-[50%] p-4">
                        <img src="{{ Storage::url($products[1]->image) }}" alt="{{ $products[1]->name }}"
                            class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-3xl font-bold text-left mt-6">Top sản phẩm đang sale</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 pt-4">
        @foreach ($productsIsSale as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 relative">
                @if ($product->is_sale)
                    <div class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
                        SALE {{ $product->sale_price }}%
                    </div>
                @else
                    <div
                        class="absolute top-0 left-0 bg-gray-800 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
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

                        <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="far fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h1 class="text-3xl font-bold text-left mt-6">Top sản phẩm được yêu thích nhất</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 pt-4">
        @foreach ($productsPopular as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 relative">
                @if ($product->is_sale)
                    <div
                        class="absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
                        SALE {{ $product->sale_price }}%
                    </div>
                @else
                    <div
                        class="absolute top-0 left-0 bg-gray-800 text-white px-2 py-1 text-xs font-bold rounded-br-lg">
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

                        <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="far fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


</x-app-layout>

<script>
    $(document).ready(function() {
        $('.categories-slider').slick({
            dots: false,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
        });
        $('.iphone_slick').slick({
            dots: false,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 10000,
        });


    });
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');

            fetch(`/products/${productId}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('far', !data.liked);
                    icon.classList.toggle('fas', data.liked);
                    icon.classList.toggle('text-red-500', data.liked);

                });
        });
    });
</script>
