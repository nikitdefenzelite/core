@extends('layouts.main')
@section('title', 'User Sessions')
@section('content')
    @php
        /**
         * User Subscription
         *
         * @category ZStarter
         *
         * @ref zCURD
         * @author  Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link    https://www.defenzelite.com
         */
        @$breadcrumb_arr = [['name' => 'User', 'url' => 'javascript:void(0);', 'class' => ''], ['name' => 'Sessions', 'url' => 'javascript:void(0);', 'class' => 'active']];
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
                            <h5>{{ $user->full_name ?? '' }}</h5>
                            <span>List of Sessions</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('panel.admin.include.breadcrumb')
                </div>
            </div>
        </div>

        {{--        <form action="#" method="GET" id="TableForm"> --}}
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Session</h3>
                        <div class="d-flex justify-content-right">
                            <form action="{{ route('panel.admin.users.session.bulk-action') }}" method="POST"
                                id="bulkAction" class="">
                                @csrf
                                <input type="hidden" name="ids" id="bulk_ids">
                                <div>
                                    <button class="dropdown-toggle p-0 custom-dopdown bulk-btn btn btn-light "
                                        type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <button type="submit" class="dropdown-item bulk-action text-danger fw-700"
                                            data-value="" data-message="You want to delete these session?"
                                            data-action="delete" data-callback="bulkDeleteCallback"><i class="ik ik-globe">
                                            </i> Bulk Logout
                                        </button>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="ajax-container">
                        @include('panel.admin.session.load')
                    </div>
                </div>
            </div>
        </div>
        {{--            <form> --}}
    </div>

    {{-- @include('panel.admin.session.include.filter') --}}
    <!-- push external js -->
    @push('script')
        {{-- START RESET BUTTON INIT --}}
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
            function tableHeadIconFixer(clonedTable) {

                clonedTable.find('i.icon-head').each(function() {
                    var dataTitle = $(this).data('title');
                    $(this).replaceWith(dataTitle);
                });

                return clonedTable;

            }


            function html_table_to_excel(type) {
                var table_core = $("#table").clone();
                var clonedTable = $("#table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                clonedTable = tableHeadIconFixer(clonedTable);
                $("#table").html(clonedTable.html());

                // Use in reverse format beacuse we are prepending it.
                var report_format = [{
                        'label': "Status",
                        'value': "{{ request()->get('status') ?? 'All Status' }}"
                    },
                    {
                        'label': "Users Address",
                        'value': "{{ $user->address ?? 'N/A' }}"
                    },
                    {
                        'label': "Users Moblie Nmuber",
                        'value': "{{ $user->phone ?? 'N/A' }}"
                    },
                    {
                        'label': "Users Name",
                        'value': "{{ $user->full_name ?? 'All Users' }}"
                    },
                    {
                        'label': "Date Range",
                        'value': "{{ request()->get('from') ?? 'N/A' }} - {{ request()->get('to') ?? 'N/A' }}"
                    },
                    {
                        'label': "Report Name",
                        'value': "Subscriptions Report"
                    },
                    {
                        'label': "Company",
                        'value': "{{ env('APP_NAME') }}"
                    }
                ];
                var report_name = report_format[5]['value'] + " | " + Date.now();
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
            });
        </script>
        <script>
            $('#reset').click(function() {
                fetchData("{{ route('panel.admin.user-subscriptions.index') }}");
                window.history.pushState("", "", "{{ route('panel.admin.user-subscriptions.index') }}");
                $('#TableForm').trigger("reset");
                $(document).find('.close.off-canvas').trigger('click');
            });
        </script>
        {{-- END RESET BUTTON INIT --}}
        {{-- START GETUSERS INIT --}}
        <script>
            $(document).ready(function() {
                getUsers();
            })
        </script>
        {{-- END GETUSERS INIT --}}
        @include('panel.admin.include.bulk-script')
    @endpush
@endsection
