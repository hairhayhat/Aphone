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
                        {{ __('User manager') }}
                    </h2>
                    <div class="d-flex align-items-center gap-3 mb-3">

                        {{-- search --}}
                        <div class="input-group flex-grow-1">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="searchInput" placeholder="Search for users..."
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
                                        href="{{ route('user.orderby', ['data' => 'name', 'by' => 'ASC']) }}">
                                        <i class="fas fa-sort-alpha-down"></i> Name
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('user.orderby', ['data' => 'created_at', 'by' => 'DESC']) }}">
                                        <i class="fas fa-calendar-plus"></i> Latest
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('user.orderby', ['data' => 'created_at', 'by' => 'ASC']) }}">
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
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <button type="button" class="btn btn-dark btn-sm"
                                            onclick="openModal('{{ $user->id }}','{{ $user->role === 'admin' ? 'user' : 'admin' }}')">
                                            {{ $user->role === 'admin' ? 'Xóa quyền' : 'Cấp quyền' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="passwordConfirmModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 ">
            <h3 class="text-lg font-medium mb-4">Xác nhận mật khẩu</h3>
            <form id="confirmPasswordForm">
                @csrf
                <input type="hidden" id="modal_new_role" name="new_role">
                <input type="hidden" id="modal_new_id" name="user_id">

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu của bạn</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-md">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-dark rounded-md">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let searchTimeout;

        function openModal(userId, newRole) {
            document.getElementById('modal_new_role').value = newRole;
            document.getElementById('modal_new_id').value = userId;
            document.getElementById('passwordConfirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('passwordConfirmModal').classList.add('hidden');
        }

        document.getElementById('confirmPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this)

            fetch("{{ route('user.confirmPassword') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Mật khẩu không trùng khớp')
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        const originalTableHTML = document.querySelector('#table tbody').innerHTML;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const searchTerm = this.value;

                if (searchTerm === '') {
                    document.querySelector('#table tbody').innerHTML = originalTableHTML;
                    return;
                }

                fetch(`{{ route('user.search') }}?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(users => {
                        const tableBody = document.querySelector('#table tbody');
                        tableBody.innerHTML = '';

                        users.forEach((user, index) => {
                            const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button type="button" class="btn btn-dark"
                                    onclick="openModal('${user.id}', '${user.role === 'admin' ? 'user' : 'admin'}')">
                                    ${user.role === 'admin' ? 'Xóa quyền' : 'Cấp quyền'}
                                </button>
                            </td>
                        </tr>
                    `;
                            tableBody.innerHTML += row;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });
    </script>
</x-admin-layout>
