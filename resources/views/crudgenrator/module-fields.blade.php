<!-- Large modal -->

<div class="modal fade" id="createModule" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Field Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Input Type</label>
                            <select name="field_type" id="type" class="form-control custom-select select2">
                                <optgroup label="Text Fields">
                                    <option @if (old('fields') && old('fields')['input'][0] == 'text') selected @endif value="text">
                                        {{ ucfirst('text') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'hidden') selected @endif value="hidden">
                                        {{ ucfirst('hidden') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'email') selected @endif value="email">
                                        {{ ucfirst('email') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'password') selected @endif value="password">
                                        {{ ucfirst('password') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'url') selected @endif value="url">
                                        {{ ucfirst('url') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'textarea') selected @endif value="textarea">
                                        {{ ucfirst('textarea') }}</option>
                                </optgroup>
                                <optgroup label="Choice Fields">
                                    <option @if (old('fields') && old('fields')['input'][0] == 'radio') selected @endif value="radio">
                                        {{ ucfirst('radio') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'checkbox') selected @endif value="checkbox">
                                        {{ ucfirst('checkbox') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'select') selected @endif value="select">
                                        {{ ucfirst('select') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'select_via_table') selected @endif value="select_via_table">
                                        {{ ucfirst('select Via Table') }}</option>
                                </optgroup>
                                <optgroup label="Number Fields">
                                    <option @if (old('fields') && old('fields')['input'][0] == 'decimal') selected @endif value="decimal">
                                        {{ ucfirst('decimal ') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'number') selected @endif value="number">
                                        {{ ucfirst('number') }}</option>
                                </optgroup>
                                <optgroup label="Date/Time Fields">
                                    <option @if (old('fields') && old('fields')['input'][0] == 'date') selected @endif value="date">
                                        {{ ucfirst('date') }}</option>
                                    <option @if (old('fields') && old('fields')['input'][0] == 'datetime-local') selected @endif value="datetime-local">
                                        {{ ucfirst('dateTime') }}</option>
                                </optgroup>
                                <optgroup label="File Upload Fields">
                                    <option @if (old('fields') && old('fields')['input'][0] == 'file') selected @endif value="file">
                                        {{ ucfirst('file') }}</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Data Type</label>
                            <select name="data_type" id="datatype" class="form-control custom-select select2">
                                <optgroup label="Text Fields">
                                    <option @if (old('fields') && old('fields')['type'] == 'char') selected @endif value="char">char
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'mediumText') selected @endif value="mediumText">
                                        mediumText</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'string') selected @endif value="string">string
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'text') selected @endif value="text">text
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'longText') selected @endif value="longText">
                                        longText</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'lineString') selected @endif value="lineString">
                                        lineString</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'ipAddress') selected @endif value="ipAddress">
                                        ipAddress</option>
                                </optgroup>
                                <optgroup label="Number Fields">
                                    <option @if (old('fields') && old('fields')['type'] == 'bigIncrements') selected @endif value="bigIncrements">
                                        bigIncrements</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'bigInteger') selected @endif value="bigInteger">
                                        bigInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'binary') selected @endif value="binary">binary
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'decimal') selected @endif value="decimal">decimal
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'double') selected @endif value="double">double
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'enum') selected @endif value="enum">enum
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'float') selected @endif value="float">float
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'mediumIncrements') selected @endif
                                        value="mediumIncrements">mediumIncrements</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'mediumInteger') selected @endif value="mediumInteger">
                                        mediumInteger</option>

                                    <option @if (old('fields') && old('fields')['type'] == 'smallInteger') selected @endif value="smallInteger">
                                        smallInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedBigInteger') selected @endif
                                        value="unsignedBigInteger">unsignedBigInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedDecimal') selected @endif value="unsignedDecimal">
                                        unsignedDecimal</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedInteger') selected @endif value="unsignedInteger">
                                        unsignedInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedMediumInteger') selected @endif
                                        value="unsignedMediumInteger">unsignedMediumInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedSmallInteger') selected @endif
                                        value="unsignedSmallInteger">unsignedSmallInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'unsignedTinyInteger') selected @endif
                                        value="unsignedTinyInteger">unsignedTinyInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'geometryCollection') selected @endif
                                        value="geometryCollection">geometryCollection</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'geometry') selected @endif value="geometry">
                                        geometry</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'uuid') selected @endif value="uuid">uuid
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'id') selected @endif value="id">id
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'increments') selected @endif value="increments">
                                        increments</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'integer') selected @endif value="integer">integer
                                    </option>
                                </optgroup>
                                <optgroup label="Choice Fields">
                                    <option @if (old('fields') && old('fields')['type'] == 'boolean') selected @endif value="boolean">boolean
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'tinyInteger') selected @endif value="tinyInteger">
                                        tinyInteger</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'tinyText') selected @endif value="tinyText">
                                        tinyText</option>
                                </optgroup>
                                <optgroup label="Date/Time Fields">
                                    <option @if (old('fields') && old('fields')['type'] == 'json') selected @endif value="json">json
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'dateTime') selected @endif value="dateTime">
                                        dateTime</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'date') selected @endif value="date">date
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'time') selected @endif value="time">time
                                    </option>
                                    <option @if (old('fields') && old('fields')['type'] == 'timestamp') selected @endif value="timestamp">
                                        timestamp</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'timestamps') selected @endif value="timestamps">
                                        timestamps</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'softDeletes') selected @endif value="softDeletes">
                                        softDeletes</option>
                                    <option @if (old('fields') && old('fields')['type'] == 'year') selected @endif value="year">year
                                    </option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Database column</label>
                            <input required type="text" class="form-control col_name"
                                value="{{ old('fields') && old('fields')['name'][0] ? old('fields')['name'][0] : '' }}"
                                data-id="0" id="col_name0" name="fields[name][0]" placeholder="Name" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Label</label>
                            <input type="text" class="form-control label_name" name="visual_title"
                                placeholder="Visual title">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="form-group">
                            <label for="">Tooltip text (will be visible below the input)</label>
                            <input type="text" class="form-control" name="visual_title"
                                placeholder="Tooltip text">
                        </div>
                        <div class="form-group table-div d-none">
                            <label for="">Select Table</label>
                            <select name="table" class="form-control table" id="table">
                                @foreach ($tmpFiles as $temp)
                                    <option @if (old('fields') && old('fields')['table'][0] == $temp['filename']) selected @endif
                                        value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group table-div d-none">
                            <label for="">Enter Table column name</label>
                            <input type="text" name="table_column" class="form-control table" value="name">
                        </div>
                        <div class="form-group table-div d-none">
                            <label for="">Enter Table column name</label>
                            <input type="text" name="table_column" class="form-control table" value="name">
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="">Options:</label>
                            <div class="">
                                <strong>Forms:</strong>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2"
                                        {{ old('fields') && @old('fields')['options']['showindex'] ? 'checked' : '' }}
                                        name="fields[options][showindex]" value="showindex" id="showindex"><span
                                        class="checkbox-label">In list</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2"
                                        {{ old('fields') && @old('fields')['options']['showcreate'] ? 'checked' : '' }}
                                        name="fields[options][showcreate]" value="showcreate" id="showcreate"><span
                                        class="checkbox-label">In create</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2"
                                        {{ old('fields') && @old('fields')['options']['showedit'] ? 'checked' : '' }}
                                        name="fields[options][showedit]" value="showedit" id="showedit"><span
                                        class="checkbox-label">In edit</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2"
                                        {{ old('fields') && @old('fields')['options']['showdetail'] ? 'checked' : '' }}
                                        name="fields[options][showdetail]" value="showdetail" id="showdetail"><span
                                        class="checkbox-label">In show</span>
                                </label>
                                <br> <strong>Addons:</strong>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-sorting"
                                        {{ old('fields') && @old('fields')['options']['sorting'] ? 'checked' : '' }}
                                        name="fields[options][sorting]" value="sorting" id="sorting"><span
                                        class="checkbox-label"> sortable</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-multi-action"
                                        {{ old('fields') && @old('fields')['options']['multi-action'] ? 'checked' : '' }}
                                        name="fields[options][multi-action]" value="multi-action" id="multi-action">
                                    <span class="checkbox-label"> multi-action</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-export"
                                        {{ old('fields') && @old('fields')['options']['export'] ? 'checked' : '' }}
                                        name="fields[options][export]" value="export" id="export"><span
                                        class="checkbox-label"> export</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-import"
                                        {{ old('fields') && @old('fields')['options']['import'] ? 'checked' : '' }}
                                        name="fields[options][import]" value="import" id="import"> <span
                                        class="checkbox-label">import</span>
                                </label>

                                <br> <strong>Validations:</strong>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-required"
                                        {{ old('fields') && @old('fields')['options']['required'] ? 'checked' : '' }}
                                        name="fields[options][required]" value="required" id="required"><span
                                        class="checkbox-label">Required</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-nullable"
                                        {{ old('fields') && @old('fields')['options']['nullable'] ? 'checked' : '' }}
                                        name="fields[options][nullable]" value="nullable" id="nullable"><span
                                        class="checkbox-label"> Nullable</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="checkbox" class="ml-2 do-unique"
                                        {{ old('fields') && @old('fields')['options']['unique'] ? 'checked' : '' }}
                                        name="fields[options][unique]" value="unique" id="unique"> <span
                                        class="checkbox-label">Unique</span>
                                </label>
                                <br> <strong>Fields:</strong>
                                <input type="checkbox" class="ml-2"
                                    {{ old('fields') && @old('fields')['options']['richtext'] ? 'checked' : '' }}
                                    name="fields[options][richtext]" value="richtext" id="richtext"><span
                                    class="checkbox-label"> Richtext Editor</span></label>
                                <input type="checkbox" class="ml-2"
                                    {{ old('fields') && @old('fields')['options']['multiple'] ? 'checked' : '' }}
                                    name="fields[options][multiple]" value="multiple" id="multiple"><span
                                    class="checkbox-label"> multiple</span></label>
                                <input type="checkbox" class="ml-2"
                                    {{ old('fields') && @old('fields')['options']['cascade'] ? 'checked' : '' }}
                                    name="fields[options][cascade]" value="cascade" id="cascade"><span
                                    class="checkbox-label"> cascade</span></label>
                            </div>
                        </div>
                    </div>


                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <h6>Card & Columns:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Select Direction</label>
                                    <select name="direction" class="form-control" id="direction">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Select Group</label>
                                    <select name="field_group" class="form-control" id="field_group">
                                        <option value="1">1</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between mb-2">
                            <h6>Add Columns:</h6>
                            <div class="btn btn-primary add-col"> Add</div>
                        </div>
                        <div class="cols">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text"
                                        id="basic-addon1">col-</span></div>
                                <input type="text" class="form-control" name="col_name" placeholder="col-"
                                    value="md" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <input type="number" class="form-control" name="col_value" value="6"
                                        aria-describedby="basic-addon1">
                                    <button type="button" class="btn btn-danger remove-col"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="">
                    <h5>Extra options</h5>
                    <div class="row ">
                        <div class="col-lg-4 col-md-4 text-div float-div">
                            <div class="form-group">
                                <label for="">Min length</label>
                                <input type="text" class="form-control" name="min_length"
                                    placeholder="Min length">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 text-div float-div">
                            <div class="form-group">
                                <label for="">Max length</label>
                                <input type="text" class="form-control" name="max_length"
                                    placeholder="Max length">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 text-div float-div">
                            <div class="form-group">
                                <label for="">Float accuracy</label>
                                <input type="number" class="form-control" name="decimal_value"
                                    placeholder="Max length">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 file-div ">
                            <div class="form-group">
                                <label for="">Max File Size</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="file_size" value="2"
                                        aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 img-div">
                            <div class="form-group">
                                <label for="">Max Width <small>(not for validation)</small></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="img-width" value="2"
                                        aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">in px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 img-div">
                            <div class="form-group">
                                <label for="">Max height <small>(not for validation)</small></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="img-height" value="2"
                                        aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">in px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 choice-div">
                            <table class="table table-field-choices">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" width="45%">Database Value</th>
                                        <th scope="col" class="enum-hide" width="45%">Label text</th>
                                        <th scope="col" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody class="choices">
                                    <tr>
                                        <td><input type="text" class="form-control" name="choice_key"
                                                required=""></td>
                                        <td><input type="text" class="form-control enum-hide" name="choice_value"
                                                required=""></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-choice"
                                                disabled=""><i class="fas fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-right"><button type="button" class="btn btn-info add-choice"><i
                                        class="fas fa-plus"></i> Add new key/value set</button></div>
                        </div>
                        <div class="col-lg-4 col-md-4 default-div">
                            <div class="form-group">
                                <label for="">Default value</label>
                                <input type="text" class="form-control default-value" name="default_value"
                                    placeholder="Default value">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 select-via-table-div">
                            <div class="form-group">
                                <label for="">Column Value</label>
                                <input type="text" class="form-control default-value" name="table_col_name"
                                    placeholder="Default value">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 select-via-table-div cascade-div">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="">Enter Ref Table Name (PhpMyAdmin)</div>
                                    <div class="form-group">
                                        <input type="text" name="fields[ref_table]"
                                            class="form-control d-inline-flex" placeholder="Enter table name"
                                            value="{{ old('fields') && @old('fields')['ref_table'] }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="">Enter Ref Column Name</div>
                                    <div class="form-group">
                                        <input type="text" name="fields[ref_col]"
                                            class="form-control d-inline-flex" placeholder="Enter column name"
                                            value="{{ old('fields') && @old('fields')['ref_col'] }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-3 mb-0">
                                        <label title="On Delete.">
                                            <input type="checkbox" class="ml-2 "
                                                {{ old('fields') && @old('fields')['ref_on_delete'] == 'OnDelete' ? 'checked' : '' }}
                                                name="fields[ref_on_delete_]" value="OnDelete" id="ref_on_delete_"
                                                checked> OnDelete<label>
                                                <label title="On update">
                                                    <input type="checkbox" class="ml-2 "
                                                        {{ old('fields') && @old('fields')['ref_on_update'] == 'OnUpdate' ? 'checked' : '' }}
                                                        name="fields[ref_on_update_]" value="OnUpdate"
                                                        id="ref_on_update_"> OnUpdate<label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
