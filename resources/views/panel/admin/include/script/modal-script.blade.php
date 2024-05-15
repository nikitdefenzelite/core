<script>
    //Add category 
    $('.category_id').on("select2:open", function() {
        let flag = $(this).data('flag');
        let level = $(this).data('level');
        if (!Number.isInteger(level))
            level = 1;
        $('#category-select-id').val($(this).attr('id'));
        $('#categoryLevelInput').val(level);
        ++flag;
        $(this).data('flag', flag);
        if (flag == 1)
            $(".select2-results").append(
                `<div class='select2-results__option'> <a href="#" id="addCategory" class="font-weight-300" data-target="#addCategoryModal" data-toggle="modal">+ Add New Category</a> </div>`
            );
    });
    $("#category-form").validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: "Please enter name",
        },
        submitHandler: function(form) {
            $(this).find('[type=submit]').attr('disabled', '');
            let formdata = new FormData(form);
            formdata.append("request_with", 'create');
            $.ajax({
                url: "{{ route('categories.store') }}",
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(ajaxMessage).html(
                        '<div class="alert alert-info"><i class="fa fa-refresh fa-spin"></i> Please wait... </div>'
                    );
                },
                success: function(res) {
                    $(form)[0].reset();
                    $('#addCategoryModal').modal('hide');
                    $(ajaxMessage).html('<div class="alert alert-success">' + res.message +
                        '</div>');
                    if (res.data)
                        $('#' + $('#category-select-id').val()).append('<option value="' + res
                            .data.id + '">' + res.data.name + '</option>');
                    $('#' + $('#category-select-id').val()).select2();
                    $('#' + $('#category-select-id').val()).data('flag', 0);
                    $('#category-select-id').val('');
                },
                complete: function() {
                    $(this).find('[type=submit]').removeAttr('disabled');
                    setTimeout(function() {
                        $(ajaxMessage).html('');
                    }, 2000);
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    if (data.status === 422) {
                        var errorString = '<ul class="ps-3 m-0">';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul>';
                        response = errorString;
                    } else {
                        response = response.error;
                    }

                    $(ajaxMessage).html('<div class="alert alert-danger">' + response +
                        '</div>');
                }
            });

        }
    });
</script>
