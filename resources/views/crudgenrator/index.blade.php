@extends('crudgenrator.layouts.master')

@section('title', 'Crudgen')

{{-- Push Styles --}}
@push('scopedCss')
    <style>
        .hash {
            margin-left: -10px;
            margin-top: -10px;
        }

        .form-group {
            margin-top: 1.2rem;
            margin-bottom: 0.4rem;
        }

        .jsoneditor {
            height: 60vh !important;
        }

        @media screen and (max-width: 950px) {
            .select2-container {
                width: 180px !important;
            }
        }

        @media (max-width:729px) {
            .select2-container {
                width: 120px !important;
            }
        }

        .select2-container--default .select2-selection--single {
            background-color: #282C2F;
            border: 1px solid #282C2F;
            border-radius: 4px;
            color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            background-color: #282C2F;
            line-height: 35px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
            background-color: #282C2F;
            color: #fff;
        }

        .select2-container .select2-selection--single {
            height: 37px;
        }

        .select2-dropdown {
            background-color: #282C2F;
            color: #ddd;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #282C2F;
            color: #ddd;
        }
    </style>
@endpush

{{-- Main Page Content --}}
@section('content')
    <div class="px-xl-5">
        <div class="container py-3 px-xl-5 px-lg-3 px-2" style="max-width: unset;">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ik ik-x"></i>
                    </button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ik ik-x"></i>
                    </button>

                </div>
            @endif
            <form action="{{ route('crudgen.generate') }}" method="post" class="repeater" id="crudgen_form"
                autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        {{-- Name --}}
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Crud Details</div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 col-md">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">Model Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('model') }}"
                                                class="form-control first-upper model_name" name="model" id="model_name"
                                                placeholder="Model Name" requireds>
                                            <small class="text-muted">Enter model name for the crud e.g: <span
                                                    class="text-accent">UserContact</span> (<span class="text-danger">Name
                                                    needs to be in singular</span>)</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">Table Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('name') }}"
                                                class="form-control lower crud_name" name="name" id="name"
                                                placeholder="Table Name" requireds>
                                            <small class="text-muted">Enter name for the crud e.g: <span
                                                    class="text-accent">user_contacts</span> (<span class="text-danger">Name
                                                    needs to be in plural</span>)</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md">
                                        <div class="form-group">
                                            <label class="form-control-label" for="view_path">View/Route Path</label>
                                            <select name="view_path" class="form-control" id="view_path">
                                                @foreach ($roles as $role)
                                                    <option value="{{ strtolower(str_replace(' ', '-', $role->name)) }}"
                                                        {{ old('view_path') == strtolower(str_replace(' ', '-', $role->name)) ? 'selected' : '' }}>
                                                        {{ strtolower(str_replace(' ', '-', $role->name)) }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">If you didn't specify view path it will defaultly take
                                                panel. It will generate views in <code
                                                    class="text-accent">resources/views/<span
                                                        id="view_path_preview">panel/admin/</span><span
                                                        id="crud_name">table_name</span> </code></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        {{-- Controller Namespace --}}
                                        <div class="form-group">
                                            <label for="controller_namespace">Controller Namespace</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">App\Http\Controllers\</span>
                                                </div>
                                                <input type="text" value="{{ old('controller_namespace') ?? 'Admin' }}"
                                                    id="controller-namespace" class="form-control first-upper"
                                                    name="controller_namespace" id="controller_path_preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Fields --}}
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <span>Fields (Required)</span>
                                <div>
                                    <button class="btn btn-accent btn-sm btn-add" type="button" title="Add New Field"
                                        id="addFieldsBtn">+</button>
                                    <button class="btn btn-accent btn-sm btn-sub" type="button" title="Last Field Delete"
                                        id="removeFieldsBtn">-</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <small><strong>Note:</strong> When you select "Select via table" and the "Category" Table,
                                    it will take the name of the "level 1 category", and you must type the name of the
                                    "Category Type." (If that name is not in our DB then system will automatically create
                                    one based on the name you entered.)</small>
                                <div class="row mt-2">
                                    <div class="col ml-5">
                                        Name
                                    </div>
                                    <div class="col">
                                        Data Type (Column)
                                    </div>
                                    <div class="col">
                                        Input Type (Field)
                                    </div>
                                    <div class="col">
                                        Default/Url Get Param <small>(hidden)</small>
                                        <label for="checkAll">
                                        <input type="checkbox" id="checkAll" placeholder="chek all import and export"> All
                                          <small>(export/import)</small> </label>
                                    </div>
                                    <div class="col">
                                        Comments <small>[Enum/Select Values(,)]</small>
                                    </div>
                                </div>
                                <ul id="sortable" class="fields p-0">
                                    <li class="row no-gutters ui-state-default align-items-center field">
                                        <span class="btn-accent btn-sm mr-3 hash">#</span>
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <input required type="text" class="form-control col_name"
                                                    value="{{ old('fields') && old('fields')['name'][0] ? old('fields')['name'][0] : '' }}"
                                                    data-id="0" id="col_name0" name="fields[name][0]"
                                                    placeholder="Name" />
                                            </div>
                                            <label
                                                title="To ensure the field is required from both the client and server sides, this is helpful.">
                                                <input type="checkbox" class="ml-2 do-required"
                                                    {{ old('fields') && @old('fields')['options']['required_0'] ? 'checked' : '' }}
                                                    name="fields[options][required_0]" value="required" id="required_0">
                                                Required
                                            </label>
                                            <label title="To ensure that null values are accepted.">
                                                <input type="checkbox" class="ml-2 do-nullable"
                                                    {{ old('fields') && @old('fields')['options']['required_0'] ? '' : 'checked' }}
                                                    name="fields[options][nullable_0]" value="nullable" id="nullable_0">
                                                Null
                                            </label>
                                            <label title="To ensure ascending descending sorting can be performed.">
                                                <input type="checkbox" class="ml-2 do-sorting"
                                                    {{ old('fields') && @old('fields')['options']['sorting_0'] ? 'checked' : '' }}
                                                    name="fields[options][sorting_0]" value="sorting" id="sorting_0">
                                                Sort
                                            </label>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mr-1 setDataType">
                                                <select required name="fields[type][0]" id="fields_type_0"
                                                    class="form-control select2 " id="">
                                                    <option value="">--Select Field Type--</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'bigIncrements') selected @endif
                                                        value="bigIncrements">bigIncrements</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'bigInteger') selected @endif
                                                        value="bigInteger">bigInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'binary') selected @endif
                                                        value="binary">binary</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'boolean') selected @endif
                                                        value="boolean">boolean</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'char') selected @endif
                                                        value="char">char</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'dateTimeTz') selected @endif value="dateTimeTz">dateTimeTz</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'dateTime') selected @endif
                                                        value="dateTime">dateTime</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'date') selected @endif
                                                        value="date">date</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'decimal') selected @endif
                                                        value="decimal">decimal</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'double') selected @endif
                                                        value="double">double</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'enum') selected @endif
                                                        value="enum">enum</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'float') selected @endif
                                                        value="float">float</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'foreignId') selected @endif value="foreignId">foreignId</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'geometryCollection') selected @endif value="geometryCollection">geometryCollection</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'geometry') selected @endif value="geometry">geometry</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'id') selected @endif
                                                        value="id">id</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'increments') selected @endif
                                                        value="increments">increments</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'integer') selected @endif
                                                        value="integer">integer</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'ipAddress') selected @endif
                                                        value="ipAddress">ipAddress</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'json') selected @endif
                                                        value="json">json</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'jsonb') selected @endif value="jsonb">jsonb</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'lineString') selected @endif
                                                        value="lineString">lineString</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'longText') selected @endif
                                                        value="longText">longText</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'macAddress') selected @endif value="macAddress">macAddress</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'mediumIncrements') selected @endif value="mediumIncrements">mediumIncrements</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'mediumInteger') selected @endif
                                                        value="mediumInteger">mediumInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'mediumText') selected @endif
                                                        value="mediumText">mediumText</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'morphs') selected @endif value="morphs">morphs</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'multiLineString') selected @endif value="multiLineString">multiLineString</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'multiPoint') selected @endif value="multiPoint">multiPoint</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'multiPolygon') selected @endif value="multiPolygon">multiPolygon</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'nullableMorphs') selected @endif value="nullableMorphs">nullableMorphs</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'nullableTimestamps') selected @endif value="nullableTimestamps">nullableTimestamps</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'nullableUuidMorphs') selected @endif value="nullableUuidMorphs">nullableUuidMorphs</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'point') selected @endif value="point">point</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'polygon') selected @endif value="polygon">polygon</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'rememberToken') selected @endif value="rememberToken">rememberToken</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'set') selected @endif value="set">set</option>
                                                <option @if (old('fields') && old('fields')['type'][0] == 'smallIncrements') selected @endif value="smallIncrements">smallIncrements</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'smallInteger') selected @endif
                                                        value="smallInteger">smallInteger</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'softDeletesTz') selected @endif value="softDeletesTz">softDeletesTz</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'softDeletes') selected @endif
                                                        value="softDeletes">softDeletes</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'string') selected @endif
                                                        value="string">string</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'text') selected @endif
                                                        value="text">text</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'timeTz') selected @endif value="timeTz">timeTz</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'time') selected @endif
                                                        value="time">time</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'timestampTz') selected @endif value="timestampTz">timestampTz</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'timestamp') selected @endif
                                                        value="timestamp">timestamp</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'timestampsTz') selected @endif value="timestampsTz">timestampsTz</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'timestamps') selected @endif
                                                        value="timestamps">timestamps</option>
                                                    {{-- <option @if (old('fields') && old('fields')['type'][0] == 'tinyIncrements') selected @endif value="tinyIncrements">tinyIncrements</option> --}}
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'tinyInteger') selected @endif
                                                        value="tinyInteger">tinyInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'tinyText') selected @endif
                                                        value="tinyText">tinyText</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedBigInteger') selected @endif
                                                        value="unsignedBigInteger">unsignedBigInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedDecimal') selected @endif
                                                        value="unsignedDecimal">unsignedDecimal</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedInteger') selected @endif
                                                        value="unsignedInteger">unsignedInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedMediumInteger') selected @endif
                                                        value="unsignedMediumInteger">unsignedMediumInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedSmallInteger') selected @endif
                                                        value="unsignedSmallInteger">unsignedSmallInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'unsignedTinyInteger') selected @endif
                                                        value="unsignedTinyInteger">unsignedTinyInteger</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'uuidMorphs') selected @endif
                                                        value="uuidMorphs">uuidMorphs</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'uuid') selected @endif
                                                        value="uuid">uuid</option>
                                                    <option @if (old('fields') && old('fields')['type'][0] == 'year') selected @endif
                                                        value="year">year</option>
                                                </select>
                                            </div>
                                            <label title="To ensure that the field is displayed in the table.">
                                                <input type="checkbox" class="ml-2"
                                                    {{ old('fields') && @old('fields')['options']['showindex_0'] ? '' : 'checked' }}
                                                    name="fields[options][showindex_0]" value="showindex"
                                                    id="showindex_0" >Index
                                            </label>
                                            <label title="To ensure that the field is searchable in the table.">
                                                <input type="checkbox" class="ml-2"
                                                    {{ old('fields') && @old('fields')['options']['cansearch_0'] ? 'checked' : '' }}
                                                    name="fields[options][cansearch_0]" value="cansearch"
                                                    id="cansearch_0">Search
                                            </label>
                                            <label
                                                title="To ensure that the record is delete in that table if the reference table record delete.">
                                                <input type="checkbox" class="ml-2"
                                                    title="To ensure that the record is delete in that table if the reference table record delete."
                                                    name="fields[options][cascade_0]"
                                                    {{ old('fields') && @old('fields')['options']['cascade_0'] ? 'checked' : 'disabled' }}
                                                    value="cascade" id="cascade_0">Cascade
                                            </label>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <select required name="fields[input][0]" id="fields_input_0"
                                                    class="form-control select2 fields-type">
                                                    <option value="">--Select Input Type--</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'text') selected @endif
                                                        value="text">{{ ucfirst('input text') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'hidden') selected @endif
                                                        value="hidden">{{ ucfirst('hidden') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'date') selected @endif
                                                        value="date">{{ ucfirst('date') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'datetime-local') selected @endif
                                                        value="datetime-local">{{ ucfirst('dateTime') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'decimal') selected @endif
                                                        value="decimal">{{ ucfirst('decimal ') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'number') selected @endif
                                                        value="number">{{ ucfirst('number') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'email') selected @endif
                                                        value="email">{{ ucfirst('email') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'password') selected @endif
                                                        value="password">{{ ucfirst('password') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'url') selected @endif
                                                        value="url">{{ ucfirst('url') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'file') selected @endif
                                                        value="file">{{ ucfirst('file') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'radio') selected @endif
                                                        value="radio">{{ ucfirst('radio') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'checkbox') selected @endif
                                                        value="checkbox">{{ ucfirst('checkbox') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'textarea') selected @endif
                                                        value="textarea">{{ ucfirst('textarea') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'select') selected @endif
                                                        value="select">{{ ucfirst('select') }}</option>
                                                    <option @if (old('fields') && old('fields')['input'][0] == 'select_via_table') selected @endif
                                                        value="select_via_table">{{ ucfirst('select Via Table') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <label
                                                title="To ensure that the field accepts unique values from the database.">
                                                <input type="checkbox" class="ml-2 do-unique"
                                                    {{ old('fields') && @old('fields')['options']['unique_0'] ? 'checked' : '' }}
                                                    name="fields[options][unique_0]" value="unique" id="unique_0">
                                                Unique
                                            </label>
                                            <label
                                                title="To ensure that multiple values can be entered into the field. (files & select)">
                                                <input type="checkbox" class="ml-2"
                                                    {{ old('fields') && @old('fields')['options']['multiple_0'] ? 'checked' : '' }}
                                                    name="fields[options][multiple_0]" value="multiple" disabled
                                                    id="multiple_0"> Multiple </label>
                                            {{-- <small>(files & select)</small>  --}}
                                        </div>
                                        <div class="col">
                                            <div class="form-group d-flex justify-content-around">
                                                <textarea name="fields[default][0]" rows="1" id="fields_default_0"
                                                    class="form-control @if (old('fields') && old('fields')['table'][0] != '') d-none @endif">{{ old('fields') && old('fields')['default']['0'] ? old('fields')['default']['0'] : '' }}</textarea>
                                                <select name="fields[table][0]"
                                                    class="form-control table @if (old('fields') && old('fields')['table'][0] != '') @else d-none @endif">
                                                    <option value="">Select Table</option>
                                                    <option @if (old('fields') && old('fields')['table'][0] == 'User') selected @endif
                                                        value="User">User</option>
                                                    @foreach ($tmpFiles as $temp)
                                                        <option @if (old('fields') && old('fields')['table'][0] == $temp['filename']) selected @endif
                                                            value="{{ $temp['filename'] }}">{{ $temp['filename'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label title="Your form contains this field in a quarter of a row.">
                                                <input type="checkbox" class="ml-2 export"
                                                    {{ old('fields') && @old('fields')['options']['export_0'] == 'export' ? 'checked' : '' }}
                                                    name="fields[options][export_0]" value="export" id="export_0">
                                                export
                                            </label>
                                            <label title="Your form contains this field in a quarter of a row.">
                                                <input type="checkbox" class="ml-2 import"
                                                    {{ old('fields') && @old('fields')['options']['import_0'] == 'import' ? 'checked' : '' }}
                                                    name="fields[options][import_0]" value="import" id="import_0">
                                                import
                                            </label>
                                            <label title="Your form contains this field in a quarter of a row.">
                                                <input type="checkbox" class="ml-2 column"
                                                    {{ old('fields') && @old('fields')['column']['column_0'] == 'col-md-3' ? 'checked' : '' }}
                                                    name="fields[column][column_0]" value="col-md-3" id="column_0"> md-3
                                            </label>

                                        </div>
                                        <div class="col">
                                            <div class="form-group ml-1">
                                                <input type="text" class="form-control d-inline-flex"
                                                    value="{{ old('fields') && old('fields')['comment'][0] ? old('fields')['comment'][0] : '' }}"
                                                    name="fields[comment][0]" id="fields_comment_0"
                                                    placeholder="Comment" />
                                            </div>
                                            <label title="Your form contains this field in a one-third of a row.">
                                                <input type="checkbox" class="ml-2 column"
                                                    {{ old('fields') && @old('fields')['column']['column_0'] == 'col-md-4' ? 'checked' : '' }}
                                                    name="fields[column][column_0]" value="col-md-4" id="column_md_4_0">
                                                md-4
                                            </label>
                                            <label title="Your form contains this field in a half of a row.">
                                                <input type="checkbox" class="ml-2 column"
                                                    {{ old('fields') && @old('fields')['column']['column_0'] != 'col-md-6' ? '' : 'checked' }}
                                                    name="fields[column][column_0]" value="col-md-6" id="column_md_6_0">
                                                md-6 </label>
                                            <label title="Your form contains this field in a full row.">
                                                <input type="checkbox" class="ml-2 column"
                                                    {{ old('fields') && @old('fields')['column']['column_0'] == 'col-md-12' ? 'checked' : '' }}
                                                    name="fields[column][column_0]" value="col-md-12"
                                                    id="column_md_12_0"> md-12<label>
                                        </div>
                                        <div class="col-12 justify-content-around d-none" id="cascadediv0">
                                            <div class="mt-4">Enter Ref Table Name (PhpMyAdmin)</div>
                                            <div class="form-group">
                                                <input type="text" name="fields[ref_table][0]"
                                                    class="form-control d-inline-flex" value=""
                                                    placeholder="Enter table name"
                                                    value="{{ old('fields') && @old('fields')['ref_table'][0] ? @old('fields')['ref_table'][0] : '' }}">
                                            </div>
                                            <div class="mt-4">Enter Ref Column Name</div>
                                            <div class="form-group">
                                                <input type="text" name="fields[ref_col][0]"
                                                    class="form-control d-inline-flex" value="id"
                                                    placeholder="Enter column name"
                                                    value="{{ old('fields') && @old('fields')['ref_col'][0] ? @old('fields')['ref_col'][0] : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label title="On Delete.">
                                                    <input type="checkbox" class="ml-2 "
                                                        {{ old('fields') && @old('fields')['ref_on_delete_0'] == 'OnDelete' ? 'checked' : '' }}
                                                        name="fields[ref_on_delete_0]" value="OnDelete"
                                                        id="ref_on_delete_0" checked> OnDelete<label>
                                            </div>
                                            <div class="form-group">
                                                <label title="On update">
                                                    <input type="checkbox" class="ml-2 "
                                                        {{ old('fields') && @old('fields')['ref_on_update_0'] == 'OnUpdate' ? 'checked' : '' }}
                                                        name="fields[ref_on_update_0]" value="OnUpdate"
                                                        id="ref_on_update_0"checked> OnUpdate<label>
                                            </div>
                                        </div>
                                    </li>
                                    @if (old('fields') && count(old('fields')['name']) > 0)
                                        @for ($i = 1; $i < count(old('fields')['name']); $i++)
                                            @isset(old('fields')['name'][$i])
                                                <li class="row no-gutters ui-state-default align-items-center field">
                                                    <span class="btn-accent btn-sm mr-3 hash">#</span>
                                                    <div class="col">
                                                        <div class="form-group mr-1">
                                                            <input required type="text" class="form-control col_name"
                                                                value="{{ old('fields') && old('fields')['name'][$i] ? old('fields')['name'][$i] : '' }}"
                                                                data-id="{{ $i }}"
                                                                id="col_name{{ $i }}"
                                                                name="fields[name][{{ $i }}]"
                                                                placeholder="Name" />
                                                        </div>
                                                        <label
                                                            title="To ensure the field is required from both the client and server sides, this is helpful.">
                                                            <input type="checkbox" class="ml-2 do-required"
                                                                name="fields[options][required_{{ $i }}]"
                                                                value="required"
                                                                {{ old('fields') && @old('fields')['options']['required_' . $i] ? 'checked' : '' }}
                                                                id="required_{{ $i }}"> Required
                                                        </label>
                                                        <label title="To ensure that null values are accepted.">
                                                            <input type="checkbox" class="ml-2 do-nullable"
                                                                title="To ensure that null values are accepted."
                                                                name="fields[options][nullable_{{ $i }}]"
                                                                value="nullable"
                                                                {{ old('fields') && @old('fields')['options']['nullable_' . $i] ? 'checked' : '' }}
                                                                id="nullable_{{ $i }}"> Null
                                                        </label>
                                                        <label
                                                            title="To ensure ascending descending sorting can be performed.">
                                                            <input type="checkbox" class="ml-2 do-sorting"
                                                                title="To ensure ascending descending sorting can be performed."
                                                                name="fields[options][sorting_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['options']['sorting_' . $i] ? 'checked' : '' }}
                                                                value="sorting" id="sorting_{{ $i }}"> Sort
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group mr-1">
                                                            <select required name="fields[type][{{ $i }}]"
                                                                class="form-control select2">
                                                                <option value="">--Select Field Type--</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'bigIncrements') selected @endif
                                                                    value="bigIncrements">bigIncrements</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'bigInteger') selected @endif
                                                                    value="bigInteger">bigInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'binary') selected @endif
                                                                    value="binary">binary</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'boolean') selected @endif
                                                                    value="boolean">boolean</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'char') selected @endif
                                                                    value="char">char</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'dateTimeTz') selected @endif value="dateTimeTz">dateTimeTz</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'dateTime') selected @endif
                                                                    value="dateTime">dateTime</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'date') selected @endif
                                                                    value="date">date</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'decimal') selected @endif
                                                                    value="decimal">decimal</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'double') selected @endif
                                                                    value="double">double</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'enum') selected @endif
                                                                    value="enum">enum</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'float') selected @endif
                                                                    value="float">float</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'foreignId') selected @endif value="foreignId">foreignId</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'geometryCollection') selected @endif value="geometryCollection">geometryCollection</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'geometry') selected @endif value="geometry">geometry</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'id') selected @endif
                                                                    value="id">id</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'increments') selected @endif
                                                                    value="increments">increments</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'integer') selected @endif
                                                                    value="integer">integer</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'ipAddress') selected @endif
                                                                    value="ipAddress">ipAddress</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'json') selected @endif
                                                                    value="json">json</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'jsonb') selected @endif value="jsonb">jsonb</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'lineString') selected @endif
                                                                    value="lineString">lineString</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'longText') selected @endif
                                                                    value="longText">longText</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'macAddress') selected @endif value="macAddress">macAddress</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'mediumIncrements') selected @endif value="mediumIncrements">mediumIncrements</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'mediumInteger') selected @endif
                                                                    value="mediumInteger">mediumInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'mediumText') selected @endif
                                                                    value="mediumText">mediumText</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'morphs') selected @endif value="morphs">morphs</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'multiLineString') selected @endif value="multiLineString">multiLineString</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'multiPoint') selected @endif value="multiPoint">multiPoint</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'multiPolygon') selected @endif value="multiPolygon">multiPolygon</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'nullableMorphs') selected @endif value="nullableMorphs">nullableMorphs</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'nullableTimestamps') selected @endif value="nullableTimestamps">nullableTimestamps</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'nullableUuidMorphs') selected @endif value="nullableUuidMorphs">nullableUuidMorphs</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'point') selected @endif value="point">point</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'polygon') selected @endif value="polygon">polygon</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'rememberToken') selected @endif value="rememberToken">rememberToken</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'set') selected @endif value="set">set</option>
                                                            <option @if (old('fields') && old('fields')['type'][$i] == 'smallIncrements') selected @endif value="smallIncrements">smallIncrements</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'smallInteger') selected @endif
                                                                    value="smallInteger">smallInteger</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'softDeletesTz') selected @endif value="softDeletesTz">softDeletesTz</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'softDeletes') selected @endif
                                                                    value="softDeletes">softDeletes</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'string') selected @endif
                                                                    value="string">string</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'text') selected @endif
                                                                    value="text">text</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'timeTz') selected @endif value="timeTz">timeTz</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'time') selected @endif
                                                                    value="time">time</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'timestampTz') selected @endif value="timestampTz">timestampTz</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'timestamp') selected @endif
                                                                    value="timestamp">timestamp</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'timestampsTz') selected @endif value="timestampsTz">timestampsTz</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'timestamps') selected @endif
                                                                    value="timestamps">timestamps</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'tinyIncrements') selected @endif value="tinyIncrements">tinyIncrements</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'tinyInteger') selected @endif
                                                                    value="tinyInteger">tinyInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'tinyText') selected @endif
                                                                    value="tinyText">tinyText</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedBigInteger') selected @endif
                                                                    value="unsignedBigInteger">unsignedBigInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedDecimal') selected @endif
                                                                    value="unsignedDecimal">unsignedDecimal</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedInteger') selected @endif
                                                                    value="unsignedInteger">unsignedInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedMediumInteger') selected @endif
                                                                    value="unsignedMediumInteger">unsignedMediumInteger
                                                                </option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedSmallInteger') selected @endif
                                                                    value="unsignedSmallInteger">unsignedSmallInteger</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'unsignedTinyInteger') selected @endif
                                                                    value="unsignedTinyInteger">unsignedTinyInteger</option>
                                                                {{-- <option @if (old('fields') && old('fields')['type'][$i] == 'uuidMorphs') selected @endif value="uuidMorphs">uuidMorphs</option> --}}
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'uuid') selected @endif
                                                                    value="uuid">uuid</option>
                                                                <option @if (old('fields') && old('fields')['type'][$i] == 'year') selected @endif
                                                                    value="year">year</option>

                                                            </select>
                                                        </div>
                                                        <label title="To ensure that the field is displayed in the table.">
                                                            <input type="checkbox" class="ml-2"
                                                                name="fields[options][showindex_{{ $i }}]"
                                                                value="showindex"
                                                                {{ old('fields') && @old('fields')['options']['showindex_' . $i] ? 'checked' : '' }}
                                                                id="showindex_{{ $i }}">Index
                                                        </label>
                                                        <label title="To ensure that the field is searchable in the table.">
                                                            <input type="checkbox" class="ml-2"
                                                                title="To ensure that the field is searchable in the table."
                                                                name="fields[options][cansearch_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['options']['cansearch_' . $i] ? 'checked' : '' }}
                                                                value="cansearch" id="cansearch_{{ $i }}">Search
                                                        </label>
                                                        <label
                                                            title="To ensure that the record is delete in that table if the reference table record delete.">
                                                            <input type="checkbox" class="ml-2"
                                                                title="To ensure that the record is delete in that table if the reference table record delete."
                                                                name="fields[options][cascade_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['options']['cascade_' . $i] ? 'checked' : 'disabled' }}
                                                                value="cascade" id="cascade_{{ $i }}">Cascade
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group mr-1">
                                                            <select required name="fields[input][{{ $i }}]"
                                                                class="form-control select2 fields-type">
                                                                <option value="">--Select Input Type--</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'text') selected @endif
                                                                    value="text">{{ ucfirst('text') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'hidden') selected @endif
                                                                    value="hidden">{{ ucfirst('hidden') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'date') selected @endif
                                                                    value="date">{{ ucfirst('date') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'datetime-local') selected @endif
                                                                    value="datetime-local">{{ ucfirst('dateTime') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'decimal') selected @endif
                                                                    value="decimal">{{ ucfirst('decimal ') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'number') selected @endif
                                                                    value="number">{{ ucfirst('number') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'email') selected @endif
                                                                    value="email">{{ ucfirst('email') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'password') selected @endif
                                                                    value="password">{{ ucfirst('password') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'url') selected @endif
                                                                    value="url">{{ ucfirst('url') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'file') selected @endif
                                                                    value="file">{{ ucfirst('file') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'radio') selected @endif
                                                                    value="radio">{{ ucfirst('radio') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'checkbox') selected @endif
                                                                    value="checkbox">{{ ucfirst('checkbox') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'textarea') selected @endif
                                                                    value="textarea">{{ ucfirst('textarea') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'select') selected @endif
                                                                    value="select">{{ ucfirst('select') }}</option>
                                                                <option @if (old('fields') && old('fields')['input'][$i] == 'select_via_table') selected @endif
                                                                    value="select_via_table">{{ ucfirst('select Via Table') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <label
                                                            title="To ensure that the field accepts unique values from the database.">
                                                            <input type="checkbox" class="ml-2 do-unique"
                                                                title="To ensure that the field accepts unique values from the database."
                                                                name="fields[options][unique_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['options']['unique_' . $i] ? 'checked' : '' }}
                                                                value="unique" id="unique_{{ $i }}"> Unique
                                                        </label>
                                                        <label
                                                            title="To ensure that multiple values can be entered into the field.">
                                                            <input type="checkbox" class="ml-2"
                                                                name="fields[options][multiple_{{ $i }}]"
                                                                value="multiple"
                                                                {{ old('fields') && @old('fields')['options']['multiple_' . $i] ? 'checked' : 'disabled' }}
                                                                id="multiple_{{ $i }}"> Multi <small>(files &
                                                                select)</small> </label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group d-flex justify-content-around">
                                                            <textarea name="fields[default][{{ $i }}]" rows="1"
                                                                class="form-control  @if (old('fields') && old('fields')['table'][$i] != '') d-none @endif">{{ old('fields') && old('fields')['default'][$i] ? old('fields')['default'][$i] : '' }}</textarea>
                                                            <select name="fields[table][{{ $i }}]"
                                                                class="form-control table @if (old('fields') && old('fields')['table'][$i] != '') @else d-none @endif">
                                                                <option value="">Select Table</option>
                                                                <option @if (old('fields') && old('fields')['table'][$i] == 'User') selected @endif
                                                                    value="User">User</option>
                                                                @foreach ($tmpFiles as $temp)
                                                                    <option
                                                                        @if (old('fields') && old('fields')['table'][$i] == $temp['filename']) selected @endif
                                                                        value="{{ $temp['filename'] }}">
                                                                        {{ $temp['filename'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <label title="Your form contains this field in a quarter of a row.">
                                                            <input type="checkbox" class="ml-2 export"
                                                                {{ old('fields') && @old('fields')['options']['export_' . $i] == 'export' ? 'checked' : '' }}
                                                                name="fields[options][export_{{ $i }}]"
                                                                value="export" id="export_{{ $i }}"> export
                                                        </label>
                                                        <label title="Your form contains this field in a quarter of a row.">
                                                            <input type="checkbox" class="ml-2 import"
                                                                {{ old('fields') && @old('fields')['options']['import_' . $i] == 'import' ? 'checked' : '' }}
                                                                name="fields[options][import_{{ $i }}]"
                                                                value="import" id="import_{{ $i }}"> import
                                                        </label>
                                                        <label title="Your form contains this field in a quarter of a row.">
                                                            <input type="checkbox" class="ml-2 column"
                                                                name="fields[column][column_{{ $i }}]"
                                                                value="col-md-3"
                                                                {{ old('fields') && @old('fields')['column']['column_' . $i] == 'col-md-3' ? 'checked' : '' }}
                                                                id="column_{{ $i }}"> md-3</label>

                                                    </div>
                                                    <div class="col ">
                                                        <div class="form-group ml-1">
                                                            <input type="text" class="form-control"
                                                                value="{{ old('fields') && old('fields')['comment'][$i] ? old('fields')['comment'][$i] : '' }}"
                                                                name="fields[comment][{{ $i }}]"
                                                                placeholder="Comment" />
                                                        </div>
                                                        <label title="Your form contains this field in a one-third of a row.">
                                                            <input type="checkbox" class="ml-2 column"
                                                                name="fields[column][column_{{ $i }}]"
                                                                value="col-md-4"
                                                                {{ old('fields') && @old('fields')['column']['column_' . $i] == 'col-md-4' ? 'checked' : '' }}
                                                                id="column_{{ $i }}"> md-4 </label>
                                                        <label title="Your form contains this field in a half of a row.">
                                                            <input type="checkbox" class="ml-2 column"
                                                                name="fields[column][column_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['column']['column_' . $i] == 'col-md-6' ? 'checked' : '' }}
                                                                value="col-md-6" id="column_{{ $i }}"> md-6
                                                        </label>
                                                        <label title="Your form contains this field in a full row.">
                                                            <input type="checkbox" class="ml-2 column"
                                                                name="fields[column][column_{{ $i }}]"
                                                                {{ old('fields') && @old('fields')['column']['column_' . $i] == 'col-md-12' ? 'checked' : '' }}
                                                                value="col-md-12" id="column_{{ $i }}"> md-12
                                                        </label>
                                                    </div>
                                                    <div class="col-12 justify-content-around  {{ old('fields') && @old('fields')['options']['cascade_' . $i] ? 'd-md-flex' : 'd-none' }} "
                                                        id="cascadediv{{ $i }}">
                                                        <div class="mt-4">Enter Ref Table Name (PhpMyAdmin)</div>
                                                        <div class="form-group">
                                                            <input type="text"
                                                                name="fields[ref_table][{{ $i }}]"
                                                                class="form-control d-inline-flex"
                                                                placeholder="Enter table name"
                                                                value="{{ old('fields') && @old('fields')['ref_table'][$i] ? @old('fields')['ref_table'][$i] : '' }}">
                                                        </div>
                                                        <div class="mt-4">Enter Ref Column Name</div>
                                                        <div class="form-group">
                                                            <input type="text"
                                                                name="fields[ref_col][{{ $i }}]"
                                                                class="form-control d-inline-flex"
                                                                placeholder="Enter column name"
                                                                value="{{ old('fields') && @old('fields')['ref_col'][$i] ? @old('fields')['ref_col'][$i] : '' }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label title="On Delete.">
                                                                <input type="checkbox" class="ml-2 "
                                                                    {{ old('fields') && @old('fields')['ref_on_delete_' . $i] == 'OnDelete' ? 'checked' : '' }}
                                                                    name="fields[ref_on_delete_{{ $i }}]"
                                                                    value="OnDelete" id="ref_on_delete_{{ $i }}"
                                                                    checked> OnDelete<label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label title="On update">
                                                                <input type="checkbox" class="ml-2 "
                                                                    {{ old('fields') && @old('fields')['ref_on_update_' . $i] == 'OnUpdate' ? 'checked' : '' }}
                                                                    name="fields[ref_on_update_{{ $i }}]"
                                                                    value="OnUpdate" id="ref_on_update_{{ $i }}"
                                                                    checked> OnUpdate<label>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endisset
                                        @endfor
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <span>Add Media Inputs</span>
                                <div>
                                    <button class="btn btn-accent btn-sm btn-add" type="button" title="Add New Field"
                                            id="addMediaInputBtn">+</button>
                                    <button class="btn btn-accent btn-sm btn-sub" type="button"
                                            title="Last Field Delete" id="removeMediaInputBtn">-</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul id="mediaSortable" class="mediaInputs p-0">
                                    @if (old('media') && count(old('media')['name']) > 0)
                                        @for ($i = 1; $i <= count(old('media')['name']); $i++)
                                            <li class="row no-gutters ui-state-default align-items-center field">
                                                <span class="btn-accent btn-sm mr-3 hash">#</span>
                                                <div class="col">
                                                    <div class="form-group mr-1">
                                                        <input required type="text" class="form-control media_col_name"
                                                               value="{{ old('media') && old('media')['name'][$i] ? old('media')['name'][$i] : '' }}"
                                                               data-id="{{ $i }}"
                                                               id="media_col_name{{ $i }}"
                                                               name="media[name][{{ $i }}]"
                                                               placeholder="Name" />
                                                    </div>
                                                    <label
                                                        title="To ensure the field is required from both the client and server sides, this is helpful.">
                                                        <input type="checkbox" class="ml-2 do-media-required"
                                                               {{ old('media') && @old('media')['options']['required_' . $i] ? 'checked' : '' }}
                                                               name="media[options][required_{{ $i }}]"
                                                               value="required" id="media-required_{{ $i }}">
                                                        Required
                                                    </label>

                                                </div>
                                                <div class="col">
                                                    <div class="form-group mr-1">
                                                        <input type="number" class="form-control input_mb"
                                                               value="{{ old('media') && old('media')['size'][$i] ? old('media')['size'][$i] : '' }}"
                                                               min="1" data-id="{{ $i }}"
                                                               id="media_name{{ $i }}"
                                                               name="media[size][{{ $i }}]"
                                                               placeholder="Size (in MB)" />
                                                    </div>
                                                    <label title="To ensure that null values are accepted.">
                                                        <input type="checkbox" class="ml-2 do-media-nullable"
                                                               {{ old('media') && @old('media')['options']['required_' . $i] ? '' : 'checked' }}
                                                               name="media[options][nullable_{{ $i }}]"
                                                               value="nullable" id="media-nullable_{{ $i }}">
                                                        Null
                                                    </label>
                                                    <label title="To ensure that null values are multiple.">
                                                        <input type="checkbox" class="ml-2"
                                                               {{ old('media') && @old('media')['options']['multiple_' . $i] ? 'checked' : '' }}
                                                               name="media[options][multiple_{{ $i }}]"
                                                               value="multiple" id="media-multiple_{{ $i }}">
                                                        multi
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group mr-1">
{{--                                                        <input type="number" class="form-control"--}}
{{--                                                               value="{{ old('media') && old('media')['col'][$i] ? old('media')['col'][$i] : '' }}"--}}
{{--                                                               data-id="{{ $i }}"--}}
{{--                                                               id="media_col{{ $i }}"--}}
{{--                                                               name="media[col][{{ $i }}]"--}}
{{--                                                               placeholder="Enter col-md" min="1" max="12" />--}}

                                                        <label title="Your form contains this field in a full row.">
                                                            <input type="radio" class="ml-2"
                                                                   name="media[col][{{ $i }}]" value="{{ old('media') && old('media')['col'][$i] ? old('media')['col'][$i] : '' }}"
                                                                   id="media_col{{ $i }}"> md-3<label>
                                                                <label title="Your form contains this field in a full row.">
                                                            <input type="radio" class="ml-2"
                                                                   name="media[col][{{ $i }}]" value="{{ old('media') && old('media')['col'][$i] ? old('media')['col'][$i] : '' }}"
                                                                   id="media_col{{ $i }}"> md-4<label>
                                                                        <label title="Your form contains this field in a full row.">
                                                            <input type="radio" class="ml-2"
                                                                   name="media[col][{{ $i }}]" value="{{ old('media') && old('media')['col'][$i] ? old('media')['col'][$i] : '' }}"
                                                                   id="media_col{{ $i }}" checked> md-6<label>
                                                                                <label title="Your form contains this field in a full row.">
                                                            <input type="radio" class="ml-2"
                                                                   name="media[col][{{ $i }}]" value="{{ old('media') && old('media')['col'][$i] ? old('media')['col'][$i] : '' }}"
                                                                   id="media_col{{ $i }}"> md-12<label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endfor
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Right Col --}}
                    <div class="col-md-6">
                        {{-- Validations --}}
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <span> Server Side Validations</span>
                                <div>
                                    <button class="btn btn-accent btn-sm btn-add" id="addValidations"
                                        type="button">+</button>
                                    <button class="btn btn-accent btn-sm btn-sub" type="button"
                                        id="removeValidations">-</button>
                                </div>
                            </div>
                            <div class="card-body validations">
                                <div class="row mb-2">
                                    <div class="col">
                                        Field
                                    </div>
                                    <div class="col">
                                        Rules
                                    </div>
                                </div>
                                <div class="row no-gutters align-items-center validation mb-2">
                                    <div class="col">
                                        <div class="form-group mr-1">
                                            <input type="text" class="form-control"
                                                value="{{ old('validations') && old('validations')['field'][0] ? old('validations')['field'][0] : '' }}"
                                                name="validations[field][]" id="validation0" placeholder="Filed" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mr-1">
                                            <input type="text" class="form-control"
                                                value="{{ old('validations') && old('validations')['rules'][0] ? old('validations')['rules'][0] : 'nullable' }}"
                                                name="validations[rules][]" id="rule0" placeholder="Rules" />
                                        </div>
                                    </div>
                                </div>
                                @if (old('validations') && count(old('validations')['field']) > 0)
                                    @for ($vi = 1; $vi < count(old('validations')['field']); $vi++)
                                        <div class="row no-gutters align-items-center validation">
                                            <div class="col">
                                                <div class="form-group mr-1">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('validations') && old('validations')['field'][$vi] ? old('validations')['field'][$vi] : '' }}"
                                                        name="validations[field][]" id="validation{{ $vi }}"
                                                        placeholder="Filed" />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mr-1">
                                                    <input type="text" class="form-control"
                                                        value="{{ old('validations') && old('validations')['rules'][$vi] ? old('validations')['rules'][$vi] : '' }}"
                                                        name="validations[rules][]" id="rule{{ $vi }}"
                                                        value="nullable" placeholder="Rules" />
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Right Col --}}
                    <div class="col-md-6">
                        {{-- Validations --}}
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <span>Groups</span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Delete</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="softdelete"><input type="checkbox" id="softdelete" name="softdelete"
                                                                               value="1" @if (old('softdelete') == 1) checked @endif /> Soft
                                                    Delete</label><br>
                                                {{--                                        <label for="api"><input type="checkbox" id="api" name="api"--}}
                                                {{--                                                value="1" @if (old('api') == 1) checked @endif />--}}
                                                {{--                                            Generate API</label><br>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Filter</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                {{--                                        <label for="api"><input type="checkbox" id="api" name="api"--}}
                                                {{--                                                value="1" @if (old('api') == 1) checked @endif />--}}
                                                {{--                                            Generate API</label><br>--}}

                                                <label for="date_filter"><input type="checkbox" id="date_filter"
                                                                                name="date_filter" value="1" checked /> Date Filter</label><br>
                                                <label for="status_filter"><input type="checkbox" id="status_filter"
                                                                                name="status_filter" value="1" @if (old('status_filter') == 1) checked @endif /> Status Filter</label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Action</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label for="export_btn"><input type="checkbox" id="export_btn" name="export_btn"
                                                                               value="1"
                                                                               @if (old('export_btn') == 1) checked @endif /> Database Export</label><br>
                                                <label for="import_btn"><input type="checkbox" id="import_btn" name="import_btn"
                                                                               value="1"
                                                                               @if (old('import_btn') == 1) checked @endif /> Database Import</label><br>

                                                <label for="bulk_activation_btn"><input type="checkbox" id="bulk_activation_btn"
                                                                                        name="bulk_activation_btn" value="1"
                                                                                        @if (old('bulk_activation_btn') == 1) checked @endif /> Bulk
                                                    Action</label><br>
                                                <label for="autofocus_btn"><input type="checkbox" id="autofocus_btn" name="autofocus_btn"
                                                                                  value="1"@if (old('autofocus_btn') == 1) checked @endif /> Auto Focus Refresh
                                                </label><br>

                                               <label for="excel_btn"><input type="checkbox" id="excel_btn" name="excel_btn"
                                                                              value="1"@if (old('excel_btn') == 1) checked @endif /> Table Export (Excel)
                                                </label><br>
                                                <label for="featured_activation"><input type="checkbox" id="featured_activation" name="featured_activation"
                                                                                        value="1" checked/> Featured Activation
                                                </label><br>
                                                {{--                                        <label for="print_btn"><input type="checkbox" id="print_btn" name="print_btn"--}}
                                                {{--                                                value="1"@if (old('print_btn') == 1) checked @endif />--}}
                                                {{--                                            Print</label><br>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Notification</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-12">

                                                <label for="mail"><input type="checkbox" id="mail" name="mail"
                                                                         value="1" @if (old('mail') == 1) checked @endif /> Mail
                                                    Notification</label><br>
                                            </div>
                                            <div class="col-12">
                                                <label for="notification"><input type="checkbox" id="notification"
                                                                                 name="notification"
                                                                                 value="1"@if (old('notification') == 1) checked @endif /> On Site
                                                    Notification</label><br>
                                            </div>
                                            <div class="col-12">

                                                <label for="fcm"><input type="checkbox" id="fcm" name="fcm"
                                                                        value="1" @if (old('fcm') == 1) checked @endif /> Push
                                                    Notification (FCM)</label><br>
                                            </div>
                                            <div class="col-12">
                                                <label for="pusher"><input type="checkbox" id="pusher"
                                                                           name="pusher"
                                                                           value="1"@if (old('pusher') == 1) checked @endif /> Real Time
                                                    Notification (Pusher)</label><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card text-white bg-primary">
                    <div class="card-body">

                        <div class="form-group m-0">
                           <i class="fa fa-info-circle"></i> Please  make sure specially
                            rules, data types, and necessary options are wisely imported.  <button type="submit" class="btn btn-accent text-grey-800 float-right">Generate</button>
                        </div>

                    </div>
                </div>
            </form>
            <div id="accordion">
                <div class="accordion-header my-3" id="headingOne">
                    <button class="btn accordion-button bg-primary" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne" style="width: 100%; height: 50px">
                        <span class="text-white">Laravel Validation Rules</span>
{{--                        <i class="fa-solid fa-chevron-down"></i>--}}
                    </button>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="accordion-body">
                            <ul>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <li>accepted</li>
                                        <li> active_url</li>
                                        <li>after:YYYY-MM-DD</li>
                                        <li>before:YYYY-MM-DD</li>
                                        <li>alpha</li>
                                        <li>alpha_dash</li>
                                        <li>alpha_num</li>
                                        <li>array</li>
                                        <li>between:1,10</li>
                                        <li>confirmed</li>
                                        <li>date</li>
                                    </div>
                                    <div class="col-md-3">
                                        <li>date_format:YYYY-MM-DD</li>
                                        <li>different:fieldname</li>
                                        <li>digits:value</li>
                                        <li>digits_between:min,max</li>
                                        <li>boolean</li>
                                        <li>email</li>
                                        <li>exists:table,column</li>
                                        <li>image</li>
                                        <li>in:foo,bar,...</li>
                                        <li>not_in:foo,bar,...</li>
                                        <li>sometimes</li>
                                    </div>
                                    <div class="col-md-3">
                                        <li>integer</li>
                                        <li>numeric</li>
                                        <li>ip</li>
                                        <li>max:value</li>
                                        <li>min:value</li>
                                        <li>mimes:jpeg,png</li>
                                        <li>regex:[0-9]</li>
                                        <li>required</li>
                                        <li>required_if:field,value</li>
                                    </div>
                                    <div class="col-md-3">
                                        <li>required_with:foo,bar,...</li>
                                        <li>required_with_all:foo,bar,...</li>
                                        <li>required_without:foo,bar,...</li>
                                        <li>required_without_all:foo,bar,...</li>
                                        <li>same:field</li>
                                        <li>size:value</li>
                                        <li>timezone</li>
                                        <li>unique:table,column,except,idColumn</li>
                                        <li>url</li>
                                    </div>
                                </div>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Push Scripts --}}
@push('scopedJs')
    <script src="{{ asset('panel/admin/plugins/js/validation.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        var pluralized = (function() {
            const vowels = "aeiou";

            const irregulars = {
                "addendum": "addenda",
                "aircraft": "aircraft",
                "alumna": "alumnae",
                "alumnus": "alumni",
                "analysis": "analyses",
                "antenna": "antennae",
                "antithesis": "antitheses",
                "apex": "apices",
                "appendix": "appendices",
                "axis": "axes",
                "bacillus": "bacilli",
                "bacterium": "bacteria",
                "basis": "bases",
                "beau": "beaux",
                "bison": "bison",
                "bureau": "bureaux",
                "cactus": "cacti",
                "château": "châteaux",
                "child": "children",
                "codex": "codices",
                "concerto": "concerti",
                "corpus": "corpora",
                "crisis": "crises",
                "criterion": "criteria",
                "curriculum": "curricula",
                "datum": "data",
                "deer": "deer",
                "diagnosis": "diagnoses",
                "die": "dice",
                "dwarf": "dwarves",
                "ellipsis": "ellipses",
                "erratum": "errata",
                "faux pas": "faux pas",
                "fez": "fezzes",
                "fish": "fish",
                "focus": "foci",
                "foot": "feet",
                "formula": "formulae",
                "fungus": "fungi",
                "genus": "genera",
                "goose": "geese",
                "graffito": "graffiti",
                "grouse": "grouse",
                "half": "halves",
                "hoof": "hooves",
                "hypothesis": "hypotheses",
                "index": "indices",
                "larva": "larvae",
                "libretto": "libretti",
                "loaf": "loaves",
                "locus": "loci",
                "louse": "lice",
                "man": "men",
                "matrix": "matrices",
                "medium": "media",
                "memorandum": "memoranda",
                "minutia": "minutiae",
                "moose": "moose",
                "mouse": "mice",
                "nebula": "nebulae",
                "nucleus": "nuclei",
                "oasis": "oases",
                "offspring": "offspring",
                "opus": "opera",
                "ovum": "ova",
                "ox": "oxen",
                "parenthesis": "parentheses",
                "phenomenon": "phenomena",
                "phylum": "phyla",
                "quiz": "quizzes",
                "radius": "radii",
                "referendum": "referenda",
                "salmon": "salmon",
                "scarf": "scarves",
                "self": "selves",
                "series": "series",
                "sheep": "sheep",
                "shrimp": "shrimp",
                "species": "species",
                "stimulus": "stimuli",
                "stratum": "strata",
                "swine": "swine",
                "syllabus": "syllabi",
                "symposium": "symposia",
                "synopsis": "synopses",
                "tableau": "tableaux",
                "thesis": "theses",
                "thief": "thieves",
                "tooth": "teeth",
                "trout": "trout",
                "tuna": "tuna",
                "vertebra": "vertebrae",
                "vertex": "vertices",
                "vita": "vitae",
                "vortex": "vortices",
                "wharf": "wharves",
                "wife": "wives",
                "wolf": "wolves",
                "woman": "women",
                "guy": "guys",
                "buy": "buys",
                "person": "people"
            };

            function pluralized(word) {
                word = word.toLowerCase();


                if (irregulars[word]) {
                    return irregulars[word];
                }

                if (word.length >= 2 && vowels.includes(word[word.length - 2])) {
                    return word + "s";
                }

                if (word.endsWith("s") || word.endsWith("sh") || word.endsWith("ch") || word.endsWith("x") || word
                    .endsWith("z")) {
                    return word + "es";
                }

                if (word.endsWith("y")) {
                    return word.slice(0, -1) + "ies";
                }


                return word + "s";
            }

            return pluralized;
        })();
    </script>
    <script>
        $(function() {
            $("#sortable").sortable();
            $("#mediaSortable").sortable();
        });
        var inputval = 0;
        @if (old('fields'))
            var iteration = +"{{ count(old('fields')['name']) }}";
            var mediaIteration = +"{{ count(old('fields')['name']) }}";
            var validationIteration = +"{{ count(old('fields')['name']) }}";;
        @else
            var iteration = 1;
            var mediaIteration = 1;
            var validationIteration = 1;
        @endif

        function autoSelect(text, $this) {
            let col_id = $this.data('id');
            let symbol = /^[A-Za-z0-9_-]*$/;
            $this.closest('.field').find('[name="fields[type][' + col_id + ']"]').removeAttr("selected").trigger('change');
            $this.closest('.field').find('[name="fields[input][' + col_id + ']"]').removeAttr("selected").trigger('change');
            $this.closest('.field').find('#multiple_' + col_id).attr('disabled', true);
            $this.closest('.field').find('#cascade_' + col_id).attr('disabled', true);
            $this.closest('.field').find('#cascade_' + col_id).prop('checked', false).trigger('change');
            $this.closest('.field').find('#multiple_' + col_id).prop('checked', false).trigger('change');
            if (text.includes('_id') || text.includes('_by')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="bigInteger"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="select_via_table"]').attr(
                    'selected', 'selected');
                let val = text.replace('_id', '');
                val = val.replace('_', '');
                let value = @json($tmpFiles).filter(function(obj) {
                    if (obj.filename.toLowerCase() === val) return obj;
                }).map(function(obj) {
                    return obj.filename;
                });
                if (value.length > 0)
                    $this.closest('.field').find('[name="fields[table][' + col_id + ']"] [value="' + value[0] + '"]').attr(
                        'selected', 'selected');
                if (value == "Category")
                    $this.closest('.field').find('[name="fields[comment][0]"]').attr('placeholder',
                        'Enter Category Type Name');
                else
                    $this.closest('.field').find('[name="fields[comment][0]"]').attr('placeholder', 'Comment');

                $this.closest('.field').find('#multiple_' + col_id).removeAttr('disabled');
                $this.closest('.field').find('#cascade_' + col_id).removeAttr('disabled');
                $this.closest('.field').find('input[name="fields[ref_table][' + col_id + ']"]').val(pluralized(val));

            } else if (text.includes('status') || text.includes('role')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="enum"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="select"]').attr('selected',
                    'selected');
                if (text.includes('role')) {
                    $this.closest('.field').find('[name="fields[comment][' + col_id + ']"]').prop('required', true).val(
                        '"Normal User","Special User"');
                    $this.closest('.field').find('[name="fields[default][' + col_id + ']"]').val('Normal User');
                } else {
                    $this.closest('.field').find('[name="fields[comment][' + col_id + ']"]').prop('required', true).val(
                        '"Published","Unpublished"');
                    $this.closest('.field').find('[name="fields[default][' + col_id + ']"]').val('Active');
                }
            } else if (text.includes('city') || text.includes('state') || text.includes('country')|| text.includes('type')|| text.includes('priority')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="bigInteger"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="select_via_table"]').attr(
                    'selected', 'selected');
            }
            else if (text.includes('is_') || text.includes('_is')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="boolean"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="radio"]').attr('selected',
                    'selected');
            } else if (text.includes('date_time')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="dateTime"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="datetime-local"]').attr(
                    'selected', 'selected');
            } else if (text.includes('date')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="date"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="date"]').attr('selected',
                    'selected');
                $('#rule' + col_id).val($('#rule' + col_id).val() + '|date');
            } else if (text.includes('email')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="string"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="email"]').attr('selected',
                    'selected');
            } else if (text.includes('phone') || text.includes('pincode') || text.includes('zipcode') || text.includes(
                    'batch')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="string"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="number"]').attr('selected',
                    'selected');
            } else if (text.includes('age')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="integer"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="number"]').attr('selected',
                    'selected');
            }else if (text.includes('ip')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="ipAddress"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="text"]').attr('selected',
                    'selected');
            } else if (text.includes('name')  || text.includes('uuid') || text.includes('gender') ||text.includes('key') || text.includes('group') || text.includes('title') || text.includes('model_type') || text.includes(
                    'slug')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="string"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="text"]').attr('selected',
                    'selected');
            } else if (text.includes('file') || text.includes('image') || text.includes('attachment')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="text"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="file"]').attr('selected',
                    'selected');
                $this.closest('.field').find('#multiple_' + col_id).removeAttr('disabled');
            } else if (text.includes('description') || text.includes('_text') || text.includes('subject')|| text.includes('message')|| text.includes('details')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="longText"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="textarea"]').attr('selected',
                    'selected');

            } else if (text.includes('url') || text.includes('website')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="string"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="url"]').attr('selected',
                    'selected');

            } else if (text.includes('meta') || text.includes('keyword')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="longText"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="text"]').attr('selected',
                    'selected');

            } else if (text.includes('amount') || text.includes('price') || text.includes('rate') || text.includes(
                    '_rate')|| text.includes('total')|| text.includes('discount')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="double"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="decimal"]').attr('selected',
                    'selected');

            } else if (text.includes('tax')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="tinyInteger"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="number"]').attr('selected',
                    'selected');

            } else if (text.includes('remark') || text.includes('address')|| text.includes('comment')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="text"]').attr('selected',
                    'selected');
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="textarea"]').attr('selected',
                    'selected');

            } else if (text.includes('payload') || text.includes('fields') || text.includes('ekyc')) {
                $this.closest('.field').find('[name="fields[type][' + col_id + ']"] [value="json"]').attr('selected',
                    'selected');
                $this.closest('.field').find('#nullable_' + col_id).prop('checked', true); //null
                $this.closest('.field').find('[name="fields[input][' + col_id + ']"] [value="textarea"]').attr('selected',
                    'selected');

            }
            $this.closest('.field').find('[name="fields[type][' + col_id + ']"]').trigger('change');
            $this.closest('.field').find('[name="fields[input][' + col_id + ']"]').trigger('change');
        }

        $(document).ready(function() {
            $(document).on('click', '#addForeignKeys', function() {
                let tmp = '<div class="row no-gutters align-items-center foreignKey">\n' +
                    '    <div class="col mr-1">\n' +
                    '        <div class="form-group">\n' +
                    '            <input type="text" class="form-control" name="foreigns[column][]" placeholder="Column" />\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col mr-1">\n' +
                    '        <div class="form-group">\n' +
                    '            <input type="text" class="form-control" name="foreigns[references][]" placeholder="References"/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col mr-1">\n' +
                    '        <div class="form-group">\n' +
                    '            <input type="text" class="form-control" name="foreigns[on][]" placeholder="On"/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col mr-1">\n' +
                    '        <div class="form-group">\n' +
                    '            <input type="text" class="form-control" name="foreigns[onDelete][]" placeholder="onDelete" value="cascade" readonly/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>';

                $('.foreignKeys').append(tmp);
            });

            $(document).on('click', '#addRelationships', function() {
                let tmp = '<div class="row no-gutters align-items-center relationship">\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input type="text" class="form-control" name="relationships[name][]" placeholder="Name" />\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input type="text" class="form-control" name="relationships[type][]" placeholder="Type"/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +

                    '    <div class="col">\n' +
                    '       <div class="input-group mb-3">\n' +
                    '           <div class="input-group-prepend">\n' +
                    '               <span class="input-group-text">App\</span>\n' +
                    '           </div>\n' +
                    '           <input type="text" class="form-control" name="relationships[class][]" placeholder="Models\User">\n' +
                    '       </div>\n' +
                    '    </div>\n' +

                    '    <div class="col">\n' +
                    '        <div class="form-group">\n' +
                    '            <textarea name="fields[option][]" rows="1"  class="form-control"></textarea>\n' +
                    '        </div>\n' +
                    '    </div>\n' +

                    '</div>';

                $('.relationships').append(tmp);
            });

            $(document).on('click', '#addValidations', function() {

                let tmp = '<div class="row no-gutters align-items-center validation mb-2">\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input type="text" class="form-control" id="validation' + iteration +
                    '" name="validations[field][]" placeholder="Filed" />\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input type="text" class="form-control" id="rule' + iteration +
                    '" name="validations[rules][]" value="nullable" placeholder="Rules"/>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>';

                $('.validations').append(tmp);
                // Increment iteration
                validationIteration++;

            });
            $(document).on('click', '#addFieldsBtn', function() {
                // inputval = 0;
                let html;
                html = '  <textarea name="fields[default][' + iteration +
                    ']" rows="1" class="form-control" id="fields_default_' + iteration + '"></textarea>\n';

                html += '   <select name="fields[table][' + iteration +
                    ']" class="form-control  table d-none" id="">\n' +
                    '<option value="">Select Table</option>' +
                    ' <option value="User">User</option>' +
                    @foreach ($tmpFiles as $temp)
                        ' <option value="' + "{{ $temp['filename'] }}" + '">' +
                        "{{ $temp['filename'] }}" + '</option>\n' +
                    @endforeach
                ' </select>\n';

                let tmp = '<li class="row no-gutters ui-state-default align-items-center field">\n' +
                    ' <span class="btn-accent btn-sm mr-3 hash">#</span>' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input required type="text" class="form-control col_name" data-id="' +
                    iteration + '" id="col_name' + iteration + '" name="fields[name][' + iteration +
                    ']" placeholder="Name" />\n' +
                    '        </div>\n' +
                    '         <label title="To ensure the field is required from both the client and server sides, this is helpful."><input type="checkbox" class="ml-2 do-required" name="fields[options][required_' +
                    iteration + ']" value="required"  id="required_' + iteration + '"> Required</label>' +
                    '      <label title="To ensure that null values are accepted.">  <input type="checkbox" class="ml-2 do-nullable" name="fields[options][nullable_' +
                    iteration + ']" value="nullable" checked id="nullable_' + iteration +
                    '"> Null</label>' +
                    '      <label title="To ensure ascending descending sorting can be performed.">  <input type="checkbox" class="ml-2 do-sorting" name="fields[options][sorting_' +
                    iteration + ']" value="sorting" id="sorting_' + iteration + '"> Sort<label>' +
                    '    </div>\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <select name="fields[type][' + iteration + ']" id="fields_type_' +
                    iteration + '" class="form-control select2">\n' +
                    '                <option value="">--Select Field Type--</option>\n' +
                    '<option value="bigIncrements">bigIncrements</option>\n' +
                    '<option value="bigInteger">bigInteger</option>\n' +
                    '<option value="binary">binary</option>\n' +
                    '<option value="boolean">boolean</option>\n' +
                    '<option value="char">char</option>\n' +
                    '<option value="dateTime">dateTime</option>\n' +
                    '<option value="date">date</option>\n' +
                    '<option value="decimal">decimal</option>\n' +
                    '<option value="double">double</option>\n' +
                    '<option value="enum">enum</option>\n' +
                    '<option value="float">float</option>\n' +
                    '<option value="id">id</option>\n' +
                    '<option value="increments">increments</option>\n' +
                    '<option value="integer">integer</option>\n' +
                    '<option value="ipAddress">ipAddress</option>\n' +
                    '<option value="json">json</option>\n' +
                    '<option value="lineString">lineString</option>\n' +
                    '<option value="longText">longText</option>\n' +
                    '<option value="smallIncrements">smallIncrements</option>\n' +
                    '<option value="smallInteger">smallInteger</option>\n' +
                    '<option value="softDeletes">softDeletes</option>\n' +
                    '<option value="string">string</option>\n' +
                    '<option value="text">text</option>\n' +
                    '<option value="time">time</option>\n' +
                    '<option value="timestamp">timestamp</option>\n' +
                    '<option value="timestamps">timestamps</option>\n' +
                    '<option value="tinyInteger">tinyInteger</option>\n' +
                    '<option value="tinyText">tinyText</option>\n' +
                    '<option value="unsignedBigInteger">unsignedBigInteger</option>\n' +
                    '<option value="unsignedDecimal">unsignedDecimal</option>\n' +
                    '<option value="unsignedInteger">unsignedInteger</option>\n' +
                    '<option value="unsignedMediumInteger">unsignedMediumInteger</option>\n' +
                    '<option value="unsignedSmallInteger">unsignedSmallInteger</option>\n' +
                    '<option value="unsignedTinyInteger">unsignedTinyInteger</option>\n' +
                    '<option value="uuid">uuid</option>\n' +
                    '<option value="year">year</option>\n' +

                    '            </select>\n' +
                    '        </div>\n' +
                    '       <label title="To ensure that the field is displayed in the table."> <input type="checkbox" class="ml-2" name="fields[options][showindex_' +
                    iteration + ']" value="showindex" checked id="showindex_' + iteration + '">Index</label>' +
                    '       <label title="To ensure that the field is searchable in the table.">  <input type="checkbox" class="ml-2"  name="fields[options][cansearch_' +
                    iteration + ']" value="cansearch" id="cansearch_' + iteration + '">Search</label>' +
                    '       <label title="To ensure that the record is delete in that table if the reference table record delete.">  <input type="checkbox" class="ml-2"  name="fields[options][cascade_' +
                    iteration + ']" value="cascade" id="cascade_' + iteration +
                    '" disabled>Cascade</label>' +
                    '    </div>\n' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '               <select name="fields[input][' + iteration + ']" id="fields_input_' +
                    iteration + '" class="form-control select2 fields-type">\n' +
                    '<option value="">--Select Input Type--</option>>\n' +
                    '<option value="text">{{ ucfirst('input text') }}</option>>\n' +
                    '<option value="hidden">{{ ucfirst('hidden') }}</option>>\n' +
                    '<option value="date">{{ ucfirst('date') }}</option>>\n' +
                    '<option value="datetime-local">{{ ucfirst('dateTime') }}</option>>\n' +
                    '<option value="decimal">{{ ucfirst('decimal') }}</option>>\n' +
                    '<option value="number">{{ ucfirst('number') }}</option>>\n' +
                    '<option value="email">{{ ucfirst('email') }}</option>>\n' +
                    '<option value="password">{{ ucfirst('password') }}</option>>\n' +
                    '<option value="url">{{ ucfirst('url') }}</option>>\n' +
                    '<option value="file">{{ ucfirst('file') }}</option>>\n' +
                    '<option value="radio">{{ ucfirst('radio') }}</option>>\n' +
                    '<option value="checkbox">{{ ucfirst('checkbox') }}</option>>\n' +
                    '<option value="textarea">{{ ucfirst('textarea') }}</option>>\n' +
                    '<option value="select">{{ ucfirst('select') }}</option>>\n' +
                    '<option value="select_via_table">{{ ucfirst('select via table') }}</option>>\n' +
                    ' </select>\n' +
                    '        </div>\n' +
                    '    <label title="To ensure that the field accepts unique values from the database.">  <input type="checkbox" class="ml-2 do-unique"  name="fields[options][unique_' +
                    iteration + ']" value="unique" id="unique_' + iteration + '"> Unique</label>' +
                    ' <label title="To ensure that multiple values can be entered into the field.">   <input type="checkbox" class="ml-2" name="fields[options][multiple_' +
                    iteration + ']" value="multiple" disabled id="multiple_' + iteration +
                    '"> Multi <small>(files & select)</small></label>' +
                    '    </div>\n' +
                    '<div class="col">\n' +
                    '<div class="form-group d-flex justify-content-around">\n ' +
                    html +
                    ' </div>\n' +
                    '<label title="Your form contains this field in a quarter of a row."><input type="checkbox" class="ml-2 export" name="fields[options][export_' +
                    iteration + ']" value="export" id="export_' + iteration + '"> export</label>' +
                    '<label title="Your form contains this field in a quarter of a row."><input type="checkbox" class="ml-2 import" name="fields[options][import_' +
                    iteration + ']" value="import" id="import_' + iteration + '"> import</label>' +
                    '<label title="Your form contains this field in a quarter of a row."><input type="checkbox" class="ml-2 column" name="fields[column][column_' +
                    iteration + ']" value="col-md-3" id="column_' + iteration + '"> md-3</label>' +

                    ' </div>\n' +
                    '<div class="col">\n' +
                    '<div class="form-group ml-1">\n ' +
                    '            <input type="text" class="form-control" name="fields[comment][' +
                    iteration + ']" placeholder="Comment"/>\n' +
                    ' </div>\n' +
                    '<label title="Your form contains this field in a one-third of a row."><input type="checkbox" class="ml-2 column" name="fields[column][column_' +
                    iteration + ']" value="col-md-4" id="column_md_4_' + iteration + '"> md-4</label>' +
                    '<label title="Your form contains this field in a half of a row."><input type="checkbox" class="ml-2 column" name="fields[column][column_' +
                    iteration + ']" checked value="col-md-6" id="column_md_6_' + iteration +
                    '"> md-6 </label>' +
                    '<label title="Your form contains this field in a full row."><input type="checkbox" class="ml-2 column" name="fields[column][column_' +
                    iteration + ']" value="col-md-12" id="column_md_12_' + iteration + '"> md-12 </label>' +
                    ' </div>\n' +
                    ' <div class="col-12 justify-content-around d-none" id="cascadediv' + iteration + '">' +
                    '<div class="mt-4">Enter Ref Table Name (PhpMyAdmin)</div>' +
                    '<div class="form-group">' +
                    '<input type="text" name="fields[ref_table][' + iteration +
                    ']" class="form-control d-inline-flex" value="" placeholder="Enter table name" value="{{ old('fields') && @old('fields')['ref_table']['+iteration+'] }}">' +
                    ' </div>' +
                    '<div class="mt-4">Enter Ref Column Name</div>' +
                    '<div class="form-group">' +
                    '<input type="text" name="fields[ref_col][' + iteration +
                    ']" class="form-control d-inline-flex" value="id" placeholder="Enter column name" value="{{ old('fields') && @old('fields')['ref_col']['+iteration+'] }}">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label title="On Delete.">' +
                    '<input type="checkbox" class="ml-2 " name="fields[ref_on_delete_' + iteration +
                    ']" value="OnDelete" id="ref_on_delete_' + iteration + '" checked> OnDelete<label>' +
                    ' </div>' +
                    '<div class="form-group">' +
                    '<label title="On update">' +
                    '<input type="checkbox" class="ml-2 " name="fields[ref_on_update_' + iteration +
                    ']" value="OnUpdate" id="ref_on_update_' + iteration + '" checked> OnUpdate<label>' +
                    ' </div>' +
                    ' </div>' +
                    '</li>';
                $('.fields').append(tmp);
                selectRefresh();
                $('#addValidations').click();
                iteration = iteration + 1;
            });
            $(document).on('click', '#addMediaInputBtn', function() {
                let tmp = '<li class="row no-gutters ui-state-default align-items-center field">\n' +
                    ' <span class="btn-accent btn-sm mr-3 hash">#</span>' +
                    '    <div class="col">\n' +
                    '        <div class="form-group mr-1">\n' +
                    '            <input required type="text" class="form-control media_col_name" data-id="' +
                    mediaIteration + '" id="media_col_name' + mediaIteration + '" name="media[name][' +
                    mediaIteration + ']" placeholder="Name" />\n' +
                    ' </div>\n' +
                    '  <label title="To ensure the field is required from both the client and server sides, this is helpful."><input type="checkbox" class="ml-2 do-media-required" name="media[options][required_' +
                    mediaIteration + ']" value="required"  id="media-required_' + mediaIteration +
                    '"> Required</label>' +
                    ' </div>' +
                    '<div class="col">' +
                    '<div class="form-group mr-1">' +
                    '<input type="number" class="form-control" min="1" data-id="' + mediaIteration +
                    '" id="media_name' + mediaIteration + '" name="media[size][' + mediaIteration +
                    ']" placeholder="Size (in MB)" />' +
                    ' </div>' +
                    '      <label title="To ensure that null values are accepted.">  <input type="checkbox" class="ml-2 do-media-nullable" name="media[options][nullable_' +
                    mediaIteration + ']" value="nullable" checked id="media-nullable_' + mediaIteration +
                    '"> Null</label>' +
                    '      <label title="To ensure ascending descending sorting can be performed.">  <input type="checkbox" class="ml-2 do-sorting" name="media[options][multiple_' +
                    mediaIteration + ']" value="multiple" id="media-multiple_' + mediaIteration +
                    '"> Multi<label>' +
                    '    </div>\n' +
                    ' </div>' +
                    '<div class="col">' +
                    '<div class="form-group mr-1">' +
                    ' <label title="Your form contains this field in a full row.">' +
                    '<input type="radio" class=" ml-2" min="1" max="12" data-id="' +
                    mediaIteration + '" id="media_col' + mediaIteration + '" name="media[col][' +
                    mediaIteration + ']" placeholder="Enter col-md" value="3" />' +
                    ' md-3<label>' +
                    ' <label title="Your form contains this field in a full row.">' +
                    '<input type="radio" class=" ml-2" min="1" max="12" data-id="' +
                    mediaIteration + '" id="media_col' + mediaIteration + '" name="media[col][' +
                    mediaIteration + ']" placeholder="Enter col-md"  value="4" />' +
                    ' md-4<label>' +
                    ' <label title="Your form contains this field in a full row.">' +
                    '<input type="radio" class=" ml-2" min="1" max="12" data-id="' +
                    mediaIteration + '" id="media_col' + mediaIteration + '" name="media[col][' +
                    mediaIteration + ']" placeholder="Enter col-md" checked value="6" />' +
                    ' md-6<label>' +
                    ' <label title="Your form contains this field in a full row.">' +
                    '<input type="radio" class=" ml-2" min="1" max="12" data-id="' +
                    mediaIteration + '" id="media_col' + mediaIteration + '" name="media[col][' +
                    mediaIteration + ']" placeholder="Enter col-md" value="12" />' +
                    ' md-12<label>' +
                    ' </div>';
                $('.mediaInputs').append(tmp);
                mediaIteration++;
            });

            $(document).on('click', '#removeFieldsBtn', function() {
                if (iteration > 1) {
                    iteration = iteration - 1;
                    $('.fields').children('.row').last().remove();
                    $('.validations').children('.row').last().remove();
                }
            });
            $(document).on('click', '#removeValidations', function() {
                if (validationIteration > 1) {
                    $('.validations').children('.row').last().remove();
                    // Decrement iteration
                    validationIteration--;
                }
            });
            $(document).on('click', '#removeMediaInputBtn', function() {
                if (mediaIteration > 1) {
                    $('.mediaInputs').children('.row').last().remove();
                    // Decrement iteration
                    mediaIteration--;
                }
            });
            $(document).on('click', '#removeMediaInputBtn', function() {
                if (mediaIteration > 1) {
                    iteration = mediaIteration - 1;
                    $('.mediaInputs').children('.row').last().remove();
                    // $('.validations').children('.row').last().remove();
                }
            });

            function selectRefresh() {
                $('.select2').select2({
                    //-^^^^^^^^--- update here
                    tags: true,
                    placeholder: "Select an Option",
                    allowClear: true,
                    width: '100%'
                });
            }
            $('.deleteForeignKey').each(function() {
                let _this = $(this);
                $(this).on('click', function() {
                    _this.parent().parent().parent().fadeOut();
                })
            })

            function convertWord(word) {
                var replacedSpaces = word.replace(/ /g, '');
                var replacedDashes = replacedSpaces.replace(/-/g, ' ');
                var ucwords = replacedDashes.replace(/(^|\s)\S/g, function(t) {
                    return t.toUpperCase();
                });
                ucwords = ucwords.replace(/ /g, '');
                return ucwords;
            }
            $(document).on('input', '#view_path', function() {
                $('#view_path_preview').html('panel/'+$(this).val() + '/');
                $('#controller-namespace').val(convertWord($(this).val()));
            })

            $(document).on('input', '#name', function() {
                if ($(this).val().length <= 0) {
                    $('#crud_name').html('crud_name');
                } else {
                    $('#crud_name').html($(this).val().toLowerCase());
                }
            })
            $(document).on('change', '.table', function() {
                let col_id = $(this).parent().parent().siblings().children().find('.col_name').data('id');
                let value = $(this).val();
                if (value == "Category")
                    $(this).closest('.field').find('[name="fields[comment][0]"]').attr('placeholder',
                        'Enter Category Type Name');
                else
                    $(this).closest('.field').find('[name="fields[comment][0]"]').attr('placeholder',
                        'Comment');
            });
            $(document).on('change', '.fields-type', function() {
                let col_id = $(this).parent().parent().siblings().children().find('.col_name').data('id');
                let col_value = $(this).parent().parent().siblings().children().find('.col_name').val();
                let target = $(this).parent().parent().siblings().children().find('textarea');
                let target1 = $(this).parent().parent().siblings().children().find('.table');
                console.log(target);
                console.log(target1);
                if ($(this).val() === 'select_via_table') {
                    inputval = 2;
                    target.addClass('d-none').addClass('disabled').css('opacity', '0');
                    target1.addClass('select2').removeClass('d-none');
                } else {
                    target1.removeClass('select2').addClass('d-none').siblings('.select2').remove();
                    target.removeClass('d-none').removeClass('disabled').css('opacity', '1');
                }
                target.val('');
                $(this).parent().parent().find('[value="multiple"]').attr('disabled', true);
                if ($(this).val() == "hidden" && $('[name="fields[type][' + col_id + ']"]').val() !=
                    'json') {
                    target.val(col_value);
                } else if ($(this).val() == "date" || $(this).val() == "datetime-local") {
                    target.val('now()');
                } else if ($(this).val() == "checkbox" || $(this).val() == "radio") {
                    target.val('1');
                } else if ($(this).val() == "select" || $(this).val() == "select_via_table" || $(this)
                    .val() == "file") {
                    $(this).parent().parent().find('[value="multiple"]').attr('disabled', false);
                }
                selectRefresh();
            })

            $(document).ready(function() {
                $('.select2').each(function() {
                    $(this).select2()
                });
            });

            $(document).on('input', '.first-upper', function(e) {
                firstUpper(e);
            })
            $(document).on('focusout', '.model_name', function(e) {
                singularize(e);
                let str = e.target.value;
                // s = str.replace(/([a-z])([A-Z])/g, '$1_$2');
                // $('.crud_name').val(s.toLowerCase());
                // $('.crud_name').focus();
                s = str.replace(/([A-Z])/g, '_$1');
                str = s.toLowerCase().substring(1);
                console.log(pluralized(str));
                $('.crud_name').val(pluralized(str));
                $('.crud_name').focus();
            })
            $(document).on('keyup', '.col_name, .media_col_name', function(e) {
                // console.log(e.which);
                let col_id = $(this).data('id');
                text = allLower(e);
                text = text.replace(/ /g, '_').replace(/-/g, '').replace(/[^\w-]+/g, '');
                if (e.which == 32 || e.which == 45) {
                    console.log('Space or hypen Detected');
                    return false;
                }
                $(this).val(text);
                //     if($(this).hasClass('col_name'))
                //    $('#validation'+col_id).val(text);
            });
            $(document).on('change', '.col_name, .media_col_name', function(e) {
                // console.log(e.which);
                let col_id = $(this).data('id');
                let $this = $(this);
                text = allLower(e);
                let count = 0;
                let firstInputValue = $(this).val();
                const autofillMap = {
                    'img': 10,
                    'image': 10,
                    'photo': 10,
                    'banner': 10,
                    'file': 25,
                    'doc': 25,
                    'attachment': 25
                };
                $('.col_name').each(function() {
                    if ($(this).val() == text && col_id != $(this).data('id')) {
                        count++;
                    }
                })
                if (count != 0) {
                    $(this).val('');
                    alert('Please enter unique column names.');
                }
                if (e.which == 32 || e.which == 45) {
                    console.log('Space or hypen Detected');
                    return false;
                }
                if ($this.hasClass('col_name')) {
                    autoSelect(text, $(this));
                    $('#validation' + col_id).val(text);
                }
                if (firstInputValue in autofillMap) {
                    $('#media_name'+ col_id).val(autofillMap[firstInputValue]);
                } else {
                    $('#media_name'+ col_id).val('');
                }
            });
            $(document).on('change', '.col_name', function(e) {
                let col_id = $(this).data('id');
                let $this = $(this);
                let name_value = $(this).val();
                const autofillMap = {
                    'name': 'string',
                    'email': 'email',
                    'number': 'numeric',
                    'id': 'integer',
                    'phone': 'numeric_phone_length:10,15',
                };
                if (name_value.endsWith('_id')) {
                    $('#rule' + col_id).val($('#rule' + col_id).val() + '|integer');
                }
                if (name_value in autofillMap) {
                    var result = autofillMap[name_value];
                    $('#rule' + col_id).val($('#rule' + col_id).val() + '|' + result) ;
                }
            });
            $(document).on('change', '.Options', function(e) {
                let opt_id = $(this).data('id');
                if ($(this).val() != 1) {
                    $('#rule' + opt_id).val('sometimes');
                } else {
                    $('#rule' + opt_id).val('required');
                }
            });
            $(document).on('click', '.do-required', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('#rule' + opt_id).val('required');
                    $('#nullable_' + opt_id).prop('checked', false);
                } else {
                    $('#rule' + opt_id).val('nullable');
                }
            });
            $(document).on('click', '.do-nullable', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('#rule' + opt_id).val('nullable');
                    $('#required_' + opt_id).prop('checked', false);
                    } else {
                        $('#rule' + opt_id).val('required');
                    }
            });
            $(document).on('click', '.do-media-required', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('#media-nullable_' + opt_id).prop('checked', false);
                }
            });
            $(document).on('click', '.do-media-nullable', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('#media-required_' + opt_id).prop('checked', false);
                }
            });
            $(document).on('click', '.column', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('[id="column_' + opt_id + '"]').prop('checked', false);
                    $(this).prop('checked', true);
                } else {
                    $('[id="column_' + opt_id + '"] [value="col-md-6"]').prop('checked', true);
                }
            });
            $(document).on('click', '.do-unique', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];

                if ($(this).prop('checked')) {
                    if ($('[name="fields[default][' + opt_id + ']"]').val() != '' || $('[name="fields[type][' +
                        opt_id + ']"]').val() == 'enum' || $('[name="fields[type][' + opt_id + ']"]')
                        .val() == 'boolean') {
                        $(this).prop('checked', false);
                        alert('unique is only possible when data type is not boolean/enum and no default value provided!');
                    }

                    $('#rule' + opt_id).val($('#rule' + opt_id).val() + '|unique:' + $('.crud_name').val() +
                        ',' + $('#col_name' + opt_id).val());
                } else {
                    $('#rule' + opt_id).val('');
                }
            });

            $(document).on('change', 'input[value="cascade"]', function(e) {
                let id = $(this).attr('id');
                let opt_id = id.split('_')[1];
                if ($(this).prop('checked')) {
                    $('#cascadediv' + opt_id).removeClass('d-none');
                    $('#cascadediv' + opt_id).addClass('d-md-flex');
                } else {
                    $('#cascadediv' + opt_id).removeClass('d-md-flex');
                    $('#cascadediv' + opt_id).addClass('d-none');
                }
            });

            $(document).on('input', '.lower', function(e) {
                allLower(e);
            })
            $(document).on('focusout', '.crud_name', function(e) {
                let element = e.target.value;
                if (element[element.length - 1] != "s") {
                    e.target.value = pluralize(0, e.target.value);
                }
            })

            function singularize(event) {
                word = event.target.value;
                const endings = {
                    ves: 'fe',
                    ies: 'y',
                    i: 'us',
                    zes: '',
                    ses: '',
                    es: '',
                    s: ''
                };
                event.target.value = word.replace(
                    new RegExp(`(${Object.keys(endings).join('|')})$`),
                    r => endings[r]
                );
            }
            const pluralize = (val, word, plural = word + 's') => {
                const _pluralize = (num, word, plural = word + 's') => [1, -1].includes(Number(num)) ? word :
                    plural;
                if (typeof val === 'object') return (num, word) => _pluralize(num, word, val[word]);
                return _pluralize(val, word, plural);
            };

            function firstUpper(event) {
                let words = event.target.value.split(/\s+/g);
                let newWords = words.map(function(element) {
                    return element !== "" ? element[0].toUpperCase() + element.substr(1, element.length) :
                        "";
                });
                event.target.value = newWords.join("");
            }

            function allLower(event) {
                let words = event.target.value.toLowerCase().split(/\s+/g);

                event.target.value = words.join("");
                return event.target.value;
            }

            function slugFunction() {
                let x = document.getElementById("slugInput").value;
                document.getElementById("slugOutput").innerHTML = "{{ url('/page/') }}/" + convertToSlug(x);
            }

            function convertToSlug(Text) {
                return Text
                    .toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '');
            }

        });


        $('.magicValidation').click(function() {
            $(document).on('each', '.validation', function(e) {
                let text = $(this).find('validations[field][]').val();
                let rules = $(this).find('validations[rules][]').val();
                if (rules != '') {
                    rules = rules + '|';
                }
            });
        });

        // window.onbeforeunload = function() {
        //     return confirm("Are you sure you want to refresh?");
        // }



        document.getElementById("checkAll").addEventListener("change", function(event) {
            var exportCheckboxes = document.querySelectorAll('.export');
            var importCheckboxes = document.querySelectorAll('.import');
            var allCheckboxes = document.querySelectorAll('.export, .import');
            allCheckboxes.forEach(function(checkbox) {
                checkbox.checked = event.target.checked;
            });
        });


    </script>
@endpush
