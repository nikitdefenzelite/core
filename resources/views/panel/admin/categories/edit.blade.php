@extends('layouts.main')
@section('title',  @$category->getPrefix().' Categories Edit')
@section('content')
    @php

        if (@$category->level == 1) {
            $page_title = 'Categories';
            $arr = null;
        } 
        // elseif (@$category->level == 2) {
        //     $page_title = 'Sub Categories';
        //     $arr = ['name' => @$parent->name, 'url' => route('categories.index',@$category->category_type_id), 'class' => ''];
        // } elseif (@$category->level == 3) {
        //     $page_title = 'Sub Sub Categories';
        //     $pre = @$category->parent_id - 1;
        //     $arr = ['name' => @$parent->name, 'url' => route('categories.index', [@$category->category_type_id, 'level' => '2', 'parent_id' => @$pre]), 'class' => ''];
        // }
        // @$breadcrumb_arr = [
        //     ['name' => @$categoryType->name ?? '--', 'url' => route('panel.admin.category-types.index'), 'class' => 'active'],
        //     @$arr,
        //     // ,
        //     ['name' => @$label, 'url' => 'javascript:void(0);', 'class' => 'active'],
        // ];
        $breadcrumb_arr = [
    ['name' => @$label, 'url' => route('categories.index',@$category->category_type_id), 'class' => ''],
    ['name' => @$category->getPrefix(), 'url' => route('categories.index',@$category->category_type_id), 'class' => ''],
    ['name' => 'Edit', 'url' => route('categories.index',@$category->category_type_id), 'class' => 'active']
];
    @endphp
    {{-- @dd(@$category->category_type_id); --}}
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit') }} {{ @$label }}</h5>
                            <span>{{ __('Update a record for') }} {{ @$label }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update') }} {{ @$label }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', @$category->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden"name="request_with" value="update">
                            <input type="hidden"name="project_id" value="{{$categoryType->id}}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row d-none">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ @$errors->has('level') ? 'has-error' : '' }}">
                                                <label for="level">{{ __('level') }}</label>
                                                {{-- {!! getHelp('Publicly readable name') !!} --}}
                                                <select name="level" id="level" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Level') }}
                                                    </option>
                                                    @foreach (@$types as $index => $item)
                                                        <option value="{{ @$index }}"
                                                            {{ @$index == @$category->level ? 'selected' : '--' }}>
                                                            {{ @$item['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ @$errors->has('name') ? 'has-error' : '' }}">
                                                <label for="name" class="control-label">{{'Name'}}<span class="text-danger">*</span></label>
                                                {{-- {!! getHelp('Sub Categories Name belong to parent Category') !!} --}}
                                                <input class="form-control" name="name" type="text"
                                                    pattern="[a-zA-Z]+.*"
                                                    title="Please enter first letter alphabet and at least one alphabet character is required."
                                                    id="name" value="{{ @$category->name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="type_id">Type<span class="text-danger">*</span></label>
                                        <select required name="type_id" id="type_id" class="form-control select2">
                                            <option value="" readonly>Select
                                                Type</option>
                                            @foreach ($statusLabels as $key => $statusLabel)
                                                <option value="{{ $key }}"
                                                {{$category->type_id == $key ? 'selected' : ''}}  >{{ $statusLabel }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary floating-btn ajax-btn"> {{ __('saveUpdate') }}:</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
