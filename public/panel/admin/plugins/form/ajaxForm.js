function pushNotification(heading, text, icon) {
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: 'slide',
        icon: icon,
        loaderBg: '#f96868',
        position: 'top-right'
    });
}


function getData(method, route, dataType, data, callback = null, event = null, toast = 1) {
    NProgress.start();
    $.ajax({
        type: method,
        url: route,
        dataType: dataType,
        data: data,
        success: function (data, textStatus, jqXHR) {
            if (callback != null) {
                response_data = data;
                eval(callback + "(data)");
            } else {
                if (toast == 1) {
                    response_data = data;
                    pushNotification(data.message, data.title, 'success');
                }
            }
        },

        //If there was no response from the server
        error: function (data, textStatus, jqXHR) {
            console.log(data);
            let err = eval("(" + data.responseText + ")");
            if (data.status == 500 || data.status == 400)
                pushNotification("Oops", err.error, "error");
            else
                $.each(err.errors, function (index, value) {
                    pushNotification("Oops", value, "error");
                });
        },

        //capture the request before it was sent to server
        beforeSend: function (jqXHR, settings) {

        },

        //this is called after the response or error functions are finished
        //so that we can take some action
        complete: function (jqXHR, textStatus) {
            NProgress.done();
        }
    });
}

function ajaxButtonLoader(direction = 'in', initial_btn_label) {
    if ($(".ajax-btn").length > 0) {
        if (direction == 'in') {
            $(".ajax-btn").removeClass("btn-primary"); // Add the "btn-secondary" class (typo fixed)
            $(".ajax-btn").addClass("disabled"); // Add the "disabled" class
            $(".ajax-btn").addClass("btn-secondary"); // Add the "btn-secondary" class (typo fixed)
            $(".ajax-btn").css("cursor", "not-allowed"); // Disable pointer events (removed the semicolon)
            $(".ajax-btn").attr("type", "button"); // Remove the "submit" type
            $(".ajax-btn").html('<i class="fa fa-spinner fa-spin"></i>');
        } else {
            setTimeout(() => {
                $(".ajax-btn").removeClass("disabled"); // Add the "disabled" class
                $(".ajax-btn").removeClass("btn-secondary"); // Add the "btn-secondary" class (typo fixed)
                $(".ajax-btn").addClass("btn-primary"); // Add the "btn-secondary" class (typo fixed)
                $(".ajax-btn").css("cursor", "initial"); // Disable pointer events (removed the semicolon)
                $(".ajax-btn").attr("type", "submit"); // Add the "submit" type
                $(".ajax-btn").html(initial_btn_label);
            }, 500);
        }
    }
    return;
}


function postData(method, route, dataType, data, callback = null, event = null, toast = 1, async = true, redirectUrl = null, form = null) {
    let response_data;
    var initial_btn_label = $(".ajax-btn").html();

    var encryptedData = {};
    if(form != null){
        form.find('input[data-encrypt="true"]').each(function() {
            var inputValue = $(this).val();
            var inputName = $(this).attr('name');
            inputValue = btoa(inputValue);
            encryptedData[inputName] = 'zDecrypt-'+inputValue;
        });
        
        // Add encrypted data to FormData
        for (var key in encryptedData) {
            data.append(key, encryptedData[key]);
        }
    }

    $.ajax({
        contentType: false,
        processData: false,
        type: method,
        url: route,
        dataType: dataType,
        async: async,
        data: data != null ? data : {},
        headers: {
            "Accept": "application/json"
        },
        //if received a response from the server
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            if (callback != null) {
                response_data = data;
                eval(callback + "(data)");
            }
            if (toast == 1) {
                response_data = data;
                pushNotification(data.message, data.title, data.status);
            }
            setTimeout(() => {
                if (typeof (response_data) != "undefined" && response_data !== null && response_data.status == "success") {
                    if(redirectUrl != 'not-reload'){
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                            window.location.reload();
                        }
                    }
                }
            }, 300);
        },

        //If there was no response from the server
        error: function (data, textStatus, jqXHR) {
            console.log(data);
            let err = eval("(" + data.responseText + ")");
            if (data.status == 500 || data.status == 400)
                pushNotification("Oops", err.error, "error");
            else
                $.each(err.errors, function (index, value) {
                    pushNotification("Oops", value, "error");
                });
        },

        //capture the request before it was sent to server
        beforeSend: function (jqXHR, settings) {
            // Disable Button & Start loading the response
            ajaxButtonLoader('in');
            NProgress.start();
        },

        //this is called after the response or error functions are finished
        //so that we can take some action
        complete: function (jqXHR, textStatus) {
            // Disable Button & Start loading the response
            ajaxButtonLoader('out', initial_btn_label);
            NProgress.done();
        }
    });
    return response_data;
}
