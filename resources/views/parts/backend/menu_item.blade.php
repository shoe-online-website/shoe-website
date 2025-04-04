<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{$name}}"
        aria-expanded="true" aria-controls="collapse{{$name}}">
        <i class="fas fa-fw fa-cog"></i>
        <span>{{$title}}</span>
    </a>
    <div id="collapse{{$name}}" class="collapse {{ request()->is('admin/'.$name.'/*') || request()->is('admin/'.$name) ? 'show' : false }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">{{$title}}:</h6>
            @if (!empty($lists))
                <a class="collapse-item" href="{{$lists}}">Danh sách</a>
            @endif
            @if (!empty($add))
                <a class="collapse-item" href="{{$add}}">Thêm mới</a>
            @endif
        </div>
    </div>
</li>