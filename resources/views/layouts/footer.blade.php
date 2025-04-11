<footer class="bg-white text-dark py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3">Về chúng tôi</h5>
                <p class="text-muted">Công ty chuyên cung cấp các sản phẩm công nghệ chất lượng cao với giá cả hợp lý.
                </p>
            </div>

            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3">Liên hệ</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận 1, TP.HCM
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2"></i> (028) 1234 5678
                    </li>
                    <li>
                        <i class="fas fa-envelope me-2"></i> info@example.com
                    </li>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="mb-3">Theo dõi chúng tôi</h5>
                <div class="social-links">
                    <a href="#" class="text-dark me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-linkedin-in fa-lg"></i></a>
                </div>

                <div class="mt-4">
                    <h5 class="mb-3">Đăng ký nhận tin</h5>
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Email của bạn">
                        <button type="submit" class="btn btn-outline-light">Gửi</button>
                    </form>
                </div>
            </div>
        </div>

        <hr class="my-4 bg-light">

        <div class="text-center">
            <p class="mb-0">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Bảo lưu mọi quyền.
                <a href="#" class="text-dark ms-2">Chính sách bảo mật</a>
                <a href="#" class="text-dark ms-2">Điều khoản sử dụng</a>
            </p>
        </div>
    </div>
</footer>
