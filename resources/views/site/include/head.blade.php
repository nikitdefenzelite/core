   
	<title> zTerminal </title>
    <meta charset="utf-8">

    <link rel="shortcut icon" href="{{asset('site/assets/img/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('site/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('site/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('site/assets/css/colors/navy.css')}}">

    <!-- Css link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"/> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" referrerpolicy="no-referrer" />
    
    {{-- Dynamic CSS Before Head --}}
   
    <style>
        .alert {
            position: relative;
            padding: 0.75rem 1.7rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.3125rem;
            font-weight: 500;
        }

            .alert-dismissible {
                padding-right: 4rem;
            }

            .alert-dismissible .close {
                position: absolute;
                top: 0;
                right: 0;
                padding: 0.75rem 1.25rem;
                color: inherit;
            }
            .alert-danger {
                color: #721c24;
                background-color: #f8d7da;
                border-color: #f5c6cb;
            }
    </style>
    