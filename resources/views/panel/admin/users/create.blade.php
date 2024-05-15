@extends('layouts.main')
@section('title', 'Add ' . @$label)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush


    <div class="container-fluid">
        {{-- @dd(request()->get('role')); --}}
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('admin/ui.add') }} {{ @$label ?? '' }}</h5>
                            <span>{{ __('Create new user, assign roles & permissions') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.admin.dashboard.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.admin.users.index') }}">{{ @$label ?? '' }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">{{ __('add') }} {{ @$label ?? '' }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <form class="ajaxForm" method="POST" action="{{ route('panel.admin.users.store') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="request_with" value="create">
            <input type="hidden" name="role" value="{{ request()->get('role') }}">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->

                <div class="col-md-7 mx-auto">
                    @include('panel.admin.include.message')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('admin/ui.personal_info') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ __('First Name') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_first_name') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="first_name" type="text" pattern="{{ regex('name')['pattern'] }}"
                                            title="{{ regex('name')['message'] }}"
                                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                            value="{{ old('first_name') }}" placeholder="Enter First Name" required>
                                        <div class="help-block with-errors"></div>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">{{ __('Last Name') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_last_name') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="last_name" type="text" pattern="{{ regex('name')['pattern'] }}"
                                            title="{{ regex('name')['message'] }}"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            pattern="[A-Za-z]{1,20}" name="last_name" value="{{ old('last_name') }}"
                                            placeholder="Enter Last Name" required>
                                        <div class="help-block with-errors"></div>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.add_user_email') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="email" type="email" pattern="{{ regex('email')['pattern'] }}"
                                            title="{{ regex('email')['message'] }}" maxlength="30" max="30"
                                            autocomplete="off" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" data-encrypt="true"
                                            placeholder="Enter Email Address" required>
                                        <div class="help-block with-errors"></div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ __('Contact Number') }}@if (@validation('common_phone_number')['pattern']['mandatory'])
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label><a data-toggle="tooltip" href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_phone') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input required id="phone" type="number" placeholder="Enter Phone Number"
                                            pattern="{{ regex('phone_number')['pattern'] }}"
                                            title="{{ regex('phone_number')['message'] }}"
                                            minlength="{{ @validation('common_phone_number')['pattern']['minlength'] }}"
                                            maxlength="{{ @validation('common_phone_number')['pattern']['minlength'] }}"
                                            {{ @validation('common_phone_number')['pattern']['mandatory'] }}
                                            min="10" class="form-control" name="phone"
                                            value="{{ old('phone') }}" data-encrypt="true">

                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">{{ __('Gender') }}</label><a data-toggle="tooltip"
                                            href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_gender') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>

                                        <div class="form-radio">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="gender" value="Male">
                                                    <i class="helper"></i>{{ __('Male') }}
                                                </label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="gender" value="Female">
                                                    <i class="helper"></i>{{ __('Female') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                @if (request()->get('role') == 'Member')
                                    <div class="col-md-6 displayRole ">
                                        <div class="form-group">
                                            <label for="display_role_name">{{ __('Designation') }}<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control select2" name="userPermission">
                                                <option value="" readonly>Select Designation</option>
                                                @foreach ($userPermissions as $key => $userPermission)
                                                    <option value="{{ $key }}">{{ $userPermission['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">{{ __('DOB') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.add_user_dob') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input required class="form-control" pattern="{{ regex('dob')['pattern'] }}"
                                            max="{{ now()->format('Y-m-d') }}" title="{{ regex('dob')['message'] }}"
                                            type="date" id="dob" name="dob"
                                            placeholder="Select your date" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-6  d-flex align-items-center">
                                    <div class="form-group d-none">
                                        <label for="">{{ __('status') }}<span class="text-red">*</span>
                                        </label><a data-toggle="tooltip" href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_status') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input class="js-switch switch-input"
                                            @if (old('status')) checked @endif name="status"
                                            type="checkbox" id="status" value="1" checked>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mx-auto">
                    @include('panel.admin.include.message')
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="mb-0">{{ __('admin/ui.roles_security') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class=" d-flex justify-content-between">
                                            <div>
                                                <label for="password">{{ __('admin/ui.set_password') }}<span
                                                        class="text-red">*</span></label>
                                                <a data-toggle="tooltip" href="javascript:void(0);"
                                                    title="{{ __('admin/tooltip.add_user_password') }}"><i
                                                        class="ik ik-help-circle text-muted ml-1"></i></a>
                                            </div>
                                            <button type="button" class="btn btn-link p-0 m-0 generate_pass">Generate
                                                Password
                                            </button>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="password" type="password" autocomplete="off"
                                                pattern="{{ regex('password')['pattern'] }}"
                                                title="{{ regex('password')['message'] }}"
                                                class="form-control @error('password') is-invalid @enderror"
                                                minlength="4" name="password" value="{{ old('password') }}"
                                                placeholder="Enter Password" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="ik ik-eye"
                                                        id="togglePassword"></i></span>
                                            </div>
                                        </div>


                                        <div class="help-block with-errors"></div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <input id="send_mail" class="py-2" type="checkbox" name="send_mail"
                                            value="1">
                                        <label for="send_mail">{{ __('send_mail') }}</label><a
                                            data-toggle="tooltip" href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.add_user_send_mail') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <div class="help-block with-errors"></div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="verify_mail" class="my-auto" type="checkbox" name="email_verify"
                                            value="1">
                                        <label for="verify_mail">{{ __('verify_mail') }} </label> <a
                                            data-toggle="tooltip" href="javascript:void(0);"
                                            title="{{ __('admin/tooltip.edit_user_send_mail') }}"><i
                                                class="ik ik-help-circle text-muted "></i></a>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="role" value="{{ request()->get('role') ?? '' }}">
            <button class="btn btn-primary floating-btn ajax-btn" type="submit">
                Create {{ request()->get('role') ?? '' }}
            </button>
        </form>
    </div>

    {{--    @include('panel.admin.users.include.modal.bulk-upload') --}}
    <!-- push external js -->
    @push('script')
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('admin/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>

        {{-- START SELECT 2 BUTTON INIT --}}
        <script src="{{ asset('admin/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script>
            $('select.select2').select2();
        </script>
        {{-- END SELECT 2 BUTTON INIT --}}

        {{-- START AJAX FORM INIT --}}

        <script>
            $('.ajaxForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var route = form.attr('action');
                var method = form.attr('method');
                var data = new FormData(this);
                var role = $('#role').val();
                var redirectUrl = "{{ url('admin/users') }}" + '?role=' + role;
                var response = postData(method, route, 'json', data, null, null, '1', true, redirectUrl, form);
            })
        </script>
        {{-- END AJAX FORM INIT --}}

        {{-- START JS HELPERS INIT --}}
        <script>
            $(document).ready(function() {
                $('#togglePassword').click(function() {
                    var input = $('#password');
                    var icon = $(this);

                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('ik-eye').addClass('ik-eye-off');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('ik-eye-off').addClass('ik-eye');
                    }
                });

                $('.generate_pass').on('click', function() {
                    var length = 6;
                    var chars = "abcdefghijklmnopqrstuvwxyz!@#@$%^&*ABCDEFGHIJKLMNOP1234567890";
                    var pass = "";
                    for (var x = 0; x < length; x++) {
                        var i = Math.floor(Math.random() * chars.length);
                        pass += chars.charAt(i);
                    }
                    $('#password').val(pass);
                });
            });




            $(document).ready(function() {
                $('#togglePassword').click(function() {
                    var input = $('#password');
                    var icon = $(this);

                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        icon.removeClass('ik-eye').addClass('ik-eye-off');
                    } else {
                        input.attr('type', 'password');
                        icon.removeClass('ik-eye-off').addClass('ik-eye');
                    }
                });


            });

            $('.generate_pass').on('click', function() {
                var length = 6;
                var chars = "abcdefghijklmnopqrstuvwxyz!@#@$%^&*ABCDEFGHIJKLMNOP1234567890";
                var pass = "";
                for (var x = 0; x < length; x++) {
                    var i = Math.floor(Math.random() * chars.length);
                    pass += chars.charAt(i);
                }
                $('#password').val(pass);
            });
        </script>
        {{-- START JS HELPERS INIT --}}
    @endpush
@endsection
