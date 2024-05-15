

     <!-- JAVASCRIPT -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
     <script src="{{ asset('panel/admin/plugins/select2/dist/js/select2.min.js') }}"></script>

     <!-- Main Js -->
     <script src="{{asset('site/assets/js/plugins.js')}}"></script>
     <script src="{{asset('site/assets/js/theme.js')}}"></script>
     <script src="{{asset('panel/admin/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>

    {{-- JQUERY CONFIRM CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    {{-- Font Awesome CDN --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

     @if (session('success'))
          <script>
          $.toast({
               heading: 'SUCCESS',
               text: "{{ session('success') }}",
               showHideTransition: 'slide',
               icon: 'success',
               loaderBg: '#f96868',
               position: 'top-right'
          });
          </script>
     @endif
     @if(session('error'))
          <script>
          $.toast({
               heading: 'ERROR',
               text: "{{ session('error') }}",
               showHideTransition: 'slide',
               icon: 'error',
               loaderBg: '#f2a654',
               position: 'top-right'
          });
          </script>
     @endif
     <script>
          $(document).on('click','.delete-item',function(e){
               e.preventDefault();
               let url = $(this).attr('href');
               let msg = $(this).data('msg') ?? "You won't be able to revert back!";
               $.confirm({
                    draggable: true,
                    title: 'Are You Sure!',
                    content: msg,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                         tryAgain: {
                         text: 'Delete',
                         btnClass: 'btn-red',
                              action: function(){
                                   window.location.href = url;
                              }
                         },
                              close: function () {
                         }
                    }
               });
          });

          $('.uil-times').hide();
            let mobnav = 0;
            $('.toggleBtn').on('click',function(){
                $('.toggle-area').toggle(200);
            });
            $('#toggle-submenu').on('click',function(){
                $('#show-submenu').toggle(200);
          });
     </script>

