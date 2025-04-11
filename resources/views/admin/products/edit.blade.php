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
                        {{ __('Trang thêm sản phẩm') }}
                    </h2>
                </div>

                <div class="table-responsive p-3">
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')

                        <!-- Thông tin cơ bản -->
                        <div class="mb-4 row">
                            <label for="name" class="col-sm-4 col-form-label fw-bold">Tên sản phẩm</label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Nhập tên sản phẩm" required
                                    value="{{ $product->name }}" />
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="price" class="col-sm-4 col-form-label fw-bold">Giá cơ bản</label>
                            <div class="col-sm-8">
                                <input type="number"
                                    class="form-control form-control-lg @error('price') is-invalid @enderror"
                                    name="price" id="price" placeholder="Nhập giá" value="{{ $product->price }}"
                                    required />
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="category_id" class="col-sm-4 col-form-label fw-bold">Loại</label>
                            <div class="col-sm-8">
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id" id="category_id" required>
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id }}"
                                            {{ $product->category_id === $cate->id ? 'selected' : '' }}>
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="image" class="col-sm-4 col-form-label fw-bold">Hình ảnh</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" />
                                @if ($product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                            class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="image" class="col-sm-4 col-form-label fw-bold">Show home</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('is_showhome') is-invalid @enderror"
                                        type="radio" name="is_showhome" id="is_showhome_yes" value="1"
                                        {{ $product->is_showhome ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="is_showhome_yes">Có</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('is_showhome') is-invalid @enderror"
                                        type="radio" name="is_showhome" id="is_showhome_no" value="0"
                                        {{ !$product->is_showhome ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="is_showhome_no">Không</label>
                                </div>
                                @error('is_showhome')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="description" class="col-sm-4 col-form-label fw-bold">Mô tả</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả sản phẩm" required
                                    style="height: 150px">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 border-top pt-4">
                            <h4 class="fw-bold mb-3">Biến thể sản phẩm</h4>

                            <div id="variants-container">
                                @foreach ($product->variants as $v)
                                    <div class="variant-item border p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0">Biến thể #<span
                                                    class="variant-number">{{ $loop->iteration }}</span></h5>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger delete-variant-btn"
                                                data-url="{{ route('products.destroy_variant', $v->id) }}">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label>Giá</label>
                                                <input type="number" name="variants[0][price]" class="form-control"
                                                    value="{{ $v->price }}" required>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label>Số lượng</label>
                                                <input type="number" name="variants[0][quantity]"
                                                    class="form-control" value="{{ $v->quantity }}" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Màu sắc</label>
                                                <select name="variants[{{ $loop->index }}][color_id]"
                                                    class="form-select" required>
                                                    <option value="">Chọn màu</option>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}"
                                                            {{ $v->color_id == $color->id ? 'selected' : '' }}>
                                                            {{ $color->color }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Dung lượng</label>
                                                <select name="variants[{{ $loop->index }}][storage_id]"
                                                    class="form-select" required>
                                                    <option value="">Chọn dung lượng</option>
                                                    @foreach ($storages as $storage)
                                                        <option value="{{ $storage->id }}"
                                                            {{ $v->storage_id == $storage->id ? 'selected' : '' }}>
                                                            {{ $storage->storage }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-variant" class="btn btn-outline-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Thêm biến thể
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 offset-sm-4 d-flex gap-3">
                                <button type="submit" class="btn btn-dark px-4">
                                    <i class="bi bi-save me-2"></i> Lưu sản phẩm
                                </button>
                                <button type="reset" class="btn btn-outline-dark px-4">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i> Đặt lại
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="variant-template" class="d-none">
                        <div class="variant-item border p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Biến thể #<span class="variant-number">1</span></h5>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-variant">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label>Giá</label>
                                    <input type="number" name="variants[__INDEX__][price]" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Số lượng</label>
                                    <input type="number" name="variants[__INDEX__][quantity]" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Màu sắc</label>
                                    <select name="variants[__INDEX__][color_id]" class="form-select" required>
                                        <option value="">Chọn màu</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->color }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Dung lượng</label>
                                    <select name="variants[__INDEX__][storage_id]" class="form-select" required>
                                        <option value="">Chọn dung lượng</option>
                                        @foreach ($storages as $storage)
                                            <option value="{{ $storage->id }}">{{ $storage->storage }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantsContainer = document.getElementById('variants-container');
            const variantTemplate = document.getElementById('variant-template');
            const addVariantBtn = document.getElementById('add-variant');

            // Thêm biến thể mới
            if (addVariantBtn) {
                addVariantBtn.addEventListener('click', function() {
                    const currentCount = variantsContainer.querySelectorAll('.variant-item').length;
                    const newVariant = variantTemplate.innerHTML
                        .replace(/__INDEX__/g, currentCount)
                        .replace(/d-none/g, '');

                    const div = document.createElement('div');
                    div.innerHTML = newVariant;
                    variantsContainer.appendChild(div.firstElementChild);

                    updateVariantNumbers();
                });
            }

            // Xử lý xóa biến thể
            variantsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-variant')) {
                    e.preventDefault();
                    const variantItem = e.target.closest('.variant-item');
                    if (confirm('Bạn có chắc muốn xóa biến thể này?')) {
                        variantItem.remove();
                        updateVariantNumbers();
                    }
                }
            });

            // Cập nhật số thứ tự và name attributes
            function updateVariantNumbers() {
                document.querySelectorAll('.variant-item').forEach((item, index) => {
                    // Cập nhật số thứ tự hiển thị
                    const numberElement = item.querySelector('.variant-number');
                    if (numberElement) {
                        numberElement.textContent = index + 1;
                    }

                    // Cập nhật tên trường form
                    item.querySelectorAll('[name]').forEach(input => {
                        const name = input.getAttribute('name');
                        if (name.includes('variants')) {
                            input.setAttribute('name', name.replace(/variants\[\d+\]/,
                                `variants[${index}]`));
                        }
                    });
                });
            }

            const mainForm = document.querySelector('form.needs-validation');
            if (mainForm) {
                mainForm.addEventListener('submit', function(event) {
                    // Bỏ qua nếu là submit từ form xóa
                    if (event.submitter && event.submitter.closest('.delete_variant_form')) {
                        return;
                    }

                    if (!this.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    this.classList.add('was-validated');
                }, false);
            }

        });
        document.querySelectorAll('.delete-variant-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                if (!confirm('Bạn chắc chắn muốn xóa biến thể này?')) {
                    return;
                }

                const variantItem = this.closest('.variant-item');
                const deleteUrl = this.dataset.url;

                try {
                    const response = await fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Lỗi khi xóa biến thể');
                    }

                    if (data.success) {
                        // Hiệu ứng xóa mượt mà
                        variantItem.style.transition = 'all 0.3s';
                        variantItem.style.opacity = '0';
                        setTimeout(() => {
                            variantItem.remove();
                            updateVariantNumbers();
                        }, 300);

                        // Hiển thị thông báo thành công
                        showToast('success', data.message);
                    } else {
                        throw new Error(data.message || 'Xóa không thành công');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('error', error.message);
                }
            });
        });
    </script>
</x-admin-layout>
