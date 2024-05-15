{{ $data['atsign'] }}extends('layouts.main')
{{ $data['atsign'] }}section('title', '{{ $heading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
* {{ $heading }}
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
        ['name'=>'{{ $heading }}', 'url'=> route('{{ $data['dotroutepath'] . $data['view_name'] }}.index') ,
        'class'
        => ''],
        ['name'=>'Edit '.{{ $variable }}->getPrefix(), 'url'=> "javascript:void(0);", 'class' => 'Active']
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
                                <h5>{{  $data['curlstart'] }} __('admin/ui.edit') }} {{ $heading }}</h5>
                                <span>{{$data['curlstart'] }} __('admin/ui.update_a_record_for') }} {{ $heading }}</span>
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
                            <h3>{{$data['curlstart'] }} __('admin/ui.update') }} {{ $heading }}</h3>
                        </div>
                        <div class="card-body">
                            <form class="ajaxForm"
                                action="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.update',{{ $variable }}->id) }}"
                                method="post" enctype="multipart/form-data" id="{{ $data['model'] }}Form">
                                {{ $data['atsign'] }}csrf
                                <input type="hidden" name="request_with" value="update">
                                <input type="hidden" name="id" value="{{ $data['curlstart'] }}{{ $variable }}->id}}">
                                <div class="row">
                                    @foreach ($data['fields']['name'] as $index => $item)
                                        @if ($data['fields']['input'][$index] == 'select')

                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Select --}}
                                                <div class="form-group">
                                                    <label
                                                        for="{{ $item }}">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <select
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        {{ array_key_exists('multiple_' . $index, $data['fields']['options']) ? 'multiple' : '' }}
                                                        name="{{ $item }}" id="{{ $item }}"
                                                        class="form-control select2">
                                                        <option value="" readonly>Select
                                                            {{ ucwords(str_replace('_', ' ', $item)) }}</option>
                                                        @if ($data['fields']['comment'][$index] != null)
                                                            {{ $data['atsign'] }}php
                                                            $arr = [{!! (string) $data['fields']['comment'][$index] !!}];
                                                            {{ $data['atsign'] }}endphp
                                                            {{ $data['atsign'] }}foreach(getSelectValues($arr) as $key => $option)
                                                            <option value=" {{ $data['curlstart'] }}  $option }}"
                                                                {{ $data['curlstart'] }} {{ $variable }}->
                                                                {{ $item }} == $option ? 'selected' :
                                                                ''}}>{{ $data['curlstart'] }} $option}}</option>
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
                                                            {{ $data['atsign'] }}foreach(App\Models\{{ $data['fields']['table'][$index] }}::get() as $option)@endif
                                                        <option value="{{ $data['curlstart'] }} $option->id }}"
                                                            {{ $data['curlstart'] }} {{ $variable }}->
                                                            {{ $item }} == $option->id ? 'selected' :
                                                            ''}}>{{ $data['curlstart'] }} $option->name ?? ''}}
                                                        </option>
                                                        {{ $data['atsign'] }}endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'textarea')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                {{-- Textarea --}}
                                                <div class="form-group">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <textarea {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        class="form-control" name="{{ $item }}" id="{{ $item }}"
                                                        placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}</textarea>
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'decimal')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
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
                                                        value="{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}">
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'datetime-local')
                                            <div class="{{ $data['fields']['column']['column_' . $index] }} col-12">
                                                <div
                                                    class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
                                                    <label for="{{ $item }}"
                                                        class="control-label">{{ ucwords(str_replace('_', ' ', $item)) }}{!! array_key_exists('required_' . $index, $data['fields']['options'])
                                                            ? '<span class="text-danger">*</span>'
                                                            : '' !!}</label>
                                                    <input
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        class="form-control" name="{{ $item }}"
                                                        type="datetime-local" id="{{ $item }}"
                                                        value="{{ $data['curlstart'] }}\Carbon\Carbon::parse({{ $variable }}->{{ $item }})->format('Y-m-d\TH:i') }}">
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
                                                            {{ $data['atsign'] }}if({{ $variable }}->{{ $item }})
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
                                                    <input class="form-control" name="{{ $item }}_file"
                                                        {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                        {{ array_key_exists('multiple_' . $index, $data['fields']['options']) ? 'multiple' : '' }}
                                                        type="{{ $data['fields']['input'][$index] }}"
                                                        id="{{ $item }}">
                                                    <img id="{{ $item }}_file"
                                                        src="{{ $data['curlstart'] }} asset({{ $variable }}->{{ $item }}) }}"
                                                        class="mt-2" />
                                                </div>
                                            </div>
                                        @elseif($data['fields']['input'][$index] == 'hidden')
                                            <input
                                                {{ array_key_exists('required_' . $index, $data['fields']['options']) ? 'required' : '' }}
                                                class="form-control" name="{{ $item }}"
                                                type="{{ $data['fields']['input'][$index] }}"
                                                id="{{ $item }}"
                                                value="{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}"
                                                placeholder="Enter {{ ucwords(str_replace('_', ' ', $item)) }}">
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
                                                        @if ($data['fields']['input'][$index] == 'checkbox') @if ($data['fields']['default'][$index] == 1)checked @endif
                                                        @endif class="form-control"
                                                    name="{{ $item }}"
                                                    type="{{ $data['fields']['input'][$index] }}"
                                                    id="{{ $item }}"
                                                    value="{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if (array_key_exists('media', $data))
                                        @foreach ($data['media']['name'] as $index => $item)
                                            <div class="col-md{{ $data['media']['col'][$index] ? '-' . $data['media']['col'][$index] : '' }} col-12">
                                                {{-- file/img --}}
                                                <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item }}') ? 'has-error' : ''}}">
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
                                                             alt="Update Image"></div>
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
                                                <div class="d-flex flex-wrap">
                                                    {{ $data['atsign'] }}if ({{ $variable }}->getMedia('img')->count() > 0)
                                                        {{ $data['atsign'] }}foreach ({{ $variable }}->getMedia('{{$item}}') as $media)
                                                            <div class=" ">
                                                                <img onclick="preview(this)" id="item_image_img"
                                                                     src="{{ $data['curlstart'] }} $media->getUrl() }}" class="mt-3 mx-1" alt="Item Image"
                                                                     style="border-radius: 10px; width: auto; height: 100px;object-fit: contain" />
                                                                <br>

                                                                <a href="{{ $data['curlstart'] }} route('admin.blogs.destroy', {{ $variable }}->id) . '?media={{$item}}&id=' . $media->id }} "
                                                                   class="btn btn-sm mt-2  btn-link delete-item">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            </div>
                                                        {{ $data['atsign'] }}endforeach
                                                    {{ $data['atsign'] }}endif
                                                </div>


