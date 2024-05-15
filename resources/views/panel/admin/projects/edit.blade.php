divdivdivdiv@extends('layouts.main')
@section('title', 'Project')
@section('content')
    @php
        /**
         * Project
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
            ['name' => 'Project', 'url' => route('admin.projects.index'), 'class' => ''],
            ['name' => 'Edit ' . $project->getPrefix(), 'url' => 'javascript:void(0);', 'class' => 'Active'],
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
                            <h5>{{ __('Edit') }} Project</h5>
                            <span>{{ __('Update a record for') }} Project</span>
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
                        <h3>{{ __('Update') }} Project</h3>
                    </div>
                    <div class="card-body">
                        <form class="ajaxForm" action="{{ route('admin.projects.update', $project->id) }}" method="post"
                            enctype="multipart/form-data" id="ProjectForm">
                            @csrf
                            <input type="hidden" name="request_with" value="update">
                            <input type="hidden" name="id" value="{{ $project->id }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name<span
                                                class="text-danger">*</span></label>
                                            <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                                This Project Name is for the Defenzelite HQ ERP Project Name.
                                            </div>
                                            <input required class="form-control" name="name" type="text" id="name"
                                            value="{{ $project->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="project_register_id">Project Register <span class="text-danger">*</span></label>
                                        <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                            This ID is for the Defenzelite HQ ERP Project Register.
                                        </div>
                                        <input type="number" placeholder="Enter Project Register ID" value="{{$project->project_register_id}}" name="project_register_id" class="form-control">
                    
                                    </div>
                                </div>
                                <!-- <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('system_variable_payload') ? 'has-error' : '' }}">
                                        <label for="system_variable_payload" class="control-label"> System Variable Payload<span
                                                class="text-danger">*</span></label>
                                        <textarea required class="form-control" name="system_variable_payload" type="text" id="system_variable_payload"
                                            value="{{ is_array($project->system_variable_payload) ?  implode(',', $project->system_variable_payload) : $project->system_variable_payload}}" placeholder="Enter Name"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                                        <label for="postman_payload" class="control-label">Postman Payload<span
                                                class="text-danger">*</span></label>
                                        <textarea required class="form-control" name="postman_payload" type="textar" id="postman_payload"
                                            value="{{ is_array($project->postman_payload) ? implode(',', $project->postman_payload) : $project->postman_payload }}" placeholder="Enter Postman Payload"></textarea>
                                    </div>
                                </div> -->
                                <div class="col-md-12 col-12">
                                <label for="system_variable_payload" class="control-label"> System Variable Payloads<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group {{ $errors->has('system_variable_payload') ? 'has-error' : '' }}">
                                    <div class="alert alert-warning mb-2 px-2 py-1 fs-12">
                                        Post-login, server auto-generates authentication token.
                                    </div>
                                    <input type="text" required class="form-control" name="system_variable_payload[bearer_token]" type="text" id="system_variable_payload"
                                        value="{{ $project->system_variable_payload['bearer_token'] }}" placeholder="Enter Bearer Token">
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group {{ $errors->has('system_variable_payload') ? 'has-error' : '' }}">
                                    <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                                        SOS-login, server auto-loggedin for Cy Senarios.
                                    </div>
                                    <input type="text" required class="form-control" name="system_variable_payload[sso_token]" type="text" id="system_variable_payload_sso_token"
                                        value="{{ $project->system_variable_payload['sso_token'] }}" placeholder="Enter SOS Token">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group {{ $errors->has('system_variable_payload') ? 'has-error' : '' }}">
                                    <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                                        This URL points to the server endpoint for easy switching between production and staging environments.
                                    </div>
                                    <input type="text" required class="form-control" name="system_variable_payload[base_url]" type="url" id="system_variable_payload_base_url"
                                    value="{{ $project->system_variable_payload['base_url'] }}" placeholder="Enter Base URL">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-12 col-12">
                                <label for="postman_payload" class="control-label"> Postman Payloads<span
                                    class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                                            In Postman, use the collection's base URL: https://zterminal.dze-labs.xyz/api.
                                        </div>
                                        <input type="text" required class="form-control" name="postman_payload[project_repo_url]" type="url" id="postman_payload"
                                        value="{{ $project->postman_payload['project_repo_url'] }}" placeholder="Enter Project Repo URL">
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                                        <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                                            In Postman, utilize the collection's Bearer Token, e.g., 1306|QDQwFWSYlAuEoqsC6YCZPtkIYBfuHaurjmucriX3b617212c.
                                        </div>
                                        <input type="text" required class="form-control" name="postman_payload[access_token]" type="text" id="postman_payload_access_token"
                                        value="{{ $project->postman_payload['access_token'] }}" placeholder="Enter Access Token">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('postman_payload') ? 'has-error' : '' }}">
                                    <div class="alert alert-warning mb-1 px-2 py-1 fs-12">
                                        Generate an API key in Postman: Login, go to settings, click "API key," name it, and generate. eg. PMAK-661e0447f52300000198a155-bd288d4deb6d022db86d9c6ce55eed8088
                                    </div>
                                    <input type="text" required class="form-control" name="postman_payload[api_key]" type="text" id="postman_payload_api_key"
                                        value="{{ $project->postman_payload['api_key'] }}" placeholder="Enter API Key">
                                </div>
                            </div>
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary floating-btn ajax-btn">{{ __('Save Update') }}</button>
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
                let redirectUrl = "{{ url('admin/projects') }}";
                let response = postData(method, route, 'json', data, null, null, 1, null, redirectUrl);
            })
        </script>
    @endpush
@endsection
