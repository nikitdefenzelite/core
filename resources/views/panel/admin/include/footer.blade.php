 <footer class="footer"style="bottom: 0px;position: fixed;width: 100%;">
     <div class="w-100 clearfix">
         <span class="text-center text-sm-left d-md-inline-block ">
             {{ str_replace('{date}', date('Y'), getSetting('copyright_text')) }} {{ __(env('APP_VERSION')) }}
         </span>
         <span class="float-sm-right mt-1 mt-sm-0 text-center">
             {{ __('admin/ui.Developed&Designedby') }}
             <a href="https://www.defenzelite.com" class="text-dark" target="_blank">
                 {{ __('admin/ui.DefenzelitePvt.Ltd') }}
             </a>
         </span>
     </div>
 </footer>
