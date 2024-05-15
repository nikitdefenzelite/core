@extends('layouts.main')
@section('title', 'Cy Runner Log')
@section('content')
    @php
        /**
         * Cy Runner Log
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
            ['name' => 'Cy Runner Log', 'url' => route('admin.cy-runner-logs.index'), 'class' => ''],
            ['name' => 'Edit ' . $cyRunnerLog->getPrefix(), 'url' => 'javascript:void(0);', 'class' => 'Active'],
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
                            <h5>{{ __('admin/ui.edit') }} Cy Runner Log</h5>
                            <span>{{ __('admin/ui.update_a_record_for') }} Cy Runner Log</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <!-- start message area-->
                @include('panel.admin.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('admin/ui.update') }} Cy Runner Log</h3>
                    </div>
                    <div class="card-body">
                        <form class="ajaxForm" action="{{ route('admin.cy-runner-logs.update', $cyRunnerLog->id) }}"
                            method="post" enctype="multipart/form-data" id="CyRunnerLogForm">
                            @csrf
                            <input type="hidden" name="request_with" value="update">
                            <input type="hidden" name="id" value="{{ $cyRunnerLog->id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">

                                    <div class="form-group">
                                        <label for="group_id">Group <span class="text-danger">*</span></label>
                                        <select required name="group_id" id="group_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                Group
                                            </option>
                                            @foreach (App\Models\Project::get() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ $cyRunnerLog->group_id == $option->id ? 'selected' : '' }}>
                                                    {{ $option->name ?? '' }}
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
                                                    {{ $cyRunnerLog->user_id == $option->id ? 'selected' : '' }}>
                                                    {{ $option->name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">

                                    <div class="form-group">
                                        <label for="payload" class="control-label">Payload<span
                                                class="text-danger">*</span></label>
                                        <textarea required class="form-control" name="payload" id="payload" placeholder="Enter Payload">{{ $cyRunnerLog->payload }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">

                                    <div class="form-group">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select
                                                Status</option>
                                            @php
                                                $arr = ['Running', 'Failed', 'Completed'];
                                            @endphp
                                            @foreach (getSelectValues($arr) as $key => $option)
                                                <option value=" {{ $option }}"
                                                    {{ $cyRunnerLog->status == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">

                                    <div class="form-group">
                                        <label for="result">Result<span class="text-danger">*</span></label>
                                        <select required name="result" id="result" class="form-control select2">
                                            <option value="" readonly>Select
                                                Result</option>
                                            @php
                                                $arr = ['Pass', 'Fail'];
                                            @endphp
                                            @foreach (getSelectValues($arr) as $key => $option)
                                                <option value=" {{ $option }}"
                                                    {{ $cyRunnerLog->result == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
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
                let redirectUrl = "{{ url('admin/cy-runner-logs') }}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
    @endpush
@endsection
