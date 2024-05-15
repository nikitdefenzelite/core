@extends('layouts.main')
@section('title', 'Cy Runner')
@section('content')
    @php
        /**
         * Cy Runner
         *
         * @category ZStarter
         *
         * @ref zCURD
         * @author Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link https://www.defenzelite.com
         */
        $breadcrumb_arr = [
            ['name' => 'Cy Scenario', 'url' => route('admin.cy-runners.index'), 'class' => ''],
            ['name' => 'Add Cy Scenario', 'url' => 'javascript:void(0);', 'class' => 'Active'],
        ];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('panel/admin/plugins/mohithg-switchery/dist/switchery.min.css') }}">
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
                            <h5>{{ __('Add') }} Cy Scenario</h5>
                            <span>{{ __('Add a new record for') }} Cy Scenario</span>
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
                        <h3>{{ __('Create') }} Cy Scenario</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.cy-runners.store') }}" method="post" enctype="multipart/form-data"
                            class="ajaxForm" id="CyRunnerForm">
                            @csrf
                            <input type="hidden" name="request_with" value="create">
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <input type="hidden" name="project_id" value="{{secureToken(request()->get('project_id'),'decrypt')}}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name<span
                                                class="text-danger">*</span></label>
                                        <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                         Method Name like: create, edit, index, delete, show.
                                        </div>
                                        <input required class="form-control" name="name" type="text" id="name"
                                            value="{{ old('name', '') }}" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                            Choose status. 
                                        </div>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select
                                                Status</option>
                                            @php
                                                $arr = ['Draft', 'Active', 'Discard'];
                                            @endphp
                                            @foreach (getSelectValues($arr) as $key => $option)
                                                <option value="{{ $option }}"
                                                    {{ old('status') == $option ? 'selected' : '' }}>{{ $option }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="group_id">Group<span class="text-danger">*</span></label>
                                        <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                            Choose a group to store name, code, and status.
                                        </div>
                                        <select required name="group_id" id="group_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                Group</option>
                                            @foreach ($groups as $key => $option)
                                                <option value="{{ $option->id }}"
                                                    >{{ $option->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">

                                    <div class="form-group">
                                        <label for="code" class="control-label">Code
                                            <span class="text-danger">*</span></label>
                                    <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                        Share your Postman API method's curl code here.
                                    </div>
                                    <textarea rows="10" required class="form-control" name="code" id="code" placeholder="Enter Code">{{ old('code') }}</textarea>
                                    </div>
                                </div>


                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary floating-btn ajax-btn">{{ __('Create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $('.ajaxForm').on('submit', function(e) {
                e.preventDefault();
                let route = $(this).attr('action');
                let method = $(this).attr('method');
                let data = new FormData(this);
                let redirectUrl = "{{ url('admin/cy-runners') }}"+"?project_id="+"{{request()->get('project_id')}}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
        <script></script>
    @endpush
@endsection
