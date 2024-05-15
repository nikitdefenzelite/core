<table id="table" class="table">
    <thead>
        <tr>
            @if (!isset($print_mode))
                <th class="no-export">
                    <input type="checkbox" class="mr-2 " id="selectall" value="">
                    {{ __('admin/ui.actions') }}
                </th>
                <th class="text-center no-export"># </div>
                </th>
            @endif
            <th class="col_1"> User/Group</th>
            <th class="col_3"> Payload
            </th>
            <th class="col_4"> Status/Result
            </th>
            <th class="col_5">
                <i class="icon-head" data-title="Created At"><i class="fa fa-clock"></i></i>
            </th>
        </tr>
    </thead>
    <tbody>
        @if ($cyRunnerLogs->count() > 0)
            @foreach ($cyRunnerLogs as $cyRunnerLog)
                <tr id="{{ $cyRunnerLog->id }}">
                    @if (!isset($print_mode))
                        <td class="no-export">
                            <div class="dropdown d-flex">
                                <input type="checkbox" class="mr-2 text-center" name="id" onclick="countSelected()"
                                    value="{{ $cyRunnerLog->id }}">
                                @if (auth()->user()->isAbleTo('edit_cy_runner_log') || auth()->user()->isAbleTo('delete_cy_runner_log'))
                                    <button style="background: transparent;border:none;" class="dropdown-toggle p-0"
                                        type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if (request()->get('trash') == 1)
                                            <a href="{{ route('admin.cy-runner-logs.restore', secureToken($cyRunnerLog->id)) }}"
                                                title="Delete Cy Runner Log" class="dropdown-item">
                                                <li class="p-0">Restore</li>
                                            </a>
                                        @else
                                            @if (auth()->user()->isAbleTo('edit_cy_runner_log'))
                                                <a href="{{ route('admin.cy-runner-logs.edit', secureToken($cyRunnerLog->id)) }}"
                                                    title="Edit Cy Runner Log" class="dropdown-item ">
                                                    <li class="p-0"><i class="ik ik-edit mr-2"></i>Edit</li>
                                                </a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('delete_cy_runner_log'))
                                                <a href="{{ route('admin.cy-runner-logs.destroy', secureToken($cyRunnerLog->id)) }}"
                                                    title="Delete Cy Runner Log"
                                                    class="dropdown-item text-danger fw-700 delete-item ">
                                                    <li class=" p-0"><i class="ik ik-trash mr-2"></i>Delete</li>
                                                </a>
                                            @endif
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </td>
                        <td class="text-center no-export"> {{ $cyRunnerLog->getPrefix() }}</td>
                    @endif
                    {{-- @dd($cyRunnerLog) --}}
                    <td class="col_1">
                        <div>{{ @$cyRunnerLog->user->name ?? 'N/A' }}</div>
                        <hr class="my-1">
                        <div>{{ @$cyRunnerLog->group_id ?? 'N/A' }}</div>
                    </td>
                   
                    <td class="col_3">
                        {{ Str::limit($cyRunnerLog->payload,100) }}</td>
                    <td class="col_5">
                        <div>
                        <span
                            class="badge badge-{{ \App\Models\CyRunnerLog::STATUSES[$cyRunnerLog->status]['color'] ?? '--' }} m-1">{{ \App\Models\CyRunnerLog::STATUSES[$cyRunnerLog->status]['label'] ?? '--' }}</span>
                        </div>
                        <hr class="my-1">
                        <div>
                        <span
                        class="badge badge-{{ \App\Models\CyRunnerLog::RESULT[$cyRunnerLog->result]['color'] ?? '--' }} m-1">{{ \App\Models\CyRunnerLog::RESULT[$cyRunnerLog->result]['label'] ?? '--' }}</span>
                        </div>
                    </td>
                    <td class="col_5">{{ $cyRunnerLog->created_at->diffForHumans() ?? '...' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">No Data Found...</td>
            </tr>
        @endif
    </tbody>
</table>
