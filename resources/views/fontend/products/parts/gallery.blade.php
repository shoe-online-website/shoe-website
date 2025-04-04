<div class="col-12 col-lg-6 col-xl-7">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10 order-1 order-xxl-2">
            <div class="position-relative">
                <div class="splide main-slider-new" id="splide03" role="region" aria-roledescription="carousel">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($gallery as $index => $image)
                                <li class="splide__slide @if($index === 0) is-active is-visible @endif" id="splide03-slide{{ $index + 1 }}">
                                    <a class="image-gallery-main image-full image-full-cover" href="{{ $image }}" data-fancybox="gallery" target="_blank">
                                        <img src="{{ $image }}" alt="Gallery Image" >
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-2 order-2 order-xxl-1 mt-2 mt-xxl-0">
            <div class="splide thumbnail-slider" id="splide04" role="region" aria-roledescription="carousel">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($gallery as $index => $image)
                            <li class="splide__slide @if($index === 0) is-active is-visible @endif" id="splide04-slide{{ $index + 1 }}">
                                <div class="image-full image-full-cover">
                                    <img src="{{ $image }}" alt="Thumbnail Image">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var main, thumbnails;
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo slider chính (main)
        main = new Splide('.main-slider-new', {
            type       : 'fade',               // Chuyển slide theo kiểu mờ dần
            height     : '100%',               // Chiều cao 100% của slider
            pagination : false,                // Tắt phân trang
            arrows     : false,                // Tắt các nút mũi tên điều hướng
            lazyLoad   : 'nearby',             // Lazy load các hình ảnh gần slide hiện tại
            breakpoints: {
                1200: { height: '100%' },
                992:  { height: '100%' },
                768:  { height: '100%', fixedHeight: 327, arrows: true },  // Điều chỉnh với màn hình nhỏ
                320:  { height: '100%', fixedHeight: 265, arrows: true }
            },
        });

        // Kiểm tra khi slider đã được gắn vào DOM (mounted)
        main.on('mounted', function () {
            if (main.length <= main.n.perPage) {
                jQuery(main.Components.Arrows.arrows.prev).hide();  // Ẩn nút điều hướng nếu chỉ có 1 slide
                jQuery(main.Components.Arrows.arrows.next).hide();
            }
            if (main.length < 2) {
                jQuery(main.Components.Arrows.arrows.prev).hide();  // Ẩn nút điều hướng nếu không có đủ slide
                jQuery(main.Components.Arrows.arrows.next).hide();
            }
        });

        // Nếu có slider thumbnail
        if (jQuery('.thumbnail-slider').length > 0) {
            // Khởi tạo slider thu nhỏ (thumbnail)
            thumbnails = new Splide('.thumbnail-slider', {
                perPage: 3,  // Hiển thị 3 ảnh thumbnail mỗi lần
                lazyLoad: 'nearby',
                direction: 'ttb',  // Hiển thị theo chiều dọc (top to bottom)
                perMove: 1,        // Di chuyển 1 ảnh mỗi lần
                gap: '2rem',       // Khoảng cách giữa các thumbnail
                height: '480px',
                rewind: true,      // Khi đến slide cuối sẽ quay lại slide đầu
                isNavigation: true, // Để thumbnail điều khiển main slider
                pagination: false,
                dragMinThreshold: { mouse: 4, touch: 10 },
                breakpoints: {
                    1600: { perPage: 3, direction: 'ttb', height: '480px' },
                    1400: { perPage: 3, direction: false, height: '100%' },
                    1200: { perPage: 3, direction: false, height: '100%' },
                    992:  { perPage: 3, direction: false },
                    768:  { perPage: 3, direction: false, fixedWidth: 66 },
                    320:  { perPage: 3, direction: false, fixedWidth: 66 },
                },
            });

            // Đồng bộ hóa giữa main slider và thumbnail slider
            main.sync(thumbnails);

            // Kiểm tra khi slider thumbnail đã được gắn vào DOM
            thumbnails.on('mounted', function () {
                if (thumbnails.length <= thumbnails.n.perPage) {
                    jQuery(thumbnails.Components.Arrows.arrows.prev).hide();  // Ẩn nút điều hướng nếu số lượng thumbnail nhỏ hơn
                    jQuery(thumbnails.Components.Arrows.arrows.next).hide();
                }
                if (thumbnails.length < 2) {
                    jQuery(thumbnails.Components.Arrows.arrows.prev).hide();
                    jQuery(thumbnails.Components.Arrows.arrows.next).hide();
                }
            });

            // Mount (kích hoạt) cả hai sliders
            main.mount();
            thumbnails.mount();

        } else {
            // Chỉ mount main slider nếu không có thumbnail slider
            main.mount();
        }
    });
</script>
