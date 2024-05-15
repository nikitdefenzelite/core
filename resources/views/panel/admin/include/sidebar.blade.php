@php
    $roles = App\Models\Role::pluck('display_name');
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $segment3 = request()->segment(3);
    $segment4 = request()->segment(4);
@endphp
<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ route('panel.admin.dashboard.index') }}">
            <div class="logo-img">
                {{-- <img height="35px" src="{{ getBackendLogo(getSetting('app_logo')) }}" class="header-brand-img" --}}
                {{-- title="App Logo"> --}}
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-chevron-left"></i></div>
        <button id="sidebarClose" class="nav-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="nav-container">
            <div class="px-20px mt-3 mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm"
                    style="background-color: #131923;border-color: #131923; color:white" type="text" name=""
                    placeholder="{{ __('Search In Menu') }}" id="menu-search" oninput="menuSearch()">
            </div>
            <nav id="search-menu-navigation" class="navigation-main">

            </nav>
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ $segment2 == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('panel.admin.dashboard.index') }}" class="a-item"><i
                            class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                </div>
                <div
                    class="nav-item {{ activeClassIfRoutes(['panel.admin.users.index', 'panel.admin.users.show', 'panel.admin.users.create', 'panel.admin.user_log.index', 'panel.admin.roles.index', 'panel.admin.permissions.index', 'panel.admin.roles.edit', 'panel.admin.users.edit'], 'active open') }} has-sub">
                    <a href="#"><i
                            class="ik ik-users"></i><span>{{ __('Administrator') }}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @foreach ($roles as $role)
                            {{-- @if (getSetting('user_management_activation') == 1) --}}
                                <a href="{{ route('panel.admin.users.index') }}?role={{ $role }}"
                                    class="menu-item a-item @if (request()->has('role') && request()->get('role') == $role) active @endif">{{ $role }}
                                    Management</a>
                            {{-- @endif --}}
                        @endforeach
                        <!-- only those have manage_role permission will get access -->
                        {{-- @if (getSetting('roles_and_permission_activation') == 1) --}}
                            {{-- @if (auth()->user()->isAbleTo('view_roles')) --}}
                                {{-- <a href="{{ route('panel.admin.roles.index') }}"
                                    class="menu-item a-item {{ activeClassIfRoute('panel.admin.roles.index', 'active') }}">{{ __('Roles') }}</a> --}}
                            {{-- @endif --}}
                            <!-- only those have manage_permission permission will get access -->
                            {{-- @if (auth()->user()->isAbleTo('view_permissions')) --}}
                                {{-- <a href="{{ route('panel.admin.permissions.index') }}"
                                    class="menu-item a-item {{ activeClassIfRoute('panel.admin.permissions.index', 'active') }}">{{ __('Permissions') }}</a> --}}
                            {{-- @endif --}}
                        {{-- @endif --}}
                    </div>
                </div>
                <div class="nav-item {{ $segment2 == 'projects' ? 'active' : '' }}">
                    <a href="{{ route('admin.projects.index') }}" class="a-item"><i
                            class=" ik ik-layers"></i><span>Projects</span></a>
                </div>

                <div
                    class="nav-item {{ activeClassIfRoutes(['admin.cy-runner-logs.index', 'admin.api-runner-logs.index'], 'active open') }} has-sub">
                    <a href="#"><i
                            class="ik ik-pie-chart"></i><span>{{ __('Logs') }}</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('admin.cy-runner-logs.index') }}"
                            class="menu-item a-item {{ activeClassIfRoute('admin.cy-runner-logs.index', 'active') }}">{{ __('Cy Scenario') }}</a>
                        <a href="{{ route('admin.api-runner-logs.index') }}"
                            class="menu-item a-item {{ activeClassIfRoute('admin.api-runner-logs.index', 'active') }}">{{ __('Api Scenario') }}</a>
                    </div>
                </div>
                <!-- <div class="nav-item {{ $segment2 == 'cy-runner-logs' ? 'active' : '' }}">
                    <a href="{{ route('admin.cy-runner-logs.index') }}" class="a-item"><i class="ik ik-pie-chart text-muted"></i><span>CyRunner Logs</span></a>
                </div> -->
                <!-- <div class="nav-item {{ ($segment2 == 'api-runners') ? 'active' : '' }}">
                    <a href="{{ route('admin.api-runners.index')}}" class="a-item"><i
                            class="ik ik-file"></i><span>Api Runner</span></a>
                </div> -->
                <!-- <div class="nav-item {{ $segment2 == 'crudgen' ? 'active' : '' }}">
                    <a href="{{ route('crudgen.index') }}" class="a-item"><i
                            class="ik ik-grid"></i><span>Crudgen</span></a>
                </div> -->
            </nav>
        </div>
    </div>
</div>
