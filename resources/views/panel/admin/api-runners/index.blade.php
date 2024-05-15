@extends('layouts.main')
@section('title', 'Api Runners')
@section('content')
    @php
        /**
         * Api Runner
         *
         * @category ZStarter
         *
         * @ref zCURD
         * @author Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link https://www.defenzelite.com
         */
        $breadcrumb_arr = [['name' => 'Api Scenarios', 'url' => 'javascript:void(0);', 'class' => 'active']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <link href="https://cdn.jsdelivr.net/npm/jsoneditor@9.5.6/dist/jsoneditor.min.css" rel="stylesheet" type="text/css">
    <style>
        .ace_editor.ace-jsoneditor {
            height: 50vh !important;
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
                            <h5>{{@$project->name}} Api Scenarios</h5>
                            <span>List of {{@$project->name}} Api Scenarios</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
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
                        <h3>Api Scenarios</h3>
                        <span class="font-weight-bold border-bottom trash-option  d-none ">Trash</span>
                        <div class="d-flex justicy-content-right">
                            <a href="#" id="importProjectLink"class="btn btn-icon btn-sm btn-outline-success mr-2 importProjectLink" title="Add New Project">
                                <i class="ik ik-upload" aria-hidden="true"></i>
                            </a>
                            @if (auth()->user()->isAbleTo('add_api_runner'))
                                <a href="{{ route('admin.api-runners.create',['project_id'=>request()->get('project_id')]) }}"
                                    class="btn btn-sm btn-outline-primary mr-2" title="Add New Api Runner"><i
                                        class="fa fa-plus" aria-hidden="true"></i> {{ __('admin/ui.add') }} </a>
                            @endif
                            <div class="dropdown d-flex justicy-content-left">
                                <button class="dropdown-toggle p-0 custom-dopdown bulk-btn btn btn-light" type="button"
                                    id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="ik ik-more-vertical fa-lg pl-1"></i></button>
                                <ul class="dropdown-menu dropdown-position multi-level" role="menu"
                                    aria-labelledby="dropdownMenu">
                                    @php
                                        $arr = ['Draft', 'Active', 'Discard'];
                                    @endphp
                                    @foreach (getSelectValues($arr) as $key => $option)
                                        <a href="javascript:void(0)" class="dropdown-item action"
                                            data-action="status-{{ $option }}">{{ $option }}</a>
                                    @endforeach
                                    <a href="javascript:void(0)" data-action="Restore"
                                        class="dropdown-item action trash-option @if (request()->get('trash') != 1) d-none @endif">Restore</a>
                                    <hr class="m-1">
                                    <a href="javascript:void(0)" data-action="Move To Trash"
                                        class="dropdown-item action trash-option @if (request()->get('trash') == 1) d-none @endif"><i
                                            class="ik ik-trash"></i> Move
                                        To Trash</a>
                                    <a href="javascript:void(0);"
                                        class="dropdown-item records-type @if (request()->get('trash') == 1) d-none @endif"
                                        data-value="Trash"><i class="ik ik-trash"></i> View Trash</a>
                                    <a href="javascript:void(0);"
                                        class="dropdown-item records-type @if (request()->get('trash') != 1) d-none @endif"
                                        data-value="All"> View All</a>
                                    <hr class="m-1">
                                    <button type="submit" class="dropdown-item action text-danger fw-700" data-value=""
                                        data-message="You want to delete these?" data-action="Delete Permanently"
                                        data-callback="bulkDeleteCallback"><i class="ik ik-trash"></i> Bulk
                                        Delete
                                    </button>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="ajax-container">
                        @include('panel.admin.api-runners.load')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('panel.admin.api-runners.include.filter')
    @include('panel.admin.api-runners.include.import-model')
    <!-- push external js -->
    @push('script')
        @include('panel.admin.include.more-action', [
            'actionUrl' => 'admin/api-runners',
            'routeClass' => 'api-runners',
        ])
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsoneditor@9.5.6/dist/jsoneditor.min.js"></script>
         <script>
             $(document).ready(function() {
                $('#importProjectLink').click(function(e) {
                    e.preventDefault(); // Prevent the default link behavior

                    // Open the modal
                    $('#importProjectModal').modal('show');
                });
            });

            $(document).ready(function() {
                $('#projectSelectionForm').submit(function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Function to get URL parameter by name
                    function getUrlParameter(name) {
                        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                        var results = regex.exec(location.search);
                        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                    };

                    // Get the project_id parameter value
                    var projectId = getUrlParameter('project_id');

                    var api_key = $('#postman_payload_api_key').val();
                    var project_repo_url = $('#postman_payload').val();
                    var access_token = $('#postman_payload_access_token').val();
                    var directory_name = $('#directoryName').val();

                    // Hide submit button text and show loading indicator
                    $('#buttonText').hide();
                    $('#loadingIndicator').show();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("admin.api-runners.import-postman-collection") }}', // Make sure to replace 'projects.create' with your actual route
                        data: {
                            _token: '{{ csrf_token() }}',
                            project_id: projectId,
                            api_key: api_key,
                            project_repo_url: project_repo_url,
                            access_token: access_token,
                            directory_name: directory_name
                        },
                        success: function(response) {
                            alert(response);
                            $('#loadingIndicator').hide();
                            $('#importProjectModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            $('#loadingIndicator').hide();
                            $('#importProjectModal').modal('hide');
                        },
                        complete: function() {
                            $('#buttonText').show();
                        }
                    });
                });
            });

         </script>



        <script>
            $(document).on('submit','.ajaxForm',function(e){
                e.preventDefault();
                let route = $(this).attr('action');
                let method = $(this).attr('method');
                let data = new FormData(this);
                let response = postData(method,route,'json',data,null,null,1,null,'not-reload');
            })
        </script>

        <script>
            $(document).ready(function() {
                // Set up the JSON Editor
                var editor = new JSONEditor(document.getElementById('jsonArea'), {
                    mode: 'code'
                });

                $(document).on('click', '.scenarioApiRunner', function() {
                    var api_runner_id = $(this).data('id');
                    if (!api_runner_id) {
                        console.error('API runner ID is missing.');
                        return;
                    }
                    $('#output').hide();
                    $('#runner-result').hide();
                    $('.all-api-scenarios').show();

                    $('#scenarioApiRunner').modal('show');
                    $.ajax({
                        url: "{{ route('admin.api-runners.run-api-scenario') }}",
                        method: "get",
                        data: {
                            api_runner_id: api_runner_id,
                            timestamp: new Date().getTime() // Add timestamp parameter
                        },
                        success: function(res) {
                            if (!res) {
                                console.error('Empty response received.');
                                return;
                            }
                            $('#runner-result').html(res);
                            $('#runner-result').show();
                            $('#scenarioApiRunnerTitle').html('#AR' + api_runner_id);
                            if (!editor) {
                                // Initialize the JSON editor only when needed
                                editor = new JSONEditor(document.getElementById('jsonArea'), {
                                    mode: 'code'
                                });
                            }
                            $('#output').show();
                            $('.all-api-scenarios').hide();
                            editor.set(JSON.parse($('#jsonOutput').val())); // Load the JSON into the editor
                        },
                        error: function(xhr, status, error) {
                            console.error('Error occurred:', error);
                        }
                    });
                });
                $('#scenarioApiRunner').on('hidden.bs.modal', function (e) {
                    if (editor) {
                        editor.destroy(); // Destroy the editor when the modal is closed.
                        editor = null;
                    }
                });
                // Function to parse JSON and handle errors
                function getJson() {
                    try {
                        var data = $('#jsonOutput').val();
                        var parsedData = JSON.parse(data);
                        editor.set(parsedData);
                        $('.api-console').addClass('d-none');
                        document.getElementById('jsonArea').style.display = 'block';
                    } catch (ex) {
                        $('.api-console').html('Wrong JSON Format:' + ex);
                        $('.api-console').removeClass('d-none');
                        document.getElementById('jsonArea').style.display = 'none';
                    }
                }
            });


            // initialize

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
                var report_format = [{
                        'label': "Status",
                        'value': "All Status"
                    },
                    {
                        'label': "Date Range",
                        'value': "-----"
                    },
                    {
                        'label': "Report Name",
                        'value': "Api Runners Report"
                    },
                    {
                        'label': "Company",
                        'value': "zStarter"
                    }
                ];

                var report_name = report_format[2]['value'] + " | " + Date.now();
                // Create a single blank row
                var blankRow = document.createElement('tr');
                var blankCell = document.createElement('th');
                blankCell.colSpan = clonedTable.find('thead tr th').length;
                blankRow.appendChild(blankCell);

                // Append the blank row to the cloned table's thead
                clonedTable.find('thead').prepend(blankRow);

                // Iterate through the report_format array and add metadata rows to the cloned table's thead
                $.each(report_format, function(index, item) {
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
                XLSX.writeFile(file, report_name + '.' + type);

                $("#table").html(table_core.html());

            }

            $(document).on('click', '#export_button', function() {
                html_table_to_excel('xlsx');
            })

            $('#reset').click(function() {
                    fetchData("{{ route('admin.api-runners.index') }}");
                    window.history.pushState("", "", "{{ route('admin.api-runners.index') }}");
                    $('#TableForm').trigger("reset");
                    $(document).find('.close.off-canvas').trigger('click');
                    window.location.reload();
                });
        </script>
        <script></script>
    @endpush
@endsection
