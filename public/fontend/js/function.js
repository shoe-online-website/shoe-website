const token = document.head.querySelector('meta[name="csrf-token"]').content;
const deleteCart = (cartId, name = "") => {
    const cartItemElements = document.querySelectorAll(".inforCart");
    const cartItemProElements = document.querySelectorAll(".ps-cart-item");
    const psCartListing = document.querySelector('.ps-cart-listing');
    Swal.fire({
        title: "Bạn có muốn xóa sản phẩm " + name + " ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    }).then(function (result) {
        if (result.value) {
            deleteCartAjax(cartId).then((response) => {
                if (response.cartPro) {
                    document.querySelectorAll(".sumPrice").forEach((element) => {
                        element.textContent = response.cartPro.sumPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + ' đ';
                    })
                    document.querySelectorAll('.numberSumProduct').forEach((element) => {
                        element.textContent = response.cartPro.totalQuantity;
                    });
                    document.querySelectorAll(".tr" + cartId).forEach((element) => {
                        element.remove();
                    });
                }

                if (cartItemProElements.length === 1) {
                    document.querySelector(".ps-cart__content").classList.add("d-none");
                }
                if (cartItemElements.length === 1) {
                    psCartListing.innerHTML =
                        `<div class="cartNull">
                        <div class="null_cart text-center">
                            <h1 class="coll-title cart-title text-uppercase">Giỏ hàng</h1>
                            <p class="text-null">Không có sản phẩm nào trong giỏ hàng</p>
                            <a href="." class="back-home">Về trang chủ</a>
                            <div class="callship text-center">
                                Khi cần trợ giúp vui lòng gọi 
                                <a class="callNow" href="tel:">0123456789</a>
                            </div>
                        </div>
                    </div>`;
                }

            }).catch((error) => {
                console.error("Có lỗi xảy ra", error);
            });
        }
    })

}
const deleteCartAjax = async (cartId) => {
    const response = await fetch(`/delete-item-cart`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({ 'cartId': cartId }),
    });
    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return await response.json();
}
// Hàm định dạng giá tiền
const formatPrice = (price) => {
    if (price === undefined || price === null) return '0 đ'; // Giá trị mặc định nếu không hợp lệ
    return price.toLocaleString('vi-VN') + ' đ';
};

// Hàm cập nhật số lượng
const updateQuantity = async (cartId, currentPrice, delta, maxQuantity) => {
    const qtyInput = document.querySelector(`#qty${cartId}`);
    const currentQuantity = parseInt(qtyInput.value) + delta;

    if (currentQuantity <= 0 || currentQuantity > maxQuantity) return;

    // Cập nhật số lượng trên giao diện trước khi gửi AJAX
    qtyInput.value = currentQuantity;
    document.querySelector(`.qtypro${cartId}`).textContent = currentQuantity;

    // Gửi yêu cầu cập nhật lên server
    const filters = { cartId, quantity: currentQuantity };
    const updatedCart = await updateQuantityAjax(filters);

    // Chỉ cập nhật giao diện nếu server trả về dữ liệu hợp lệ
    if (updatedCart) {
        const sumPriceItem = document.querySelectorAll(`.sumprice${cartId}`);
        const sumPriceAllItems = document.querySelectorAll('.sumPrice');
        const totalQuantityCart = document.querySelectorAll('.numberSumProduct');

        // Cập nhật giá tiền của sản phẩm cụ thể
        sumPriceItem.forEach((element) => {
            element.innerHTML = formatPrice(updatedCart.itemPrice || currentPrice * currentQuantity); // Dùng giá tính thủ công nếu server không trả về
        });

        // Cập nhật tổng giá tiền và tổng số lượng
        sumPriceAllItems.forEach((element) => {
            element.innerHTML = formatPrice(updatedCart.sumPrice); // Tổng giá từ server
        });
        totalQuantityCart.forEach((element) => {
            element.innerHTML = updatedCart.totalQuantity || currentQuantity; // Tổng số lượng từ server
        });
    }
};

