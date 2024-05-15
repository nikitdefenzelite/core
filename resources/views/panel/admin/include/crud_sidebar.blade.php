@if (auth()->user()->isAbleTo('view_promo_codes'))
    <div class="nav-item {{ $segment2 == 'promo-codes' ? 'active' : '' }}">
        <a href="{{ route('admin.promo-codes.index') }}" class="a-item"><i class="ik ik-user-x"></i><span>Promo
                Code</span></a>
    </div>
@endif
@if (auth()->user()->isAbleTo('view_projects'))
    @if (getSetting('projects_activation') == 1)
        <div class="nav-item {{ $segment2 == 'projects' ? 'active' : '' }}">
            <a href="{{ route('admin.projects.index') }}" class="a-item"><i class="ik ik-grid"></i><span>Project</span></a>
        </div>
    @endif
@endif
@if (auth()->user()->isAbleTo('view_cy_runners'))
    @if (getSetting('cy-runners_activation') == 1)
        <div class="nav-item {{ $segment2 == 'cy-runners' ? 'active' : '' }}">
            <a href="{{ route('admin.cy-runners.index') }}" class="a-item"><i class="ik ik-grid"></i><span>Cy
                    Runner</span></a>
        </div>
    @endif
@endif
@if (auth()->user()->isAbleTo('view_cy_runner_logs'))
    @if (getSetting('cy-runner-logs_activation') == 1)
        <div class="nav-item {{ $segment2 == 'cy-runner-logs' ? 'active' : '' }}">
            <a href="{{ route('admin.cy-runner-logs.index') }}" class="a-item"><i class="ik ik-grid"></i><span>Cy Runner
                    Log</span></a>
        </div>
    @endif
@endif
@if(auth()->user()->isAbleTo('view_api_runners'))
@if(getSetting('api-runners_activation') == 1)
<div class="nav-item {{ ($segment2 == 'api-runners') ? 'active' : '' }}">
    <a href="{{ route('admin.api-runners.index')}}" class="a-item"><i
            class="ik ik-grid"></i><span>Api Runner</span></a>
</div>
@endif
@endif
