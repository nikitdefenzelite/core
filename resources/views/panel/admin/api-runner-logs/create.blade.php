@extends('layouts.main')
@section('title', 'CyRunner Log')
@section('content')
    @php
        /**
         * CyRunner Log
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
            ['name' => 'CyRunner Log', 'url' => route('admin.cy-runner-logs.index'), 'class' => ''],
            ['name' => 'Add CyRunner Log', 'url' => 'javascript:void(0);', 'class' => 'Active'],
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
                            <h5>{{ __('admin/ui.add') }} Api Runner Log</h5>
                            <span>{{ __('admin/ui.add_a_new_record_for') }} Api Runner Log</span>
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
                        <h3>{{ __('admin/ui.create') }} Api Runner Log</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.api-runner-logs.store') }}" method="post"
                            enctype="multipart/form-data" class="ajaxForm" id="CyRunnerLogForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <div class="row mx-auto">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="group_id">Group <span class="text-danger">*</span></label>
                                        <select required name="group_id" id="group_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                Group
                                            </option>
                                            @foreach (App\Models\Project::get() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ old('group_id') == $option->id ? 'Selected' : '' }}>
                                                    {{ @$option->name ?? '--' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select
                                                Status</option>
                                            @php
                                                $arr = ['Running', 'Failed', 'Completed'];
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
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                User
                                            </option>
                                            @foreach (App\Models\User::get() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ old('user_id') == $option->id ? 'Selected' : '' }}>
                                                    {{ $option->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="result">Result<span class="text-danger">*</span></label>
                                        <select required name="result" id="result" class="form-control select2">
                                            <option value="" readonly>Select
                                                Result</option>
                                            @php
                                                $arr = ['Pass', 'Fail'];
                                            @endphp
                                            @foreach (getSelectValues($arr) as $key => $option)
                                                <option value="{{ $option }}"
                                                    {{ old('result') == $option ? 'selected' : '' }}>{{ $option }}
                                                </option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="payload" class="control-label">Payload
                                            <span class="text-danger">*</span></label>
                                        <textarea required class="form-control" name="payload" id="payload" placeholder="Enter Payload">{{ old('payload') }}</textarea>
                                    </div>
                                </div> 
                                
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary floating-btn ajax-btn">{{ __('admin/ui.create') }}</button>
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
                let redirectUrl = "{{ url('admin/api-runner-logs') }}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
        <script></script>
    @endpush
@endsection
