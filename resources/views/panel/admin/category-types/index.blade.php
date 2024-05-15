@extends('layouts.main')
@section('title', @$label)
@section('content')
    @php
        $breadcrumb_arr = [['name' => @$label, 'url' => 'javascript:void(0);', 'class' => 'active']];
    @endphp
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
                            <h5>{{ __(@$label) }}</h5>
                            <span>{{ __('List of') }}{{ @$label }}</span>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h3>{{ @$label }}</h3>
{{--                            <span><a href="javascript:void(0);" class="btn-link active records-type"--}}
{{--                            data-value="All">All</a> | <a href="javascript:void(0);" class="btn-link records-type"--}}
{{--                            data-value="Trash">Trash</a></span>--}}
                        </div>

                        <div class="d-flex justify-content-right">
                            <form action="{{ route('panel.admin.category-types.index') }}" class="d-flex" method="GET"
                                id="TableForm">

                                <div class="dropdown">
                                    @if (auth()->user()->isAbleTo('add_category'))
                                        <a href="{{ route('panel.admin.category-types.create') }}"
                                        class="btn btn-sm btn-outline-primary mr-2" title="Add New Category"><i
                                        class="fa fa-plus" aria-hidden="true"></i>{{ __('add') }} </a>
                                    @endif


                                    {{-- <a href="javascript:void(0)" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a> --}}

                            </form>
                        </div>

{{--                        <div class="">--}}

{{--                            <select name="action" class=" form-control select-action ml-2" id="action">--}}
{{--                                <option value="">Select Action</option>--}}
{{--                                <option value="Restore"--}}
{{--                                    class="trash-option @if (request()->get('trash') != 1) d-none @endif">Restore</option>--}}
{{--                                <option value="Move To Trash"--}}
{{--                                    class="trash-option @if (request()->get('trash') == 1) d-none @endif">Move To Trash--}}
{{--                                </option>--}}
{{--                                <option value="Delete Permanently">Delete Permanently</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div id="ajax-container">
                    @include('panel.admin.category-types.load')
                </div>
            </div>
        </div>
        @include('panel.admin.modal.sitemodal', [
            'title' => 'How to use',
            'content' =>
                'You need to create a unique code and call the unique code with paragraph content helper.',
        ])
    </div>
    </div>
@endsection
<!-- push external js -->
@push('script')
    {{-- @include('panel.admin.include.bulk-script') --}}
    @include('panel.admin.include.more-action', [
        'actionUrl' => 'admin/category-types',
        'routeClass' => 'category-types',
    ])
    {{-- START HTML TO EXCEL INIT --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function html_table_to_excel(type) {
            var table_core = $("#categoryTypeTable").clone();
            var clonedTable = $("#categoryTypeTable").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#categoryTypeTable").html(clonedTable.html());
            var data = document.getElementById('categoryTypeTable');

            var file = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
            XLSX.write(file, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            XLSX.writeFile(file, 'leadFile.' + type);
            $("#categoryTypeTable").html(table_core.html());
        }

        $(document).on('click', '#export_button', function() {
            html_table_to_excel('xlsx');
        });
    </script>
    {{-- END HTML TO EXCEL INIT --}}

    {{-- START RESET BUTTON INIT --}}
    <script>
        $('#reset').click(function() {
            fetchData("{{ route('panel.admin.category-types.index') }}");
            window.history.pushState("", "", "{{ route('panel.admin.category-types.index') }}");
            $('#TableForm').trigger("reset");
            $(document).find('.close.off-canvas').trigger('click');
        });
    </script>
    {{-- END RESET BUTTON INIT --}}
@endpush
