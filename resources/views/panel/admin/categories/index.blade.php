@extends('layouts.main')
@section('title', @$label)
@section('content')
    @php
     if(@$level == 1){
        @$page_title = 'Categories';  @$arr = null;
    }
     elseif(@$level == 2){
         $page_title = 'Sub Categories';
         $arr = ['name'=> App\Models\Category::where('parent_id',@$categoryType->id)->first()->name, 'url'=> route('categories.index',@$categoryTypeId), 'class' => ''];
        }
     elseif(@$level == 3){
        $page_title = 'Sub Sub Categories';
        $pre = request('parent_id')-1; @$arr = ['name'=> @$categoryType->name ?? '', 'url'=> route('categories.index',[@$categoryTypeId,'level' => 2,'parent_id'=> @$pre]), 'class' => ''];
    }
    // $breadcrumb_arr = [
    //     ['name'=> 'Category Groups', 'url'=> route("panel.admin.category-types.index"), 'class' => 'active'],
    //     @$arr,
    //         // ,
    //     ['name'=> @$page_title, 'url'=> "javascript:void(0);", 'class' => 'active']
    // ]
    @endphp
    <!-- push external head elements to head -->


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>
                                @if(@$level == 1){{ ucwords(str_replace('_',' ',@$categoryType->name ?? '')) }} @elseif(@$level == 2) Sub Category @elseif(@$level == 3) Sub Sub Category  @endif
                            </h5>
                            <span>{{ __('List of')}} {{@$label}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- @include("panel.admin.include.breadcrumb") --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                @include('panel.admin.include.message')
                <div class="card ">
                    <div class="card-header">
                            <h3>{{ __('Create Category')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" class="ajaxForm">
                            @csrf
                            <input type="hidden" name="request_with" value="create">
                            {{-- <input type="hidden" id="encodedCategoryId" value="{{ secureToken(@$projectId) }}"> --}}
                            <input type="hidden" id="projectId" name="project_id" value="{{ @$projectId }}">
                            <input type="hidden" id="level" name="level" value="{{ @$level }}">
                            @if(@$level > 1)
                                <input type="hidden" id="parentId" name="parent_id" value="{{request()->parent_id ?? 0}}">
                            @endif
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ @$errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label mb-0">{{ 'Name' }}<span class="text-danger">*</span>
                                                </label>
                                                {{-- {!! getHelp('Sub Categories Name belong to parent Category') !!}<br> --}}
                                                <span class="text-danger fw-400 mb-1">
                                                    <i class="fa fa-circle-info"></i>
                                                    Use line separation to bulk creation

                                                </span>
                                                <textarea required name="name" id="" cols="30" rows="1" class="form-control mt-1"></textarea>
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
                                                            >{{ $statusLabel }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary float-right ajax-btn">{{ __('create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h3>{{ __('manage') }}</h3>
                            <span><a href="javascript:void(0);" class="btn-link active records-type" data-value="All" >All</a> | <a href="javascript:void(0);" class="btn-link records-type" data-value="Trash">Trash</a></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <select name="action" class=" form-control select-action ml-2 " id="action">
                                    <option value="">Select Action</option>
                                    <option value="Restore" class="trash-option @if(request()->get('trash') != 1)  d-none @endif">Restore</option>
                                    <option value="Move To Trash" class="trash-option @if(request()->get('trash') == 1)  d-none @endif">Move To Trash</option>
                                    <option value="Delete Permanently">Delete Permanently</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="ajax-container">
                        @include('panel.admin.categories.load')
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- push external js -->
    @push('script')

      <script src="{{ asset('panel/admin/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    @include('panel.admin.include.more-action',['actionUrl'=> "admin/categories",'routeClass'=>"categories"])

    {{-- START HTML TO EXCEL INIT --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
         function html_table_to_excel(type)
            {
                var table_core =$("#categoryTable").clone();
                var clonedTable =$("#categoryTable").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
               $("#categoryTable").html(clonedTable.html());
                var data = document.getElementById('categoryTable');

                var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                XLSX.writeFile(file, 'leadFile.' + type);
               $("#categoryTable").html(table_core.html());
            }

           $(document).on('click','#export_button',function(){
                html_table_to_excel('xlsx');
            });
    </script>
    {{-- END HTML TO EXCEL INIT --}}

    {{-- START JS HELPERS INIT --}}
    <script>
        var categoryTypeId =$('#categoryTypeId').val();
        var parentId =$('#parentId').val();
        var level =$('#level').val();
    </script>
    {{-- END JS HELPERS INIT --}}

    {{-- START AJAX FORM INIT --}}

        <script>
               $('.ajaxForm').on('submit',function(e){
                    e.preventDefault();
                    var route =$(this).attr('action');
                    var method =$(this).attr('method');
                    var data = new FormData(this);
                    var redirectUrl = "{{url('/categories')}}";
                    var response = postData(method,route,'json',data,null,redirectUrl);
                });
        </script>
    {{-- END AJAX FORM INIT --}}
   @endpush
@endsection

