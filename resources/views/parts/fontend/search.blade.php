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