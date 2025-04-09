<section class="ps-section ps-section--top-sales ps-owl-root pt-40 pb-40">
  <div class="container">
    <div class="ps-section__header mb-30">
      <div class="row">
        <div class="col-12">
          <h3 class="ps-section__title" data-mask="Products">- Sản phẩm bán chạy nhất</h3>
        </div>
      </div>
    </div>
    <div class="ps-section__content pt-3">
      <div
        class="splide slider-splide-config splide--slide splide--ltr splide--draggable is-active is-overflow is-initialized"
        data-options="{
          'type': 'slide',
          'perPage': '5',
          'perMove': '1',
          'gap': '1rem',
          'lazyLoad': 'nearby',
          'height': '100%',
          'pagination': false,
          'breakpoints': {
            '1400': { 'perPage': '5', 'gap': '.7rem' },
            '1200': { 'perPage': '4', 'gap': '0.7rem' },
            '992': { 'perPage': '4', 'gap': '1rem' },
            '768': { 'perPage': '3', 'gap': '1rem' },
            '640': { 'perPage': '2', 'gap': '0.5rem' },
            '480': { 'perPage': '2', 'gap': '0.5rem' }
          }
        }" id="splide01" role="region" aria-roledescription="carousel">

        <div class="splide__track">
          <ul class="splide__list">
            @if ($bestSeller)
                @foreach ($bestSeller as $item)
                <li class="splide__slide">
                  <div class="ps-shoes--carousel">
                    <div class="ps-shoe">
                      <div class="ps-shoe__thumbnail">
                        <div class="product-label-group">
                          @if ($item->discount > 0)
                              <div class="product-label ps-badge ps-badge--sale ps-badge--2nd">
                                  <span>-{{money($item->discount)}}%</span>
                              </div>
                          @endif
                      </div>
                        <img src="{{$item->image}}"
                          data-splide-lazy="{{$item->image}}" alt="{{$item->name}}">
                        <a class="ps-shoe__overlay" href="/san-pham/chi-tiet/{{$item->slug}}"></a>
                      </div>
                      <div class="ps-shoe__content">
                        <div class="ps-shoe__detail">
                          <a class="ps-shoe__name" href="/san-pham/{{$item->slug}}">{{$item->name}}</a>
                          <select class="ps-rating ps-shoe__rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                          </select>
                          <span class="ps-shoe__price">
                              @if ($item->discount > 0)
                                  {{money($item->sale_price)}} đ
                                  <del class="old-price">{{money($item->price)}} đ</del>
                              @else
                                  {{money($item->price)}} đ
                              @endif
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                @endforeach
            @endif

          </ul>
        </div>
      </div>
    </div>
  </div>
</section>