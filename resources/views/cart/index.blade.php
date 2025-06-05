<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> {{-- Đảm bảo liên kết đúng file CSS của bạn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* CSS tùy chỉnh cho trang giỏ hàng */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .cart-page-container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-page-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .cart-items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-details h3 {
            margin: 0 0 5px 0;
            font-size: 1.1em;
            color: #333;
        }

        .cart-item-details p {
            margin: 0;
            font-size: 0.9em;
            color: #666;
        }

        .cart-item-price {
            font-weight: bold;
            color: #e74c3c;
            min-width: 100px;
            text-align: right;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            margin-left: 20px;
            min-width: 120px;
        }

        .cart-item-quantity input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            margin: 0 5px;
        }

        .cart-item-quantity button {
            background-color: #eee;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .cart-item-remove {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 20px;
            font-size: 0.9em;
        }

        .cart-summary {
            border-top: 2px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .cart-actions a,
        .cart-actions button {
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .continue-shopping-btn {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .continue-shopping-btn:hover {
            background-color: #e0e0e0;
        }

        .checkout-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .checkout-btn:hover {
            background-color: #45a049;
        }

        .empty-cart-message {
            text-align: center;
            color: #666;
            padding: 50px;
            font-size: 1.1em;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .cart-item {
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .cart-item-details,
            .cart-item-quantity,
            .cart-item-price,
            .cart-item-remove {
                flex-basis: 100%;
                text-align: left;
                margin-left: 0;
                margin-top: 10px;
            }

            .cart-item-price {
                text-align: left;
            }

            .cart-item-quantity {
                justify-content: flex-start;
            }

            .cart-item-remove {
                margin-left: 0;
            }

            .cart-actions {
                flex-direction: column;
                gap: 15px;
            }

            .cart-actions a,
            .cart-actions button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div id="app-notification" class="app-notification" style="display: none;">
        <span id="notification-message"></span>
        <button class="close-notification-btn"></button>
    </div>
    <div class="cart-page-container">
        <h1>Giỏ hàng của bạn</h1>

        @if (!Auth::check())
            <div id="guest-cart-container">
                <!-- Giỏ hàng cho khách -->
                <ul class="cart-items-list" id="guest-cart-list"></ul>
                <div class="cart-summary" id="guest-cart-total">
                    Tổng cộng: 0₫
                </div>
            </div>
        @else
            <ul class="cart-items-list">
                @foreach ($cartItems as $item)
                    <li class="cart-item">
                        <img src="{{ asset($item->product->image_path ?? 'https://placehold.co/80x80/cccccc/ffffff?text=No+Image') }}"
                            alt="{{ $item->product->name ?? 'Sản phẩm' }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3>{{ $item->product->name ?? 'Sản phẩm không rõ' }}</h3>
                            <p>Giá: {{ number_format($item->product->price ?? 0, 0, ',', '.') }}₫</p>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="decrease-quantity" data-cart-id="{{ $item->id }}">-</button>
                            <input type="number" value="{{ $item->quantity }}" min="1" class="quantity-input"
                                data-cart-id="{{ $item->id }}">
                            <button class="increase-quantity" data-cart-id="{{ $item->id }}">+</button>
                        </div>
                        <div class="cart-item-price">
                            {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }}₫
                        </div>
                        <button class="cart-item-remove" data-cart-id="{{ $item->id }}">Xóa</button>
                    </li>
                @endforeach
            </ul>

            <div class="cart-summary">
                Tổng cộng: {{ number_format($totalPrice, 0, ',', '.') }}₫
            </div>

            <div class="cart-actions">
                <a href="/" class="continue-shopping-btn">Tiếp tục mua hàng</a>
                <button class="checkout-btn">Tiến hành thanh toán</button>
            </div>
        @endif
    </div>

    {{-- JavaScript cho trang giỏ hàng --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const decreaseButtons = document.querySelectorAll('.decrease-quantity');
            const increaseButtons = document.querySelectorAll('.increase-quantity');
            const removeButtons = document.querySelectorAll('.cart-item-remove');
            const cartSummary = document.querySelector('.cart-summary');
            const cartItemsList = document.querySelector('.cart-items-list');
            // ... existing variables ...

            function displayGuestCart() {
                const guestCartList = document.getElementById('guest-cart-list');
                const guestCartTotal = document.getElementById('guest-cart-total');
                if (!guestCartList) return;

                const guestCart = JSON.parse(localStorage.getItem('guest_cart') || '[]');
                let html = '';
                let total = 0;

                if (guestCart.length === 0) {
                    html =
                        '<p class="empty-cart-message">Giỏ hàng của bạn đang trống. Hãy thêm một vài chiếc bánh ngon nhé!</p>';
                } else {
                    guestCart.forEach(item => {
                        const itemTotal = item.price * item.quantity;
                        total += itemTotal;
                        html += `
                    <li class="cart-item">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3>${item.name}</h3>
                            <p>Giá: ${item.price.toLocaleString('vi-VN')}₫</p>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="decrease-quantity" data-product-id="${item.productId}">-</button>
                            <input type="number" value="${item.quantity}" min="1" class="quantity-input"
                                data-product-id="${item.productId}">
                            <button class="increase-quantity" data-product-id="${item.productId}">+</button>
                        </div>
                        <div class="cart-item-price">
                            ${itemTotal.toLocaleString('vi-VN')}₫
                        </div>
                        <button class="cart-item-remove" data-product-id="${item.productId}">Xóa</button>
                    </li>
                `;
                    });
                }

                guestCartList.innerHTML = html;
                guestCartTotal.textContent = `Tổng cộng: ${total.toLocaleString('vi-VN')}₫`;

                // Thêm event listeners cho các nút trong giỏ hàng
                attachGuestCartEventListeners();
            }

            function attachGuestCartEventListeners() {
                // Xử lý nút tăng giảm số lượng cho guest cart
                document.querySelectorAll('.decrease-quantity[data-product-id]').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        updateGuestCartQuantity(productId, -1);
                    });
                });

                document.querySelectorAll('.increase-quantity[data-product-id]').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        updateGuestCartQuantity(productId, 1);
                    });
                });

                document.querySelectorAll('.cart-item-remove[data-product-id]').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        removeFromGuestCart(productId);
                    });
                });
            }

            function updateGuestCartQuantity(productId, change) {
                let guestCart = JSON.parse(localStorage.getItem('guest_cart') || '[]');
                const itemIndex = guestCart.findIndex(item => item.productId === productId);

                if (itemIndex > -1) {
                    guestCart[itemIndex].quantity = Math.max(1, guestCart[itemIndex].quantity + change);
                    localStorage.setItem('guest_cart', JSON.stringify(guestCart));
                    displayGuestCart();
                }
            }

            function removeFromGuestCart(productId) {
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    let guestCart = JSON.parse(localStorage.getItem('guest_cart') || '[]');
                    guestCart = guestCart.filter(item => item.productId !== productId);
                    localStorage.setItem('guest_cart', JSON.stringify(guestCart));
                    displayGuestCart();
                    showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
                }
            }

            // Gọi hàm hiển thị giỏ hàng khi trang được tải
            displayGuestCart();



            // Hàm hiển thị thông báo
            function showNotification(message, type = 'success') {
                const notificationDiv = document.getElementById('app-notification');
                const notificationMessageSpan = document.getElementById('notification-message');
                const closeButton = notificationDiv.querySelector('.close-notification-btn');

                notificationMessageSpan.textContent = message;
                notificationDiv.className = 'app-notification ' + type; // Thêm class type (success/error)
                notificationDiv.style.display = 'flex'; // Hiển thị thông báo

                // Tự động ẩn sau 3 giây
                setTimeout(() => {
                    notificationDiv.style.display = 'none';
                }, 3000);

                // Đóng thủ công
                closeButton.onclick = () => {
                    notificationDiv.style.display = 'none';
                };
            }


            // Hàm cập nhật tổng giá trị giỏ hàng trên giao diện
            function updateCartTotalDisplay(newTotal) {
                if (cartSummary) {
                    cartSummary.textContent = `Tổng cộng: ${newTotal.toLocaleString('vi-VN')}₫`;
                }
            }

            // Hàm gửi yêu cầu AJAX để cập nhật số lượng
            function updateCartItemQuantity(cartId, newQuantity) {
                fetch('/api/cart/update', { // Bạn sẽ cần tạo route này
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            cart_id: cartId,
                            quantity: newQuantity
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification('Cập nhật số lượng thành công!', 'success');
                            updateCartTotalDisplay(data.total_price); // Cập nhật tổng giá
                            // Cập nhật số lượng giỏ hàng trên header (nếu có)
                            const headerCartCount = document.getElementById('cart-count');
                            if (headerCartCount) {
                                headerCartCount.textContent = data.cart_count;
                            }
                        } else {
                            showNotification('Có lỗi khi cập nhật số lượng.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi cập nhật số lượng:', error);
                        showNotification('Lỗi mạng hoặc lỗi server khi cập nhật số lượng.', 'error');
                    });
            }

            // Hàm gửi yêu cầu AJAX để xóa mục giỏ hàng
            function removeCartItem(cartId, listItemElement) {
                fetch(`/api/cart/remove/${cartId}`, { // Bạn sẽ cần tạo route này
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
                            listItemElement.remove(); // Xóa mục khỏi DOM
                            updateCartTotalDisplay(data.total_price); // Cập nhật tổng giá
                            // Cập nhật số lượng giỏ hàng trên header (nếu có)
                            const headerCartCount = document.getElementById('cart-count');
                            if (headerCartCount) {
                                headerCartCount.textContent = data.cart_count;
                            }
                            // Nếu giỏ hàng trống, hiển thị thông báo
                            if (data.cart_count === 0) {
                                cartItemsList.innerHTML =
                                    '<p class="empty-cart-message">Giỏ hàng của bạn đang trống. Hãy thêm một vài chiếc bánh ngon nhé!</p>';
                                const cartActions = document.querySelector('.cart-actions');
                                if (cartActions) {
                                    cartActions.innerHTML =
                                        '<a href="/" class="continue-shopping-btn">Tiếp tục mua hàng</a>';
                                    cartActions.style.justifyContent = 'center';
                                }
                            }
                        } else {
                            showNotification('Có lỗi khi xóa sản phẩm.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi xóa sản phẩm:', error);
                        showNotification('Lỗi mạng hoặc lỗi server khi xóa sản phẩm.', 'error');
                    });
            }

            // Lắng nghe sự kiện thay đổi số lượng
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const cartId = this.dataset.cartId;
                    let newQuantity = parseInt(this.value);
                    if (isNaN(newQuantity) || newQuantity < 1) {
                        newQuantity = 1; // Đảm bảo số lượng tối thiểu là 1
                        this.value = 1;
                    }
                    updateCartItemQuantity(cartId, newQuantity);
                });
            });

            // Lắng nghe sự kiện giảm số lượng
            decreaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.dataset.cartId;
                    const input = this.nextElementSibling; // Lấy input kế tiếp
                    let newQuantity = parseInt(input.value) - 1;
                    if (newQuantity < 1) {
                        newQuantity = 1;
                    }
                    input.value = newQuantity;
                    updateCartItemQuantity(cartId, newQuantity);
                });
            });

            // Lắng nghe sự kiện tăng số lượng
            increaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.dataset.cartId;
                    const input = this.previousElementSibling; // Lấy input trước đó
                    let newQuantity = parseInt(input.value) + 1;
                    input.value = newQuantity;
                    updateCartItemQuantity(cartId, newQuantity);
                });
            });

            // Lắng nghe sự kiện xóa mục
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cartId = this.dataset.cartId;
                    const listItemElement = this.closest('.cart-item'); // Lấy thẻ li cha
                    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                        removeCartItem(cartId, listItemElement);
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
