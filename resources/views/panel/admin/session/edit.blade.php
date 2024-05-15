@extends('layouts.main')
@section('title', ' User Subscription Edit')
@section('content')
    @php
        /**
         * User Subscription
         *
         * @category zStarter
         *
         * @ref zCURD
         * @author  Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link    https://www.defenzelite.com
         */
        @$breadcrumb_arr = [
            // ['name' => $label, 'url' => 'javascript:void(0);', 'class' => ''],
            ['name' => $user_subscription->getPrefix(), 'url' => route('panel.admin.user-subscriptions.index'), 'class' => ''],
            ['name' => 'Edit', 'url' => route('panel.admin.user-subscriptions.index'), 'class' => 'active'],
        ];
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
                            <h5>Update {{ @$user_subscription->user ? @$user_subscription->user->full_name : 'N/A' }}
                                Subscription</h5>
                            <span>Update a record for User Subscription</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 mx-auto">
                <!-- start message area-->
                @include('panel.admin.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Subscription</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.user-subscriptions.update', $user_subscription->id) }}"
                            method="post" enctype="multipart/form-data" id="UserSubscriptionForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="subscription_id">Subscription <span class="text-danger">*</span></label>
                                        {{-- <select required  name="subscription_id" id="subscription_id" class="form-control select2">
                                            <option value="" readonly>Select Subscription </option>

                                            @foreach (App\Models\Subscription::get() as $option)
                                                <option value="{{ @$option->id }}" {{ @$user_subscription->subscription_id  ==  @$option->id ? 'selected' : ''}}>{{  @$option->name ?? ''}} | {{@$option->duration}} Days - {{format_price(@$option->price)}}</option>
                    @endforeach
                                        </select> --}}
                                        <select required name="subscription_id" id="subscription_id"
                                            class="form-control select2">
                                            <option value="" readonly>Select Subscription </option>

                                            @foreach (App\Models\Subscription::orderBy('name', 'ASC')->get() as $option)
                                                <option value="{{ @$option->id }}"
                                                    {{ @$user_subscription->subscription_id == @$option->id ? 'Selected' : '' }}
                                                    data-to_date="{{ now()->addDays(@$option->duration)->format('Y-m-d') }}">
                                                    {{ @$option->name ?? '' }} | {{ @$option->duration }} Days -
                                                    @if (@$option->price == 0)
                                                        <span class="badge badge-primary">Free</span>
                                                    @else
                                                        {{ format_price(@$option->price) }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ @$errors->has('from_date') ? 'has-error' : '' }}">

                                        <label for="from_date" class="control-label">From Date<span
                                                class="text-danger">*</span></label>
                                        <input readonly required class="form-control" name="from_date" type="date"
                                            id="from_date" value="{{ now()->format('Y-m-d') }}"
                                            min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>


                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ @$errors->has('to_date') ? 'has-error' : '' }}">
                                        <label for="to_date" class="control-label">To Date<span
                                                class="text-danger">*</span></label>
                                        <input required class="form-control" name="to_date" type="date" id="to_date"
                                            value="{{ @$user_subscription->to_date }}" min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="parent_id">Parent </label>
                                        <select   name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="" readonly>Select Parent </option>

                                            @foreach (App\Models\User::all() as $option)
                                                <option value="{{ @$option->id }}" {{ @$user_subscription->parent_id  ==  @$option->id ? 'selected' : ''}}>{{  @$option->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <button type="submit" class="btn btn-primary floating-btn ajax-btn">Update</button>
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

        <script>
            $('#UserSubscriptionForm').validate();
            $('#subscription_id').change(function() {
                $('#to_date').val($("#subscription_id").select2().find(":selected").data("to_date"));
            });
        </script>
    @endpush
@endsection
