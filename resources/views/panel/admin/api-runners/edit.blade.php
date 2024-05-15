@extends('layouts.main')
@section('title', 'Api Runner')
@section('content')
    @php
        /**
         * Api Runner
         *
         * @category zStarter
         *
         * @ref zCURD
         * @author Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link https://www.defenzelite.com
         */
        $breadcrumb_arr = [
            ['name' => 'Api Runner', 'url' => route('admin.api-runners.index'), 'class' => ''],
            ['name' => 'Edit ' . $apiRunner->getPrefix(), 'url' => 'javascript:void(0);', 'class' => 'Active'],
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
                            <h5>{{ __('admin/ui.edit') }} Api Runner</h5>
                            <span>{{ __('admin/ui.update_a_record_for') }} Api Runner</span>
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
                        <h3>{{ __('admin/ui.update') }} Api Scenario</h3>
                    </div>
                    <div class="card-body">
                        <form class="ajaxForm" action="{{ route('admin.api-runners.update', $apiRunner->id) }}"
                            method="post" enctype="multipart/form-data" id="ApiRunnerForm">
                            @csrf
                            <input type="hidden" name="request_with" value="update">
                            <input type="hidden" name="id" value="{{ $apiRunner->id }}">
                            <input type="hidden" name="project_id" value="{{$apiRunner->project_id}}">
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <input type="hidden" name="group" value="{{$apiRunner->group}}">
                            <div class="row">
                                <div class="col-md-6 col-12">

                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                        <label for="title" class="control-label">Title<span
                                                class="text-danger">*</span></label>
                                        <input required class="form-control" name="title" type="text" id="title"
                                            value="{{ $apiRunner->title }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-6">

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select
                                                Status</option>
                                            @php
                                                $arr = ['Draft', 'Active', 'Discard'];
                                            @endphp
                                            @foreach (getSelectValues($arr) as $key => $option)
                                                <option value=" {{ $option }}"
                                                    {{ $apiRunner->status == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="group_id">Group<span class="text-danger">*</span></label>
                                        <select required name="group_id" id="group_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                Group</option>
                                            @foreach ($groups as $key => $option)
                                                <option value="{{ $option->id }}"
                                                    {{ $apiRunner->group_id == $option->id ? 'selected' : '' }}>{{ $option->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">

                                    <div class="form-group">
                                        <label for="code" class="control-label">Code<span
                                                class="text-danger">*</span></label>
                                        <textarea required class="form-control" rows="10" name="code" id="code" placeholder="Enter Code">{{ $apiRunner->code }}</textarea>
                                    </div>
                                </div>



                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary floating-btn ajax-btn">{{ __('admin/ui.save_update') }}</button>
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
                let redirectUrl = "{{ url('admin/api-runners') }}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
    @endpush
@endsection
