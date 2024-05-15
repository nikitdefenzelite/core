// start an prefill columns code
$(document).ready(function () {
    // Function to append fields based on JSON
    function appendFields() {
        var jsonData;
        try {
            jsonData = JSON.parse($('#json').val());

            // Append Crud Details
            var model = jsonData.model;
            $('#model_name').val(model && model.name || '');
            $('#name').val(model && model.table || '');
            $('#view_path').val(model && model.viewPath || '');
            $('#view_path').trigger('change');
            $('#controller-namespace').val(model && model.controllerNamespace || '');

            // Append Server Side Validations
            if (jsonData.fields && Array.isArray(jsonData.fields)) {
                $.each(jsonData.fields, function (index, fieldsVal) {
                    if(index != 0){
                        $('#addFieldsBtn').trigger('click');
                    } 
                    // Create and append input field based on JSON data
                    $('#col_name'+index).val(fieldsVal && fieldsVal.name || '');
                    $('#required_'+index).prop('checked', fieldsVal.required);
                    $('#nullable_'+index).prop('checked', fieldsVal.null);
                    $('#sorting_'+index).prop('checked', fieldsVal.sort);

                    $('#fields_type_'+index).val(fieldsVal && fieldsVal.dataType || '');
                    $('#fields_type_'+index).trigger('change');
                    $('#showindex_'+index).prop('checked', fieldsVal.index);
                    $('#cansearch_'+index).prop('checked', fieldsVal.search);
                    $('#cascade_'+index).prop('checked', fieldsVal.cascade);

                    $('#fields_input_'+index).val(fieldsVal && fieldsVal.inputType || '');
                    $('#fields_input_'+index).trigger('change');
                    $('#unique_'+index).prop('checked', fieldsVal.unique);
                    $('#multiple_'+index).prop('checked', fieldsVal.multiple);

                    $('#fields_default_'+index).val(fieldsVal && fieldsVal.default || '');
                    $('#export_'+index).prop('checked', fieldsVal.export);
                    $('#import_'+index).prop('checked', fieldsVal.import);
                    $('#column_'+index).prop('checked', fieldsVal.md3);

                    $('#fields_comment_'+index).val(fieldsVal && fieldsVal.comments || '');
                    $('#column_md_4_'+index).prop('checked', fieldsVal.md4);
                    $('#column_md_6_'+index).prop('checked', fieldsVal.md6);
                    $('#column_md_12_'+index).prop('checked', fieldsVal.md12);

                });
            }


            // Append Server Side Validations
            if (jsonData.validations && Array.isArray(jsonData.validations)) {
                $.each(jsonData.validations, function (index, validation) {
                    if(index != 0){
                        // $('#addValidations').trigger('click');
                    }
                    // Create and append input field based on JSON data
                    $('#validation'+index).val(validation && validation.field || '');
                    $('#rule'+index).val(validation && validation.rules || '');
                });
            }

            // Append Addons
            var addons = jsonData.addons;
            if (addons) {
                // Set checkbox values based on boolean values
                $('#softdelete').prop('checked', addons.softDelete);
                $('#api').prop('checked', addons.generateAPI);
                $('#date_filter').prop('checked', addons.dateFilter);
                $('#export_btn').prop('checked', addons.export);
                $('#bulk_activation_btn').prop('checked', addons.bulkActivation);
                $('#mail').prop('checked', addons.notifications && addons.notifications.mail);
                $('#notification').prop('checked', addons.notifications && addons.notifications.site);
                $('#excel_btn').prop('checked', addons.excel);
                $('#print_btn').prop('checked', addons.print);
                $('#import_btn').prop('checked', addons.import);
            }

            // Append Server Side Validations
            if (jsonData.media && Array.isArray(jsonData.media)) {
                $.each(jsonData.media, function (index, mediaVal) {
                    index++;
                    $('#addMediaInputBtn').trigger('click');
                    // Create and append input field based on JSON data
                    $('#media_col_name'+index).val(mediaVal && mediaVal.name || '');
                    $('#media_size'+index).val(mediaVal && mediaVal.size || '');
                    $('#media_col'+index).val(mediaVal && mediaVal.column || '');
                    $('#media-required_'+index).prop('checked', mediaVal.required);
                    $('#media-nullable_'+index).prop('checked', mediaVal.column);
                    $('#media-multiple_'+index).prop('checked', mediaVal.multi);
                });
            }
        } catch (error) {
            alert(error);
            return;
        }
    }
    // Event listener for the button click
    $('#prefillButton').on('click', function () {
        $("#prefillButton").html('<i class="fa fa-spinner fa-spin"></i>');
        appendFields();
        setTimeout(() => {
            $("#prefillButton").html('Start Prefill');
            $('#loadJsonModal').modal('hide');
        }, 300);
    });

   
});
// end an prefill columns code


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
            "viewPath": "admin",
            "controllerNamespace": "Admin"
        },
        "fields": [
            {
                "name": "title",
                "required": true,
                "null": false,
                "sort": true,
                "dataType": "string",
                "index": true,
                "search": true,
                "cascade": false,
                "inputType": "text",
                "default": null,
                "export": false,
                "import": false,
                "md3": true,
                "md4": false,
                "md6": false,
                "md12": false
            },
            {
                "name": "name",
                "required": true,
                "null": false,
                "sort": true,
                "dataType": "string",
                "index": true,
                "search": true,
                "cascade": false,
                "inputType": "text",
                "default": null,
                "export": false,
                "import": false,
                "md3": true,
                "md4": false,
                "md6": false,
                "md12": false
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
        ],
        "addons": {
            "softDelete": false,
            "generateAPI": true,
            "dateFilter": true,
            "export": true,
            "bulkActivation": false,
            "notifications": {
                "mail": false,
                "site": true
            },
            "excel": false,
            "print": false,
            "import": false
        },
        "media": [
            {
                "name": "photo",
                "required": true,
                "size": "10",
                "null": true,
                "column": "3",
                "multi": true
            },
            {
                "name": "video",
                "required": true,
                "size": "10",
                "null": true,
                "column": "3",
                "multi": true
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
    // Perform an AJAX post request
    $.ajax({
        type: 'POST',
        url: route,
        data: formData,
        success: function (response) {
            $('#requirementConvertorModal').modal('hide');
            editor.set(JSON.parse(response));
            setTimeout(() => {
                $('#loadJsonModal').modal('show');
            }, 500);
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



