    (function($){
        $.fn.focusTextToEnd = function(){
            this.focus();
            var $thisVal = this.val();
            this.val('').val($thisVal);
            return this;
        }
    }(jQuery));

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    function getUrlParam(parameter, defaultvalue){
        var urlparameter = defaultvalue;
        if(window.location.href.indexOf(parameter) > -1){
            urlparameter = getUrlVars()[parameter];
            }
        return urlparameter;
    }
    function updateURLParam(key,val){
        var url = window.location.href;
        var reExp = new RegExp("[\?|\&]"+key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

        if(reExp.test(url)) {
            // update
            var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
            var delimiter = reExp.exec(url)[0].charAt(0);
            url = url.replace(reExp, delimiter + key + "=" + val);
        } else {
            // add
            var newParam = key + "=" + val;
            if(!url.indexOf('?')){url += '?';}

            if(url.indexOf('#') > -1){
                var urlparts = url.split('#');
                url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
            }else if(url.indexOf('&') > -1 || url.indexOf('?') > -1){
                url += "&" + newParam;
            } else {
                url += "?" + newParam;
            }
        }
        window.history.pushState(null, document.title, url);
    return url;
        // window.history.pushState(null, document.title, url);
    }
    

    var checkUrlParameter = function checkUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return true;
            }
        }
        return false;
    };
    function  tableLoading(status){
        if(status == 'start'){
            $('#ajax-container').html('<div id="floatingBarsG"> <div class="blockG" id="rotateG_01"></div> <div class="blockG" id="rotateG_02"></div> <div class="blockG" id="rotateG_03"></div> <div class="blockG" id="rotateG_04"></div> <div class="blockG" id="rotateG_05"></div> <div class="blockG" id="rotateG_06"></div> <div class="blockG" id="rotateG_07"></div> <div class="blockG" id="rotateG_08"></div> </div>');  

            $('.ajax-multi-container').html('<div id="floatingBarsG"> <div class="blockG" id="rotateG_01"></div> <div class="blockG" id="rotateG_02"></div> <div class="blockG" id="rotateG_03"></div> <div class="blockG" id="rotateG_04"></div> <div class="blockG" id="rotateG_05"></div> <div class="blockG" id="rotateG_06"></div> <div class="blockG" id="rotateG_07"></div> <div class="blockG" id="rotateG_08"></div> </div>');  
        }
    }
    $(document).on('click', '.col-btn',function(){
        var val = $(this).data('val');
        $('.'+val).toggleClass('d-none');
        $(this).toggleClass('bg-dark');
        $(this).find('a').toggleClass('text-white');
    });

    function fetchData(url,activeTab = null) {
        if(activeTab == null){
            activeTab =  getUrlParam('active');
        }
        NProgress.start();
        tableLoading('start');
        $.ajax({
            url : url ,
            cache : false,
        }).done(function (data) {
            if(activeTab == null)
                $('#ajax-container').html(data);    
            else
            $('.ajax-'+activeTab).html(data);
            
            NProgress.done();
            if(checkUrlParameter('trash')){
                if(getUrlParam('trash','') == 1){
                    $(document).find('.trash-option[value="Restore"]').removeClass('d-none');
                    $(document).find('.trash-option[value="Move To Trash"]').addClass('d-none');
                }else{
                    $(document).find('.trash-option[value="Restore"]').addClass('d-none');
                    $(document).find('.trash-option[value="Move To Trash"]').removeClass('d-none');
                }
            }
            if(checkUrlParameter('search'))
            $('#search').focusTextToEnd();
            $('.search').focusTextToEnd();
            if(checkUrlParameter('from') && checkUrlParameter('to')){
                let formattedFromDate = moment(getUrlParam('from'), 'YYYY-MM-DD HH:mm:ss').format('DD-MMM-YYYY');
                let formattedToDate = moment(getUrlParam('to'), 'YYYY-MM-DD HH:mm:ss').format('DD-MMM-YYYY');

                $('.from-date-html').html(formattedFromDate);
                $('.to-date-html').html(formattedToDate);
            }
            refreshCheckboxes(); 
        }).fail(function () {
            alert('Data could not be loaded.');
        });
    }    
    $('.records-type').click(function() {
        if($(this).data('value') == "Trash"){
            if(checkUrlParameter('trash'))
                url = updateURLParam('trash', 1);
            else
                url =  updateURLParam('trash', 1);
        }else{
            if(checkUrlParameter('trash'))
                url = updateURLParam('trash','');
            else
                url =  updateURLParam('trash','');
        }
        fetchData(url);
    });
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');  
        fetchData(url);
        window.history.pushState("", "", url);
    });

    $(document).on('submit','#TableForm',function(e){
        e.preventDefault();
        var formdata = $(this).serialize();
        var route = $(this).attr('action');
        window.history.pushState(null, document.title, route+'?'+formdata);
        fetchData(route+'?'+formdata);
        $(document).find('.close.off-canvas').trigger('click');
    });
        $(document).on('change','#jumpTo, .jumpTo',function() {
            var url;
            if(checkUrlParameter('page')){
               url = updateURLParam('page', $(this).val());
            }else{
              url =  updateURLParam('page', $(this).val());
            }
            fetchData(url);
        });
        $(document).on('change','#length, .length',function() {
            var url;
            if(checkUrlParameter('length')){
            url = updateURLParam('length', $(this).val());
            }else{
            url =  updateURLParam('length', $(this).val());
            }
            fetchData(url);
        });
        $(document).on('change','#search, .search',function() {
            var url;
            if(checkUrlParameter('search')){
               url = updateURLParam('search', $(this).val());
            }else{
               url = updateURLParam('search', $(this).val());
            }
            fetchData(url);
            $('#search').focus();
            $('.search').focus();
        });
          
        $(document).on('click','.asc',function(){
            var desc = getUrlParam('desc');
            var val = $(this).data('val');
            // if(desc == val){
                updateURLParam('desc', "");
            // }
            if(checkUrlParameter('asc')){
                url = updateURLParam('asc', val);
            }else{
                url =  updateURLParam('asc', val);
            }
            fetchData(url);
        });
        $(document).on('click','.desc',function(){
            var asc = getUrlParam('asc');
            var val = $(this).data('val');
            // if(asc == val){
                updateURLParam('asc', "");
            // }
            if(checkUrlParameter('desc')){
                url = updateURLParam('desc', val);
            }else{
                url =  updateURLParam('desc', val);
            }
            fetchData(url);
        });
        
        $(document).on('click','#print',function(){
       
            var tbl_data = $(this).data('rows');
            var print_url = $(this).data('url');
            $.ajax({
                url: print_url,
                method: "post",
                data: {records:tbl_data},
                dataType: 'html',
                success: function(res){
                var w = window.open();
                $(w.document.body).html(res);
                w.print();
                var timer = setInterval(function () {
                    clearInterval(timer);
                    window.location.reload(); // Refresh the parent page
                }, 100);
                }
            });

        });