<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard admin') }}
            </h2>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="alert alert-dark ml-4" x-transition
                    x-init="setTimeout(() => show = false, 1500)">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center justify-between p-6 text-gray-900">

                    <h2 class="font-semibold text-xl">
                        {{ __('Products manager') }}
                    </h2>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <a href="{{ route('products.create') }}" class="btn btn-dark flex-shrink-0">
                            <i class="fas fa-plus me-1"></i> Add new product
                        </a>

                        {{-- search --}}
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" placeholder="Search for products..."
                                class="form-control">
                        </div>

                        {{-- sortby --}}
                        <div class="dropdown" style="width: 150px; position: relative;">
                            <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i> Sort By
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100%;">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.orderby', ['data' => 'name', 'by' => 'ASC']) }}">
                                        <i class="fas fa-sort-alpha-down"></i> Name
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.orderby', ['data' => 'price', 'by' => 'ASC']) }}">
                                        <i class="fas fa-sort-amount-up"></i> Price up
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.orderby', ['data' => 'price', 'by' => 'DESC']) }}">
                                        <i class="fas fa-sort-amount-down"></i> Price down
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.orderby', ['data' => 'created_at', 'by' => 'DESC']) }}">
                                        <i class="fas fa-calendar-plus"></i> Latest
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.orderby', ['data' => 'created_at', 'by' => 'ASC']) }}">
                                        <i class="fas fa-calendar-minus"></i> Oldest
                                    </a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-bordered  table-hover text-center align-middle" id="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Image</th>
                                <th scope="col">Has Variants</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $p)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->price }}Vnđ</td>
                                    <td>{{ $p->category['name'] }}</td>
                                    <td><img src="{{ Storage::url($p->image) }}" alt="" width="100px"></td>
                                    <td>{{ $p->variants_count }} Variants</td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <!-- Nút Edit -->
                                        <a href="{{ route('products.edit', $p->id) }}" class="btn btn-dark btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Form Delete -->
                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {{ $products->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        let searchTimeout;
        const tableBody = document.querySelector('#table tbody');
        const originalTableHTML = tableBody.innerHTML;

        // Xử lý tìm kiếm
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);

            const searchTerm = this.value.trim();

            searchTimeout = setTimeout(() => {
                if (searchTerm === '') {
                    tableBody.innerHTML = originalTableHTML;
                    return;
                }

                tableBody.innerHTML = '<tr><td colspan="7">Loading...</td></tr>';

                fetch(`{{ route('products.search') }}?query=${encodeURIComponent(searchTerm)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(products => {
                        if (!products || products.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="7">No results found</td></tr>';
                            return;
                        }

                        let html = '';
                        products.forEach((product, index) => {
                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${escapeHtml(product.name)}</td>
                                <td>${escapeHtml(product.price)} Vnđ</td>
                                <td>${escapeHtml(product.category.name)}</td>
                                <td class="text-center">
                                    <img src="${product.image}" alt="" width="100px" style="display: block; margin: auto;">
                                </td>
                                <td>${product.variants_count} Variants</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="/admin/products/${product.id}/edit" class="btn btn-dark btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="/admin/products/${product.id}" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        });

                        tableBody.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        tableBody.innerHTML = '<tr><td colspan="7">Error loading data</td></tr>';
                    });
            }, 300);
        });

        // Hàm escape HTML để tránh lỗi XSS
        function escapeHtml(unsafe) {
            return unsafe?.toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;") || '';
        }
    </script>

</x-admin-layout>
