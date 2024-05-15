@extends('layouts.main')
@section('title', 'Projects')
@section('content')
    @php
        /**
         * Project
         *
         * @category ZStarter
         *
         * @ref zCURD
         * @author Defenzelite <hq@defenzelite.com>
         * @license https://www.defenzelite.com Defenzelite Private Limited
         * @version <zStarter: 1.1.0>
         * @link https://www.defenzelite.com
         */
        $breadcrumb_arr = [['name' => 'Api Runner', 'url' => 'javascript:void(0);', 'class' => 'active']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <style>
            .border-completed {
                border-right: 1px solid gray;
            }

            .cy-run-width {
                width: 60px !important;
            }

            /* Add cursor style to the drag handle */
            .drag-handle {
                cursor: move;
            }
        </style>
    @endpush
    <div class="container-fluid">
        <!-- start message area-->
        <div class="ajax-message text-center"></div>
        <!-- end message area-->
        <div class="col-md-12">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="position: sticky;top: 80px">
                        <div class="card-header justify-content-between">
                            <div class="row">
                                <div class="col">
                                    <h6 class="mb-0 fw-700">Api Scenarios</h6>
                                    <div>{{ $project->name }} / {{ $groupProject->name }}</div>
                                </div>
                            </div>
                            @php
                                $totalRunnersCount = $runners->count();
                            @endphp
                            <div class="d-flex justify-content-end float-right">
                                <div class="runner-controls d-flex justify-content-end float-right">
                                    <a class="btn btn-primary mr-2 d-flex justify-content-center align-items-center"
                                        title="Flow Runner" target="_blank"
                                        href="{{ route('admin.api-runners.get-bulk-scenario', ['project_id' => $project->id, 'group_id' => $groupProject->id]) }}">
                                        Runner all api Scenarios ({{ $totalRunnersCount }})
                                    </a>
                                </div>
                            </div>
                        </div>

                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th class="no-export">
                                        <input type="checkbox" class="mr-2 " id="selectall" value="">
                                        {{ __('admin/ui.actions') }}
                                    </th>
                                    <th class="no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc"
                                                data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                                    </th>
                                    <th class="col_1"> Title
                                    </th>
                                    <th class="col_3"> Status
                                    </th>
                                    <th class="">
                                        <i class="icon-head" data-title="Created At"><i class="fa fa-clock pl-30"></i></i>
                                    </th>
                                    <th class=""> Action </th>
                                </tr>
                            </thead>
                            <tbody id="sortable" class="sortable">
                                @if ($runners->count() > 0)
                                    @foreach ($runners as $apiRunner)
                                        <tr id="{{ $apiRunner->id }}" class="drag-item">
                                            <td class="no-export">
                                                <div class="dropdown d-flex">
                                                    <input type="checkbox" class="mr-2 " name="id" onclick="countSelected()"
                                                        value="{{ $apiRunner->id }}">
                                                    @if (auth()->user()->isAbleTo('edit_api_runner') || auth()->user()->isAbleTo('delete_api_runner'))
                                                        <button style="background: transparent;border:none;" class="dropdown-toggle p-0"
                                                            type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                            @if (request()->get('trash') == 1)
                                                                <a href="{{ route('admin.api-runners.restore', secureToken($apiRunner->id)) }}"
                                                                    title="Delete Api Runner" class="dropdown-item">
                                                                    <li class="p-0">Restore</li>
                                                                </a>
                                                            @else
                                                                @if (auth()->user()->isAbleTo('edit_api_runner'))
                                                                    <a href="{{ route('admin.api-runners.edit', secureToken($apiRunner->id)) }}"
                                                                        title="Edit Api Runner" class="dropdown-item ">
                                                                        <li class="p-0"><i class="ik ik-edit mr-2"></i>Edit</li>
                                                                    </a>
                                                                @endif
                                                                @if (auth()->user()->isAbleTo('delete_api_runner'))
                                                                    <a href="{{ route('admin.api-runners.destroy', secureToken($apiRunner->id)) }}"
                                                                        title="Delete Api Runner"
                                                                        class="dropdown-item text-danger fw-700 delete-item ">
                                                                        <li class=" p-0"><i class="ik ik-trash mr-2"></i>Delete</li>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class=" no-export"> {{ $apiRunner->getPrefix() }}</td>
                                            <td class="col_1 fw-800">
                                                {{ $apiRunner->title }}</td>
                                            <td class="col_5"><span
                                                    class="badge badge-{{ \App\Models\CyRunner::STATUSES[$apiRunner->status]['color'] ?? '--' }} m-1">{{ \App\Models\CyRunner::STATUSES[$apiRunner->status]['label'] ?? '--' }}</span>
                                            </td>
                                            <td class="col_5">{{ $apiRunner->created_at->diffForHumans() ?? '...' }}</td>
                                            <td class="col_6"><a href="javascript:void(0);" class=" btn btn-primary btn-sm scenarioApiRunner" data-id="{{$apiRunner->id}}" data-title="{{$apiRunner->getPrefix().' - '.$apiRunner->name}}"> Run <i class="ik ik-play"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="" colspan="8">No Data Found...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('panel.admin.api-runners.include.run-modal')
    @push('script')
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsoneditor@9.5.6/dist/jsoneditor.min.js"></script>
        <script>
            $(document).ready(function() {
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
                        editor.destroy(); 
                        editor = null;
                    }
                });

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
            </script>
    @endpush
@endsection
