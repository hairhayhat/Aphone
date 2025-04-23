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
                        {{ __('Order manager') }}
                    </h2>
                    <div class="d-flex align-items-center flex-wrap gap-2 mb-4">

                        <!-- Pending -->
                        <form action="{{ route('orders.orderIndex') }}" method="GET">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                                @if (request('status') == 'pending') style="background-color: #000000; color: #ffffff;" @endif>
                                <i class="fas fa-clock me-1"></i>
                                Pending
                                @if ($totalPendingOrders > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalPendingOrders }}
                                    </span>
                                @endif
                            </button>
                        </form>

                        <!-- Processing -->
                        <form action="{{ route('orders.orderIndex') }}" method="GET">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="hidden" name="status" value="processing">
                            <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                                @if (request('status') == 'processing') style="background-color: #000000; color: #ffffff;" @endif>
                                <i class="fas fa-cog me-1"></i>
                                Processing
                                @if ($totalProcessingOrders > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalProcessingOrders }}
                                    </span>
                                @endif
                            </button>
                        </form>

                        <!-- Shipped -->
                        <form action="{{ route('orders.orderIndex') }}" method="GET">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="hidden" name="status" value="shipped">
                            <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                                @if (request('status') == 'shipped') style="background-color: #000000; color: #ffffff;" @endif>
                                <i class="fas fa-truck me-1"></i>
                                Shipping
                                @if ($totalShippedOrders > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalShippedOrders }}
                                    </span>
                                @endif
                            </button>
                        </form>

                        <!-- Delivered -->
                        <form action="{{ route('orders.orderIndex') }}" method="GET">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                                @if (request('status') == 'delivered') style="background-color: #000000; color: #ffffff;" @endif>
                                <i class="fas fa-check-circle me-1"></i>
                                Delivered
                                @if ($totalDeliveredOrders > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalDeliveredOrders }}
                                    </span>
                                @endif
                            </button>
                        </form>

                        <!-- Cancelled -->
                        <form action="{{ route('orders.orderIndex') }}" method="GET">
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-outline-dark border-2 position-relative"
                                @if (request('status') == 'cancelled') style="background-color: #000000; color: #ffffff;" @endif>
                                <i class="fas fa-times-circle me-1"></i>
                                Cancelled
                                @if ($totalCancelledOrders > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalCancelledOrders }}
                                    </span>
                                @endif
                            </button>
                        </form>
                    </div>

                </div>




                <div class="table-responsive p-3">
                    <table class="table table-bordered  table-hover text-center align-middle" id="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Code</th>
                                <th scope="col">User</th>
                                <th scope="col">Products</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Paymen Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No orders found</td>
                                </tr>
                            @else
                                @foreach ($orders as $order)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td>
                                            <p class="text-sm">{{ $order->user->email }}</p>
                                            <p class="text-sm">{{ $order->customer_phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm">
                                                @foreach ($order->items as $item)
                                                    {{ $item->product->name }}-{{ $item->color }}-{{ $item->storage }}
                                                    (SL: {{ $item->quantity }})
                                                    <br>
                                                @endforeach
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm">{{ number_format($order->total, 0, ',', '.') }} VND</p>
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($order->status == 'processing')
                                                <span class="badge bg-info text-dark">Processing</span>
                                            @elseif ($order->status == 'shipped')
                                                <span class="badge bg-primary text-white">Shipped</span>
                                            @elseif ($order->status == 'delivered')
                                                <span class="badge bg-success text-white">Delivered</span>
                                            @else
                                                <span class="badge bg-danger text-white">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->payment_status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($order->payment_status == 'paid')
                                                <span class="badge bg-success text-white">Paid</span>
                                            @else
                                                <span class="badge bg-danger text-white">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <form action="{{ route('orders.changeStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-dark btn-sm">Pended</button>
                                                </form>
                                            @elseif($order->status == 'processing')
                                                <form action="{{ route('orders.changeStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-dark btn-sm">Processed</button>
                                                </form>
                                            @elseif($order->status == 'shipped')
                                                <form action="{{ route('orders.changeStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-dark btn-sm">Order
                                                        tracking</button>
                                                </form>
                                            @elseif($order->status == 'delivered')
                                                <a href="{{ route('admin.comments.showComment', $order->id) }}"
                                                    class="btn btn-dark">Xem đánh giá</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
