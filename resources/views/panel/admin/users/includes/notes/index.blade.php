<div class="table-controller mb-2">
    <div class="d-flex justify-content-between">
        <div class="mr-3">
            <label for="">{{ __('admin/ui.show') }}
                <select name="length" class="length-input" id="length">
                    @foreach (tableLimits() as $limit)
                        <option value="{{ @$limit }}"{{ @$notes->perPage() == @$limit ? 'selected' : '' }}>
                            {{ @$limit }}</option>
                    @endforeach
                </select>
                {{ __('admin/ui.entry') }}
            </label>
        </div>
        <div>
            <button type="button" id="notes_export_button" class="btn btn-light btn-sm" data-table="#notes_table"
                data-file="Note">{{ __('admin/ui.btn_excel') }}</button>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <input type="text" name="search" class="form-control mr-2 w-unset search" placeholder="Search"
                value="{{ request()->get('search') }}">
        </div>
        {{-- <button type="button" class="off-canvas btn btn-outline-light text-muted btn-icon"><i
                class="fa fa-filter fa-lg"></i>
            </button> --}}
    </div>
</div>

<div class="table-responsive">
    <table id="notes_table" class="table p-0">
        <thead>
            <tr>
                <th class="no-export">{{ __('admin/ui.actions') }}</th>
                <th>{{ __('admin/ui.sNo') }}</th>
                <th>#</th>
                <th>{{ __('admin/ui.title') }}</th>
                <th>{{ __('admin/ui.description') }}</th>
                <th>{{ __('admin/ui.category') }}</th>
                <th>{{ __('admin/ui.created_at') }}</th>
            </tr>
        </thead>
        <tbody class="no-data">
            @if (@$notes->count() > 0)
                @foreach (@$notes as $index => $userNote)
                    <tr>
                        <td class="no-export">
                            <div class="dropdown d-flex">
                                <button class="dropdown-toggle btn btn-secondary" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu multi-level" role="menu"
                                    aria-labelledby="dropdownMenuNptes">

                                    <li class="dropdown-item p-0"><a href="javascript:void(0);"
                                            data-item="{{ @$userNote }}" title=""
                                            class="btn btn-sm edit-btn edit-note"><i
                                                class="ik ik-edit mr-2"></i>Edit</a></li>

                                    <li class="dropdown-item p-0"><a
                                            href="{{ route('panel.admin.user-notes.destroy', $userNote->id) }}"
                                            title="Delete Notes" class="btn btn-sm delete-item text-danger"><i
                                                class="ik ik-trash mr-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>{{ @$loop->iteration }}</td>
                        <td>{{ @$userNote->getPrefix() }}</td>
                        <td>{{ Str::limit(@$userNote->title, 50) }}</td>
                        <td>{{ Str::limit(@$userNote->description, 80) }}</td>
                        <td>{{ (@$userNote->category->name ?? '--') }}</td>
                        <td>{{ @$userNote->formatted_created_at ?? '--' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="6">@include('panel.admin.include.components.no-data-img')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="card-footer">
    <div class="row d-flex justify-content">
        <div class="col-lg-6 mt-2">
            <div class="pagination mobile-justify-center">
                {{ @$notes->appends(request()->except('page'))->links() }}
            </div>
        </div>
        <div class="col-lg-6 pt-0 mb-4 mobile-mt-20">
            @if (@$notes->lastPage() > 1)
                <label class="d-flex justify-content-end mobile-justify-center" for="">
                    <div class="mr-2 pt-2 ">
                        {{ __('admin/ui.jumpTo') }}:
                    </div>
                    <input type="number" class="w-25 form-control jumpTo" name="page"
                        value="{{ @$notes->currentPage() ?? '' }}">
                </label>
            @endif
        </div>
    </div>
</div>


<!-- push external js -->
@push('script')
    {{-- START HTML TO EXCEL INIT --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script>
        function html_note_table_to_excel(type) {
            var table_core = $("#notes_table").clone();
            var clonedTable = $("#notes_table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#notes_table").html(clonedTable.html());

            // Use in reverse format beacuse we are prepending it.
            var report_format = [{
                    'label': "Status",
                    'value': "{{ request()->get('status') ?? 'All Status' }}"
                },
                {
                    'label': "Date Range",
                    'value': "{{ request()->get('from') ?? 'N/A' }} - {{ request()->get('to') ?? 'N/A' }}"
                },
                {
                    'label': "Report Name",
                    'value': "User Notes"
                },
                {
                    'label': "Company",
                    'value': "{{ env('APP_NAME') }}"
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
            $("#notes_table").html(table_core.html());
        }

        $(document).on('click', '#notes_export_button', function() {
            html_note_table_to_excel('xlsx');
        });
    </script>
    {{--    <script> --}}
    {{--        $('#reset').click(function() { --}}
    {{--            fetchData("{{ route('panel.admin.website-enquiries.index') }}"); --}}
    {{--            window.history.pushState("", "", "{{ route('panel.admin.website-enquiries.index') }}"); --}}
    {{--            $('#TableForm').trigger("reset"); --}}
    {{--            $(document).find('.close.off-canvas').trigger('click'); --}}
    {{--            $('#status').select2('val', ""); --}}
    {{--            $('#status').trigger('change'); --}}
    {{--        }); --}}
    {{--    </script> --}}
    {{--    --}}{{-- END RESET BUTTON INIT --}}
    @include('panel.admin.include.bulk-script')
@endpush
