@extends('layouts.main')
@section('title', 'User Subscription')
@section('content')
    @php
        /**
         * User Subscription
         *
         * @category ZStarter
         *
         * @ref zCURD
         * @author  Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link    https://www.defenzelite.com
         */
        @$breadcrumb_arr = [['name' => 'Add User Subscription', 'url' => route('panel.admin.user-subscriptions.index'), 'class' => '--']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5> Assign Subscription</h5>
                            <span>Create a record for Assign Subscription</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
                @include('panel.admin.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3> Create From Subscription</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.user-subscriptions.store') }}" method="post"
                            enctype="multipart/form-data" id="UserSubscriptionForm">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="user_id">Given To <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach (App\Models\User::whereRoleIs('User')->orderBy('first_name', 'ASC')->get() as $option)
                                                <option value="{{ @$option->id }}"
                                                    {{ old('user_id') == @$option->id ? 'Selected' : '--' }}>
                                                    {{ @$option->name ?? '--' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{-- @dd(App\Models\Subscription::where('is_published', 1)->get()) --}}
                                        <label for="subscription_id">Subscription Plan <span
                                                class="text-danger">*</span></label>
                                        <select required name="subscription_id" id="subscription_id"
                                            class="form-control select2">
                                            <option value="" readonly>Select Subscription </option>
                                            @foreach (App\Models\Subscription::where('is_published', 1)->orderBy('name', 'ASC')->get() as $option)
                                                <option value="{{ @$option->id }}"
                                                    {{ old('subscription_id') == @$option->id ? 'Selected' : '--' }}
                                                    data-to_date="{{ now()->addDays(@$option->duration)->format('Y-m-d') }}">
                                                    {{ @$option->name ?? '--' }} | {{ @$option->duration }} days |
                                                    @if (@$option->price == 0)
                                                        <span class="badge badge-primary">Free</span>
                                                    @else
                                                        {{ format_price(@$option->price ?? '--') }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ @$errors->has('from_date') ? 'has-error' : '--' }}">
                                        <label for="from_date" class="control-label">From Date<span
                                                class="text-danger">*</span></label>
                                        <input readonly required class="form-control" name="from_date" type="date"
                                            id="from_date" value="{{ now()->format('Y-m-d') }}"
                                            min="{{ now()->format('Y-m-d') }}" placeholder="Enter From Date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="to_date" class="control-label">To Date<span
                                                class="text-danger">*</span></label>
                                        <input readonly required class="form-control" name="to_date" type="date"
                                            id="to_date" value="{{ now()->format('Y-m-d') }}" placeholder="Enter To Date"
                                            min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="parent_id">Parent </label>
                                        <select    name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="" readonly>Select Parent </option>
                                            @foreach (App\Models\User::all() as $option)
                                                <option value="{{ @$option->id }}" {{  old('parent_id') == @$option->id ? 'Selected' : '--' }}>{{  @$option->name ?? '--'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <button type="submit" class="btn btn-primary floating-btn ajax-btn">Activate
                                Subscription</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('admin/js/ajaxForm.js') }}"></script>
        <script src="{{ asset('panel/admin/plugins/ckeditor5/ckeditor.js') }}"></script>
        <script>
            $('#UserSubscriptionForm').validate();
            $('#subscription_id').change(function() {
                $('#to_date').val($("#subscription_id").select2().find(":selected").data("to_date"));
            });
        </script>
    @endpush
@endsection
