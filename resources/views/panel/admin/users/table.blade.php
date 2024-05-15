<table id="table" class="table p-0">
    <thead>
    <tr>
        @if (!isset($print_mode))
            <th class="col_1 no-export">
                @if (@$bulk_activation == 1)
                    <input type="checkbox" class="allChecked mr-1" name="id" value="">
                @endif Actions
            </th>
            <th class="col_2 text-center no-export">{{ __('#') }}
                <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i
                        class="ik ik ik-arrow-down desc" data-val="id"></i></div>
            </th>
        @endif
        <th class="col_3">{{ __('Customer') }}</th>
        <th class="col_4">{{ __('Role') }}</th>
        <th class="col_5">{{ __('Email') }}</th>
        <th class="col_5">{{ __('Phone') }}</th>
        @if (getSetting('wallet_activation') == 1)
            {{-- <th class="col_6">{{ __('Balance') }}</th> --}}
        @endif
        {{-- <th class="col_7">{{ __('Status') }}</th> --}}
        <th class="col_8"><i class="icon-head" data-title="Join At"><i class="fa fa-clock pl-30"></i></i></th>
    </tr>
    </thead>
    <tbody class="no-data">
    @if (@$users->count() > 0)
        @foreach (@$users as $user)
            <tr id="{{ @$user->id }}">
                @if (!isset($print_mode))
                    <td class="col_1 no-export">
                        <div class="d-flex mb-3">
                            @if (@$bulk_activation == 1)
                                <input type="checkbox" class="mr-2 delete_Checkbox text-center" name="id"
                                       value="{{ @$user->id }}">
                            @endif
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-secondary" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('actions') }}
                                </button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    @if (auth()->user()->isAbleTo('edit_user'))
                                        <li class="dropdown-item">
                                            <a
                                                href="{{ route('panel.admin.users.edit', secureToken($user->id)) }}"><i
                                                    class="ik ik-edit mr-2"> </i>Edit</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->hasRole('admin'))


                                        @if($user->status == App\Models\User::STATUS_ACTIVE)

                                            @if (getSetting('dac_activation') ==1)
                                                <a
                                                    href="{{ route('panel.admin.users.login-as', secureToken($user->id)) }}">
                                                    <li class="dropdown-item loginAsBtn" data-user_id="{{ $user->id }}"
                                                        data-first_name="{{ $user->first_name }}"><i
                                                            class="ik ik-log-in mr-2"> </i> Login As
                                                    </li>
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('panel.admin.users.login-as', $user->id) }}">
                                                    <li class="dropdown-item"><i
                                                            class="ik ik-log-in mr-2"> </i> Login As
                                                    </li>
                                                </a>

                                            @endif

                                        
                                        @endif

                                    @endif
                                    @if (auth()->user()->hasRole('admin'))
                                        <a href="{{ route('panel.admin.users.sessions', $user->id) }}">
                                            <li class="dropdown-item"><i class="ik ik-globe mr-2"> </i> Sessions
                                            </li>
                                        </a>
                                    @endif

                                    @if (getSetting('wallet_activation') == 1)
                                        <a href="javascript:void(0);" class="walletLogButton dropdown-item "
                                           data-id="{{ $user->id }}"><i
                                                class="ik ik-credit-card mr-2 text-dark"></i>
                                            Balance C/D</a>
                                    @endif

                                    <hr class="m-1 b-0">
                                    @if (env('DEV_MODE') == 1)
                                        <a class="delete-item"
                                           href="{{ route('panel.admin.users.destroy', secureToken($user->id)) }}">
                                            <li class="dropdown-item text-danger fw-700"><i
                                                    class="ik ik-trash mr-2"> </i> Delete
                                            </li>
                                        </a>
                                    @endif
                                    {{-- <li class="dropdown-submenu">
                                    <a  class="dropdown-item" tabindex="-1" href="#">Status</a>
                                    <ul class="dropdown-menu">
                                        @if (@$user->status != 0)
                                            <li class="dropdown-item"><a tabindex="-1" class="statusChanger"   href="javascript:void(0)" data-value="Active" data-class="badge-danger" data-status="0"  data-url="{{url('admin/users/update/status/'.@$user->id)}}" data-id="{{@$user->id}}">Inactive</a></li>
                                        @endif
                                        @if (@$user->status != 1)
                                            <li class="dropdown-item"  ><a tabindex="-1" class="statusChanger" data-id="{{@$user->id}}" data-class="badge-success" href="javascript:void(0)" data-status="1" data-value="Inactive" data-url="{{url('admin/users/update/status/'.@$user->id)}}">Active</a></li>
                                        @endif
                                    </ul>
                                </li> --}}
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td class="col_2 text-center no-export"><a class="btn btn-link p-1"
                                                               href="{{ route('panel.admin.users.show', [secureToken($user->id), 'active' => 'account-verfication']) }}">{{ @$user->getPrefix() }}</a>
                    </td>
                @endif

                <td class="col_3 max-w-150">{{ Str::limit(@$user->full_name, 15) }}@if (@$user->is_verified)
                        <span class="ml-1"><i class="ik ik-check-circle"></i></span>
                    @endif
                </td>
                <td class="col_4">{{ @$user->role_name ?? '--' }}</td>
                <td class="col_5">{{ @$user->email ?? '--' }}</td>
                <td class="col_5">{{ @$user->phone ?? '---' }}</td>
                {{-- <td class="col_7 status-{{ @$user->id }} p-2 mt-3" data-status="{{ @$user->status ?? '--' }}">
                        <span
                            class="badge badge-{{ @$user->status_parsed->color }}">{{ @$user->status_parsed->label ?? '--' }}</span>
                </td> --}}
                <td class="col_8">{{ @$user->created_at ?? '--' }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td class="text-center" colspan="8">@include('panel.admin.include.components.no-data-img')</td>
        </tr>
    @endif
    </tbody>
</table>
