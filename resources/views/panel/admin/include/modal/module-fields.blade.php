<!-- Large modal -->

<div class="modal fade" id="createModule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
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
                            <label for="">Type</label>
                            <select name="field_type" id="type" class="form-control custom-select">
                                <optgroup label="Text Fields">
                                    <option value="text">Text</option>
                                    <option value="email">Email</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="password">Password</option>
                                </optgroup>
                                <optgroup label="Choice Fields">
                                    <option value="radio">Radio</option>
                                    <option value="select">Select</option>
                                    <option value="checkbox">Checkbox</option>
                                </optgroup>
                                <optgroup label="Number Fields">
                                    <option value="number">Integer</option>
                                    <option value="float">Float</option>
                                    <option value="money">Money</option>
                                </optgroup>
                                <optgroup label="Date/Time Fields">
                                    <option value="date">Date Picker</option>
                                    <option value="datetime">Date/Time Picker</option>
                                    <option value="time">Time Picker</option>
                                </optgroup>
                                <optgroup label="File Upload Fields">
                                    <option value="file">File</option>
                                    <option value="photo">Photo</option>
                                </optgroup>
                                <optgroup label="Relationship Fields">
                                    <option value="belongsToRelationship">BelongsTo Relationship</option>
                                    <option value="belongsToManyRelationship">BelongsToMany Relationship</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Label</label>
                            <input type="text" pattern="[a-zA-Z]+.*"
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                class="form-control" name="visual_title" placeholder="Visual title">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Database column</label>
                            <input type="text" pattern="[a-zA-Z]+.*"
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                class="form-control" name="visual_title" placeholder="Database column">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="">Validation Options</label>
                            <select class="form-control custom-select" name="field_validation">
                                <option value="optional">Optional</option>
                                <option value="required">Required</option>
                                <option value="required_unique">Required | Unique</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Tooltip text (will be visible below the input)</label>
                            <input type="text" pattern="[a-zA-Z]+.*"
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                title="Please enter first letter alphabet and at least one alphabet character is required."
                                class="form-control" name="visual_title" placeholder="Tooltip text">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="">Options</label>
                            <div class="">
                                <label class="form-check-label">
                                    <input name="in_list" type="checkbox" checked=""><span class="checkbox-label">In
                                        list</span>
                                </label>
                                <label class="form-check-label">
                                    <input name="in_create" type="checkbox" checked=""><span
                                        class="checkbox-label">In create</span>
                                </label>
                                <label class="form-check-label">
                                    <input name="in_edit" type="checkbox" checked=""><span
                                        class="checkbox-label">In edit</span>
                                </label>
                                <label class="form-check-label">
                                    <input name="in_show" type="checkbox" checked=""><span
                                        class="checkbox-label">In show</span>
                                </label>
                                <label class="form-check-label">
                                    <input name="in_sortable" type="checkbox" checked=""><span
                                        class="checkbox-label">Is sortable</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="">
                    <h5>Extra options</h5>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="">Min length</label>
                                <input type="text" class="form-control" name="min_length"
                                    placeholder="Min length">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="">Max length</label>
                                <input type="text" class="form-control" name="max_length"
                                    placeholder="Max length">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="">Default value</label>
                                <input type="text" class="form-control" name="default_value"
                                    placeholder="Default value">
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
