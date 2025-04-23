<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between p-6 text-gray-900">
                    <h2 class="font-semibold text-xl">
                        {{ __('Order Details') }} #{{ $order->order_code }}
                    </h2>
                    <div class="text-sm text-gray-500">
                        Đặt hàng: {{ $order->created_at->format('F j, Y \a\t g:i a') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        Nhận hàng: {{ $order->updated_at->format('F j, Y \a\t g:i a') }}
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Customer Information -->
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-medium mb-2">{{ __('Customer Information') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="font-medium">{{ __('Name') }}</p>
                                <p>{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('Email') }}</p>
                                <p>{{ $order->customer_email }}</p>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('Phone') }}</p>
                                <p>{{ $order->customer_phone }}</p>
                            </div>
                            <div>
                                <p class="font-medium">{{ __('Address') }}</p>
                                <p>{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-medium mb-2">{{ __('Order Items') }}</h3>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-md overflow-hidden">
                                            @if ($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">Màu: {{ $item->color }}</p>
                                            <p class="text-sm text-gray-500">Dung Lượng: {{ $item->storage }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p>{{ $item->quantity }} × {{ number_format($item->price, 2) }}</p>
                                        <p class="font-medium">{{ number_format($item->quantity * $item->price, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($comment)
                            <div>
                                <h3 class="text-lg font-medium mb-2">{{ __('Phản hồi từ khách hàng') }}</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">{{ __('Content') }}:</span> {{ $comment->content }}
                                    </p>
                                    <p><span class="font-medium">{{ __('Rating') }}:</span>
                                        {{ $comment->rating }} sao</p>
                                    <p><span class="font-medium">{{ __('Status') }}:</span>
                                        <span
                                            class="px-2 py-1 text-sm rounded-full
                                        {{ $comment->status === 'pending' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $comment->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $comment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($comment->status) }}
                                        </span>
                                    </p>
                                    <p><span class="font-medium">{{ __('Vào lúc') }}:</span>
                                        {{ $comment->created_at->format('F j, Y \a\t g:i a') }}</p>

                                    @if ($comment->status != 'approved')
                                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ __('Đồng ý') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                {{ __('Từ chối') }}
                                            </button>
                                        </form>
                                    @endif


                                </div>
                            </div>
                        @else
                            <div>
                                <h3 class="text-lg font-medium mb-2">{{ __('Chưa có bình luận') }}</h3>
                                <p>{{ __('khách hàng chưa phản hồi sản phẩm.') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Actions -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('orders.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            {{ __('Back to Orders') }}
                        </a>
                        @if ($order->status === 'processing')
                            <form action="{{ route('orders.complete', $order) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    {{ __('Mark as Completed') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
