{{-- Feature Activation Start --}}

'{{ ucfirst($data['view_name']) }} Module' => [
'options' => [
['name' => "{{ ucfirst($data['view_name']) }} Manage", 'key' => '{{ $data['view_name'] }}_activation', 'tooltip' => "Activate {{ ucfirst($data['view_name']) }}", 'sub_options' => []],
]
],
{{-- Feature Activation End --}}
