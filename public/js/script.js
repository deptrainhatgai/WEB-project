// script.js

document.addEventListener("DOMContentLoaded", () => {
    const accountLink = document.getElementById("account-link"); // Đổi id từ login-signup-link thành account-link
    const userDisplayName = document.getElementById("user-display");
    const usernameSpan = document.getElementById("username");

    // Giả lập trạng thái đăng nhập
    let isLoggedIn = true;

    function updateLoginStatus() {
        if (isLoggedIn) {
            accountLink.style.display = "inline-block"; // Hiển thị link Tài khoản
            userDisplayName.style.display = "inline-block"; // Hiển thị tên người dùng
            usernameSpan.textContent = currentUser;
        } else {
            accountLink.style.display = "none"; // Ẩn link Tài khoản
            userDisplayName.style.display = "none"; // Ẩn tên người dùng
        }
    }
    const addToCartButtons = document.querySelectorAll(".choose-button");
    const cartIconLink = document.querySelector(".cart-icon");
    const cartCountElement = document.getElementById("cart-count");
    const header = document.querySelector(".top-bar");

    function updateLocalCartCount() {
        let guestCart = JSON.parse(localStorage.getItem("guest_cart") || "[]");
        // Tính tổng số lượng chính xác
        const totalCount = guestCart.reduce(
            (sum, item) => sum + (parseInt(item.quantity) || 0),
            0
        );
        if (cartCountElement) {
            cartCountElement.textContent = totalCount;
        }
    }

    updateLocalCartCount();

    // ...existing code...

    function syncGuestCartToServer() {
        const guestCartData = localStorage.getItem("guest_cart");
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        if (guestCartData && csrfToken) {
            const guestCart = JSON.parse(guestCartData);

            fetch("/api/cart/sync", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ items: guestCart }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log("Đồng bộ giỏ hàng thành công.");
                        localStorage.removeItem("guest_cart");
                        // Cập nhật lại số lượng giỏ hàng sau khi đồng bộ
                        fetch("/api/cart/count")
                            .then((response) => response.json())
                            .then((data) => {
                                cartCountElement.textContent = data.count;
                            });
                    } else {
                        console.error("Lỗi đồng bộ giỏ hàng:", data.message);
                    }
                })
                .catch((error) => {
                    console.error("Lỗi mạng khi đồng bộ giỏ hàng:", error);
                });
        }
    }

    // Gọi updateLoginStatus để kiểm tra trạng thái đăng nhập ban đầu

    // Bạn có thể cần một cách chính xác hơn để phát hiện khi người dùng đăng nhập thành công,
    // ví dụ như sau khi nhận được response thành công từ một API đăng nhập.
    // Tùy thuộc vào cách bạn xử lý đăng nhập, bạn có thể cần điều chỉnh logic này.
    // Ví dụ, nếu bạn có một API đăng nhập, bạn có thể gọi syncGuestCartToServer() trong .then() của promise đó.
    // Vì hiện tại chúng ta đang giả lập trạng thái đăng nhập, chúng ta gọi nó một lần khi DOMContentLoaded.
});

document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar-menu");
    const overlay = document.getElementById("sidebar-overlay");
    const openBtn = document.querySelector(".user-actions .action-item");
    const closeBtn = document.getElementById("close-sidebar");
});
// document.addEventListener("DOMContentLoaded", function () {
//     const backToTopButton = document.getElementById("back-to-top");

