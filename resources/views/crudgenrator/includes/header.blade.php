<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('vendor/DevsBuddy/crudgen/images/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ config('crudgen.home') ? config('crudgen.home') : url('/') }}">Home</a>
                </li> --}}
                <li class="nav-item @if (\Route::currentRouteName() == 'crudgen.index') active @endif }}">
                    <a class="nav-link" href="{{ route('crudgen.index') }}">zCRUD Generator</a>
                </li>
            </ul>
        </div>
        <a class="dropdown-toggle mr-4" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="text-dark fw-800 text-white">Ai</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item  cursor-pointer text-white" data-toggle="modal" data-target="#loadJsonModal"
                style="cursor: pointer;"><i class="ik ik-user dropdown-icon"></i> Load Json</a>
            <a class="dropdown-item  cursor-pointer text-white" data-toggle="modal"
                data-target="#requirementConvertorModal" style="cursor: pointer;"><i
                    class="ik ik-user dropdown-icon"></i> Requirement Convertor</a>
        </div>

        <div>
            <a href="{{ route('crudgen.index') }}" class="btn btn-danger delete-item">Reset</a>
        </div>
    </div>
</nav>
@include('crudgenrator.includes.modal.load-json')
@include('crudgenrator.includes.modal.requirement-convertor')

