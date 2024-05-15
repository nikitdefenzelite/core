@extends('layouts.main')
@section('title', @$user->getPrefix() . ' User Show')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('panel/admin/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('panel/admin/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .dt-button.dropdown-item.buttons-columnVisibility.active {
                background: #322d2d !important;
            }

            .center {
                position: absolute;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ Str::limit(@$user->full_name, 20) }}</h5>
                            <span>{{ __('admin/ui.user') }} {{ __('admin/ui.profile') }}</span>
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
                                <a href="{{ route('panel.admin.users.index') }}">{{ __('admin/ui.user') }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">{{ __('admin/ui.show') }}</li>
                            <li class="breadcrumb-item fw-600" aria-current="page">{{ __('admin/ui.profile') }}</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>

        @include('panel.admin.include.message')

        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="d-flex">
                                @if (getSetting('dac_activation') == 1)
                                    <div class="" style="position: relative">
                                        @if ($user->status == App\Models\User::STATUS_ACTIVE)
                                            <a href="{{ route('panel.admin.users.login-as', $user->id) }}"
                                                class="text-danger loginAsBtn" data-user_id="{{ $user->id }}"
                                                data-first_name="{{ $user->first_name }}">
                                                <span title="Login As User">
                                                    <i class="fa fa-right-to-bracket "></i>
                                                </span>
                                        @endif
                                        </a>
                                    </div>
                                @else
                                    @if ($user->status == App\Models\User::STATUS_ACTIVE)
                                        <div class="" style="position: relative">
                                            <a href="{{ route('panel.admin.users.login-as', $user->id) }}"
                                                class="text-danger" data-user_id="{{ $user->id }}"
                                                data-first_name="{{ $user->first_name }}">
                                                <span title="Login As User">
                                                    <i class="fa fa-right-to-bracket "></i>
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                                <div style="width: 150px; height: 150px; position: relative" class="mx-auto">
                                    <img src="{{ @$user && @$user->avatar ? @$user->avatar : asset('panel/admin/default/default-avatar.png') }}"
                                        class="rounded-circle" width="150"
                                        style="object-fit: cover; width: 150px; height: 150px" />
                                    <button class="btn btn-dark rounded-circle position-absolute"
                                        style="width: 30px; height: 30px; padding: 8px; line-height: 1; top: 0; right: 0"
                                        data-toggle="modal" data-target="#updateProfileImageModal"><i
                                            class="ik ik-camera"></i></button>
                                </div>
                                <div class="dropdown d-flex" style="margin-bottom: 130px;">
                                    <button style="background: transparent;border:none;" class="dropdown-toggle"
                                        type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="ik ik-more-vertical"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if (env('DEV_MODE') == 1)
                                            <a>
                                                <li class="dropdown-item text-dark fw-700">
                                                    {{ __('admin/ui.send_credential') }}</li>
                                            </a>
                                        @endif
                                    </ul>
                                </div>


                            </div>
                            <h5 class="mb-0 mt-3">
                                {{ Str::limit(@$user->full_name, 20 ?? '--') }}
                                @if (@$user->is_verified == 1)
                                    <strong class="mr-1"><i class="ik ik-check-circle"></i></strong>
                                @endif
                            </h5>
                            <span class="text-muted fw-600">Role: {{ UserRole(@$user->id)->display_name ?? '--' }}
                            </span>

                            <a href="{{ route('panel.admin.users.edit', secureToken($user->id)) }}" class="btn btn-link">
                                <span title="Edit User"><i class="fa fa-edit"></i></span> Edit
                            </a>
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="card-body">
                        <small class="text-muted d-block">{{ __('admin/ui.email_address') }}</small>
                        <div class="d-flex justify-content-between">
                            <h6 style="overflow-wrap: anywhere;"><span><i class="ik ik-mail mr-1"></i><a
                                        href="mailto:{{ @$user->email ?? '--' }}"
                                        id="copyemail">{{ @$user->email ?? '--' }}</a></span></h6>
                            <span class="text-copy" title="Copy" data-clipboard-target="#copyemail">
                                <i class="ik ik-copy"></i>
                            </span>
                        </div>
                        <small class="text-muted d-block pt-10">{{ __('admin/ui.phone_number') }}</small>
                        <div class="d-flex justify-content-between">
                            <h6><span><a href="tel:{{ @$user->phone ?? '--' }}" id="copyphone"><i
                                            class="ik ik-phone mr-1"></i>{{ @$user->phone ?? '--' }}</a></span>
                            </h6>
                            <span class="text-copy" title="Copy" data-clipboard-target="#copyphone" tile>
                                <i class="ik ik-copy"></i>
                            </span>
                        </div>
                        <small class="text-muted d-block pt-10">{{ __('admin/ui.member_since') }}</small>
                        <h6>{{ @$user->formatted_created_at ?? '--' }}</h6>
                        <div>
                            {{-- @if (getSetting('dac_activation') == 1) --}}
                            <small class="text-muted d-block pt-10">{{ __('admin/ui.delegate_access_code') }}</small>
                            {{-- <h6>{{ @$user->delegate_access ?? 'No Code Here Create New User' }}</h6> --}}
                            <div class="input-group mb-3">
                                <input id="password" type="password" autocomplete="off"
                                    class="form-control @error('password') is-invalid @enderror" minlength="4"
                                    name="password" value="{{ @$user->delegate_access }}" placeholder="Enter Password"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ik ik-eye" id="togglePassword"></i></span>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        @if (UserRole(@$user->id)->name != 'admin')
                            <li class="nav-item">
                                <a data-active="account-verfication"
                                    class="nav-link active-swicher @if ((request()->has('active') && request()->get('active') == 'account-verfication') || !request()->has('active')) active @endif"
                                    id="pills-note-tab" data-toggle="pill" href="#kyc-tab" role="tab"
                                    aria-controls="pills-note"
                                    aria-selected="false">{{ __('admin/ui.account_verification') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a data-active="password-tab"
                                class="nav-link active-swicher @if (
                                    (UserRole(@$user->id)->name == 'admin' && !request()->has('active')) ||
                                        (request()->has('active') && request()->get('active') == 'password-tab')) active @endif"
                                id="pills-password-tab" data-toggle="pill" href="#password-tab" role="tab"
                                aria-controls="pills-password"
                                aria-selected="false">{{ __('admin/ui.change_password') }}</a>
                        </li>
                        <li class="nav-item">
                            <a data-active="lead-tab"
                                class="nav-link active-swicher @if (request()->has('active') && request()->get('active') == 'lead-tab') show active @endif"
                                id="pills-lead-tab" data-toggle="pill" href="#lead-tab" role="tab"
                                aria-controls="pills-lead" aria-selected="false">{{ __('admin/ui.notes') }}</a>
                        </li>
                        <li class="nav-item">
                            <a data-active="contact-tab"

                               class="nav-link active-swicher @if (request()->has('active') && request()->get('active') == 'contact-tab') show active @endif"
                               id="pills-contact-tab" data-toggle="pill" href="#contact-tab" role="tab"
                               aria-controls="pills-contact"
                               aria-selected="false">{{ __('admin/ui.contacts') }}</a>

                        </li>
                        @if (auth()->user()->isAbleTo('view_addresses'))
                            <li class="nav-item">
                                <a data-active="address-tab"

                                   class="nav-link active-swicher @if (request()->has('active') && request()->get('active') == 'address-tab') show active @endif"
                                   id="pills-address-tab" data-toggle="pill" href="#address-tab" role="tab"
                                   aria-controls="pills-address"
                                   aria-selected="false">{{ __('admin/ui.addresses') }}</a>

                            </li>
                        @endif
                        @if (auth()->user()->isAbleTo('view_banks'))
                            <li class="nav-item">
                                <a data-active="Bank-details-tab"

                                   class="nav-link active-swicher @if (request()->has('active') && request()->get('active') == 'Bank-details-tab') show active @endif"
                                   id="pills-Bank-details-tab" data-toggle="pill" href="#Bank-details-tab"
                                   role="tab" aria-controls="pills-bank-details"
                                   aria-selected="false">{{ __('admin/ui.banks') }}</a>

                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        @if (UserRole(@$user->id)->name != 'admin')
                            <div class="tab-pane fade  @if ((request()->has('active') && request()->get('active') == 'account-verfication') || !request()->has('active')) show active @endif"
                                id="kyc-tab" role="tabadmin" aria-labelledby="pills-note-tab">
                                @include('panel.admin.users.includes.kyc')
                            </div>
                        @endif
                        <div class="tab-pane fade @if (
                            (UserRole(@$user->id)->name == 'admin' && !request()->has('active')) ||
                                (request()->has('active') && request()->get('active') == 'password-tab')) show active @endif" id="password-tab"
                            role="tabadmin" aria-labelledby="pills-setting-tab" id="ajax-container">
                            @include('panel.admin.users.includes.change-password')
                        </div>

                        <div class="tab-pane fade @if (request()->has('active') && request()->get('active') == 'lead-tab') show active @endif" id="lead-tab"
                            role="tabadmin" aria-labelledby="pills-setting-tab">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <h3>{{ __('admin/ui.notes') }}</h3>
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-primary"
                                    data-toggle="modal" data-target="#exampleModalCenter" title="Add New Note"><i
                                        class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-body ajax-lead-tab" style="overflow: auto" id="">
                                @include('panel.admin.users.includes.notes.index')
                            </div>
                        </div>

                        <div class="tab-pane fade @if (request()->has('active') && request()->get('active') == 'contact-tab') show active @endif" id="contact-tab"
                            role="tabadmin" aria-labelledby="pills-setting-tab">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <h3>{{ __('admin/ui.contacts') }}</h3>
                                @if (auth()->user()->isAbleTo('add_contact'))
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-primary"
                                        data-toggle="modal" data-target="#ContactModalCenter" title="Add New Contact"><i
                                            class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                            </div>
                            <div class="card-body ajax-contact-tab" id="">
                                @include('panel.admin.users.includes.contacts.index')
                            </div>
                        </div>
                        <div class="tab-pane fade @if (request()->has('active') && request()->get('active') == 'address-tab') show active @endif" id="address-tab"
                            role="tabadmin" aria-labelledby="pills-setting-tab">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <h3>{{ __('admin/ui.address') }}</h3>
                                @if (auth()->user()->isAbleTo('add_address'))
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-primary"
                                        data-toggle="modal" data-target="#addressModalCenter" title="Add New Address"><i
                                            class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                            </div>
                            @if (auth()->user()->isAbleTo('control_address'))
                                <div class="card-body ajax-address-tab" id="">
                                    @include('panel.admin.users.includes.addresses.index')
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade @if (request()->has('active') && request()->get('active') == 'Bank-details-tab') show active @endif"
                            id="Bank-details-tab" role="tabadmin" aria-labelledby="pills-setting-tab">
                            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                                <h3>{{ __('admin/ui.bank_details') }}</h3>
                                @if (auth()->user()->isAbleTo('add_bank'))
                                    <a href="javascript:void(0);"
                                        class="btn btn-icon btn-sm btn-outline-primary addPayoutDetailBtn"
                                        data-toggle="modal" data-target="#BankDetailsModalCenter"
                                        title="Add New Bank Detail"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                            </div>
                            @if (auth()->user()->isAbleTo('control_bank'))
                                <div class="card-body ajax-Bank-details-tab" id="">
                                    @include('panel.admin.users.includes.bank-details.index')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- tab end --}}


            </div>

        </div>
    </div>
    @include('panel/admin/users/includes/profile-modal')
    @include('panel.admin.users.includes.modal.delegate-access')
    @include('panel.admin.users.includes.contacts.create')
    @include('panel.admin.users.includes.contacts.edit')
    @include('panel.admin.users.includes.notes.create')
    @include('panel.admin.users.includes.notes.edit')
    @include('panel.admin.users.includes.addresses.create')
    @include('panel.admin.users.includes.addresses.edit')
    @include('panel.admin.users.includes.bank-details.create')
    @include('panel.admin.users.includes.bank-details.edit')
    @push('script')
        <script src="{{ asset('panel/admin/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('panel/admin/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.12/clipboard.min.js"></script>
        <script src="{{ asset('panel/admin/plugins/datedropper/croppie.min.js') }}"></script>


        {{-- START AJAX FORM INIT --}}

        <script>
            // STORE DATA USING AJAX
            $('.ajaxForm').on('submit', function(e) {
                e.preventDefault();
                var route = $(this).attr('action');
                var method = $(this).attr('method');
                var data = new FormData(this);
                var response = postData(method, route, 'json', data, null, null);
                if (typeof(response) != "undefined" && response !== null && response.status == "success") {}
            });
        </script>
        {{-- END AJAX FORM INIT --}}

        {{-- START JS HELPERS INIT --}}
        <script>
            $(document).ready(function() {
                var table = $('.data_table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [{
                        extend: 'excel',
                        className: 'btn-sm btn-success',
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: ':visible',
                        }
                    }, ]

                });
            });

            document.getElementById('avatar').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#avatar_file').removeClass('d-none');
                document.getElementById('avatar_file').src = src
            }

            function updateCoords(im, obj) {
                $('#x').val(obj.x1);
                $('#y').val(obj.y1);
                $('#w').val(obj.width);
                $('#h').val(obj.height);
            }

            function getStates(countryId = 101) {
                $.ajax({
                    url: '{{ route('world.get-states') }}',
                    method: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(res) {
                        $('#state').html(res).css('width', '100%').select2();
                    }
                })
            }

            function getCities(stateId = 101) {
                $.ajax({
                    url: '{{ route('world.get-cities') }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(res) {
                        $('#city').html(res).css('width', '100%').select2();
                    }
                })
            }

            // Country, City, State Code
            $('#state, #country, #city').css('width', '100%').select2();

            getStates(101);
            $('#country').on('change', function(e) {
                getStates($(this).val());
            })

            $('#state').on('change', function(e) {
                getCities($(this).val());
            })

            // this functionality work in edit page
            function getStateAsync(countryId) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route('world.get-states') }}',
                        method: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(data) {
                            $('#state').html(data);
                            $('#stateEdit').html(data);
                            $('.state').html(data);
                            resolve(data)
                        },
                        error: function(error) {
                            reject(error)
                        },
                    })
                })
            }

            function getCityAsync(stateId) {
                if (stateId != "") {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route('world.get-cities') }}',
                            method: 'GET',
                            data: {
                                state_id: stateId
                            },
                            success: function(data) {
                                $('#city').html(data);
                                $('#cityEdit').html(data);
                                $('.city').html(data);
                                resolve(data)
                            },
                            error: function(error) {
                                reject(error)
                            },
                        })
                    })
                }
            }

            $(document).ready(function() {
                $('.accept').on('click', function() {
                    $('#status').val(1)
                });
                $('.reject').on('click', function() {
                    $('#status').val(2)
                });
                $('.reset').on('click', function() {
                    $('#status').val(0)
                });
                var country = "{{ $user->country_id }}";
                var state = "{{ $user->state_id }}";
                var city = "{{ $user->city_id }}";

                if (state) {
                    getStateAsync(country).then(function(data) {
                        $('#state').val(state).change();
                        $('#state').trigger('change');
                    });
                }
                if (city) {
                    $('#state').on('change', function() {
                        if (state == $(this).val()) {
                            getCityAsync(state).then(function(data) {
                                $('#city').val(city).change();
                                $('#city').trigger('change');
                            });
                        }
                    });
                }
            });
            $(function() {
                new Clipboard('.text-copy');
            });
            $('.edit-note').each(function() {
                $(this).click(function() {
                    var data = $(this).data('item');
                    $('#note-type_id').val(data.type_id);
                    $('#note-title').val(data.title);
                    $('#note-description').val(data.description);
                    setTimeout(() => {
                        $('#category_id').val(data.category_id).change();
                    }, 500);
                    var url = "{{ url('/admin/user-notes/update') }}" + '/' + data.id;
                    $('#editNoteForm').attr('action', url);
                    $('#editModalCenter').modal('show');
                })
            });
            $('.edit-contact').each(function() {
                $(this).click(function() {
                    var contact = $(this).data('contact');
                    $('#edit_type_id').val(contact.type_id);
                    $('#edit_first_name').val(contact.first_name);
                    $('#edit_last_name').val(contact.last_name);
                    $('#edit_job_title').val(contact.job_title);
                    $('#edit_job_title').val(contact.job_title);
                    $('#edit_email').val(contact.email);
                    $('#edit_job_title').val(contact.job_title);
                    $('#edit_phone').val(contact.phone);
                    if (contact.gender == 'male') {
                        $('.male-radio').attr('checked', true)
                    } else {
                        $('.female-radio').attr('checked', true)
                    }
                    var url = "{{ url('/admin/contacts/update') }}" + '/' + contact.id;
                    $('#editContactForm').attr('action', url);
                    $('#editContact').modal('show');
                })
            });
            $('.editAddress').click(function() {
                var address = $(this).data('id');
                var details = address.details;
                if (details.type == 0) {
                    $('.homeInput').attr("checked", "checked");
                } else {
                    $('.officeInput').attr("checked", "checked");
                }

                $('#editName').val(details.name);
                $('#id').val(address.id);
                $('#addressId').val(address.id);
                $('#user_id').val(address.user_id);
                $('#type').val(address.type);
                $('#editPhone').val(details.phone);
                $('#editAddress').val(details.address_1);
                $('#editAddress_2').val(details.address_2);
                $('#pincode_id').val(details.pincode_id);
                $('#countryEdit').val(details.country_id).change();
                getStateAsync(details.country_id).then(function(data) {
                    $('#stateEdit').val(details.state_id).change();
                    $('#stateEdit').trigger('change');
                });
                getCityAsync(details.state_id).then(function(data) {
                    $('#cityEdit').val(details.city).change();
                    $('#cityEdit').trigger('change');
                });
                $('#editAddressModal').modal('show');
            });

            $(document).on('click', '.addPayoutDetailBtn', function() {
                $('#bankDetailsModalCenter').modal('show');
            });
            $(document).on('click', '.editPayoutDetailBtn', function() {
                let record = $(this).data('row');
                console.log(record);
                let payload = $(this).data('payload');
                console.log(payload);
                if (record.type == "Saving")
                    $('#editsaving').prop('checked', true);
                else
                    $('#editcurrent').prop('checked', true);

                $('#payoutdetailId').val(record.id);
                $('#editAcountHolderName').val(payload.account_holder_name);
                $('#editAccountNo').val(payload.account_no);
                $('#editIfscCode').val(payload.ifsc_code);
                $('#editBranch').val(payload.branch);
                $('#editbank option[value="' + payload.bank_name + '"]').prop('selected', true);
                $('#editBankDetailsModal').modal('show');
            });
            $('.active-swicher').on('click', function() {
                var active = $(this).attr('data-active');
                updateURL('search', ' ');
                updateURL('active', active);
            });
        </script>
        {{-- END JS HELPERS INIT --}}

        {{-- START DELEGATE ACCESS BUTTON INIT --}}
        <script>
            $(document).on('click', '.loginAsBtn', function(e) {
                e.preventDefault();
                let user_id = $(this).data('user_id');
                let first_name = $(this).data('first_name');
                $('.delegateUserId').val(user_id);
                $('.delegateUserName').html(first_name);
                $('#DelegateAccessModel').modal('show');
            });
        </script>
        {{-- END DELEGATE ACCESS BUTTON INIT --}}

        {{-- START DELEGATE ACCESS CODE HIDE SHOW INIT --}}
        <script>
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
        </script>
        {{-- END DELEGATE ACCESS CODE HIDE SHOW INIT --}}

        {{-- START PROFILE IMAGE CROPPER --}}
        <script>
            const avatar = document.getElementById('avatar');
            const imagePreview = document.getElementById('imagePreview');
            const croppedImageDataInput = document.getElementById('croppedImageData');
            const croppieContainer = document.querySelector('.demo');

            let croppieInstance = null;

            // When the input field for selecting an image changes
            avatar.onchange = evt => {
                const [file] = avatar.files;
                if (file) {
                    // Show the selected image in the preview
                    imagePreview.src = URL.createObjectURL(file);
                    // Initialize Croppie on the `.demo` element
                    croppieInstance = new Croppie(croppieContainer, {
                        enableExif: true,
                        viewport: {
                            width: 200,
                            height: 200,
                            type: 'circle'
                        },
                        boundary: {
                            width: 300,
                            height: 300
                        }
                    });

                    // Bind the selected image to Croppie
                    croppieInstance.bind({
                        url: URL.createObjectURL(file),
                    });
                }
            };

            // Capture cropped image data when the form is submitted
            document.querySelector('#updateProfileImageModal').onsubmit = () => {
                if (croppieInstance) {
                    croppieInstance.result('base64').then(function(result) {
                        // Set the cropped image data to the hidden input
                        croppedImageDataInput.value = result;
                    });
                }
            };
        </script>
        {{-- END PROFILE IMAGE CROPPER --}}

        {{-- START PREVIEW MODAL INIT --}}
        <script>
            $(document).ready(function() {
                // Handle click event on the open-modal class
                $('.open-modal').on('click', function() {
                    // Get the image source from the clicked link
                    var documentSrc = $(this).attr('href');

                    // Set the image source dynamically in the modal
                    $('#previewImageContainer').html(
                        `<img src="${documentSrc}" class="img-fluid" alt="File Preview">`);
                });

                // Initialize Bootstrap modal
                $('#filePreviewModal').modal({
                    show: false
                });
            });
        </script>
        {{-- END PREVIEW MODAL INIT --}}
    @endpush
@endsection
