<li class="menu-item @if (!empty($subMenu)) menu-item-has-children dropdown @endif 1 menu-{{$name}} 
    {{ request()->is('san-pham/'.$name) || request()->query('categorySlug') == $name ? 'active' : ''}}" 
     id="menu-{{$name}}">
    <a href="{{$url}}">{{$title}}</a>
    @if (!empty($subMenu))
        <ul class="sub-menu">
            @foreach ($subMenu as $key => $item)
            <li class="menu-item {{$key}} menu-{{$name}}-{{$key}}" id="menumenu-{{$name}}-{{$key}}">
                <a href="{{$item['url']}}">{{$item['title']}}</a>
            </li>
            @endforeach
        </ul>
    @endif

  </li>