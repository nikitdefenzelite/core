{{ $data['atsign'] }}extends('layouts.main')
{{ $data['atsign'] }}section('title', '{{ $heading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
* {{ $heading }}
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
        ['name'=>'{{ $heading }}', 'url'=> route('{{ $data['dotroutepath'] . $data['view_name'] }}.index') ,
        'class'
        => ''],
        ['name'=>'Add {{ $heading }}', 'url'=> "javascript:void(0);", 'class' => 'Active']
        ]
        {{ $data['atsign'] }}endphp
        <!-- push external head elements to head -->
        {{ $data['atsign'] }}push('head')
        <link rel="stylesheet"
            href="{{ $data['curlstart'] }} asset('panel/admin/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
        </style>
        {{ $data['atsign'] }}endpush

        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-grid bg-blue"></i>
                            <div class="d-inline">
                                <h5>{{  $data['curlstart'] }} __('admin/ui.add') }} {{ $heading }}</h5>
                                <span>{{  $data['curlstart'] }} __('admin/ui.add_a_new_record_for') }} {{ $heading }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{ $data['atsign'] }}include('panel.admin.include.breadcrumb')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <!-- start message area-->
                    {{ $data['atsign'] }}include('panel.admin.include.message')
                    <!-- end message area-->
                    <div class="card ">
                        <div class="card-header">
                            <h3>{{  $data['curlstart'] }} __('admin/ui.create') }} {{ $heading }}</h3>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.store') }}"
                                method="post" enctype="multipart/form-data" class="ajaxForm"
                                id="{{ $data['model'] }}Form">
                                {{ $data['atsign'] }}csrf
                                <input type="hidden" name="request_with" value="create">
                                <div class="row">
                                    @foreach ($data['fields']['name'] as $index => $item)
                                        @if ($data['fields']['input'][$index] == 'select')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Select --}}
                                                <div class="form-group">
                                                    <label for="{{ $item }}">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <select
                                                        {{ array_key_exists('required_' .$index, $data['fields']['options']) ? 'required' : '' }}
                                                        {{ array_key_exists('multiple_' .$index, $data['fields']['options']) ? 'multiple' : '' }}
                                                        name="{{ $item }}" id="{{ $item }}"
                                                        class="form-control select2">
                                                        <option value="" readonly>Select
                                                            {{ ucwords(str_replace('_', ' ', $item)) }}</option>
                                                        @if ($data['fields']['comment'][$index] != null)
                                                            {{ $data['atsign'] }}php
                                                            $arr = [{!! (string) $data['fields']['comment'][$index] !!}];
                                                            {{ $data['atsign'] }}endphp
                                                            {{ $data['atsign'] }}foreach(getSelectValues($arr) as $key=> $option)
                                                            <option value="{{ $data['curlstart'] }}  $option }}"
                                                                {{ $data['curlstart'] }}
                                                                old('{{ $item }}')==$option ? 'selected' : ''
                                                                }}>{{ $data['curlstart'] }} $option}}</option>
                                                            {{ $data['atsign'] }}endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'select_via_table')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Select --}}
                                                <div class="form-group">
                                                    <label
                                                        for="{{ $item }}">{{ str_replace('Id', '', ucwords(str_replace('_', ' ', $item))) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <select
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        {{ array_key_exists('multiple_' . $index, $data['fields']['options']) ? 'multiple' : '' }}
                                                        name="{{ $item }}" id="{{ $item }}"
                                                        class="form-control select2">
                                                        <option value="" readonly>Select
                                                            {{ str_replace('Id', '', ucwords(str_replace('_', ' ', $item))) }}
                                                        </option>
                                                        @if ($data['fields']['table'][$index] == 'Category')
                                                            {{ $data['atsign'] }}foreach(getCategoriesByCode('{{ $data['fields']['comment'][$index] }}') as $option)
                                                        @else
                                                            {{ $data['atsign'] }}foreach(App\Models\{{ $data['fields']['table'][$index] }}::get() as $option)
                                                        @endif
                                                        <option value="{{ $data['curlstart'] }} $option->id }}"
                                                            {{ $data['curlstart'] }}
                                                            old('{{ $item }}')==$option->id ? 'Selected' : ''
                                                            }}>{{ $data['curlstart'] }} $option->name ?? ''}}</option>
                                                        {{ $data['atsign'] }}endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'textarea')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Textarea --}}
                                                <div class="form-group">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}
                                                        {!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <textarea {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        class="form-control" name="{{ $item }}" id="{{ $item }}"
                                                        placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">{{ $data['curlstart'] }} old('{{ $item }}')}}</textarea>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'decimal')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- decimal --}}
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <input
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        class="form-control" name="{{ $item }}" type="number"
                                                        step="any" id="{{ $item }}"
                                                        value="{{ $data['curlstart'] }}old('{{ $item }}')}}"
                                                        placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'checkbox' || $data['fields']['input'][$index] == 'radio')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- checkbox radio --}}
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <br>
                                                    <label for="{{ $item }}" class="control-label">
                                                        <input
                                                            {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                            class="switch-input js-switch"
                                                            @if ($data['fields']['default'][$index] == 1) checked @endif
                                                            {{ $data['atsign'] }}if(old('{{ $item }}'))
                                                            checked {{ $data['atsign'] }}endif
                                                            name="{{ $item }}"
                                                            type="{{ $data['fields']['input'][$index] }}"
                                                            id="{{ $item }}" value="1">
                                                        {{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'file')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- file/img --}}
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <input
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        {{ array_key_exists('multiple_' . $index, $data['fields']['options']) ? 'multiple' : '' }}
                                                        class="form-control" name="{{ $item }}_file"
                                                        type="{{ $data['fields']['input'][$index] }}"
                                                        id="{{ $item }}"
                                                        value="{{ $data['curlstart'] }}old('{{ $item }}')}}">
                                                    <img id="{{ $item }}_file" class="d-none mt-2"
                                                        style="border-radius: 10px;width:100px;height:80px;" />
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'hidden')
                                            <input
                                                {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                class="form-control" name="{{ $item }}"
                                                type="{{ $data['fields']['input'][$index] }}"
                                                id="{{ $item }}"
                                                value="{{ $data['curlstart'] }}old('{{ $item }}',request()->get('{{ $data['fields']['default'][$index] }}'))}}"
                                                placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">
                                        @else
                                            @if($data['fields']['name'][$index] == 'slug')
                                                <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                    {{-- Input --}}
                                                    <div
                                                        class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                        <label for="{{ $item }}"
                                                               class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                        <input
                                                            {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                            class="form-control" name="{{ $item }}"
                                                            type="hidden" oninput="slugFunction()"
                                                            id="slug"
                                                            value="{{ $data['curlstart'] }}old('{{ $item }}','{{ $data['fields']['default'][$index] }}')}}"
                                                            placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text flex-grow-1"
                                                                  style="overflow: auto" id="slugOutput">{{ $data['curlstart'] }} url("{{$heading}}/") }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Input --}}
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <input
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        class="form-control" name="{{ $item }}"
                                                        type="{{ $data['fields']['input'][$index] }}"
                                                        id="{{ $item }}"
                                                        value="{{ $data['curlstart'] }}old('{{ $item }}','{{ $data['fields']['default'][$index] }}')}}"
                                                        placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">
                                                </div>
                                            </div>
                                        @endif
                                        @endif
                                    @endforeach
{{--                                    @dd($data['media']['options']['multiple_1'] == "multiple")--}}
                                    @if (array_key_exists('media', $data))
                                        @foreach ($data['media']['name'] as $index => $item)
                                            <div
                                                class="col-md{{ $data['media']['col'][$index] ? '-' . $data['media']['col'][$index] : '' }} col-12">
                                                {{-- file/img --}}
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['media']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
{{--                                                    <input--}}
{{--                                                        {{ array_key_exists('required_' . $index, $data['media']['options']) ? 'required' : '' }}--}}
{{--                                                        {{ array_key_exists('multiple_' . $index, $data['media']['options']) ? 'multiple' : '' }}--}}
{{--                                                        class="form-control" name="{{ $item }}"--}}
{{--                                                        type="file" accept="image/jpeg, image/png, image/gif" id="{{ $item }}"--}}
{{--                                                        value="{{ $data['curlstart'] }}old('{{ $item }}')}}">--}}
                                                    @if(isset($data['media']['options']['multiple_'.$index]) && $data['media']['options']['multiple_'.$index] == "multiple")
                                                    <div class="input-images" data-input-name="{{ $item }}"
                                                         data-label="Drag & Drop product images here or click to browse"
                                                         alt=" Update Image"></div>
                                                    <img id="{{ $item }}" class="d-none mt-2"
                                                        style="border-radius: 10px;width:100px;height:80px;" />
                                                    @else
                                                        <div class="input-images" data-input-name="{{ $item }}"
                                                             data-label="Drag & Drop product image here or click to browse"
                                                             alt=" Update Image"></div>
                                                        <img id="{{ $item }}" class="d-none mt-2"
                                                             style="border-radius: 10px;width:100px;height:80px;" />
                                                        @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="col-md-12 ml-auto">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-primary floating-btn ajax-btn">{{  $data['curlstart'] }} __('admin/ui.create') }}</button>
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
        {{ $data['atsign'] }}push('script')
        <{{ $data['script'] }}>
        {{-- $('#{{ $data['model'] }}Form').validate();--}}
            $('.ajaxForm').on('submit',function(e){
            e.preventDefault();
            let route = $(this).attr('action');
            let method = $(this).attr('method');
            let data = new FormData(this);
            let redirectUrl = "{{ $data['curlstart'] }} url('{{ $route_name }}') }}";
            let response = postData(method,route,'json',data,null,null,1,null,redirectUrl);
            })
            @foreach ($data['fields']['name'] as $index => $item)
                @if ($data['fields']['input'][$index] == 'file')
                    document.getElementById('{{ $item }}').onchange = function () {
                    let src = URL.createObjectURL(this.files[0])
                    $('#{{ $item }}_file').removeClass('d-none');
                    document.getElementById('{{ $item }}_file').src = src
                    }
                @endif
            @endforeach
            @if (array_key_exists('media', $data))
                @foreach ($data['media']['name'] as $index => $item)
                    document.getElementById('{{ $item }}').onchange = function () {
                    let src = URL.createObjectURL(this.files[0])
                    $('#{{ $item }}').removeClass('d-none');
                    document.getElementById('{{ $item }}').src = src
                    }
                @endforeach
            @endif

            </{{ $data['script'] }}>
<{{ $data['script'] }}>
@foreach ($data['fields']['name'] as $index => $item)
    @if($data['fields']['name'][$index] == 'slug')
        function slugFunction() {
        var x = document.getElementById("slug").value;
        document.getElementById("slugOutput").innerHTML = "{{ $data['curlstart'] }} url("{{$heading}}") }}/" + x;
        }

        function convertToSlug(Text) {
        return Text
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
        }

        $('#title').on('keyup', function() {
        $('#slug').val(convertToSlug($('#title').val()));
        slugFunction();
        });
    @endif
@endforeach
</{{ $data['script'] }}>
            {{ $data['atsign'] }}endpush
            {{ $data['atsign'] }}endsection