{{--                                                    {{ $data['atsign'] }}if({{ $variable }}->getMedia('{{ $item }}')->count() > 0)--}}
{{--                                                    <div class="media-div">--}}
{{--                                                        <img id="{{ $item }}_img"--}}
{{--                                                            src="{{ $data['curlstart'] }} {{ $variable }}->getFirstMediaUrl('{{ $item }}') }}"--}}
{{--                                                            class=" mt-2" />--}}
{{--                                                        <a href="{{ $data['curlstart'] }} route('panel.admin.media.destroy').'?model_type={{ $data['model'] }}&model_id='.{{ $variable }}->id.'&media={{ $item }}' }}"--}}
{{--                                                            class="btn btn-icon btn-danger delete-media"><i--}}
{{--                                                                class="fa fa-trash"></i></a>--}}
{{--                                                    </div>--}}
{{--                                                    {{ $data['atsign'] }}endif--}}
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="col-md-12 mx-auto">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary floating-btn ajax-btn">{{  $data['curlstart'] }} __('admin/ui.save_update') }}</button>
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
        {{--$('#{{ $data['model'] }}Form').validate();--}}
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
                    document.getElementById('{{ $item }}_img').src = src
                    }
                @endforeach
            @endif
            </{{ $data['script'] }}>
            {{ $data['atsign'] }}endpush
            {{ $data['atsign'] }}endsection
