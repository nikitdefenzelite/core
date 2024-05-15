{{ $data['atsign'] }}extends('layouts.main')
{{ $data['atsign'] }}section('title', '{{ $indexheading }}')
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
        ['name'=>'{{ $indexheading }}', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
        {{ $data['atsign'] }}endphp
        <!-- push external head elements to head -->
        {{ $data['atsign'] }}push('head')
        {{ $data['atsign'] }}endpush
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-grid bg-blue"></i>
                            <div class="d-inline">
                                <h5>{{ $indexheading }}</h5>
                                <span>{{  $data['curlstart'] }} {{__('List of') }} {{ $indexheading }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{ $data['atsign'] }}include("panel.admin.include.breadcrumb")
                    </div>
                </div>
            </div>
            <!-- start message area-->
            <div class="ajax-message text-center"></div>
            <!-- end message area-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ $indexheading }}</h3>
                             <span class="font-weight-bold border-bottom trash-option @if(request()->get('trash') != 1)  d-none @endif">Trash</span> <div class="d-flex justicy-content-right">
                                {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['add'] }}'))
                                <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.create') }}"
                                    class="btn btn-sm btn-outline-primary mr-2" title="Add New {{ $heading }}"><i
                                        class="fa fa-plus" aria-hidden="true"></i> {{  $data['curlstart'] }} __('admin/ui.add') }} </a>
                                {{ $data['atsign'] }}endif
                                <div class="dropdown d-flex justicy-content-left">
                                    <button
                                        class="dropdown-toggle p-0 custom-dopdown bulk-btn btn btn-light" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="ik ik-more-vertical fa-lg pl-1"></i></button>
                                    <ul class="dropdown-menu dropdown-position multi-level" role="menu"
                                        aria-labelledby="dropdownMenu">
                                        @foreach ($data['fields']['name'] as $index => $item)
                                            @if ($data['fields']['input'][$index] == 'select')
                                                {{ $data['atsign'] }}php
                                                $arr = [{!! (string) $data['fields']['comment'][$index] !!}];
                                                {{ $data['atsign'] }}endphp
                                                {{ $data['atsign'] }}foreach(getSelectValues($arr) as $key => $option)
                                                <a href="javascript:void(0)" class="dropdown-item action"
                                                    data-action="{{ $item }}-{{ $data['curlstart'] }}$option }}">{{ $data['curlstart'] }}
                                                    $option }}</a>
                                                {{ $data['atsign'] }}endforeach
                                            @elseif($data['fields']['input'][$index] == 'checkbox' || $data['fields']['input'][$index] == 'radio')
                                                <a href="javascript:void(0)" class="dropdown-item action"
                                                    data-action="{{ $item }}-1">{{ $item }}</a>
                                                <a class="dropdown-item action" data-action="{{ $item }}-0">Not
                                                    {{ $item }}</a>
                                            @endif
                                        @endforeach
                                        @isset($data['softdelete'])
                                            <a href="javascript:void(0)" data-action="Restore"
                                                class="dropdown-item action trash-option {{ $data['atsign'] }}if(request()->get('trash') != 1)  d-none {{ $data['atsign'] }}endif">Restore</a>
                                                <hr class="m-1">
                                            <a href="javascript:void(0)" data-action="Move To Trash"
                                                class="dropdown-item action trash-option {{ $data['atsign'] }}if(request()->get('trash') == 1) d-none {{ $data['atsign'] }}endif"><i class="ik ik-trash"></i> Move
                                                To Trash</a>
                                                <a href="javascript:void(0);"
                                                   class="dropdown-item records-type {{ $data['atsign'] }}if(request()->get('trash') == 1)  d-none {{ $data['atsign'] }}endif"
                                                   data-value="Trash"><i class="ik ik-trash"></i> View Trash</a>
                                                <a href="javascript:void(0);" class="dropdown-item records-type {{ $data['atsign'] }}if(request()->get('trash') != 1)  d-none {{ $data['atsign'] }}endif"
                                                   data-value="All"> View All</a>
                                                <hr class="m-1">
                                                @isset($data['import_btn'])
                                                    <a href="javascript:void(0);" class="dropdown-item text-primary fw-700"
                                                       id="import" title="Import {{ $heading }}"><i class="ik ik-upload"
                                                                                                    aria-hidden="true"></i> Bulk Upload</a>
                                                    <hr class="m-1">
                                                @endisset
                                                <button type="submit" class="dropdown-item action text-danger fw-700"
                                                        data-value="" data-message="You want to delete these?"
                                                        data-action="Delete Permanently" data-callback="bulkDeleteCallback"><i
                                                        class="ik ik-trash"></i> Bulk
                                                    Delete
                                                </button>
                                        @else
                                            <a href="javascript:void(0)" data-action="Move To Trash"
                                                class="dropdown-item action trash-option"><i class="ik ik-trash"></i> Move To Trash</a>
                                        @endisset

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="ajax-container">
                            {{ $data['atsign'] }}include('{{ $data['dotviewpath'] }}{{ $data['view_name'] }}.load')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @isset($data['import_btn'])
            <!-- Modal -->
            <div class="modal fade" id="importXlsx" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Import {{ $indexheading }}</h5>
                            <div class="d-flex justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-link excel-template" download=""><i
                                        class="ik ik-arrow-down"></i> Download Template</a>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="ImportForm" method="post" enctype="multipart/form-data">
                                {{ $data['atsign'] }}csrf
                                <input type="hidden" name="request_with" value="upload">

                                <div class="form-group">
                                    <label for="">Upload Updated Excel Template</label>
                                    <input reuired type="file" class="form-control" name="file"
                                        accept=".xlsx,.xls,.csv">
                                    <small>If template is not present use export file as a format.</small>
                                </div>
                                <div class="ajax-modal-message"></div>
                                <button type="submit" class="btn btn-primary" id="import-btn">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
        {{ $data['atsign'] }}include('{{ $data['dotviewpath'] }}{{ $data['view_name'] }}.include.filter')
        <!-- push external js -->
        {{ $data['atsign'] }}push('script')
        {{ $data['atsign'] }}include('panel.admin.include.more-action',['actionUrl'=>
        "{{ $data['slashroutepath'] }}{{ strtolower($data['view_name']) }}",'routeClass'=>"{{ strtolower($data['view_name']) }}"])
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <{{ $data['script'] }}>

    function tableHeadIconFixer(clonedTable) {
    clonedTable.find('i.icon-head').each(function() {
    var dataTitle = $(this).data('title');
    $(this).replaceWith(dataTitle);
    });
    return clonedTable;
    }

    function html_table_to_excel(type) {
    let table_core = $("#table").clone();
    let clonedTable = $("#table").clone();
    clonedTable.find('[class*="no-export"]').remove();
    clonedTable.find('[class*="d-none"]').remove();
    clonedTable = tableHeadIconFixer(clonedTable);
    $("#table").html(clonedTable.html());

    // Use in reverse format beacuse we are prepending it.
            var report_format = [
            { 'label': "Status", 'value': "{{ request()->get('status') ?? 'All Status' }}" },
            { 'label': "Date Range", 'value': "{{ request()->get('from') ?? '--' }}-{{ request()->get('to') ?? '--' }}" },
            { 'label': "Report Name", 'value': "{{ $indexheading }} Report" },
            { 'label': "Company", 'value': "{{ env('APP_NAME') }}" }
            ];

            var report_name = report_format[2]['value']+" | "+Date.now();
            // Create a single blank row
            var blankRow = document.createElement('tr');
            var blankCell = document.createElement('th');
            blankCell.colSpan = clonedTable.find('thead tr th').length;
            blankRow.appendChild(blankCell);

            // Append the blank row to the cloned table's thead
            clonedTable.find('thead').prepend(blankRow);

            // Iterate through the report_format array and add metadata rows to the cloned table's thead
            $.each(report_format, function (index, item) {
            var metadataRow = document.createElement('tr');
            var labelCell = document.createElement('th');
            var valueCell = document.createElement('th');

            labelCell.innerHTML = item.label;
            valueCell.innerHTML = item.value;

            metadataRow.appendChild(labelCell);
            metadataRow.appendChild(valueCell);

            clonedTable.find('thead').prepend(metadataRow);
            });

            var data = clonedTable[0]; // Use the cloned table for export

            var file = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
            });

            // Write and download the Excel file
            XLSX.write(file, {
            bookType: type,
            bookSST: true,
            type: 'base64'
            });
            XLSX.writeFile(file, report_name+'.' + type);

            $("#table").html(table_core.html());

            }

            $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
            })

            @isset($data['import_btn'])
                let ajaxMessageModal = ".ajax-modal-message";
                $('#import').click(function(){
                $('#importXlsx').modal('show');
                });

                $('#import-btn').click(function(e){
                e.preventDefault();
                let formdata = new FormData($('#ImportForm')[0]);
                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                formdata.append("request_with", 'import');

                $.ajax({
                url: "{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.import') }}",
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function () {
                $(ajaxMessageModal).html(
                '<div class="alert alert-info"><i class="fa fa-refresh fa-spin"></i> Please wait... </div>'
                );
                },
                success: function (res) {
                $(ajaxMessageModal).html('<div class="alert alert-success">' + res.message +
                    '</div>');
                page = '';
                fetchData("{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.index') }}");
                setTimeout(function () {
                $("#importCSV").modal('hide');
                },5000);
                },
                complete: function () {
                $(this).find('[type=submit]').removeAttr('disabled');
                setTimeout(function () {
                $(ajaxMessageModal).html('');
                },5000);
                },
                error: function (data) {
                let response = JSON.parse(data.responseText);
                if (data.status === 400) {
                let errorString = '<ul>';
                $.each(response.errors, function (key, value) {
                errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';
                response = errorString;
                }

                if (data.status === 401)
                response = response.error;
                $(ajaxMessageModal).html('<div class="alert alert-danger">' + response +
                    '</div>');
                }
                });
                });
            @endisset


            </{{ $data['script'] }}>
            @isset($data['import_btn'])
            <{{ $data['script'] }}>
            $('#reset').click(function(){
            let url = "{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.index') }}";
            fetchData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset"); $(document).find('.close.off-canvas').trigger('click');
                });
            </{{ $data['script'] }}>
            @endisset
<{{ $data['script'] }}>
@isset($data['autofocus_btn'])
    document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible') {
    location.reload();
    }
    });
@endisset
    </{{ $data['script'] }}>
            {{ $data['atsign'] }}endpush
            {{ $data['atsign'] }}endsection
