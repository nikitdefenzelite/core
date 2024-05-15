<table id="table" class="table">
    <thead>
        <tr>
            @if (!isset($print_mode))
                <th class="no-export">
                    <input type="checkbox" class="mr-2 " id="selectall" value="">
                    {{ __('Actions') }}
                </th>
                <th class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc"
                            data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                </th>
            @endif
            <th>Scenario</th>
            <th class="col_1"> User
            </th>
            @if(!request()->project_id)
            <th class="col_2"> Project
            </th>
            @endif
            <th class="col_3"> Group
            </th>
            <th class="col_5"> Status
            </th>
           
            <th class="">
                <i class="icon-head" data-title="Created At"><i class="fa fa-clock pl-30"></i></i>
            </th>
            <th class=""> Action </th>
        </tr>
    </thead>
    <tbody>
        @if ($cyRunners->count() > 0)
            @foreach ($cyRunners as $cyRunner)
                <tr id="{{ $cyRunner->id }}">
                    @if (!isset($print_mode))
                        <td class="no-export">
                            <div class="dropdown d-flex">
                                <input type="checkbox" class="mr-2 text-center" name="id" onclick="countSelected()"
                                    value="{{ $cyRunner->id }}">
                                @if (auth()->user()->isAbleTo('edit_cy_runner') || auth()->user()->isAbleTo('delete_cy_runner'))
                                    <button style="background: transparent;border:none;" class="dropdown-toggle p-0"
                                        type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if (request()->get('trash') == 1)
                                            <a href="{{ route('admin.cy-runners.restore', secureToken($cyRunner->id)) }}"
                                                title="Delete Cy Runner" class="dropdown-item">
                                                <li class="p-0">Restore</li>
                                            </a>
                                        @else
                                            @if (auth()->user()->isAbleTo('edit_cy_runner'))
                                                <a href="{{ route('admin.cy-runners.edit', secureToken($cyRunner->id)) }}"
                                                    title="Edit Cy Runner" class="dropdown-item ">
                                                    <li class="p-0"><i class="ik ik-edit mr-2"></i>Edit</li>
                                                </a>
                                            @endif
                                            @if (auth()->user()->isAbleTo('delete_cy_runner'))
                                                <a href="{{ route('admin.cy-runners.destroy', secureToken($cyRunner->id)) }}"
                                                    title="Delete Cy Runner"
                                                    class="dropdown-item text-danger fw-700 delete-item ">
                                                    <li class=" p-0"><i class="ik ik-trash mr-2"></i>Delete</li>
                                                </a>
                                            @endif
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </td>
                        <td class="text-center no-export"> {{ $cyRunner->getPrefix() }}</td>
                    @endif
                    <td class="col_1">{{ @$cyRunner->name ?? 'N/A' }}
                    <td class="col_1">{{ @$cyRunner->user->name ?? 'N/A' }}
                    </td>
                    @if(!request()->project_id)
                        <td class="col_2">{{ @$cyRunner->project->name ?? 'N/A' }}
                        </td>
                    @endif
                    <td class="col_3">
                        @php
                            $category = \App\Models\Category::where('id', $cyRunner->group_id)->first();
                        @endphp
                        {{ $category->name  ?? ""}}
                    </td>
                    <td class="col_5"><span
                            class="badge badge-{{ \App\Models\CyRunner::STATUSES[$cyRunner->status]['color'] ?? '--' }} m-1">{{ \App\Models\CyRunner::STATUSES[$cyRunner->status]['label'] ?? '--' }}</span>
                    </td>
                    <td class="col_5">{{ $cyRunner->created_at->diffForHumans() ?? '...' ?? '...' }}</td>
                    <td class="col_6"><a href="javascrip:void(0);" class=" btn btn-primary btn-sm scenarioRunner" data-id="{{$cyRunner->id}}" data-title="{{$cyRunner->getPrefix().' - '.$cyRunner->name}}">Run <i class="ik ik-play"></i></a></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">No Data Found...</td>
            </tr>
        @endif
    </tbody>
</table>
@include('panel.admin.cy-runners.include.run-modal')