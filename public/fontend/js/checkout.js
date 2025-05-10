const token = document.head.querySelector('meta[name="csrf-token"]').content;
const searchDistricts = (provinceId, districtId, wardId) => {
    const provinceElement = document.querySelector(provinceId);
    const districtElement = document.querySelector(districtId);
    const wardElement = document.querySelector(wardId);
    
    const getDistricts = async (id) => {
        const response = await fetch(`/search-districts`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN" : token,
                "Content-Type" : "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({'id' : id}),
        });
        const { success, districts } = await response.json();
        
        if(!success) {
            location.reload();
        }

        return districts;
    }
    districtElement.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
    wardElement.innerHTML = '<option value="">Chọn Phường/Xã</option>';
    getDistricts(provinceElement.value).then((districts) => {
        let options = '<option value="">Chọn Quận/Huyện</option>';
        districts.forEach((element) => {
            options += '<option value="' + element.code + '" data-code="' + element.code + '">' + element.full_name + '</option>'
        });
        districtElement.innerHTML = options;
    });
}
const searchWards = (districtId, wardId) => {
    const districtElement = document.querySelector(districtId);
    const wardElement = document.querySelector(wardId);
    
    const getWards = async (id) => {
        const response = await fetch(`/search-wards`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN" : token,
                "Content-Type" : "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({'id' : id}),
        });
        const { success, wards } = await response.json();
        
        if(!success) {
            location.reload();
        }

        return wards;
    }
    wardElement.innerHTML = '<option value="" selected>Chọn Phường/Xã</option>';
    getWards(districtElement.value).then((wards) => {
        let options = '<option value="" selected>Chọn Phường/Xã</option>';
        wards.forEach((element) => {
            options += '<option value="' + element.code + '" data-code="' + element.code + '">' + element.full_name + '</option>'
        });
        wardElement.innerHTML = options;
    });
}
const couponForm = document.querySelector('#form_discount_add');
if(couponForm) {
    const couponCode = couponForm.querySelector('#discount_code');
    couponForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const couponVerify = async (code) => {
            try {
                couponCode.disabled = true;
                couponForm.querySelector('.error').innerHTML = '';
                const response = await fetch(`/coupon/verify`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({'code' : code}),
                });
                const { success, errors, cart } = await response.json();
                
                if(!success) {
                    throw new Error(errors);
                }
                Toastify({
                    text: "Áp dụng mã giảm giá thành công",
                    duration: 5000,
                    destination: "https://github.com/apvarun/toastify-js",
                    newWindow: true,
                    close: true,
                    gravity: "top", 
                    position: "right", 
                    stopOnFocus: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
                couponForm.querySelector('#btn-usage').classList.add('d-none');
                couponCode.style.backgroundColor = 'green';
                couponCode.style.color = 'white';
                couponCode.value = cart['code'];
                couponForm.querySelector('#button-reset').classList.remove('d-none');
                document.querySelector('.price_discount').innerHTML = cart['discount'].toLocaleString() + ' đ';
                document.querySelector('.price_total_end').innerHTML = cart['sumPrice'].toLocaleString() + ' đ';
                
                
            } catch (errors) {
                couponCode.disabled = false;
                couponForm.querySelector('.error').innerHTML = errors.message;
            } finally {
            }
        }
        couponVerify(couponCode.value);
    });
    couponForm.querySelector('#button-reset').addEventListener('click', (e) => {
        e.preventDefault();
        const removeCoupon = async (code) => {
            try {
                couponForm.querySelector('.error').innerHTML = '';
                const response = await fetch(`/coupon/remove`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({'code' : code}),
                });
                const { success, errors, sumPrice } = await response.json();
                
                if(!success) {
                    throw new Error(errors);
                }
                couponForm.querySelector('#button-reset').classList.add('d-none');
                couponForm.querySelector('#btn-usage').classList.remove('d-none');

                couponCode.style.backgroundColor = 'white';
                couponCode.style.color = 'black';
                couponCode.disabled = false;
                couponCode.value = '';

                document.querySelector('.price_discount').innerHTML = 'Chưa bao gồm';
                document.querySelector('.price_total_end').innerHTML = sumPrice.toLocaleString() + ' đ';
            } catch (errors) {
                couponForm.querySelector('.error').innerHTML = errors.message;
            } finally {

            }
        };
        removeCoupon(couponCode.value);
    });
} 
const orderButton = document.querySelector('#finished');
if(orderButton) {
    const fieldInputElements = document.querySelectorAll('.field-input');
    const errorsElements = document.querySelectorAll('label.error');
    orderButton.addEventListener('click', (e) => {
        e.preventDefault();
        let filters = {};
        errorsElements.forEach((element) => {
            element.innerHTML = '';
            element.classList.add('d-none');
        })
        fieldInputElements.forEach((element) => {
            filters[element.name] = element.value;
        });
        const submitForm = async (filters) => {
            try {
                const response = await fetch(`/thong-tin-don-hang`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(filters),
                });
                const { success, errors, message, data } = await response.json();
                if(!success) {
                    throw errors;
                }
                window.location = `/phuong-thuc-thanh-toan`;
                
            } catch (errors) {
                Object.keys(errors).forEach((field) => {
                    const elementId = '#' + field + '-error';
                    document.querySelector(elementId).classList.remove('d-none');
                    document.querySelector(elementId).innerHTML = errors[field];
                });
            }
            
        };
        submitForm(filters);
        
    });
    
}
const inputNumberInt = (input) => {
    input.value = input.value.replace(/[^\d].+/, "");
    if(event.which < 48 || event.which > 57) {
        event.preventDefault();
    }
}
const checkoutButton = document.querySelector('#finished-checkout');
if(checkoutButton) {
    checkoutButton.addEventListener('click', (e) => {
        e.preventDefault();
        let buttonText = checkoutButton.querySelector('.btn-content');
        let buttonTextInit = buttonText.textContent;
        const paymentConfirm = async () => {
            try {
                buttonText.innerHTML = 'Đang xử lý <i class="fa-solid fa-spinner"></i>';
                const response = await fetch('/phuong-thuc-thanh-toan', {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(),
                });   
                const { success, errors, data } = await response.json();
                console.log(data);
                if(!success) {
                    throw Error(errors);
                }
                Swal.fire({
                    title: "Thanh toán thành công",
                    text: "Chúng tôi sẽ liên hệ với bạn sau!",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonText: 'Đồng ý',
                }).then((result) => {
                    window.location.href = '/';
                });
            } catch (errors) {
                console.log(errors);
            } finally {
                buttonText.innerHTML = buttonTextInit;
            }
        };  
        
        paymentConfirm();
    })
}