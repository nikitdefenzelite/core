<table id="table" class="table">
    <thead>
        <tr>

            @if (!isset($print_mode))
                <th class="col_1 no-export">
                    <input type="checkbox" class="allChecked mr-1" name="id" value="">
                </th>
            @endif
            <th class="col_2">IP Address </th>
            {{--             <th class="col_3">User Agent </th> --}}
            <th class="col_4">Last Activity </th>
            <th class="col_4">Log Out</th>

        </tr>
    </thead>
    <tbody>
        @if (@$sessions->count() > 0)
            @foreach (@$sessions as $session)
                <tr id="{{ @$session->id }}">
                    <td>
                        <input type="checkbox" class="mr-2 delete_Checkbox text-center" name="id"
                            value="{{ @$session->id }}">
                    </td>
                    <td class="col_3">{{ @$session->ip_address ?? 'N/A' }}</td>
                    {{--                     <td class="col_4">{{@$session->user_agent ?? 'N/A' }}</td> --}}

                    <td class="col_4 ml-2">
                        {{ isset($session->last_activity)? \Carbon\Carbon::createFromTimestamp($session->last_activity)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'): 'N/A' }}
                    </td>
                    <td class="col_3">
                        <div class="d-flex justify-content-right">
                            <a href="{{ route('panel.admin.users.delete', $session->id) }}"
                                class="btn btn-outline-danger mr-2" title="Add New User Subscription">Log Out</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center no-export" colspan="8">@include('panel.admin.include.components.no-data-img')</td>
            </tr>
        @endif
    </tbody>
</table>
