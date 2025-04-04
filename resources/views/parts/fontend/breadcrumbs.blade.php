<section class="section-breadcrumbs">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-light d-flex justify-content-center justify-content-lg-start" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <li class="breadcrumb-item text-nowrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                  <a itemprop="item" href="#">
                    <span itemprop="name"><i class="fa-light fa-house"></i> Home</span>
                  </a>
                  <meta itemprop="position" content="1">
                </li>
                @if ($breadcrumbs)
                 @php $index = 2; @endphp
                  @foreach ($breadcrumbs as $name => $url)
                    <li class="breadcrumb-item text-nowrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                      <a itemprop="item" href="{{$url}}">
                        <span itemprop="name">{{$name}}</span>
                      </a>
                      <meta itemprop="position" content="{{$index++}}">
                    </li>
                  @endforeach
                @endif
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
  