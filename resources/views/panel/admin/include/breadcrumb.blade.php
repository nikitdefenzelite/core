<nav class="breadcrumb-container" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('panel.admin.dashboard.index') }}"><i class="ik ik-home"></i></a>
        </li>
        @foreach ($breadcrumb_arr as $item)
            @if ($item != null)
                <li class="breadcrumb-item {{ $item['class'] }}"><a href="{{ $item['url'] }}"
                        class="item">{{ $item['name'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
