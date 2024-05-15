<div class="col-md-12">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                </button>
            </div>
        @endforeach
    @endif
</div>

{{--@if (session('success'))--}}
{{--    <div class="alert alert-success alert-icon alert-dismissible fade show" role="alert">--}}
{{--        <i class="uil uil-check-circle"></i>--}}
{{--        {{ session('success') }}--}}

{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if (session('error'))--}}
{{--    <div class="alert alert-danger alert-icon alert-dismissible fade show" role="alert">--}}
{{--        <i class="uil uil-check-circle"></i>--}}
{{--        {{ session('error') }}--}}

{{--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--@endif--}}
