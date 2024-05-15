// Form Advanced

"use strict";
$(document).ready(function() {
    // Single swithces
    var elemsingle = document.querySelector('.js-single');
   if(elemsingle != null){
       var switchery = new Switchery(elemsingle, {
           color: '#4099ff',
           jackColor: '#fff'
       });
   }
    // Multiple swithces
    var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elem.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#4099ff',
            jackColor: '#fff',
            size: 'small'
        });
    });
    // Disable enable swithces
    var elemstate = document.querySelector('.js-dynamic-state');
    if(elemsingle != null){
        var switcheryy = new Switchery(elemstate, {
            color: '#4099ff',
            jackColor: '#fff'
        });
    }

    $('.switch-input').on('click', function (e) {
        var content = $(this).closest('.switch-content');
        if (content.hasClass('d-none')) {
            $(this).attr('checked', 'checked');
            content.find('input').attr('required', true);
            content.removeClass('d-none');
        } else {
            content.addClass('d-none');
            content.find('input').attr('required', false);
        }
    });
});

//Form Components
(function($) {
    'use strict';
    $(function() {
      $('.file-upload-browse').on('click', function() {
        var file = $(this).parent().parent().parent().find('.file-upload-default');
        file.trigger('click');
      });
      $('.file-upload-default').on('change', function() {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
      });
    });
})(jQuery);

// Form Picker
(function($) {
    'use strict';
    $(document).ready(function() {
        $(".date-default").dateDropper({
            dropWidth: 200,
            format: "d F Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c"
        }),
        $("#dropper-default").dateDropper({
            dropWidth: 200,
            format: "d F Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c"
        }),
        $("#dropper-animation").dateDropper({
            dropWidth: 200,
            init_animation: "bounce",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c"
        }),
        $("#dropper-format").dateDropper({
            dropWidth: 200,
            format: "F S, Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c"
        }),
        $("#dropper-lang").dateDropper({
            dropWidth: 200,
            format: "F S, Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            lang: "ar"
        }),
        $("#dropper-lock").dateDropper({
            dropWidth: 200,
            format: "F S, Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            lock: "from"
        }),
        $("#dropper-max-year").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            maxYear: "2020"
        }),
        $("#dropper-min-year").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            minYear: "1990"
        }),
        $("#year-range").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            yearsRange: "5"
        }),
        $("#dropper-width").dateDropper({
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            dropWidth: 500
        }),
        $("#dropper-dangercolor").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#e74c3c",
            dropBorder: "1px solid #e74c3c",
        }),
        $("#dropper-backcolor").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            dropBackgroundColor: "#bdc3c7"
        }),
        $("#dropper-txtcolor").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#46627f",
            dropBorder: "1px solid #46627f",
            dropTextColor: "#FFF",
            dropBackgroundColor: "#e74c3c"
        }),
        $("#dropper-radius").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            dropBorderRadius: "0"
        }),
        $("#dropper-border").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "2px solid #1abc9c"
        }),
        $("#dropper-shadow").dateDropper({
            dropWidth: 200,
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c",
            dropBorderRadius: "20px",
            dropShadow: "0 0 20px 0 rgba(26, 188, 156, 0.6)"
        }),
        $('#inlinedatetimepicker').datetimepicker({
            inline: true,
            sideBySide: true
        });
        $('#datepicker').datetimepicker({
            format: 'L'
        });
        $('#timepicker').datetimepicker({
            format: 'LT'
        });
    })
})(jQuery);
