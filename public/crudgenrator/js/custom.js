$(document).ready(function () {
    function appendFields() {
        var jsonData;
        try {
            jsonData = JSON.parse($('#json').val());

            // Append Crud Details
            var model = jsonData.model;
            $('#model_name').val(model && model.name || '');
            $('#name').val(model && model.table || '');
            $('#view_path').val(model && model.view_path || '');
            $('#view_path').trigger('change');
            $('#controller-namespace').val(model && model.controllerNamespace || '');

            // Append fields
            if (jsonData.fields && Array.isArray(jsonData.fields)) {
                appendField(jsonData.fields, 0);
            }
            // Append Server Side Validations
            if (jsonData.validations && Array.isArray(jsonData.validations)) {
                appendValidation(jsonData.validations, 0);
            }
            // Append Addons

            // Set checkbox values true
            $('#softdelete').prop('checked', true);
            $('#api').prop('checked', true);
            $('#date_filter').prop('checked', true);
            $('#export_btn').prop('checked', true);
            $('#bulk_activation_btn').prop('checked', true);
            $('#mail').prop('checked', true);
            $('#notification').prop('checked', true);
            $('#excel_btn').prop('checked', true);
            $('#print_btn').prop('checked', true);
            $('#import_btn').prop('checked', true);

            // Append Server Side Validations
            // if (jsonData.media && Array.isArray(jsonData.media)) {
            //     appendMedia(jsonData.media, 0);
            // }
        } catch (error) {
            alert(error);
            return;
        }
    }

    $(document).on('click', '.delete-item', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let is_ajax = $(this).data('is_ajax');
        let callback = $(this).data('callback');
        let method = $(this).data('method');
        let msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Reset',
                    btnClass: 'btn-red',
                    action: function () {
                        if (is_ajax == 1) {
                            getData(method, url, "json", null, callback = null, event = null,
                                toast = 1);
                        } else {
                            window.location.href = url;
                        }
                    }
                },
                close: function () {
                }
            }
        });
    });
    $(document).on('click', '.confirm', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-blue',
                    action: function () {
                        window.location.href = url;
                    }
                },
                close: function () {
                }
            }
        });
    });

    function appendField(fields, index) {
        if (index < fields.length) {
            if(index != 0){
                $('#addFieldsBtn').trigger('click');
            }
            var fieldsVal = fields[index];
            $('#col_name' + index).val(fieldsVal && fieldsVal.name || '');
            $('#required_'+index).prop('checked', fieldsVal.required);
            $('#nullable_'+index).prop('checked', false);
            $('#sorting_'+index).prop('checked', true);

            $('#fields_type_'+index).val(fieldsVal && fieldsVal.dataType || '');
            $('#fields_type_'+index).trigger('change');
            $('#showindex_'+index).prop('checked', true);
            $('#cansearch_'+index).prop('checked', true);
            $('#cascade_'+index).prop('checked', true);

            $('#fields_input_'+index).val(fieldsVal && fieldsVal.inputType || '');
            $('#fields_input_'+index).trigger('change');
            $('#unique_'+index).prop('checked', true);
            $('#multiple_'+index).prop('checked', true);

            $('#fields_default_'+index).val(fieldsVal && fieldsVal.default || '');
            $('#export_'+index).prop('checked', true);
            $('#import_'+index).prop('checked', true);
            $('#column_'+index).prop('checked', true);

            $('#fields_comment_'+index).val(fieldsVal && fieldsVal.comments || '');
            $('#column_md_4_'+index).prop('checked', true);
            $('#column_md_6_'+index).prop('checked', true);
            $('#column_md_12_'+index).prop('checked', true);
            // Call the next iteration
            appendField(fields, index + 1);
        }
    }

    function appendValidation(validations, index) {
        if (index < validations.length) {
            // $('#addValidations').trigger('click');
            var validation = validations[index];
            $('#validation' + index).val(validation && validation.field || '');
            $('#rule'+index).val(validation && validation.rules || '');

            // Call the next iteration
            appendValidation(validations, index + 1);
        }
    }

    // function appendMedia(media, index) {
    //     if (index < media.length) {
    //         index++;
    //         $('#addMediaInputBtn').trigger('click');
    //         var mediaVal = media[index];
    //         // Set media values here
    //         $('#media_col_name'+index).val(mediaVal && mediaVal.name || '');
    //         $('#media_size'+index).val(mediaVal && mediaVal.size || '');
    //         $('#media_col'+index).val(mediaVal && mediaVal.column || '');
    //         $('#media-required_'+index).prop('checked', mediaVal.required);
    //         $('#media-nullable_'+index).prop('checked', mediaVal.column);
    //         $('#media-multiple_'+index).prop('checked', mediaVal.multi);
    //         // Call the next iteration
    //         appendMedia(media, index + 1);
    //     }
    // }

    // Event listener for the button click
    $('#prefillButton').on('click', function () {
        $("#prefillButton").prop('disabled',true);
        $("#prefillButton").html('<i class="fa fa-spinner fa-spin"></i>');
        appendFields();
        setTimeout(() => {
            $("#prefillButton").html('Start Prefill');
            $("#prefillButton").prop('disabled',false);
            $('#loadJsonModal').modal('hide');
        }, 500);
    });
});


// start an instance of JSONEditor
var container = document.getElementById('jsoneditor');
var options = {
    modes: ['code', 'text', 'tree', 'view'],
    onError: function (error) {
        alert(error.toString());
    },
};
var editor = new JSONEditor(container, options);
function initializeJSONEditor() {
    // Predefined JSON structure
    var initialJson = {
        "model": {
            "name": "TestAi",
            "table": "test_ais",
            "view_path": "admin",
            "controllerNamespace": "Admin"
        },
        "fields": [
            {
                "name": "title",
                "required": true,
                "dataType": "string",
                "inputType": "text",
            },
            {
                "name": "name",
                "required": true,
                "dataType": "string",
                "inputType": "text",
            }
        ],
        "validations": [
            {
                "field": "title",
                "rules": "required|string|max:255"
            },
            {
                "field": "name",
                "rules": "required"
            }
        ]
    };

    editor.set(initialJson);

    // Periodically check for changes in JSONEditor content
    setInterval(function () {
        var jsonString = JSON.stringify(editor.get(), null, 2);
        if ($('#json').val() !== jsonString) {
            $('#json').val(jsonString);
            console.log('Editor content changed:', jsonString);
        }
    }, 1000);
}
// end json editor code

//Process requirements form
$('#processForm').submit(function (e) {
    e.preventDefault(); // Prevent the default form submission
    // Serialize the form data
    var route = this.action;
    var formData = $(this).serialize();
    $("#proceedButton").prop('disabled',true);
    $("#proceedButton").html('<i class="fa fa-spinner fa-spin"></i>');
    // Perform an AJAX post request
    $.ajax({
        type: 'POST',
        url: route,
        data: formData,
        success: function (response) {
            $('#requirementConvertorModal').modal('hide');
            editor.set(JSON.parse(response));
            // setTimeout(() => {
                $("#proceedButton").prop('disabled',false);
                $("#proceedButton").html('Start Process');
                $('#loadJsonModal').modal('show');
            // }, 500);
            $('#json').val(response);
            // Handle the success response here
        },
        error: function (error) {
            // Handle the error response here
            console.error(error);
        }
    });
});
// end Process requirements form

//start initialize json editor
$(document).ready(function () {
    initializeJSONEditor();
});
//end initialize json editor



