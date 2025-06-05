<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Thêm CSRF Token cho các request AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Liên kết Font Awesome (đảm bảo chỉ có một link) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <title>Tiệm Bánh Ngọt - Bánh Kem Thơm Ngon!</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    {{-- Script Font Awesome này có thể bị trùng với link CDN ở trên, nên cân nhắc xóa nếu không cần --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    {{-- Phần tử để hiển thị thông báo lỗi/thành công --}}
    <div id="app-notification" class="app-notification" style="display: none;">
        <span id="notification-message"></span>
        <button class="close-notification-btn">&times;</button>
    </div>

    <header class="top-bar">
        <div class="container">
            <div class="user-actions">
                <a href="#" class="action-item open-sidebar-btn">
                    <i class="fas fa-light fa-bars fa-xl" style="color: #ffffff"></i>
                </a>
            </div>
            <div id="sidebar-menu" class="sidebar">
                <div class="sidebar-header">
                    <span class="close-btn" id="close-sidebar">&times;</span>
                    <h3>Ngọc Ánh</h3>
                </div>
                <ul class="menu-list">
                    <li><a href="#">Bánh Sinh Nhật</a></li>
                    <li><a href="#">Bánh Sự Kiện</a></li>
                    <li><a href="#">Bánh Hoa Quả</a></li>
                    <li><a href="#">Bánh Vẽ và Tạo Hình</a></li>
                    <li><a href="#">Bánh Bento</a></li>
                    <li><a href="#">Phụ Kiện Bánh</a></li>
                </ul>
                <div class="contact-info">
                    <p>Bạn cần hỗ trợ?</p>
                    <p><i class="fas fa-phone"></i> 0862398217</p>
                    <p><i class="fas fa-envelope"></i> quocthanh12tet@gmail.com</p>
                </div>
            </div>

            <div id="sidebar-overlay" class="sidebar-overlay"></div>

            <div class="logo">
                <a href="#">Ngọc Ánh</a>
            </div>

            <div class="search-input-wrapper">
                <input type="text" placeholder="Tìm kiếm sản phẩm..." />
                <i class="fas fa-search search-icon"></i>
            </div>
            <div class="user-actions">
                {{-- Cập nhật: Thêm id="cart-icon" và span#cart-count --}}
                {{-- Cập nhật: Thay đổi href để trỏ đến trang giỏ hàng --}}
                <a href="{{ route('cart.index') }}" class="cart-icon action-item" id="cart-icon-link"
                    style="position: relative;">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng
                    <span id="cart-count" class="cart-badge">0</span>
                </a>
                <a href="#" class="action-item">
                    <i class="fa-solid fa-phone"></i>Liên hệ
                </a>
                @auth
                    <a href="{{ route('account.info') }}" class="action-item">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                @else
                    <a href="{{ route('login') }}" id="account-link" class="action-item">
                        <i class="fas fa-user"></i> Tài khoản
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <nav class="main-nav">
        <div class="container">
            <ul>
                <li>
                    <a href="#" class="home">
                        <i class="fas fa-thin fa-house fa-xl" style="color: #f6b5f7"></i>
                    </a>
                </li>
                <li><a href="#" class="nav-item">Bánh Sinh Nhât</a></li>
                <li><a href="#" class="nav-item">Bánh Sự KIện</a></li>
                <li><a href="#" class="nav-item">Bánh Hoa Quả</a></li>
                <li><a href="#" class="nav-item">Bánh Vẽ và Tạo Hình</a></li>
                <li><a href="#" class="nav-item">Bánh Bento</a></li>
                <li><a href="#" class="nav-item">Phụ kiện bánh</a></li>
            </ul>
        </div>
    </nav>

    <main class="content">
        {{-- Phần Bánh Sinh Nhật --}}
        <section class="category-section s-birthday">
            <div class="container">
                <h2 class="category-banner">Bánh Sinh Nhật</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    {{-- Giả sử biến $products chứa tất cả sản phẩm và có thuộc tính 'category' --}}
                    @if (isset($products) && count($products->where('category', 'Bánh Sinh Nhật')) > 0)
                        @foreach ($products->where('category', 'Bánh Sinh Nhật') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/anh1.png') }}"
                                    alt="{{ $product->name ?? 'Bánh Sinh Nhật' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Bánh Sinh Nhật' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/anh1.png') }}" alt="Bánh Sinh Nhật K1" />
                            <div class="product-info">
                                <h3>Bánh sinh nhật K1</h3>
                                <p class="price">123,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="1">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh2.png') }}" alt="Bánh Sinh Nhật K2" />
                            <div class="product-info">
                                <h3>Bánh sinh nhật k2</h3>
                                <p class="price">223,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="2">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh3.png') }}" alt="Bánh Sinh Nhật K3" />
                            <div class="product-info">
                                <h3>Bánh Sinh Nhật K3</h3>
                                <p class="price">423,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="3">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh4.png') }}" alt="Bánh Sinh Nhật K4" />
                            <div class="product-info">
                                <h3>Bánh sinh nhật K4</h3>
                                <p class="price">Trả bằng tình cảm</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="4">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>

        {{-- Phần Bánh Sự Kiện --}}
        <section class="category-section s-event">
            <div class="container">
                <h2 class="category-banner">Bánh Sự Kiện</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    @if (isset($products) && count($products->where('category', 'Bánh Sự Kiện')) > 0)
                        @foreach ($products->where('category', 'Bánh Sự Kiện') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/anh5.png') }}"
                                    alt="{{ $product->name ?? 'Bánh Sự Kiện' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Bánh Sự Kiện' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/anh5.png') }}" alt="Bánh Cưới Mẫu 1" />
                            <div class="product-info">
                                <h3>Bánh Cưới Mẫu 2</h3>
                                <p class="price">123,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="5">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh6.png') }}" alt="Bánh Cưới Mẫu 2" />
                            <div class="product-info">
                                <h3>Bánh Cưới Mẫu 2</h3>
                                <p class="price">223,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="6">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh7.png') }}" alt="Bánh Cưới Mẫu 3" />
                            <div class="product-info">
                                <h3>Bánh Cưới Mẫu 3</h3>
                                <p class="price">423,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="7">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh8.png') }}" alt="Bánh Cưới Mẫu 4" />
                            <div class="product-info">
                                <h3>Bánh Cưới Mẫu 4</h3>
                                <p class="price">Trả bằng tình cảm</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="8">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>

        {{-- Phần Bánh Hoa Quả --}}
        <section class="category-section s-fruit">
            <div class="container">
                <h2 class="category-banner">Bánh Hoa Quả</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    @if (isset($products) && count($products->where('category', 'Bánh Hoa Quả')) > 0)
                        @foreach ($products->where('category', 'Bánh Hoa Quả') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/a9.png') }}"
                                    alt="{{ $product->name ?? 'Bánh Hoa Quả' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Bánh Hoa Quả' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/a9.png') }}" alt="Bánh Hoa Quả K1" />
                            <div class="product-info">
                                <h3>Bánh Hoa Quả K1</h3>
                                <p class="price">123,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="9">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/a10.png') }}" alt="Bánh Hoa Quả K2" />
                            <div class="product-info">
                                <h3>Bánh Hoa Quả k2</h3>
                                <p class="price">223,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="10">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/a11.png') }}" alt="Bánh Hoa Quả K3" />
                            <div class="product-info">
                                <h3>Bánh Hoa Quả K3</h3>
                                <p class="price">423,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="11">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/a12.png') }}" alt="Bánh Hoa Quả K4" />
                            <div class="product-info">
                                <h3>Bánh Hoa Quả K4</h3>
                                <p class="price">Trả bằng tình cảm</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="12">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>

        {{-- Phần Bánh Vẽ và Tạo Hình --}}
        <section class="category-section s-drawing">
            <div class="container">
                <h2 class="category-banner">Bánh Vẽ và Tạo Hình</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    @if (isset($products) && count($products->where('category', 'Bánh Vẽ và Tạo Hình')) > 0)
                        @foreach ($products->where('category', 'Bánh Vẽ và Tạo Hình') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/anh13.png') }}"
                                    alt="{{ $product->name ?? 'Mẫu vẽ' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Mẫu vẽ' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/anh13.png') }}" alt="Mẫu vẽ 1" />
                            <div class="product-info">
                                <h3>Mẫu vẽ 1</h3>
                                <p class="price">123,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="13">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh14.png') }}" alt="Mẫu vẽ 2" />
                            <div class="product-info">
                                <h3>Mẫu vẽ 2</h3>
                                <p class="price">223,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="14">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh15.png') }}" alt="Mẫu vẽ 3" />
                            <div class="product-info">
                                <h3>Mẫu vẽ 3</h3>
                                <p class="price">423,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="15">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh16.png') }}" alt="Mẫu vẽ 4" />
                            <div class="product-info">
                                <h3>Mẫu vẽ 4</h3>
                                <p class="price">Trả bằng tình cảm</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="16">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>

        {{-- Phần Bánh Bento --}}
        <section class="category-section s-bento">
            <div class="container">
                <h2 class="category-banner">Bánh Bento</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    @if (isset($products) && count($products->where('category', 'Bánh Bento')) > 0)
                        @foreach ($products->where('category', 'Bánh Bento') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/anh17.png') }}"
                                    alt="{{ $product->name ?? 'Bánh Bento' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Bánh Bento' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/anh17.png') }}" alt="Bánh Bento Mẫu 1" />
                            <div class="product-info">
                                <h3>Bánh Bento Mẫu 1</h3>
                                <p class="price">123,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="17">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh18.png') }}" alt="Bánh Bento Mẫu 2" />
                            <div class="product-info">
                                <h3>Bánh Bento Mẫu 2</h3>
                                <p class="price">223,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="18">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh19.png') }}" alt="Bánh Bento Mẫu 3" />
                            <div class="product-info">
                                <h3>Bánh Bento Mẫu 3</h3>
                                <p class="price">423,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="19">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh20.png') }}" alt="Bánh Bento Mẫu 4" />
                            <div class="product-info">
                                <h3>Bánh Bento Mẫu 4</h3>
                                <p class="price">Trả bằng tình cảm</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="20">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>

        {{-- Phần Phụ kiện bánh --}}
        <section class="category-section s-accessories"> {{-- Đổi class cho phù hợp với phụ kiện --}}
            <div class="container">
                <h2 class="category-banner">Phụ kiện bánh</h2>
                <div class="product-grid">
                    {{-- Ví dụ vòng lặp nếu bạn có dữ liệu động từ controller --}}
                    @if (isset($products) && count($products->where('category', 'Phụ kiện bánh')) > 0)
                        @foreach ($products->where('category', 'Phụ kiện bánh') as $product)
                            <div class="product-card">
                                <img src="{{ asset($product->image_path ?? 'img/anh21.png') }}"
                                    alt="{{ $product->name ?? 'Phụ kiện' }}" />
                                <div class="product-info">
                                    <h3>{{ $product->name ?? 'Tên Phụ kiện' }}</h3>
                                    <p class="price">{{ number_format($product->price ?? 0) }}₫</p>
                                    <p class="sold">{{ $product->sold_count ?? 0 }} Đã bán</p>
                                    <button class="choose-button" data-product-id="{{ $product->id ?? '' }}">
                                        <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Nếu không có dữ liệu động, sử dụng các sản phẩm tĩnh với data-product-id --}}
                        <div class="product-card">
                            <img src="{{ asset('img/anh21.png') }}" alt="Kính sinh nhật" />
                            <div class="product-info">
                                <h3>Kính sinh nhật</h3>
                                <p class="price">100,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="21">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh22.png') }}" alt="Mũ sinh nhật" />
                            <div class="product-info">
                                <h3>Mũ sinh nhật</h3>
                                <p class="price">100,000₫</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="22">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh23.png') }}" alt="Nến xoắn sinh nhật" />
                            <div class="product-info">
                                <h3>Nến xoắn sinh nhật</h3>
                                <p class="price">100,000₫</p>
                                <p class="sold">2 Đã bán</p>
                                <button class="choose-button" data-product-id="23">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>

                        <div class="product-card">
                            <img src="{{ asset('img/anh24.png') }}" alt="Nến số nhũ vàng" />
                            <div class="product-info">
                                <h3>Nến số nhũ vàng</h3>
                                <p class="price">100,000</p>
                                <p class="sold">0 Đã bán</p>
                                <button class="choose-button" data-product-id="24">
                                    <i class="fas fa-shopping-bag"></i> CHỌN MUA
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="view-more-container">
                    <a href="#" class="view-more-button">Xem thêm mẫu....</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Tiệm Bánh Ngọt. Mọi quyền được bảo lưu.</p>
        </div>
    </footer>

    {{-- Nút quay lại đầu trang --}}
    <div id="back-to-top">
        <a href="#"><i class="fas fa-arrow-up"></i></a>
    </div>

    {{-- Liên kết file JavaScript của bạn --}}
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
