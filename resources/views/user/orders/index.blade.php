<x-app-layout>
    <div class="bg-white rounded-lg shadow-md p-4 mb-4">
        <h1 class="text-2xl font-bold mb-4">Quản lý đơn hàng</h1>
        <div class="d-flex align-items-center flex-wrap gap-2 mb-4">

            <!-- Pending -->
            <form action="{{ route('user.orders.orderIndex') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="hidden" name="status" value="pending">
                <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                    @if (request('status') == 'pending') style="background-color: #000000; color: #ffffff;" @endif>
                    <i class="fas fa-clock me-1"></i>
                    Chờ xử lý
                    @if ($totalPendingOrders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalPendingOrders }}
                        </span>
                    @endif
                </button>
            </form>

            <!-- Processing -->
            <form action="{{ route('user.orders.orderIndex') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="hidden" name="status" value="processing">
                <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                    @if (request('status') == 'processing') style="background-color: #000000; color: #ffffff;" @endif>
                    <i class="fas fa-cog me-1"></i>
                    Đang xử lý
                    @if ($totalProcessingOrders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalProcessingOrders }}
                        </span>
                    @endif
                </button>
            </form>

            <!-- Shipped -->
            <form action="{{ route('user.orders.orderIndex') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="hidden" name="status" value="shipped">
                <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                    @if (request('status') == 'shipped') style="background-color: #000000; color: #ffffff;" @endif>
                    <i class="fas fa-truck me-1"></i>
                    Đang giao
                    @if ($totalShippedOrders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalShippedOrders }}
                        </span>
                    @endif
                </button>
            </form>

            <!-- Delivered -->
            <form action="{{ route('user.orders.orderIndex') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="hidden" name="status" value="delivered">
                <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                    @if (request('status') == 'delivered') style="background-color: #000000; color: #ffffff;" @endif>
                    <i class="fas fa-check-circle me-1"></i>
                    Đã nhận
                    @if ($totalDeliveredOrders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalDeliveredOrders }}
                        </span>
                    @endif
                </button>
            </form>

            <!-- Cancelled -->
            <form action="{{ route('user.orders.orderIndex') }}" method="GET">
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                    @if (request('status') == 'cancelled') style="background-color: #000000; color: #ffffff;" @endif>
                    <i class="fas fa-times-circle me-1"></i>
                    Đã hủy
                    @if ($totalCancelledOrders > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $totalCancelledOrders }}
                        </span>
                    @endif
                </button>
            </form>
        </div>
    </div>
    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($orders as $order)
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Đơn hàng {{ $loop->iteration }} -
                                <p class="text-sm text-gray-500">
                                    (Mã đơn {{ $order->order_code }})
                                </p>
                            </h3>
                            <p class="text-sm text-gray-500">
                                Đặt vào {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>

                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium
                                    @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                            {{ __(ucfirst($order->status)) }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700 mb-2">Sản phẩm</h4>
                        <ul class="space-y-2">
                            @foreach ($order->items as $item)
                                <li class="flex items-center py-2">
                                    <!-- Hình ảnh sản phẩm -->
                                    <div class="flex-shrink-0 mr-3">
                                        <img src="{{ Storage::url($item->product->image) }}"
                                            alt="{{ $item->product->name }}" width="50" height="50">
                                    </div>

                                    <!-- Thông tin sản phẩm -->
                                    <div class="flex-grow flex justify-between items-center">
                                        <span
                                            class="text-gray-800">{{ $item->product->name }}-{{ $item->color }}-{{ $item->storage }}
                                            ×
                                            {{ $item->quantity }}</span>
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="font-medium">Tổng cộng:</span>
                        <span class="font-bold text-lg">{{ number_format($order->total) }}đ</span>
                    </div>
                    <div class="mt-4 flex justify-end gap-2">
                        @if (in_array($order->status, ['pending', 'processing']))
                            <a href="" class="px-4 py-2 bg-dark text-white rounded-lg">
                                Xem chi tiết
                            </a>
                            <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200
                                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Hủy đơn hàng
                                </button>
                            </form>
                        @endif

                        @if ($order->status == 'shipped')
                            <a href="" class="px-4 py-2 bg-dark text-white rounded-lg">
                                Theo dõi đơn hàng
                            </a>
                            <form action="{{ route('user.orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200
                                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Nhận hàng thành công
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Không có đơn hàng nào</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
    @if (session('success'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-down">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" class="ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-down">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
                <button onclick="this.parentElement.remove()" class="ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const alerts = document.querySelectorAll('[class*="fixed top-4 right-4"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    });
</script>
