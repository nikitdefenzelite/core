<{{ $data['wildcard'] }}php namespace App\Imports; use App\Models\{{ $data['model'] }}; use Maatwebsite\Excel\Concerns\WithHeadingRow; use Illuminate\Support\Str; use Illuminate\Validation\ValidationException; use Maatwebsite\Excel\Concerns\ToCollection;use Illuminate\Support\Collection;
                            @foreach ($data['fields']['name'] as $index => $item) @if (array_key_exists('import_' . $index, $data['fields']['options'])) @if ($data['fields']['input'][$index] == 'select_via_table')

                                use App\Models\{{ $data['fields']['table'][$index] }}; @endif @endif @endforeach
                            class {{ $data['model'] }}Import implements ToCollection, WithHeadingRow { /** * @param array $row * * @return
\Illuminate\Database\Eloquent\Model|null */public $importData = []; public function collection(Collection $rows) {
$batchSize = 500;
$batches = $rows->chunk($batchSize);
try {
$batchSize = 500;
$batches = $rows->chunk($batchSize);

foreach ($batches as $batch) {
foreach ($batch as $index => $row) {

@foreach ($data['fields']['name'] as $index => $item)
    @if (array_key_exists('import_' . $index, $data['fields']['options']))
        @if ($data['fields']['input'][$index] == 'select_via_table')
            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,
        @else
            if ($row['{{ $item }}'] == null) {
            throw ValidationException::withMessages(['{{ ucfirst($item) }} can not be null at row:' . $index + 2]);
            }
        @endif
    @endif
@endforeach


}
}
} catch (ValidationException $e) {
$failures = $e->validator->getMessageBag()->all();
return $this->importData['errors'] = [
'success' => false,
'message' => $failures[0],
];
}
foreach ($batches as $batch) {
$insertRows = [];
$updateRows = [];
foreach ($batch as $row) {
if (isset($row['id'])) {
$updateRows[] = [
@foreach ($data['fields']['name'] as $index => $item)
    @if (array_key_exists('import_' . $index, $data['fields']['options']))
        @if ($data['fields']['input'][$index] == 'select_via_table')
            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,
        @else
            '{{ $item }}' => $row['{{ $item}}'],
        @endif
    @endif
@endforeach
];
} else {
$insertRows[] = [
@foreach ($data['fields']['name'] as $index => $item)
    @if (array_key_exists('import_' . $index, $data['fields']['options']))
        @if ($data['fields']['input'][$index] == 'select_via_table')
            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,
        @else
            '{{ $item }}' => $row['{{ $item }}'],
        @endif
    @endif
@endforeach
];
}
}

if (!empty($updateRows)) {
{{ $data['model'] }}::upsert($updateRows, ['id'], [ @foreach ($data['fields']['name'] as $index => $item)
    @if (array_key_exists('import_' . $index, $data['fields']['options']))
        @if ($data['fields']['input'][$index] == 'select_via_table')
            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,
        @else
            '{{ $item }}',
        @endif
    @endif
@endforeach]);
}

if (!empty($insertRows)) {
{{ $data['model'] }}::insert($insertRows);
}

}
}
}


{{--{{ $variable }}={{ $data['model'] }}::whereId(ltrim(str_replace('#'.preg_replace('[^A-Z]', ''--}}
{{--, '{{ $data['model'] }}' ),'',$row[0]), '0' ))->first();--}}
{{--@foreach ($data['fields']['name'] as $index => $item)--}}
{{--    @if (array_key_exists('import_' . $index, $data['fields']['options']))--}}
{{--        @if ($data['fields']['input'][$index] == 'select_via_table')--}}
{{--            @if ($data['fields']['table'][$index] == 'User')--}}
{{--                ${{ str_replace('_id', '', $item) }} =--}}
{{--                {{ $data['fields']['table'][$index] }}::where(\DB::raw("CONCAT(first_name, ' ', last_name)"),--}}
{{--                'like', '%' . $row[{{ $index + 1 }}] . '%')->first();--}}
{{--            @else--}}
{{--                ${{ str_replace('_id', '', $item) }} =--}}
{{--                {{ $data['fields']['table'][$index] }}::where('name',$row[{{ $index + 1 }}])->first();--}}
{{--            @endif--}}
{{--        @endif--}}
{{--    @endif--}}
{{--@endforeach--}}

{{--if({{ $variable }}){--}}
{{--{{ $variable }}->update([ @foreach ($data['fields']['name'] as $index => $item)--}}
{{--    @if (array_key_exists('import_' . $index, $data['fields']['options']))--}}
{{--        @if ($data['fields']['input'][$index] == 'select_via_table')--}}
{{--            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,--}}
{{--        @else--}}
{{--            '{{ $item }}' => $row[{{ $index + 1 }}],--}}
{{--        @endif--}}
{{--    @endif--}}
{{--@endforeach--}}

{{--]);--}}
{{--}else{--}}
{{--return new {{ $data['model'] }}([ @foreach ($data['fields']['name'] as $index => $item)--}}
{{--    @if (array_key_exists('import_' . $index, $data['fields']['options']))--}}
{{--        @if ($data['fields']['input'][$index] == 'select_via_table')--}}
{{--            '{{ $item }}' => ${{ str_replace('_id', '', $item) }}->id??0,--}}
{{--        @else--}}
{{--            '{{ $item }}' => $row[{{ $index + 1 }}],--}}
{{--        @endif--}}
{{--    @endif--}}
{{--@endforeach--}}

{{--]);--}}
{{--}--}}
{{--}--}}

{{--public function startRow(): int--}}
{{--{--}}
{{--return 2;--}}
{{--}--}}
{{--}--}}
