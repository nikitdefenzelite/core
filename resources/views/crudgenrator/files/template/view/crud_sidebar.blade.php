{{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['view'] }}'))
@isset($data['featured_activation'])
{{ $data['atsign'] }}if(getSetting('{{ $data['view_name'] }}_activation') == 1)
@endisset
<div class="nav-item {{ $data['curlstart'] }} ($segment2 == '{{ $data['view_name'] }}') ? 'active' : '' }}">
    <a href="{{ $data['curlstart'] }} route('{{ $as }}.index')}}" class="a-item"><i
            class="ik ik-grid"></i><span>{{ $heading }}</span></a>
</div>
{{ $data['atsign'] }}endif
@isset($data['featured_activation'])
{{ $data['atsign'] }}endif
@endisset