// Hàm gửi AJAX cập nhật số lượng
const updateQuantityAjax = async (filters) => {
    try {
        const response = await fetch('/updateQuantity', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            body: JSON.stringify(filters),
        });
        const { success, errors, cart } = await response.json();
        if (!success) throw new Error(errors);
        return cart; // Trả về dữ liệu giỏ hàng từ server
    } catch (error) {
        return null; // Trả về null nếu có lỗi
    }
};
const cartForm = document.querySelector('#addToCart');
const productSizeElement = document.querySelector('.product-size');
if (cartForm && productSizeElement) {
    const buttonCartElements = cartForm.querySelectorAll('.btn-pro-detail');
    const inputSizeElements = productSizeElement.querySelectorAll("input");
    inputSizeElements[0].checked = true;
    let sizeNumberDefault = inputSizeElements[0].dataset.id;
    let maxQuantityCurrentSize = inputSizeElements[0].getAttribute('maxlength');
    const productId = cartForm.querySelector("#productId").value;
    const quantityElement = cartForm.querySelector('#qty');
    let quantity = 1;
    const addButton = cartForm.querySelector('.add');
    const subButton = cartForm.querySelector('.sub');
    inputSizeElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            inputSizeElements.forEach((input) => input.checked = false);
            e.target.checked = true;
            sizeNumberDefault = element.dataset.id;
            maxQuantityCurrentSize = element.getAttribute('maxlength');
            quantity = 1;
            quantityElement.value = quantity;
        });
    });
    addButton.addEventListener('click', (e) => {
        if(quantity < maxQuantityCurrentSize) {
            quantity++;
            quantityElement.value = quantity;
        }
    });
    subButton.addEventListener('click', (e) => {
        if(quantity > 1) {
            quantity--;
            quantityElement.value = quantity;
        }
    });


    buttonCartElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            let cartId = productId + sizeNumberDefault;
            const filters = {
                'id': productId,
                'size_number': sizeNumberDefault,
                'cartId': cartId,
                'quantity': quantityElement.value,
                'maxQuantity': maxQuantityCurrentSize,
            }
            const addToCartAjax = async (filters) => {
                try {
                    const response = await fetch(`/add-to-cart`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                        body: JSON.stringify(filters)
                    });
                    const { success, errors, cart } = await response.json();
                    if (!success) {
                        throw new Error(errors);
                    }
                    return cart;
                } catch (errors) {
                    alert(errors.message);
                }
            }
            if (element.dataset.action === "addCart") {
                addToCartAjax(filters).then((cart) => {
                    document.querySelector('.ps-cart__toggle .numberSumProduct').textContent = cart.totalQuantity;
                    Swal.fire({
                        title: "Thêm thành công",
                        text: "Sản phẩm " + cart.currentName + " đã được thêm vào giỏ hàng!",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: false,
                        footer: `
                                <div class="btn-cart-popup mt-1">
                                    <a class="ps-btn text-center mt-3 mb-0" href="/gio-hang">Xem giỏ hàng</a>
                                </div>
                        `,
                        timer: 10000
                    });
                    let rows = "";
                    Object.values(cart.data).forEach((item) => {
                        rows +=
                            `<div class="ps-cart-item tr${item.cartId}">
                            <a href="#" class="ps-cart-item__close" onclick="return deleteCart(${item.cartId}, '${item.name}')"></a>
                            <div class="ps-cart-item__thumbnail">
                                <a href="/san-pham/chi-tiet/${item.slug}"></a>
                                <img src="${item.image}" 
                                    alt="${item.name}">
                            </div>
                            <div class="ps-cart-item__content">
                                <a class="ps-cart-item__title" href="/san-pham/chi-tiet/${item.slug}">
                                    ${item.name}
                                </a>
                                <div class="attribute_pro">
                                    <span class="badge bg-primary me-2">Size Giày: <b>${item.size_number}</b></span>
                                </div>
                                <p>
                                    <span>Số lượng: <i class="qtypro${item.cartId}">${item.quantity}</i></span>
                                    <span>Thành tiền: <i class="sumprice${item.cartId}">${item.price.toLocaleString()} đ</i></span>
                                </p>
                            </div>
                        </div>`;
                    });
                    rows +=
                        `<div class="ps-cart__total">
                        <p>Số sản phẩm: <span class="numberSumProduct">${cart.totalQuantity}</span></p>
                        <p>Tổng: <span class="sumPrice">${cart.sumPrice.toLocaleString()} đ</span></p>
                    </div>
                    <div class="ps-cart__footer">
                        <a class="ps-btn" href="gio-hang">
                            Giỏ hàng
                            <i class="ps-icon-arrow-left"></i>
                        </a>
                    </div>`;
                    document.querySelector('.ps-cart__content').classList.remove('d-none');
                    document.querySelector('.ps-cart__content').innerHTML = rows;

                });

            }

            if (element.dataset.action === "buyNow") {
                addToCartAjax(filters).then(() => window.location.href = `/gio-hang`);
            }

        });
    });




}
const searchform = document.querySelector("#searchform");
if (searchform) {
    const inputElement = document.querySelector("#inputString");
    const suggestions = searchform.querySelector("#suggestions");
    const buttonElement = searchform.querySelector("button[type='submit']");

    let typingTimer;
    const typingDelay = 700; // 500ms delay

    inputElement.addEventListener("input", (e) => {
        suggestions.style.display = "none";
        suggestions.innerHTML = "";
        buttonElement.innerHTML = `<i class="fa-solid fa-rotate-right">`;
        clearTimeout(typingTimer);

        typingTimer = setTimeout(() => {
            let keyword = e.target.value.trim();
            if (keyword.length > 1) {
                search(keyword);
            }
            buttonElement.innerHTML = `<i class="ps-icon-search">`;
        }, typingDelay);
    });

    const search = async (keyword) => {
        let rows = "";
        try {

            const response = await fetch(`/show-suggestions`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ keyword }),
            });

            const { success, errors, products } = await response.json();

            if (!success) {
                rows = `<ul class="search_auto">
                            <li><span class="red">Không tìm thấy sản phẩm bạn đang tìm kiếm!</span></li>
                        </ul>`;
                throw new Error(errors);
            }

            rows = `<ul class="search_auto">`;
            for (let i = 0; i < Math.min(4, products.length); i++) {
                rows += `
                    <li>
                        <div class="image_left_price">
                            <div class="image_left">
                                <a href="/san-pham/chi-tiet/${products[i].slug}">
                                    <img src="${products[i].image}">
                                </a>
                            </div>
                            <div class="name_price">
                                <a class="name" href="/san-pham/chi-tiet/${products[i].slug}">${products[i].name}</a><br>
                                <p class="ps-product__category product__code_pro">
                                    Mã SP: <strong>${products[i].code}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </li>`;
            }
            rows += `<li style="text-align:right;">
                        <a href="/tim-kiem/?keyword=${keyword}">
                            <span class="red">Xem tất cả sản phẩm</span>
                        </a>
                    </li>
                    </ul>`;

        } catch (error) {

        } finally {
            suggestions.style.display = "block";
            suggestions.innerHTML = rows;
        }

    };
}
