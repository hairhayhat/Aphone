<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard admin') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="alert alert-dark">{{ session('success') }}</div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container p-6">
                    <form class="needs-validation" novalidate method="post" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="mb-4 row">
                            <label for="name" class="col-sm-4 col-form-label fw-bold">Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Enter name" required />
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="overview" class="col-sm-4 col-form-label fw-bold">Overview</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" name="overview"
                                    id="overview" placeholder="Enter overview" required />
                                @error('overview')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="description" class="col-sm-4 col-form-label fw-bold">Description</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" placeholder="Enter description" required
                                    style="height: 150px"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 offset-sm-4 d-flex gap-3">
                                <button type="submit" class="btn btn-dark px-4">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>
                                <button type="reset" class="btn btn-outline-dark px-4">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap validation script -->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</x-admin-layout>
