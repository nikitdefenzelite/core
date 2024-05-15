(function($) {
'use strict';
    // Roles data table
        function validatenumber(event) {
            var val = event.target.value;
            var max = event.target.max;
            var min= event.target.min;
            if(val>max){
                event.target.value = max;
            }else if(val< min){
                event.target.value = min;
            }else{
                event.target.value = val;
            }
        }
        function firstUpper(event) {
            var words = event.target.value.split(/\s+/g);
            var newWords = words.map(function(element){
                return element !== "" ?  element[0].toUpperCase() + element.substr(1, element.length) : "";
            });
            event.target.value = newWords.join("");
        }
     
        function allLower(event) {
            var words = event.target.value.toLowerCase().split(/\s+/g);
 
            event.target.value = words.join("");
            return event.target.value;
        }
     $('body').on('keyup','.slug',function(){
        $(this).val($(this).val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''));
     });

    
})(jQuery);