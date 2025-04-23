<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <!-- Biểu tượng checkmark -->
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Nhận hàng thành công!</h2>

                    <p class="text-gray-600 mb-6">
                        Cảm ơn bạn đã mua sắm tại cửa hàng chúng tôi. Hy vọng bạn hài lòng với sản phẩm.
                    </p>

                    <div class="text-sm text-gray-500 mb-8">
                        <p>Mã đơn hàng: {{ $order->order_code }}</p>
                        <p>Ngày nhận hàng: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('home') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition duration-200">
                            <i class="fas fa-home mr-2"></i> Về trang chủ
                        </a>
                        <a href=""
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-clipboard-list mr-2"></i> Xem đơn hàng
                        </a>
                        <a href="{{ Route('user.comments.create', $order->id) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            <i class="fas fa-star mr-2"></i> Đánh giá sản phẩm
                        </a>
                    </div>

                    <!-- Nút bỏ qua (nếu cần) -->
                    <div class="mt-4">
                        <form action="" method="POST">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                                Bỏ qua, tôi sẽ đánh giá sau
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
