@extends('backend.layouts.main') 
@section('title', 'Deploy Config')
@section('content')
@php
/**
 * Deploy Config 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
$breadcrumb_arr = [
    ['name'=>'Add Deploy Config', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Deploy Config</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.deploy_configs.store') }}" method="post" enctype="multipart/form-data" id="DeployConfigForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name"  value="{{ old('name')}}">
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="project_register_id">Project Register <span class="text-danger">*</span></label>
                                        <select required name="project_register_id" id="project_register_id" class="form-control select2">
                                            <option value="" readonly>Select Project Register </option>
                                            @foreach(App\Models\ProjectRegister::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('project_register_id') == $option->id ? 'Selected' : '' }}>{{  $option->project_name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                           
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}"><br>
                                        <label for="status" class="control-label">Status</label>
                                        <input    class="js-single switch-input" @if(old('status'))   @endif name="status" type="checkbox" id="status" value="1" >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h5>Payload Details:</h5>
                                    <hr>    
                                </div>        
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                                        <label for="url" class="control-label">URL<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[url]" type="url" id="url" value="{{old('url')}}" placeholder="Enter url"  value="{{ old('url')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('host') ? 'has-error' : ''}}">
                                        <label for="host" class="control-label">Host<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[host]" type="text" id="host" value="{{old('host')}}" placeholder="Enter host"  value="{{ old('host')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('username') ? 'has-error' : ''}}">
                                        <label for="username" class="control-label">Username<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[username]" type="text" id="username" value="{{old('username')}}" placeholder="Enter username"  value="{{ old('username')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                        <label for="password" class="control-label">Password<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[password]" type="text" id="password" value="{{old('password')}}" placeholder="Enter password"  value="{{ old('password')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('port') ? 'has-error' : ''}}">
                                        <label for="port" class="control-label">Port<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[port]" type="text" id="port" value="{{old('port')}}" placeholder="Enter port"  value="{{ old('port')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('code_structure') ? 'has-error' : ''}}">
                                        <label for="code_structure" class="control-label">Code Structure<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[code_structure]" type="text" id="code_structure" value="{{old('code_structure')}}" placeholder="Enter code_structure"  value="{{ old('code_structure')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('local_folders') ? 'has-error' : ''}}">
                                        <label for="local_folders" class="control-label">Local Folders<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[local_folders]" type="text" id="local_folders" value="{{old('local_folders')}}" placeholder="Enter local_folders"  value="{{ old('local_folders')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('core_folders') ? 'has-error' : ''}}">
                                        <label for="core_folders" class="control-label">Core Folders<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[core_folders]" type="text" id="core_folders" value="{{old('core_folders')}}" placeholder="Enter core_folders"  value="{{ old('core_folders')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('project_directory_path') ? 'has-error' : ''}}">
                                        <label for="project_directory_path" class="control-label">Project Directory Path<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[project_directory_path]" type="text" id="project_directory_path" value="{{old('project_directory_path')}}" placeholder="Enter project_directory_path"  value="{{ old('project_directory_path')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('local_directory_path') ? 'has-error' : ''}}">
                                        <label for="local_directory_path" class="control-label">Local Directory Path<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="payload[local_directory_path]" type="text" id="local_directory_path" value="{{old('local_directory_path')}}" placeholder="Enter local_directory_path"  value="{{ old('local_directory_path')}}">
                                    </div>
                                </div>

                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#DeployConfigForm').validate();
                                                                                            </script>
    @endpush
@endsection
