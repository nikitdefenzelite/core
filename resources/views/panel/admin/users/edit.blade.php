@extends('layouts.main')
@section('title', ' User Edit')
@section('content')

    @php
        @$breadcrumb_arr = [
            // ['name' =>@$label, 'url' =>  route('panel.admin.users.index'), 'class' => '--'],
            ['name' => $label, 'url' => route('panel.admin.users.index'), 'class' => '--'],
            ['name' => @$user->getPrefix(), 'url' => route('panel.admin.users.index'), 'class' => '--'],
            ['name' => 'Edit', 'url' => route('panel.admin.users.index'), 'class' => 'active'],
        ];
        $permissions = [
            ['module' => 'Manage Order','childrens'=>
                [
                    
                ['label'=>'View','name'=>'view_order'],
                ['label'=>'Add','name'=>'add_order'],
                ['label'=>'Edit','name'=>'edit_order'],
                ['label'=>'Delete','name'=>'delete_order'],
                
                ],
         ],
            ['module' => 'Manage Subscribers','childrens'=>
                [
                    
                ['label'=>'View','name'=>'view_subscribers'],
                ['label'=>'Add','name'=>'add_subscribers'],
                ['label'=>'Edit','name'=>'edit_subscribers'],
                ['label'=>'Delete','name'=>'delete_subscribers'],
                
                ],
         ],
            ['module' => 'Manage Payouts','childrens'=>
                [
                    
                ['label'=>'View','name'=>'view_payout'],
                ['label'=>'Add','name'=>'add_payout'],
                ['label'=>'Edit','name'=>'edit_payout'],
                ['label'=>'Delete','name'=>'delete_payout'],
                
                ],
         ],
            ['module' => 'Manage Items','childrens'=>
                [

                ['label'=>'View','name'=>'view_item'],
                ['label'=>'Add','name'=>'add_item'],
                ['label'=>'Edit','name'=>'edit_item'],
                ['label'=>'Delete','name'=>'delete_item'],
                ['label'=>'Bulk Upload','name'=>'bulk_upload_item'],
                ['label'=>'FeedBack','name'=>'view_feedback'],
                
                ],
         ],
            ['module' => 'Subscriptions Plans','childrens'=>
                [

                ['label'=>'View','name'=>'view_subscriptions'],
                ['label'=>'Add','name'=>'add_subscriptions'],
                ['label'=>'Edit','name'=>'edit_subscriptions'],
                ['label'=>'Delete','name'=>'delete_subscriptions'],
                
                ],
         ],
            ['module' => 'Reports','childrens'=>
                [

                ['label'=>' Purchase Flow','name'=>'view_purchase'],
                ['label'=>'Registeration Flow','name'=>'view_registeration'],
                
                ],
         ],
            ['module' => 'Administrator','childrens'=>
                [
                    
                ['label'=>'Admin Management','name'=>'view_admin'],
                ['label'=>'Add Admin','name'=>'add_admin'],
                ['label'=>'Edit Admin','name'=>'edit_admin'],
                ['label'=>'Delete Admin','name'=>'delete_admin'],
                ['label'=>'User Management','name'=>'view_user'],
                ['label'=>'Add User','name'=>'add_user'],
                ['label'=>'Edit User','name'=>'edit_user'],
                ['label'=>'Delete User','name'=>'delete_user'],
                
                ],
         ],
            ['module' => 'Contact-Enquiry','childrens'=>
                [
                    
                ['label'=>'View','name'=>'view_enquiry'],
                ['label'=>'Add','name'=>'add_website_enquiry'],
                ['label'=>'Show','name'=>'show_website_enquiry'],
                ['label'=>'Edit','name'=>'edit_website_enquiry'],
                ['label'=>'Delete','name'=>'delete_website_enquiry'],
                ['label'=>'Bulk Upload','name'=>'bulk_upload_enquiry'],
                
                ],
         ],
            ['module' => 'Newsletters','childrens'=>
                [
                    ['label'=>'View','name'=>'view_newsletter'],
                    ['label'=>'Add ','name'=>'add_newsletter'],
                    ['label'=>'Edit ','name'=>'edit_newsletter'],
                    ['label'=>'Delete ','name'=>'delete_newsletter'],
                    ['label'=>'Bulk Upload ','name'=>'bulk_upload_newsletter'],
                ],
         ],
            ['module' => 'Lead','childrens'=>
                [
                    ['label'=>'View','name'=>'view_Lead'],
                    ['label'=>'Add ','name'=>'add_Lead'],
                    ['label'=>'Show ','name'=>'show_Lead'],
                    ['label'=>'Edit ','name'=>'edit_Lead'],
                    ['label'=>'Delete ','name'=>'delete_Lead'],
                    ['label'=>'Bulk Upload ','name'=>'bulk_upload_Lead'],
                ],
         ],
            ['module' => 'Templates','childrens'=>
                [
                    ['label'=>'View','name'=>'view_template'],
                    ['label'=>'Add ','name'=>'add_template'],
                    ['label'=>'Show ','name'=>'show_template'],
                    ['label'=>'Edit ','name'=>'edit_template'],
                    ['label'=>'Delete ','name'=>'delete_template'],
                    
                ],
            ],
            ['module' => 'Category Groups','childrens'=>
                [
                    ['label'=>'View','name'=>'view_category_type'],
                    ['label'=>'Add ','name'=>'add_category_type'],
                    ['label'=>'Edit ','name'=>'edit_category_type'], 
                    ['label'=>'Sync ','name'=>'sync_category_type'], 
                ],
            ],
            ['module' => 'Categories ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_categories'],
                    ['label'=>'Add ','name'=>'add_categories'],
                    ['label'=>'Edit ','name'=>'edit_categories'], 
                 
                ],
            ],
            ['module' => 'Slider Type ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_slider_type'],
                    ['label'=>'Add ','name'=>'add_slider_type'],
                    ['label'=>'Edit ','name'=>'edit_slider_type'], 
                    ['label'=>'Sync ','name'=>'sync_slider_type'], 
                 
                ],
            ],
            ['module' => 'Slider ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_slider'],
                    ['label'=>'Add ','name'=>'add_slider'],
                    ['label'=>'Edit ','name'=>'edit_slider'], 
                    ['label'=>'Delete ','name'=>'delete_slider'], 
                    ['label'=>'Bulk Upload ','name'=>'bulk_upload_slider'], 
                 
                ],
            ],
            ['module' => 'Paragraph Contents ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_paragraph'],
                    ['label'=>'Add ','name'=>'add_paragraph'],
                    ['label'=>'Edit ','name'=>'edit_paragraph'], 
                    ['label'=>'Delete ','name'=>'delete_paragraph'], 
                    ['label'=>'Bulk Upload ','name'=>'bulk_upload_paragraph'], 
                 
                ],
            ],
            ['module' => 'FAQs ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_faq'],
                    ['label'=>'Add ','name'=>'add_faq'],
                    ['label'=>'Edit ','name'=>'edit_faq'], 
                    ['label'=>'Delete ','name'=>'delete_faq'], 
                    ['label'=>'Bulk Upload ','name'=>'bulk_upload_faq'], 
                 
                ],
            ],
            ['module' => 'Locations ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_location'],
                    ['label'=>'Add ','name'=>'add_location'],
                    ['label'=>'Edit ','name'=>'edit_location'],   
                ],
            ],
            ['module' => 'State ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_state'],
                    ['label'=>'Add ','name'=>'add_state'],
                    ['label'=>'Edit ','name'=>'edit_state'],   
                ],
            ],
            ['module' => 'City ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_city'],
                    ['label'=>'Add ','name'=>'add_city'],
                    ['label'=>'Edit ','name'=>'edit_city'],   
                ],
            ],
            ['module' => 'Control Seo ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_seo'],
                    ['label'=>'Add ','name'=>'add_seo'],
                    ['label'=>'Edit ','name'=>'edit_seo'],   
                    ['label'=>'Delete ','name'=>'delete_seo'],   
                ],
            ],
            ['module' => 'Website Pages ','childrens'=>
                [
                    ['label'=>'View','name'=>'view_pages'],
                    ['label'=>'Add ','name'=>'add_pages'],
                    ['label'=>'Edit ','name'=>'edit_pages'],     
                ],
            ],
            ['module' => 'Resource','childrens'=>
                [
                    
                ['label'=>'View','name'=>'view_resource'],
                ['label'=>'Add','name'=>'add_resource'],
                ['label'=>'Edit','name'=>'edit_resource'],
                ['label'=>'Delete','name'=>'delete_resource'],
                
                ],
         ],
            ['module' => 'Blog','childrens'=>
                [
                ['label'=>'View','name'=>'view_blog'],
                ['label'=>'Add','name'=>'add_blog'],
                ['label'=>'Edit','name'=>'edit_blog'],
                ['label'=>'Show','name'=>'show_blog'],
                ['label'=>'Delete','name'=>'delete_blog'],
                
                ],
         ],
            ['module' => 'Support Ticket','childrens'=>
                [
                ['label'=>'View','name'=>'view_support_ticket'],
                ['label'=>'Add','name'=>'add_support_ticket'],
                ['label'=>'Edit','name'=>'edit_support_ticket'],
                ['label'=>'Show','name'=>'show_support_ticket'],
                ['label'=>'Delete','name'=>'delete_support_ticket'],
                
                ],
         ],
       
    ];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/jquery-minicolors/jquery.minicolors.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/datedropper/datedropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .modal-loading-css {
            min-height: 274px;
            justify-content: center;
            display: flex;
            align-items: center;
        }
        </style>
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            @if ($user->hasRole('admin'))
                                <h5>{{ __('admin/ui.edit') }} {{ $label }}</h5>
                                <span>{{ __('admin/ui.update_record') }} {{ $label }}</span>
                            @else
                                <h5>{{ __('admin/ui.edit') }} {{ __('admin/ui.user') }}</h5>
                                <span>{{ __('admin/ui.admin_subheading') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                    {{-- <nav class="breadcrumb-container" aria-label="breadcrumb">

                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('admin/ui.User')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ Str::limit($user->full_name,20)}}
                            </li>

                        </ol>
                    </nav> --}}
                </div>
            </div>
        </div>
        <form class="forms-sample ajaxForm" method="POST" action="{{ route('panel.admin.users.update', $user->id) }}">
            <div class="row">
                <!-- start message area-->
                @include('panel.admin.include.message')
                <!-- end message area-->
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <input type="hidden" name="request_with" value="update">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('admin/ui.personal_details') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ __('admin/ui.first_name') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_first_name') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="first_name" type="text" 
                                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                            value="{{ @$user->first_name }}" placeholder="Enter First Name" required>
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
                                        <label for="last_name">{{ __('admin/ui.last_name') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_last_name') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="last_name" type="text"  pattern="{{ regex('name')['pattern'] }}"
                                        title="{{ regex('name')['message'] }}"
                                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            value="{{ @$user->last_name }}" placeholder="Enter Last Name" required>
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
                                        <label for="email">{{ __('admin/ui.email') }}<span
                                                class="text-red">*</span></label><a
                                            data-toggle="tooltip"href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_email') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="email" type="email"  pattern="{{ regex('email')['pattern'] }}"
                                        title="{{ regex('email')['message'] }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter your email" maxlength="30" max="30" name="email"
                                            required value="{{ @$user->email }}" required>
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
                                        <label for="phone">{{ __('admin/ui.contact_number') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_phone') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="phone" type="number" class="form-control" name="phone"  pattern="{{ regex('phone_number')['pattern'] }}"
                                        title="{{ regex('phone_number')['message'] }}"
                                            pattern="^[0-9]*$" min="0" placeholder="Enter Contact Number" required
                                            value="{{ @$user->phone }}">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">{{ __('admin/ui.dob') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_dob') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input class="form-control" type="date" name="dob" 
                                            placeholder="Select your date" max="{{ now()->format('Y-m-d') }}"
                                            value="{{ @$user->dob }}" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role" required>{{ __('admin/ui.assign_role') }}<span
                                                class="text-red">*</span></label><a data-toggle="tooltip"
                                            href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_role') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <select name="role" id="role" class="form-control select2">
                                            <option value="" readonly>Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ @$role }}" @selected($user->role_name == @$role)>
                                                    {{ @$role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">{{ __('admin/ui.gender') }}</label><a
                                            data-toggle="tooltip" href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_gender') }}"><i
                                                class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <div class="form-radio">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="gender" value="Male"
                                                        {{ @$user->gender == 'Male' ? 'checked' : '--' }}>
                                                    <i class="helper"></i>{{ __('admin/ui.male') }}
                                                </label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="gender" value="Female"
                                                        {{ @$user->gender == 'Female' ? 'checked' : '--' }}>
                                                    <i class="helper"></i>{{ __('admin/ui.female') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 d-flex d-md-block d-lg-flex justify-content-between">
                                    <div class="form-group mt-30">
                                        <input id="send_mail" type="checkbox" name="send_mail" value="1"
                                            @if ($user->send_mail == 1) checked @endif>
                                        <label for="send_mail">{{ __('admin/ui.send_mail') }} </label> <a
                                            data-toggle="tooltip" href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_send_mail') }}"><i
                                                class="ik ik-help-circle text-muted "></i></a>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group mt-30">
                                        <input id="verify_mail" type="checkbox" name="email_verify" value="1"
                                            @if ($user->email_verified_at) checked @endif>
                                        <label for="verify_mail">{{ __('admin/ui.verify_mail') }}</label> <a
                                            data-toggle="tooltip" href="javascript:void(0);" title="{{ __('admin/tooltip.edit_user_send_mail') }}"><i
                                                class="ik ik-help-circle text-muted "></i></a>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group mt-30">
                                        <label for="status">{{ __('admin/ui.status') }} </label>
                                        <input class="js-switch switch-input"
                                            @if (old('status')) checked @endif name="status"
                                            type="checkbox" id="status" value="1"checked>
                                        {{-- <select required name="status" class="form-control select2">
                                            @foreach ($statuses as $key => $status)
                                                <option value="{{@$key }}" @selected($user->status ==@$key)>{{$status['label']}}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ __('admin/ui.verification') }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- <div class="fw-700 alert alert-info mb-2">This form does not need to be filled out if you do not wish to change your password.</div> --}}
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('admin/ui.Password')}}</label>
                                        <a href="javascript:void(0);" title="@lang('admin/ui.edit_user_password')"><i class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
                                        <div class="help-block with-errors"></div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{@$message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password-confirm">{{ __('admin/ui.Confirm Password')}}</label>
                                        <a href="javascript:void(0);" title="@lang('admin/ui.edit_user_password_confirmation')"><i class="ik ik-help-circle text-muted ml-1"></i></a>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="">
                                @php
                                    @$kyc_record = null;
                                    if ($user_kyc && isset($user_kyc->details) && @$user_kyc->details != null) {
                                        @$kyc_record = json_decode($user_kyc->details, true);
                                    }
                                @endphp
                                <div class="card-body">
                                    {{-- Status --}}
                                    @if (isset($user_kyc) && @$user_kyc->status == 0)
                                        <div class="alert alert-info">
                                            <i class="ik ik-alert-triangle"></i> Verification request isn't submitted yet!
                                        </div>
                                    @elseif(isset($user_kyc) && @$user_kyc->status == 1)
                                        <div class="alert alert-success">
                                            User Verification request has been verified!
                                        </div>
                                    @elseif(isset($user_kyc) && @$user_kyc->status == 2)
                                        <div class="alert alert-danger">
                                            User Verification request has been rejected!
                                        </div>
                                    @elseif(isset($user_kyc) && @$user_kyc->status == 3)
                                        <div class="alert alert-warning">
                                            User submited Verification request, Please validate and take appropriated
                                            action.
                                        </div>
                                    @else
                                        <div class="alert alert-info p-2">
                                            User havn't submitted Verification Request yet!
                                        </div>
                                    @endif

                                    {{-- <form action="{{ route('panel.admin.users.update-kyc-status') }}" method="POST" class="form-horizontal"> --}}
                                    @csrf
                                    <input id="status" type="hidden" name="status" value="">
                                    <input type="hidden" name="user_id" value="{{ @$user->id }}">
                                    <div class="row">
                                        <div class="col-md-6 col-6"> <label>{{ __('admin/ui.document') }}</label>
                                            <br>
                                            <h5 class="strong text-muted">{{ @$kyc_record['document_type'] ?? '--' }}</h5>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <label>{{ __('admin/ui.unique_identifier') }}</label>
                                            <br>
                                            <h5 class="strong text-muted">
                                                {{ Str::limit($kyc_record['document_number'] ?? '--', 25) }}</h5>
                                        </div>
                                        <div class="col-md-6 col-6"> <label>{{ __('admin/ui.front_side') }}</label>
                                            <br>
                                            @if ($kyc_record != null && @$kyc_record['document_front'] != null)
                                                <a href="{{ asset($kyc_record['document_front']) }}" target="_blank"
                                                    class="btn btn-outline-danger">View Attachment</a>
                                            @else
                                                <button disabled class="btn btn-secondary">Not Submitted</button>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-6"> <label>{{ __('admin/ui.back_side') }}</label>
                                            <br>
                                            @if ($kyc_record != null && @$kyc_record['document_back'] != null)
                                                @if ($kyc_record != null && @$kyc_record['document_back'] != null)
                                                    <a href="{{ asset($kyc_record['document_back']) }}" target="_blank"
                                                        class="btn btn-outline-danger">View Attachment</a>
                                                @else
                                                    <button disabled class="btn btn-secondary">Not Submitted</button>
                                                @endif
                                            @else
                                                <button disabled class="btn btn-secondary">Not Submitted</button>
                                            @endif
                                        </div>


                                        <hr class="m-2">

                                        @if (auth()->user()->hasRole('admin'))
                                            @if (isset($user_kyc) && @$user_kyc->status == 1)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <label>{{ __('admin/ui.note') }}</label>
                                                    <textarea class="form-control" name="remark" type="text">{{ @$Verification['admin_remark'] ?? '--' }}</textarea>
                                                    <button type="submit"
                                                        class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                                                </div>
                                            @elseif(isset($user_kyc) && @$user_kyc->status == 2)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <button type="submit"
                                                        class="btn btn-warning mt-2 btn-lg reset">Reset</button>
                                                </div>
                                            @elseif(isset($user_kyc) && @$user_kyc->status == 3)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <label>{{ __('admin/ui.rejection_reason') }}</label>
                                                    <textarea class="form-control" name="remark" type="text">{{ @$kyc_record['admin_remark'] ?? '--' }}</textarea>
                                                    <button type="submit"
                                                        class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                                                    <button type="submit"
                                                        class="btn btn-success accept ml-5 accept mt-2 btn-lg">Accept</button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (UserRole($user->id)->display_name == 'Member')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="mb-1 mt-1">{{ __('Access Permissions:')}}</h3>
                                <div>
                                    
                                    <select class="form-control select2" name="userPermission">
                                        <option value="" readonly>Select Permission Group</option>
                                        @foreach ($userPermissions as $key => $userPermission)
                                        <option value="{{ $key }}" @if($user->permissions != null && isset($user->permissions['key']) && $user->permissions['key'] == $key) selected @endif>{{ $userPermission['name'] }}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="loading-icon d-none">
                                <div class="modal-loading-css">
                                    <div class="text-center">
                                        <strong><i class="ik ik-loader fa-spin"></i></strong>
                                        <h6>Loading...</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body allPermission">
                                <div class="mb-2">
                                    <label class="custom-control custom-checkbox text-muted mb-0" style="width:90px;">
                                        {{-- @dd($user->permissions); --}}
                                        <input type="checkbox" class="custom-control-input"  id="select_all" name="permissions[all_item]"  @if($user->permissions &&$user->permissions && isset($user->permissions['permissions']) && in_array('all_item',$user->permissions)) checked @endif> 
                                            <span class="custom-control-label fw-700 "> 
                                                Select All
                                            </span> 
                                    </label>   
                                </div>
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-2 mb-3">
                                            <label class="fw-700 text-muted">{{ $permission['module'] }}</label>
                                            <div id="resCheked_{{ $permission['module'] }}">
                                                @foreach($permission['childrens'] as $child)
                                                <label class="custom-control custom-checkbox text-muted mb-0">
                                                    <input type="checkbox" class="custom-control-input checkbox-item" name="permissions[{{ $child['name'] }}]" value="{{ $child['name'] }}"  @if ($user->permissions && isset($user->permissions['permissions']) && in_array($child['name'], $user->permissions['permissions'])) checked @endif>
                                                    <span class="custom-control-label fw-700">{{ $child['label'] }}</span>
                                                </label>
                                            @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif 
            </div>
            <input type="hidden" id="role" value="{{ request()->get('role') ?? '--' }}">
            <button type="submit"
                class="btn btn-primary floating-btn ajax-btn">{{ __('admin/ui.save_update') }}
            </button>
        </form>
    </div>
    <!-- push external js -->
    @push('script')
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('admin/js/get-role.js') }}"></script>
        <script src="{{ asset('admin/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>
        <script src="{{ asset('admin/plugins/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/datedropper/datedropper.min.js') }}"></script>
        <script src="{{ asset('admin/js/form-picker.js') }}"></script>
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
                let route = $(this).attr('action');
                let method = $(this).attr('method');
                let data = new FormData(this);
                var role = $('#role').val();
                var redirectUrl = "{{ url('admin/users') }}" + '?role=' + role;
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
                console.log(response);
            })
        </script>
        {{-- END AJAX FORM INIT --}}
        <script>
             $(document).ready(function() {
                $('.select2[name="userPermission"]').on('change', function() {
                    var selectedPermission = $(this).val();
                    $('.allPermission').addClass('d-none');
                    $('.loading-icon').removeClass('d-none');
                    $.ajax({
                        url: '{{ route("panel.admin.users.get.permission") }}',
                        method: 'GET',
                        data: {
                            roleId: selectedPermission
                        },
                        success: function(res) {
                            $('.loading-icon').addClass('d-none');
                            $('.allPermission').removeClass('d-none');
                            var permissions = res.permissions;
                            document.querySelectorAll('.checkbox-item').forEach(function(checkbox) {
                                if (permissions.includes(checkbox.value)) {
                                    checkbox.checked = true;
                                }else{
                                    checkbox.checked = false;
                                }
                            });
                           
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });
        </script>
        {{-- START JS HELPERS INIT --}}
        
        {{-- END JS HELPERS INIT --}}
    @endpush
@endsection
