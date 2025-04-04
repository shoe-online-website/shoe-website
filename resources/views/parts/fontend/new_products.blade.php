<div class="theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; transform: none;">
    <aside class="ps-widget--sidebar">
      <div class="ps-widget__header">
        <h3>Sản phẩm mới</h3>
      </div>
      <div class="ps-widget__content">
        @if (getNewProducts())
          @foreach ( getnewProducts() as $item )
          <!-- Product 1 -->
          <div class="ps-shoe--sidebar">
            <div class="ps-shoe__thumbnail">
              <a href="/san-pham/chi-tiet/{{$item->slug}}"></a>
              <img class="lazy" src="{{$item->image}}">
              <div class="product-label-group"></div>
            </div>
            <div class="ps-shoe__content">
              <a class="ps-shoe__title" href="/san-pham/chi-tiet/{{$item->slug}}">{{$item->name}}</a>
              <div class="br-wrapper br-theme-fontawesome-stars">
                <select class="ps-rating ps-shoe__rating" style="display: none;">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5" selected="">5</option>
                </select>
              </div>
              <p>
                @if ($item->discount > 0)
                  {{money($item->sale_price)}} đ 
                  <del class="old-price">{{money($item->price)}} đ</del>
                @else
                    {{money($item->price)}}
                @endif
              </p>
            </div>
            <span class="clear"></span>
          </div>
          @endforeach
        @endif

        
      </div>
    </aside>

    <aside class="ps-widget--sidebar">
      <div class="ps-widget__header">
        <h3>Danh mục</h3>
      </div>
      <div class="ps-widget__content">
        <ul class="ps-tags">
          @if (getTag())
            @foreach (getTag() as $item)
              <li><a href="/san-pham/{{$item->slug}}">{{$item->name}}</a></li>
            @endforeach
          @endif

        </ul>
      </div>
    </aside>
  </div>
  <div class="resize-sensor" style="position: absolute; inset: 0px; overflow: hidden; z-index: -1; visibility: hidden;">
    <div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
      <div style="position: absolute; left: 0px; top: 0px; transition: all; width: 340px; height: 2417px;"></div>
    </div>
    <div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;">
      <div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div>
    </div>
  </div>