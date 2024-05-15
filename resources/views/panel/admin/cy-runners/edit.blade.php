@extends('layouts.main')
@section('title', 'Cy Runner')
@section('content')
@php
/**
* Cy Runner
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
        ['name' => 'Cy Runner', 'url' => route('admin.cy-runners.index'), 'class' => ''],
        ['name' => 'Edit ' . $cyRunner->getPrefix(), 'url' => 'javascript:void(0);', 'class' => 'Active'],
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
                                <h5>{{ __('Edit') }} Cy Runner</h5>
                                <span>{{ __('Update a record for') }} Cy Runner</span>
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
                            <h3>{{ __('Update') }} Cy Runner</h3>
                        </div>
                        <div class="card-body">
                            <form class="ajaxForm" action="{{ route('admin.cy-runners.update', $cyRunner->id) }}" method="post" enctype="multipart/form-data" id="CyRunnerForm">
                                @csrf
                                <input type="hidden" name="request_with" value="update">
                                <input type="hidden" name="id" value="{{ $cyRunner->id }}">
                                <input type="hidden" name="user_id" value="{{auth()->id()}}">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label for="name" class="control-label">Name<span class="text-danger">*</span></label>
                                            <input required class="form-control" name="name" type="text" id="name" value="{{ $cyRunner->name }}" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status">Status<span class="text-danger">*</span></label>
                                            <select required name="status" id="status" class="form-control select2">
                                                <option value="" readonly>Select
                                                    Status</option>
                                                @php
                                                $arr = ['Draft', 'Active', 'Discard'];
                                                @endphp
                                                @foreach (getSelectValues($arr) as $key => $option)
                                                <option value=" {{ $option }}" {{ $cyRunner->status == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
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
                                                        {{ $cyRunner->group_id == $option->id ? 'selected' : '' }}>{{ $option->name }}
                                                    </option>
                                                @endforeach
    
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="code" class="control-label">Code<span class="text-danger">*</span></label>
                                            <textarea required class="form-control" name="code" id="code" placeholder="Enter Code" rows="10">{{ $cyRunner->code }}</textarea>
                                        </div>
                                    </div>



                                    <div class="col-md-12 mx-auto">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary floating-btn ajax-btn">{{ __('Save Update') }}</button>
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
                let redirectUrl = "{{ url('admin/cy-runners') }}?project_id={{ secureToken($cyRunner->project_id)}}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
        @endpush
        @endsection