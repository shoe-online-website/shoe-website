@if ($breadcrumbs)
    <div class="main-header">
        <ul class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{(!$breadcrumb['active']) ? 'breadcrumb-item-current' : ''}}">
                    @if ($breadcrumb['active'])
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    @else
                        {{ $breadcrumb['name'] }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif

