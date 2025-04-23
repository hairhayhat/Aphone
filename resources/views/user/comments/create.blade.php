<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Tiêu đề -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Để lại bình luận</h2>

                    <!-- Form bình luận -->
                    <form action="{{ route('user.comments.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label>Sản phẩm cần đánh giá</label>
                            <select name="product_id" class="form-control" required>
                                @foreach ($order->items as $item)
                                    <option value="{{ $item->product_id }}">
                                        {{ $item->product->name }} ({{ $item->quantity }}x)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Đánh giá sao -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Đánh giá</label>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="text-gray-400 hover:text-yellow-400 focus:outline-none star-rating"
                                        data-rating="{{ $i }}">
                                        <i class="far fa-star text-2xl"></i>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="rating-value" value="0">
                            </div>
                        </div>

                        <!-- Nội dung bình luận -->
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 text-sm font-medium mb-2">Nội dung bình
                                luận</label>
                            <textarea name="content" id="content" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Hãy chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                        </div>


                        <!-- Nút gửi -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-paper-plane mr-2"></i> Gửi bình luận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script xử lý đánh giá sao -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating');
            const ratingInput = document.getElementById('rating-value');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;

                    // Cập nhật hiển thị sao
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.innerHTML =
                                '<i class="fas fa-star text-2xl text-yellow-400"></i>';
                        } else {
                            s.innerHTML =
                                '<i class="far fa-star text-2xl text-gray-400"></i>';
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
