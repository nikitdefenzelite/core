
<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>

                <a href="javascript:void(0)" onclick="window.history.back();" title="Back" type="button" id=""
                    class="nav-link bg-gray mr-1"><i class="ik ik-arrow-left"></i></a>

                <button type="button" id="navbar-fullscreen" title="Full Screen" class="nav-link"><i
                        class="ik ik-maximize"></i></button>
                <a href="{{ url('/') }}" type="button" id="" title="Go to Home"
                    class="nav-link bg-gray ml-1"><i class="ik ik-home"></i></a>
               
            </div>
            <div class="top-menu d-flex align-items-center">
                
                <div class="dropdown">

                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="avatar"
                            src="{{ auth()->user() && auth()->user()->avatar ? auth()->user()->avatar : asset('backend/default/default-avatar.png') }}"
                            style="object-fit: cover; width: 35px; height: 35px" alt="">
                        <span class="user-name font-weight-bolder"
                            style="top: -0.8rem;position: relative;margin-left: 8px;">{{ auth()->user()->full_name }}
                            <span class="text-muted"
                                style="font-size: 10px;position: absolute;top: 16px;left: 0px;">{{ auth()->user()->role_name }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="" onClick="event.preventDefault();this.closest('form').submit();"
                                class="dropdown-item text-danger fw-700"><i
                                    class="ik ik-power dropdown-icon text-danger"></i>
                                {{ __('Log out') }}
                            </a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
