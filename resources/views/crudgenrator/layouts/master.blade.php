<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Crudgen')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('panel/admin/plugins/jquery-confirm-3.3.2/jquery-confirm.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.0.0/jsoneditor.min.css" />
    <link rel="stylesheet" href="{{ asset('crudgenrator/css/main.css') }}">

    @stack('scopedCss')
</head>

<body>
    {{-- Include Header --}}
    @include('crudgenrator.includes.header')

    {{-- Main Contents --}}
    @yield('content')

    {{-- Include Header --}}
    @include('crudgenrator.includes.footer')

    {{-- Scripts --}}

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('panel/admin/plugins/jquery-confirm-3.3.2/jquery-confirm.min.js') }}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.0.0/jsoneditor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <script src="{{ asset('crudgenrator/js/custom.js') }}"></script>
    @stack('scopedJs')
</body>

</html>
