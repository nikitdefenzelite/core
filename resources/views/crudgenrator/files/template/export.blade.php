<{{ $data['wildcard'] }}php namespace App\Exports; use App\Models\{{ $data['model'] }}; use
    Maatwebsite\Excel\Concerns\FromCollection; use Maatwebsite\Excel\Concerns\WithHeadings; use
    Maatwebsite\Excel\Concerns\WithStyles; use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; class
    {{ $data['model'] }}Export implements FromCollection, WithHeadings, WithStyles { /** * @return
    \Illuminate\Support\Collection */ protected $ids; function __construct($ids) { $this->ids = $ids;
    }

    public function collection()
    {
    $ids = $this->ids;
    return {{ $data['model'] }}::where(function ($query) use ($ids){
    if(!empty($ids))
    $query->whereIn('id', $ids);

    })->get()->map(function($row) {
    return [
    'id' => $row->id,@foreach ($data['fields']['name'] as $index => $item)
        @if (array_key_exists('export_' . $index, $data['fields']['options']))
            @if ($data['fields']['input'][$index] == 'select_via_table')
                "{{ $item }}"=>
                @$row->{{ lcfirst(str_replace(' ', '', str_replace('Id', '', ucwords(str_replace('_', ' ', $item))))) }}->name??'N/A',
            @else
                "{{ $item }}" => $row->{{ $item }},
            @endif
        @endif
    @endforeach

    'created_at' => $row->created_at,
    'updated_at' => $row->updated_at,
    ];
    });
    }

    public function headings(): array
    {
    return [
    "Id",@foreach ($data['fields']['name'] as $index => $item)
        @if (array_key_exists('export_' . $index, $data['fields']['options']))
            @if ($data['fields']['input'][$index] == 'select_via_table')
                "{{ str_replace('Id', '', ucwords(str_replace('_', ' ', $item))) }}",
            @else
                "{{ ucwords(str_replace('_', ' ', $item)) }}",
            @endif
        @endif
@endforeach

    "Created At",
    "Updated At",
    ];
    }

    public function styles(Worksheet $sheet)
    {
    return [
    1 => [
    'font' => ['bold' => true],
    ],
    ];
    }
    }
