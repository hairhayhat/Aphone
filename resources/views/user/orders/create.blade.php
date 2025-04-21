<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Đặt hàng</h1>

        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
            <h2 class="text-xl font-semibold mb-4">Thông tin sản phẩm</h2>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-50 rounded-lg">
                </div>
                <div class="w-full md:w-2/3">
                    <h3 class="text-lg font-medium">{{ $product->name }}</h3>
                    <p class="text-gray-600 mt-2">
                        <span class="font-medium">Màu:</span> {{ $variant->color->color }} -
                        <span class="font-medium">Dung lượng:</span> {{ $variant->storage->storage }}
                    </p>
                    <p class="text-gray-600 mt-1">
                        <span class="font-medium">Số lượng:</span> {{ $quantity }}
                    </p>
                    <p class="text-gray-600 mt-1">
                        <span class="font-medium">Giá:</span> {{ number_format($variant->price, 0, ',', '.') }} ₫
                    </p>
                    <p class="text-lg font-bold mt-2">
                        <span class="font-medium">Thành tiền:</span>
                        {{ number_format($quantity * $variant->price, 0, ',', '.') }} ₫
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Thông tin đặt hàng</h2>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <!-- Thông tin sản phẩm ẩn để gửi đi -->
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="price" value="{{ $variant->price }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="total" value="{{ $quantity * $variant->price }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="customer_name" class="block text-gray-700 font-medium mb-2">Họ tên *</label>
                            <input type="text" id="customer_name" name="customer_name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500"
                                value="{{ auth()->user()->name ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="customer_phone" class="block text-gray-700 font-medium mb-2">Số điện thoại
                                *</label>
                            <input type="tel" id="customer_phone" name="customer_phone"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500"
                                value="+84{{ auth()->user()->phone ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="customer_email" class="block text-gray-700 font-medium mb-2">Email *</label>
                            <input type="email" id="customer_email" name="customer_email"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500"
                                value="{{ auth()->user()->email ?? '' }}" required>
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <label for="shipping_address" class="block text-gray-700 font-medium mb-2">Địa chỉ giao hàng
                                *</label>
                            <textarea id="shipping_address" name="shipping_address" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700 font-medium mb-2">Phương thức thanh
                                toán *</label>
                            <select id="payment_method" name="payment_method"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500"
                                required>
                                <option value="">-- Chọn phương thức --</option>
                                <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                                <option value="momo">Ví điện tử MoMo</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-gray-700 font-medium mb-2">Ghi chú</label>
                            <textarea id="note" name="note" rows="2"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-dark-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-dark text-white font-medium rounded-lg hover:bg-dark focus:outline-none focus:ring-2 focus:ring-darkfocus:ring-offset-2">
                        Đặt hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
