@extends('crudgenrator.layouts.master')

@section('title', 'Bulk Import')

{{-- Push Styles --}}
@push('scopedCss')
    <style>
        .input {
            background: rgba(0, 0, 0, 0.3) !important;
            color: #ffc25c;
            border-color: rgba(0, 0, 0, 0.5);
            padding: 0.5rem 0.75rem !important;
            height: 37.5px;
            font-size: 0.9rem;
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

    <div class="container py-3 ">
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
        <form action="{{ route('crudgen.bulkimport.generate') }}" method="POST" class="repeater" id="crudgen_form"
            enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    {{-- Name --}}
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Bulk Import Details</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Select Model <span
                                                class="text-danger">*</span></label>
                                        <select required name="model" class="form-control select2" id="model">
                                            <option value="" readonly>Select</option>
                                            <option value="User">User</option>
                                            @foreach ($tmpFiles as $temp)
                                                <option value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Select Parent Model</label>
                                      <select name="parent_model" class="form-control select2" id="parent_model">
                                        <option value="" readonly>Select</option>
                                        <option value="User">User</option>
                                            @foreach ($tmpFiles as $temp)
                                                <option value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              </div>
                              <div class="col-12 col-md-3">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Enter Parent Model Value</label>
                                      <input type="text" name="parent_value" class="form-control" id="">
                                  </div>
                              </div> --}}
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Enter Excel File</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            accept=".xls,.xlsx">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Fields (Required)</span>
                        </div>
                        <div class="card-body fields">
                        </div>
                    </div>

                    {{-- Fields --}}
                    {{-- <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Fields (Required)</span>
                            <button class="btn btn-accent btn-sm btn-add" type="button" id="addFieldsBtn">+</button>
                        </div>
                        <div class="card-body fields">
                            <div class="row mb-2">
                                <div class="col">
                                    Name
                                </div>
                                <div class="col">
                                   Data Type (Column)
                                </div>
                                <div class="col">
                                    Input Type (Field)
                                </div>
                                <div class="col">
                                   Options
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center field">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input required type="text" class="form-control col_name" data-id="0" id="col_name0" name="fields[name][]" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[type][]" class="form-control select2">
                                            <option value="">--Select Field Type--</option>
                                            <option value="bigIncrements">bigIncrements</option>
                                            <option value="bigInteger">bigInteger</option>
                                            <option value="binary">binary</option>
                                            <option value="boolean">boolean</option>
                                            <option value="char">char</option>
                                            <option value="dateTimeTz">dateTimeTz</option>
                                            <option value="dateTime">dateTime</option>
                                            <option value="date">date</option>
                                            <option value="decimal">decimal</option>
                                            <option value="double">double</option>
                                            <option value="enum">enum</option>
                                            <option value="float">float</option>
                                            <option value="foreignId">foreignId</option>
                                            <option value="geometryCollection">geometryCollection</option>
                                            <option value="geometry">geometry</option>
                                            <option value="id">id</option>
                                            <option value="increments">increments</option>
                                            <option value="integer">integer</option>
                                            <option value="ipAddress">ipAddress</option>
                                            <option value="json">json</option>
                                            <option value="jsonb">jsonb</option>
                                            <option value="lineString">lineString</option>
                                            <option value="longText">longText</option>
                                            <option value="macAddress">macAddress</option>
                                            <option value="mediumIncrements">mediumIncrements</option>
                                            <option value="mediumInteger">mediumInteger</option>
                                            <option value="mediumText">mediumText</option>
                                            <option value="morphs">morphs</option>
                                            <option value="multiLineString">multiLineString</option>
                                            <option value="multiPoint">multiPoint</option>
                                            <option value="multiPolygon">multiPolygon</option>
                                            <option value="nullableMorphs">nullableMorphs</option>
                                            <option value="nullableTimestamps">nullableTimestamps</option>
                                            <option value="nullableUuidMorphs">nullableUuidMorphs</option>
                                            <option value="point">point</option>
                                            <option value="polygon">polygon</option>
                                            <option value="rememberToken">rememberToken</option>
                                            <option value="set">set</option>
                                            <option value="smallIncrements">smallIncrements</option>
                                            <option value="smallInteger">smallInteger</option>
                                            <option value="softDeletesTz">softDeletesTz</option>
                                            <option value="softDeletes">softDeletes</option>
                                            <option value="string">string</option>
                                            <option value="text">text</option>
                                            <option value="timeTz">timeTz</option>
                                            <option value="time">time</option>
                                            <option value="timestampTz">timestampTz</option>
                                            <option value="timestamp">timestamp</option>
                                            <option value="timestampsTz">timestampsTz</option>
                                            <option value="timestamps">timestamps</option>
                                            <option value="tinyIncrements">tinyIncrements</option>
                                            <option value="tinyInteger">tinyInteger</option>
                                            <option value="tinyText">tinyText</option>
                                            <option value="unsignedBigInteger">unsignedBigInteger</option>
                                            <option value="unsignedDecimal">unsignedDecimal</option>
                                            <option value="unsignedInteger">unsignedInteger</option>
                                            <option value="unsignedMediumInteger">unsignedMediumInteger</option>
                                            <option value="unsignedSmallInteger">unsignedSmallInteger</option>
                                            <option value="unsignedTinyInteger">unsignedTinyInteger</option>
                                            <option value="uuidMorphs">uuidMorphs</option>
                                            <option value="uuid">uuid</option>
                                            <option value="year">year</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[input][]" class="form-control select2 fields-type">
                                            <option value="">--Select Input Type--</option>
                                            <option value="text">{{ ucfirst('text') }}</option>
                                            <option value="hidden">{{ ucfirst('hidden') }}</option>
                                            <option value="date">{{ ucfirst('date') }}</option>
                                            <option value="datetime-local">{{ ucfirst("dateTime") }}</option>
                                            <option value="decimal">{{ ucfirst("decimal ") }}</option>
                                            <option value="number">{{ ucfirst('number') }}</option>
                                            <option value="email">{{ ucfirst('email') }}</option>
                                            <option value="password">{{ ucfirst('password') }}</option>
                                            <option value="url">{{ ucfirst('url') }}</option>
                                            <option value="file">{{ ucfirst('file') }}</option>
                                            <option value="radio">{{ ucfirst('radio') }}</option>
                                            <option value="checkbox">{{ ucfirst('checkbox') }}</option>
                                            <option value="textarea">{{ ucfirst('textarea') }}</option>
                                            <option value="select">{{ ucfirst('select') }}</option>
                                            <option value="select_via_table">{{ ucfirst('select Via Table') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group d-flex justify-content-around">
                                        <select name="fields[default][]" data-id="0" id="fields0" class="form-control Options">
                                            <option value="1">Required</option>
                                            <option value="2">Nullable</option>
                                            <option value="3">Default 0</option>
                                            <option value="4">Default 1</option>
                                        </select>
                                        <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>
                                        <select name="fields[table][]" class="form-control table d-none">
                                            <option value="User">User</option>
                                            @foreach ($tmpFiles as $temp)
                                                <option value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>

            </div>
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-accent text-grey-800">Generate</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



@endsection

{{-- Push Scripts --}}
@push('scopedJs')
    <script>
        $(document).ready(function() {
            $('#model').change(function() {
                var model = $(this).val();
                if (model == '') {
                    alert('Please select a Model First!');
                    return false;
                }
                $.ajax({
                    url: "{{ route('crudgen.getcol') }}",
                    method: "get",
                    data: {
                        model: model
                    },
                    success: function(res) {
                        console.log(res);
                        $('.fields').html(res.html);
                        return res;
                    }
                })
            });
        });
    </script>
@endpush
