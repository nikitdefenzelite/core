<table id="table" class="table">
    <thead>
        <tr>
            {{ $data['atsign'] }}if(!isset($print_mode))
            <th class="no-export">
                <input type="checkbox" class="mr-2 " id="selectall" value="">
                {{  $data['curlstart'] }} __('admin/ui.actions') }}
            </th>
            <th class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i
                        class="ik ik ik-arrow-down desc" data-val="id"></i></div>
            </th>
            {{ $data['atsign'] }}endif
            @php $hi = 1;@endphp @foreach (getKeysByValue('showindex', $data['fields']['options']) as $temp)
                <th class="col_{{ $hi }}"> @php
                    $index = explode('_', $temp)[1];
                    $item = $data['fields']['name'][$index];
                @endphp @if ($data['fields']['input'][$index] == 'select_via_table')
                        {{ str_replace('Id', '', ucwords(str_replace('_', ' ', $item))) }}
                        @else{{ ucwords(str_replace('_', ' ', $item)) }}
                        @endif @if (array_key_exists('sorting_' . $index, $data['fields']['options']))
                            <div class="table-div"><i class="ik ik-arrow-up  asc " data-val="{{ $item }}"></i><i
                                    class="ik ik ik-arrow-down desc" data-val="{{ $item }}"></i></div>
                        @endif
                </th> @php ++$hi; @endphp
            @endforeach
            <th class="">
                <i class="icon-head" data-title="Created At"><i class="fa fa-clock pl-30"></i></i>
            </th>
        </tr>
    </thead>
    <tbody>
        {{ $data['atsign'] }}if({{ $indexvariable }}->count() > 0) @php $ti = 1; @endphp

        {{ $data['atsign'] }}foreach({{ $indexvariable }} as {{ $variable }})
        <tr id="{{ $data['curlstart'] }}  {{ $variable }}->id}}">
            {{ $data['atsign'] }}if(!isset($print_mode))
            <td class="no-export">
                <div class="dropdown d-flex">
                    <input type="checkbox" class="mr-2 text-center" name="id" onclick="countSelected()"
                        value="{{ $data['curlstart'] }}  {{ $variable }}->id}}">
                    {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['edit'] }}') ||
                    auth()->user()->isAbleTo('{{ $data['permissions']['delete'] }}'))
                    <button style="background: transparent;border:none;" class="dropdown-toggle p-0" type="button"
                        id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="ik ik-more-vertical pl-1"></i></button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        @isset($data['softdelete'])
                            {{ $data['atsign'] }}if(request()->get('trash') == 1)
                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.restore',secureToken({{ $variable }}->id)) }}"
                                title="Delete {{ $heading }}" class="dropdown-item">
                                <li class="p-0">Restore</li>
                            </a>
                            {{ $data['atsign'] }}else
                            {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['edit'] }}'))
                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.edit',secureToken({{ $variable }}->id)) }}"
                                title="Edit {{ $heading }}" class="dropdown-item ">
                                <li class="p-0"><i class="ik ik-edit mr-2"></i>Edit</li>
                            </a>
                            {{ $data['atsign'] }}endif
                            {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['delete'] }}'))
                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.destroy',secureToken({{ $variable }}->id)) }}"
                                title="Delete {{ $heading }}" class="dropdown-item text-danger fw-700 delete-item ">
                                <li class=" p-0"><i class="ik ik-trash mr-2"></i>Delete</li>
                            </a>
                            {{ $data['atsign'] }}endif
                        @else
                            {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['edit'] }}'))
                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.edit',secureToken({{ $variable }}->id)) }}"
                                title="Edit {{ $heading }}" class="dropdown-item ">
                                <li class="p-0"><i class="ik ik-edit mr-2"></i>Edit</li>
                            </a>
                            {{ $data['atsign'] }}endif
                            {{ $data['atsign'] }}if(auth()->user()->isAbleTo('{{ $data['permissions']['delete'] }}'))
                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'] . $data['view_name'] }}.destroy',secureToken({{ $variable }}->id)) }}"
                                title="Delete {{ $heading }}" class="dropdown-item text-danger fw-700 delete-item">
                                <li class="p-0"><i class="ik ik-trash mr-2"></i>Delete</li>
                            </a>
                        @endisset

                        {{ $data['atsign'] }}endif
                    </ul>
                    {{ $data['atsign'] }}endif
                </div>
            </td>
            <td class="text-center no-export"> {{ $data['curlstart'] }} {{ $variable }}->getPrefix() }}</td>
            {{ $data['atsign'] }}endif
            @foreach (getKeysByValue('showindex', $data['fields']['options']) as $temp)
                @php
                    $index = explode('_', $temp)[1];
                    $item = $data['fields']['name'][$index];
                @endphp
                @if ($data['fields']['input'][$index] == 'select_via_table')
                    <td class="col_{{ $ti }}">{{ $data['curlstart'] }}
                        {{ '@' . $variable }}->{{ lcfirst(str_replace(' ', '', str_replace('Id', '', ucwords(str_replace('_', ' ', $item))))) }}->name??'N/A'}}
                    </td>
                @elseif($data['fields']['input'][$index] == 'file')
                    <td class="col_{{ $ti }}"><a
                            href="{{ $data['curlstart'] }} asset({{ $variable }}->{{ $item }}) }}"
                            target="_blank"
                            class="btn-link">{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}</a>
                    </td>
                @elseif($data['fields']['input'][$index] == 'checkbox' || $data['fields']['input'][$index] == 'radio')
                    <td class="col_{{ $ti }}"><input type="checkbox"
                            class="switch-input js-switch isboolrec-update" name="{{ $item }}"
                            {{ $data['atsign'] }}if({{ $variable }}->{{ $item }}) checked
                        {{ $data['atsign'] }}endif value='{{ $data['curlstart'] }}{{ $variable }}->id }}'></td>
                @else
                    @if(isset($data['status_filter']) && $item == 'status' && $data['status_filter'] == 1)
                        <td class="col_{{ $ti }}"><span
                                class="badge badge-{{ $data['curlstart'] }} \App\Models\{{ $data['model']}}::STATUSES[ {{ $variable }}->{{ $item }} ]['color'] ?? '--' }} m-1">{{ $data['curlstart'] }} \App\Models\{{ $data['model'] }}::STATUSES[ {{ $variable }}->{{ $item }}]['label']  ?? '--'}}</span>
                        </td>
                    @else
                        <td class="col_{{ $ti }}">
                            {{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}</td>
                    @endif
                @endif @php ++$ti; @endphp
            @endforeach
            <td class="col_5">{{ $data['curlstart'] }}{{ $variable }}->formatted_created_at ?? '...' }}</td>
        </tr>
        {{ $data['atsign'] }}endforeach
        {{ $data['atsign'] }}else
        <tr>
            <td class="text-center" colspan="8">No Data Found...</td>
        </tr>
        {{ $data['atsign'] }}endif
    </tbody>
</table>
