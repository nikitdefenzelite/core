<script defer>
    var bulk_ids = [];

    $('.action').on("click", function() {
        let actionValue = $(this).data('action');
        request_with = 'action';
        if (actionValue == "Export") {
            $.ajax({
                url: "{{ url($actionUrl) }}" + '/more-action',
                type: 'POST',
                data: {
                    ids: bulk_ids,
                    action: actionValue
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    NProgress.start();
                },
                success: function(blob) {
                    bulk_ids = [];
                    $("#counted").val('0 Selected');

                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{ $routeClass }}-" + new Date() + ".csv";
                    link.click();
                    setTimeout(() => {
                        $(ajaxMessage).html('');
                    }, 1000);
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    if (data.status === 400) {
                        var errorString = '<ul>';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul>';
                        response = errorString;
                    }

                    if (data.status === 401)
                        response = response.error;
                    $(ajaxMessage).html('<div class="alert alert-danger">' + response + '</div>');

                }
            });
        } else if (actionValue == "customUpdate") {
            $('#ids').val(bulk_ids);
            $('#CustomUpdateModal').modal('show');
        } else if (actionValue == "Move To Trash" || actionValue == "Delete Permanently") {
            $.confirm({
                draggable: true,
                title: 'Are You Sure!',
                content: "You won't be able to revert back!",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Confirm',
                        btnClass: 'btn-red',
                        action: function() {

                            $.ajax({
                                url: "{{ url($actionUrl) }}" + '/more-action',
                                type: 'POST',
                                data: {
                                    ids: bulk_ids,
                                    action: actionValue
                                },
                                beforeSend: function() {
                                    NProgress.start();
                                },
                                success: function(res) {
                                    bulk_ids = [];
                                    $("#counted").val('0 Selected');
                                    NProgress.done();

                                    if (actionValue == "Delete") {
                                        page = '';
                                        fetchData();
                                    } else {
                                        fetchData();
                                    }
                                    // alert(res.count);
                                    if(res.count == 0){
                                        $(document).find('.move-to-trash').addClass('d-none');
                                    }
                                    setTimeout(() => {
                                        $(ajaxMessage).html('');
                                    }, 1000);
                                },
                                error: function(data) {
                                    var response = JSON.parse(data.responseText);
                                    if (data.status === 400) {
                                        var errorString = '<ul>';
                                        $.each(response.errors, function(key, value) {
                                            errorString += '<li>' + value +
                                                '</li>';
                                        });
                                        errorString += '</ul>';
                                        response = errorString;
                                    }

                                    if (data.status === 401)
                                        response = response.error;
                                    $(ajaxMessage).html(
                                        '<div class="alert alert-danger">' +
                                        response + '</div>');
                                }
                            });
                        }
                    },
                    close: function() {}
                }
            });
        } else if (actionValue != "") {
            $.ajax({
                url: "{{ url($actionUrl) }}" + '/more-action',
                type: 'POST',
                data: {
                    ids: bulk_ids,
                    action: actionValue
                },
                beforeSend: function() {
                    NProgress.start();
                },
                success: function(res) {
                    NProgress.done();
                    bulk_ids = [];
                    $("#counted").val('0 Selected');

                    if (actionValue == "Delete") {
                        page = '';
                        fetchData();
                    } else {
                        fetchData();
                    }
                    setTimeout(() => {
                        $(ajaxMessage).html('');
                    }, 1000);
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    if (data.status === 400) {
                        var errorString = '<ul>';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value +
                                '</li>';
                        });
                        errorString += '</ul>';
                        response = errorString;
                    }

                    if (data.status === 401)
                        response = response.error;
                    $(ajaxMessage).html(
                        '<div class="alert alert-danger">' +
                        response + '</div>');
                }
            });
        }
        $('[name="action"]').val('').change();
    });
    $('.select-action').on("change", function() {
        let actionValue = $(this).val();
        request_with = 'action';
        if (actionValue == "Export") {
            $.ajax({
                url: "{{ url($actionUrl) }}" + '/more-action',
                type: 'POST',
                data: {
                    ids: bulk_ids,
                    action: actionValue
                },
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    NProgress.start();
                },
                success: function(blob) {
                    bulk_ids = [];
                    $("#counted").val('0 Selected');

                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{ $routeClass }}-" + new Date() + ".csv";
                    link.click();
                    setTimeout(() => {
                        $(ajaxMessage).html('');
                    }, 1000);
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    if (data.status === 400) {
                        var errorString = '<ul>';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul>';
                        response = errorString;
                    }

                    if (data.status === 401)
                        response = response.error;
                    $(ajaxMessage).html('<div class="alert alert-danger">' + response + '</div>');

                }
            });
        } else if (actionValue == "customUpdate") {
            $('#ids').val(bulk_ids);
            $('#CustomUpdateModal').modal('show');
        } else if (actionValue == "Move To Trash" || actionValue == "Delete Permanently") {
            $.confirm({
                draggable: true,
                title: 'Are You Sure!',
                content: "You won't be able to revert back!",
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Confirm',
                        btnClass: 'btn-red',
                        action: function() {

                            $.ajax({
                                url: "{{ url($actionUrl) }}" + '/more-action',
                                type: 'POST',
                                data: {
                                    ids: bulk_ids,
                                    action: actionValue
                                },
                                beforeSend: function() {
                                    NProgress.start();
                                },
                                success: function(res) {
                                    bulk_ids = [];
                                    $("#counted").val('0 Selected');
                                    NProgress.done();

                                    if (actionValue == "Delete") {
                                        page = '';
                                        fetchData();
                                    } else {
                                        fetchData();
                                    }
                                    setTimeout(() => {
                                        $(ajaxMessage).html('');
                                    }, 1000);
                                },
                                error: function(data) {
                                    var response = JSON.parse(data.responseText);
                                    if (data.status === 400) {
                                        var errorString = '<ul>';
                                        $.each(response.errors, function(key, value) {
                                            errorString += '<li>' + value +
                                                '</li>';
                                        });
                                        errorString += '</ul>';
                                        response = errorString;
                                    }

                                    if (data.status === 401)
                                        response = response.error;
                                    $(ajaxMessage).html(
                                        '<div class="alert alert-danger">' +
                                        response + '</div>');
                                }
                            });
                        }
                    },
                    close: function() {}
                }
            });
        } else if (actionValue != "") {
            $.ajax({
                url: "{{ url($actionUrl) }}" + '/more-action',
                type: 'POST',
                data: {
                    ids: bulk_ids,
                    action: actionValue
                },
                beforeSend: function() {
                    NProgress.start();
                },
                success: function(res) {
                    NProgress.done();
                    bulk_ids = [];
                    $("#counted").val('0 Selected');

                    if (actionValue == "Delete") {
                        page = '';
                        fetchData();
                    } else {
                        fetchData();
                    }
                    setTimeout(() => {
                        $(ajaxMessage).html('');
                    }, 1000);
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    if (data.status === 400) {
                        var errorString = '<ul>';
                        $.each(response.errors, function(key, value) {
                            errorString += '<li>' + value +
                                '</li>';
                        });
                        errorString += '</ul>';
                        response = errorString;
                    }

                    if (data.status === 401)
                        response = response.error;
                    $(ajaxMessage).html(
                        '<div class="alert alert-danger">' +
                        response + '</div>');
                }
            });
        }
        $('[name="action"]').val('').change();
    });

    $(document).on('change', '.isboolrec-update', function(e) {
        e.preventDefault();
        let name = $(this).attr('name');
        let id = $(this).val();
        let val = 0;
        if ($(this).prop('checked')) {
            val = 1;
        }
        $.ajax({
            url: "{{ url($actionUrl) }}" + '/more-action',
            type: 'POST',
            data: {
                ids: [id],
                action: name + '-' + val
            },
            beforeSend: function() {
                NProgress.start();
            },
            success: function(res) {
                bulk_ids = [];
                $("#counted").val('0 Selected');
                NProgress.done();
                setTimeout(() => {
                    $(ajaxMessage).html('');
                }, 1000);
            },
            error: function(data) {
                var response = JSON.parse(data.responseText);
                if (data.status === 400) {
                    var errorString = '<ul>';
                    $.each(response.errors, function(key, value) {
                        errorString += '<li>' + value +
                            '</li>';
                    });
                    errorString += '</ul>';
                    response = errorString;
                }

                if (data.status === 401)
                    response = response.error;
                $(ajaxMessage).html(
                    '<div class="alert alert-danger">' +
                    response + '</div>');
            }
        });
    });
    $(document).on('click', '.excel-template', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ url($actionUrl) }}" + '/more-action',
            type: 'POST',
            data: {
                ids: [0],
                action: "Export"
            },
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                NProgress.start();
            },
            success: function(blob) {
                bulk_ids = [];
                $("#counted").val('0 Selected');

                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "{{ $routeClass }}-" + new Date() + ".xlsx";
                link.click();
                setTimeout(() => {
                    $(ajaxMessage).html('');
                }, 1000);
            },
            error: function(data) {
                var response = JSON.parse(data.responseText);
                if (data.status === 400) {
                    var errorString = '<ul>';
                    $.each(response.errors, function(key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    errorString += '</ul>';
                    response = errorString;
                }

                if (data.status === 401)
                    response = response.error;
                    $(ajaxMessage).html('<div class="alert alert-danger">' + response + '</div>');

            },
            complete: function (jqXHR, textStatus) {
                NProgress.done();
            }

        });
    });

    String.prototype.rtrim = function() {
        return this.replace(/\s+$/, "");
    }

    $(ajaxContainer).on('click', '#selectall', function() {
        $('tbody input[type="checkbox"]').prop('checked', this.checked);
        countSelected();
    });

    function countSelected(e = null) {
        if (e != null) {
            if (e.hasClass('toggle-selected')) {
                e.parent().parent().find('.custom-card').toggleClass('selected');
            }
        }
        bulk_ids = $("tbody input:checkbox:checked,.custom-bulk-section input:checkbox:checked").map(function() {
            return $(this).val();
        }).get();

        if (bulk_ids.length) {
            $("#counted").val(bulk_ids.length + ' Selected');
            $("#action-section").fadeIn();
        } else {
            $("#counted").val('0 Selected');
            $("#action-section").fadeOut();
            $("#selectall").prop('checked', false);
        }

    }
</script>
