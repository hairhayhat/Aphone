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
                        {{ __('Categories manager') }}
                    </h2>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <a href="{{ route('categories.create') }}" class="btn btn-dark flex-shrink-0">
                            <i class="fas fa-plus me-1"></i> Add new category
                        </a>

                        <div class="input-group flex-grow-1">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" placeholder="Search for categories..."
                                class="form-control">
                        </div>

                        <div class="dropdown" style="width: 150px; position: relative;">
                            <button class="btn btn-dark dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i> Sort By
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100%;">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('categories.orderby', ['data' => 'name', 'by' => 'ASC']) }}">
                                        <i class="fas fa-sort-alpha-down"></i> Name
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('categories.orderby', ['data' => 'products_count', 'by' => 'DESC']) }}">
                                        <i class="fas fa-sort-amount-up"></i> Most products
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('categories.orderby', ['data' => 'products_count', 'by' => 'ASC']) }}">
                                        <i class="fas fa-sort-amount-down"></i> Least products
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('categories.orderby', ['data' => 'created_at', 'by' => 'DESC']) }}">
                                        <i class="fas fa-calendar-plus"></i> Latest
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('categories.orderby', ['data' => 'created_at', 'by' => 'ASC']) }}">
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
                                <th scope="col">Overview</th>
                                <th scope="col">Has Products</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $cate)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $cate->name }}</td>
                                    <td>{{ $cate->overview }}</td>
                                    <td>{{ $cate->products_count }} Products</td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <!-- Nút Edit -->
                                        <a href="{{ route('categories.edit', $cate->id) }}"
                                            class="btn btn-dark btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Form Delete -->
                                        <form action="{{ route('categories.destroy', $cate->id) }}" method="POST"
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

                tableBody.innerHTML = '<tr><td colspan="5">Loading...</td></tr>';

                fetch(`{{ route('categories.search') }}?query=${encodeURIComponent(searchTerm)}`, {
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
                    .then(categories => {
                        if (!categories || categories.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="5">No results found</td></tr>';
                            return;
                        }

                        let html = '';
                        categories.forEach((category, index) => {

                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${escapeHtml(category.name)}</td>
                                <td>${escapeHtml(category.overview)}</td>
                                <td>${category.products_count}</td>
                                <td class="d-flex justify-content-center gap-2">
                                    <a href="/admin/categories/${category.id}/edit" class="btn btn-dark btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="/admin/categories/${category.id}" method="POST" class="d-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-dark btn-sm"
                                            onclick="return confirm('Are you sure?')">
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
                        tableBody.innerHTML = '<tr><td colspan="5">Error loading data</td></tr>';
                    });
            }, 300);
        });

        // Hàm escape HTML để phòng XSS
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
