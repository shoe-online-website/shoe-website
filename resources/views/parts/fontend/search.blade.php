<section class="search">
  <div class="container">
    <section class="search">
      <div class="container">
        <form method="GET" action="/tim-kiem">
          <input type="hidden" name="categorySlug" value="{{request('categorySlug') ?? getCategory()}}">
          <div class="row" role="toolbar">
            <!-- Chọn Size Giày -->
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 dvtoolbar dvtool input-search">
              <div class="form-group">
                <label class="label-search">Chọn Size Giày</label>
                <select class="form-control col-lg-12 js-example-tags d-none select2-hidden-accessible" name="listSize"
                  placeholder="Chọn size" aria-hidden="true">
                  <option value="">Tất cả</option>
                  @if (getSizes())
                    @foreach (getSizes() as $size)
                    <option value="{{$size->size_number}}" {{( request('listSize') == $size->size_number ) ? 'selected' : ''}}>
                      {{$size->size_number}}
                    </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>

            <!-- Khoảng giá -->
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 dvtoolbar dvtool select-price">
              <div class="form-group">
                <label class="label-search">Khoảng giá</label>
                <select class="form-control col-lg-12 js-example-basic-single d-none select2-hidden-accessible"
                  name="priceRange" aria-hidden="true">
                  <option value="">Tất cả</option>
                  @if (priceRangeArr())
                    @foreach (priceRangeArr() as $key => $value)
                    <option value="{{$value}}" {{( request('priceRange') == $value ) ? 'selected' : ''}}>
                      {{$key}}
                    </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>

            <!-- Sắp xếp theo -->
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 dvtoolbar dvtool select-price">
              <div class="form-group">
                <label class="label-search">Sắp xếp theo</label>
                <select class="form-control col-lg-12 js-example-basic-single d-none select2-hidden-accessible"
                  name="sort" aria-hidden="true">
                  @if (sortArr())
                    @foreach (sortArr() as $key => $value)
                      <option value="{{$value}}" {{( request('sort') == $value ) ? 'selected' : ''}}>
                        {{$key}}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>

            <!-- Nút Tìm kiếm -->
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 dvtool btn-search-lock">
              <button type="submit" class="btn btn-info btn-registration btn-search btn-lg col-sm-12">Tìm Giày Ngay <i
                  class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </div>
</section>
<div class="mobile-filter">
      <div class="hamburger-menu show-fixed">
			<i class="fa-light fa-filter-list"></i>
      </div>
 </div>
<div class="mobile-nav-filter" hidden>
  <section class="search">
      <div class="hamburger-menu close">
        <i class="fa fa-times"></i>
      </div>
      <div class="clearfix">
        <form method="GET" action="/tim-kiem">
          <input type="hidden" name="categorySlug" value="{{request('categorySlug') ?? getCategory()}}">
          <div class="row" role="toolbar">
            <div class="col-sm-12 dvtoolbar dvtool input-search">
              <div class="form-group">
                <label class="label-search">Chọn Size Giày</label>
                <select class="form-control col-lg-12 js-example-tags d-none select2-hidden-accessible" name="listSize" placeholder="Chọn size" data-select2-id="4" tabindex="-1" style="" aria-hidden="true">
                  <option value="" data-select2-id="6">Tất cả</option>
                  @if (getSizes())
                    @foreach (getSizes() as $size)
                    <option value="{{$size->size_number}}" {{( request('listSize') == $size->size_number ) ? 'selected' : ''}}>
                      {{$size->size_number}}
                    </option>
                    @endforeach
                  @endif
                </select>
            </div>
            
            <div class="col-sm-12 dvtoolbar dvtool select-price">
              <div class="form-group">
                <label class="label-search">Khoảng giá</label>
                <select class="form-control col-lg-12 js-example-basic-single d-none select2-hidden-accessible"
                  name="priceRange" aria-hidden="true">
                  <option value="">Tất cả</option>
                  @if (priceRangeArr())
                    @foreach (priceRangeArr() as $key => $value)
                    <option value="{{$value}}" {{( request('priceRange') == $value ) ? 'selected' : ''}}>
                      {{$key}}
                    </option>
                    @endforeach
                  @endif
                </select>
              </div>

            </div>
            <div class="col-sm-12 dvtoolbar dvtool select-price">
              <div class="form-group">
                <label class="label-search">Sắp xếp theo</label>
                <select class="form-control col-lg-12 js-example-basic-single d-none select2-hidden-accessible"
                  name="sort" aria-hidden="true">
                  @if (sortArr())
                    @foreach (sortArr() as $key => $value)
                      <option value="{{$value}}" {{( request('sort') == $value ) ? 'selected' : ''}}>
                        {{$key}}
                      </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="col-sm-12  dvtool btn-search-lock">
              <button type="submit" class="btn btn-info btn-registration btn-search btn-lg col-sm-12">Tìm Giày Ngay <i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
        </div>   
  </section>
</div>
<div class="overflow-filter"></div>
<script>
  (function() {
    const hamburgerMenus = document.querySelectorAll('.hamburger-menu');
    const mobileNav = document.querySelector('.mobile-nav-filter');
    mobileNav.hidden = true;
    hamburgerMenus.forEach(menu => {
        menu.addEventListener('click', function() {
            mobileNav.hidden = !mobileNav.hidden;
        });
    });
})();
</script>
