<table id="table" class="table">
    <thead>
        <tr>
            @if (!isset($print_mode))
                <th class="no-export">
                    <input type="checkbox" class="mr-2 " id="selectall" value="">
                    {{ __('admin/ui.actions') }}
                </th>
                <th class=" no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i
                            class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                </th>
            @endif
            <th class="col_1"> Title
            </th>
            <th class="col_1"> Groups
            </th>
            <th class="col_3"> Status
            </th>

            <th class="">
                <i class="icon-head" data-title="Created At"><i class="fa fa-clock pl-30"></i></i>
            </th>
            <th class=""> Action </th>
        </tr>
    </thead>
    <tbody>
        @if ($apiRunners->count() > 0)
            @foreach ($apiRunners as $apiRunner)
                <tr id="{{ $apiRunner->id }}">
                    @if (!isset($print_mode))
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
                    @endif
                    <td class="col_1 fw-800"> {{ $apiRunner->title }}</td>
                    <td class="col_3">
                        @php
                            $category = \App\Models\Category::where('id', $apiRunner->group_id)->first();
                        @endphp
                        {{ $category->name ?? '' }}
                    </td>
                    <td class="col_5"><span
                            class="badge badge-{{ \App\Models\CyRunner::STATUSES[$apiRunner->status]['color'] ?? '--' }} m-1">{{ \App\Models\CyRunner::STATUSES[$apiRunner->status]['label'] ?? '--' }}</span>
                    </td>
                    <td class="col_5">{{ $apiRunner->created_at->diffForHumans() ?? '...' }}</td>
                    <td class="col_6"><a href="javascript:void(0);" class=" btn btn-primary btn-sm scenarioApiRunner"
                            data-id="{{ $apiRunner->id }}"
                            data-title="{{ $apiRunner->getPrefix() . ' - ' . $apiRunner->name }}"> Run <i
                                class="ik ik-play"></i></a></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="" colspan="8">No Data Found...</td>
            </tr>
        @endif
    </tbody>
</table>
@include('panel.admin.api-runners.include.run-modal')