//     // Xử lý sự kiện click để cuộn lên đầu trang mượt mà
//     backToTopButton.addEventListener("click", function (e) {
//         e.preventDefault();
//         window.scrollTo({
//             top: 0,
//             behavior: "smooth",
//         });
//     });
// });
document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".choose-button");
    const cartIconLink = document.querySelector(".cart-icon"); // Lấy phần tử <a> chứa icon giỏ hàng
    const cartCountElement = document.getElementById("cart-count");
    const header = document.querySelector(".top-bar"); // Lấy header nếu header của bạn cố định

    // Cập nhật số lượng giỏ hàng ban đầu từ localStorage khi trang tải
    updateLocalCartCount();

    console.log(
        "Cart after add:",
        JSON.parse(localStorage.getItem("guest_cart"))
    );

    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.dataset.productId; // Lấy ID sản phẩm
            const productCard = this.closest(".product-card");
            const productRect = productCard.getBoundingClientRect();
            const cartRect = cartIconLink.getBoundingClientRect();

            // Lưu vào localStorage
            let guestCart = JSON.parse(
                localStorage.getItem("guest_cart") || "[]"
            );
            const existingItemIndex = guestCart.findIndex(
                (item) => item.productId === productId
            );
            if (existingItemIndex > -1) {
                guestCart[existingItemIndex].quantity =
                    (guestCart[existingItemIndex].quantity || 1) + 1;
            } else {
                guestCart.push({ productId: productId, quantity: 1 });
            }
            localStorage.setItem("guest_cart", JSON.stringify(guestCart));

            // Cập nhật số lượng trên biểu tượng giỏ hàng (cục bộ)
            updateLocalCartCount();

            // Hiệu ứng bay
            const flyingItem = document.createElement("div");
            flyingItem.classList.add("flying-item");
            flyingItem.style.width = "30px";
            flyingItem.style.height = "30px";
            flyingItem.style.backgroundColor = "pink";
            flyingItem.style.position = "fixed";
            flyingItem.style.left =
                productRect.left + productRect.width / 2 - 15 + "px";
            flyingItem.style.top =
                productRect.top + productRect.height / 2 - 15 + "px";
            document.body.appendChild(flyingItem);

            const translateX =
                cartRect.left +
                cartRect.width / 2 -
                (productRect.left + productRect.width / 2);
            const translateY =
                cartRect.top +
                cartRect.height / 2 -
                (productRect.top + productRect.height / 2);

            setTimeout(() => {
                flyingItem.style.transform = `translate(${translateX}px, ${translateY}px) scale(0.1)`;
                flyingItem.style.opacity = 0;

                flyingItem.addEventListener("transitionend", () => {
                    if (flyingItem.parentNode === document.body) {
                        document.body.removeChild(flyingItem);
                    } else {
                        console.warn(
                            "flyingItem không còn là con của document.body, không thể xóa."
                        );
                    }
                    cartCountElement.classList.add("animate-badge");
                    setTimeout(() => {
                        cartCountElement.classList.remove("animate-badge");
                    }, 300);
                });
            }, 50);

            console.log(
                "Đã thêm sản phẩm có ID:",
                productId,
                "vào giỏ hàng tạm thời."
            );
        });
    });
    // Thêm hàm displayGuestCart
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.dataset.productId;
            const productCard = this.closest(".product-card");

            // Thêm kiểm tra và log để debug
            console.log("Product Card:", productCard);

            const productName = productCard.querySelector("h3").textContent;
            // Đảm bảo lấy được giá
            const priceElement = productCard.querySelector(".price");
            console.log("Price Element:", priceElement);

            const productPrice = priceElement
                ? parseInt(priceElement.textContent.replace(/[^\d]/g, ""))
                : 0;
            console.log("Product Price:", productPrice);

            const productImage = productCard.querySelector("img").src;

            // Kiểm tra dữ liệu trước khi lưu
            if (!productId || !productName || !productPrice) {
                console.error("Missing product information:", {
                    id: productId,
                    name: productName,
                    price: productPrice,
                });
                return;
            }

            let guestCart = JSON.parse(
                localStorage.getItem("guest_cart") || "[]"
            );
            const existingItemIndex = guestCart.findIndex(
                (item) => item.productId === productId
            );

            if (existingItemIndex > -1) {
                guestCart[existingItemIndex].quantity += 1;
            } else {
                guestCart.push({
                    productId: productId,
                    name: productName,
                    price: productPrice, // Đảm bảo price là số
                    image: productImage,
                    quantity: 1,
                });
            }

            // Log giỏ hàng trước khi lưu
            console.log("Cart before saving:", guestCart);

            localStorage.setItem("guest_cart", JSON.stringify(guestCart));
            updateLocalCartCount();

            // Hiển thị thông báo
            showNotification("Đã thêm sản phẩm vào giỏ hàng!");
        });
    });

    function displayGuestCart() {
        const guestCartList = document.getElementById("guest-cart-list");
        const guestCartTotal = document.getElementById("guest-cart-total");
        if (!guestCartList) return;

        const guestCart = JSON.parse(
            localStorage.getItem("guest_cart") || "[]"
        );
        console.log("Loading cart data:", guestCart); // Thêm log để debug

        let html = "";
        let total = 0;

        if (guestCart.length === 0) {
            html =
                '<p class="empty-cart-message">Giỏ hàng của bạn đang trống.</p>';
        } else {
            guestCart.forEach((item) => {
                // Đảm bảo price và quantity là số
                const price = parseInt(item.price) || 0;
                const quantity = parseInt(item.quantity) || 0;
                const itemTotal = price * quantity;
                total += itemTotal;

                html += `
                <li class="cart-item">
                    <img src="${item.image}" alt="${
                    item.name
                }" class="cart-item-image">
                    <div class="cart-item-details">
                        <h3>${item.name}</h3>
                        <p>Giá: ${price.toLocaleString("vi-VN")}₫</p>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="decrease-quantity" data-product-id="${
                            item.productId
                        }">-</button>
                        <input type="number" value="${quantity}" min="1" class="quantity-input" data-product-id="${
                    item.productId
                }">
                        <button class="increase-quantity" data-product-id="${
                            item.productId
                        }">+</button>
                    </div>
                    <div class="cart-item-price">
                        ${itemTotal.toLocaleString("vi-VN")}₫
                    </div>
                    <button class="cart-item-remove" data-product-id="${
                        item.productId
                    }">Xóa</button>
                </li>
            `;
            });
        }

        guestCartList.innerHTML = html;
        guestCartTotal.textContent = `Tổng cộng: ${total.toLocaleString(
            "vi-VN"
        )}₫`;
    }
    // Gọi hàm khi trang load
    document.addEventListener("DOMContentLoaded", function () {
        if (window.location.pathname === "/cart") {
            displayGuestCart();
            // Thêm event listeners cho các nút trong giỏ hàng
            attachCartEventListeners();
        }
    });
    function updateLocalCartCount() {
        let guestCart = JSON.parse(localStorage.getItem("guest_cart") || "[]");
        // Tính tổng số lượng chính xác
        const totalCount = guestCart.reduce(
            (sum, item) => sum + (parseInt(item.quantity) || 0),
            0
        );
        if (cartCountElement) {
            cartCountElement.textContent = totalCount;
        }
    }

    function showNotification(message, type = "success") {
        const notificationDiv = document.createElement("div");
        notificationDiv.className = `notification ${type}`;
        notificationDiv.textContent = message;
        document.body.appendChild(notificationDiv);

        setTimeout(() => {
            notificationDiv.remove();
        }, 3000);
    }
    // Logic chạy sau khi trang tải để đồng bộ giỏ hàng sau khi đăng nhập
    window.onload = function () {
        const userDisplayName = document.getElementById("user-display");
        if (
            userDisplayName &&
            userDisplayName.style.display === "inline-block"
        ) {
            const guestCartData = localStorage.getItem("guest_cart");
            if (guestCartData) {
                const guestCart = JSON.parse(guestCartData);
                guestCart.forEach((item) => {
                    fetch("/api/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({
                            product_id: item.productId,
                            quantity: item.quantity || 1,
                        }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            console.log(
                                `Đã thêm ${item.quantity || 1} sản phẩm ${
                                    item.productId
                                } vào giỏ hàng.`
                            );
                            // Cập nhật lại số lượng giỏ hàng trên giao diện sau khi đồng bộ
                            fetch("/api/cart/count")
                                .then((response) => response.json())
                                .then((data) => {
                                    cartCountElement.textContent = data.count;
                                });
                        });
                });
                // Xóa giỏ hàng tạm thời sau khi đã đồng bộ
                localStorage.removeItem("guest_cart");
            } else {
                // Nếu đã đăng nhập nhưng không có giỏ hàng tạm thời, lấy số lượng từ server
                fetch("/api/cart/count")
                    .then((response) => response.json())
                    .then((data) => {
                        cartCountElement.textContent = data.count;
                    });
            }
        }
    };

    // Hàm thêm vào giỏ hàng
    function addToCart(button) {
        const productCard = button.closest(".product-card");
        const productId = button.dataset.productId;
        const productName = productCard.querySelector("h3").textContent;
        const priceText = productCard.querySelector(".price").textContent;
        const productPrice = parseInt(priceText.replace(/[^\d]/g, ""));
        const productImage = productCard.querySelector("img").src;

        console.log("Adding product:", {
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
        });

        // Lấy giỏ hàng từ localStorage
        let guestCart = JSON.parse(localStorage.getItem("guest_cart") || "[]");

        // Tìm sản phẩm trong giỏ hàng
        const existingItemIndex = guestCart.findIndex(
            (item) => item.productId === productId
        );

        if (existingItemIndex > -1) {
            // Nếu sản phẩm đã tồn tại, tăng số lượng
            guestCart[existingItemIndex].quantity += 1;
        } else {
            // Nếu chưa có, thêm sản phẩm mới
            guestCart.push({
                productId: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1,
            });
        }

        // Lưu lại vào localStorage
        localStorage.setItem("guest_cart", JSON.stringify(guestCart));

        // Cập nhật số lượng hiển thị
        updateCartCount();

        // Hiển thị thông báo
        showNotification("Đã thêm sản phẩm vào giỏ hàng!");

        console.log("Current cart:", guestCart);
    }

    // Cập nhật số lượng hiển thị
    function updateCartCount() {
        const guestCart = JSON.parse(
            localStorage.getItem("guest_cart") || "[]"
        );
        const totalCount = guestCart.reduce(
            (sum, item) => sum + (parseInt(item.quantity) || 0),
            0
        );
        if (cartCountElement) {
            cartCountElement.textContent = totalCount;
        }
    }

    // Thêm sự kiện click cho các nút "CHỌN MUA"
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", () => addToCart(button));
    });

    // Cập nhật số lượng khi trang load
    updateCartCount();
});
