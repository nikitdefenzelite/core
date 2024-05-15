@extends('layouts.empty')

@section('meta_data')
    @php
        $meta_title = 'Register';
    @endphp
@endsection
<style>
    .strength-meter {
            margin-top: 10px;
            font-size: 14px;
        }

        .strength-0 {
            color: red;
        }

        .strength-1 {
            color: orange;
        }

        .strength-2 {
            color: yellow;
        }

        .strength-3 {
            color: green;
        }

        .strength-4 {
            color: darkgreen;
        }
</style>

@section('content')
    <section class="bg-home-75vh">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-6 col-xxl-5 mx-auto">
                    <div class="card form-signin p-4  mt-2">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                                    {{ $error }}
                                    <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            @endforeach
                        @endif
                        <form action="{{ route('register', $role) }}" method="post" class="mt-3 register-form">
                            @csrf
                            <a href="{{ url('/') }}">
                                <img src="{{ getBackendLogo(getSetting('app_logo')) }}" class="avatar-small d-block mx-auto"
                                    height="100px" alt="">
                            </a>
                            <h5 class="mb-3 text-center">Register Admin and Join {{ getSetting('app_name') }}</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="text" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            class="form-control" id="floatingInput" placeholder="Enter First Name"
                                            name="first_name" value="{{ old('first_name') }}" required>
                                        <label for="floatingInput">First Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="text" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            class="form-control" id="floatingInput" placeholder="Enter last Name"
                                            name="last_name" value="{{ old('last_name') }}" required>
                                        <label for="floatingInput">Last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="email" class="form-control" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            id="floatingEmail" placeholder="name@example.com" name="email"
                                            value="{{ old('email') }}" required>
                                        <label for="floatingEmail">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class=" form-floating mb-2">
                                        <input type="number" class="form-control" id="floatingPhone" min="0"
                                            placeholder="Enter Phone Number" name="phone" pattern="^[0-9]*$"
                                            value="{{ old('phone') }}" required>
                                        <label for="floatingPhone">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating form-group mb-2">
                                        <input id="floatingPassword" type="password" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            class="form-control" placeholder="Password" name="password" required>
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div id="password-strength"class="strength-meter"></div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating form-group mb-2">
                                        <input id="floatingPassword" type="password" pattern="[a-zA-Z]+.*"
                                            title="Please enter first letter alphabet and at least one alphabet character is required."
                                            class="form-control" placeholder="Confirm Password" name="password_confirmation"
                                            required>
                                        <label for="floatingPassword">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mx-3">
                                <input class="form-check-input" required type="checkbox" value=""
                                    id="flexCheckDefault">
                                <label class="form-check-label fw-normal text-muted fs-6 ln-1" for="flexCheckDefault">
                                    <small>
                                        By clicking Sign Up, you agree to our Terms, Privacy Policy and Cookies Policy.
                                        You
                                        may receive SMS notifications from us and can opt out at any time.
                                    </small>
                                </label>
                            </div>

                            <button class="btn btn-primary rounded-pill btn-login w-100 mb-2" type="submit">Complete
                                Registration
                            </button>

                            <div class="col-12 text-center mt-3">
                                <a href="{{ url('admin/login') }}" class="text-dark">Already have an account?</a>
                            </div><!--end col-->

                            <p class="mb-0 text-muted mt-5 text-center">©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ getSetting('app_name') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>

<script>
    const passwordInput = document.getElementById('floatingPassword');
    const strengthMeter = document.getElementById('password-strength');

    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        const strength = zxcvbn(password);

        // Update the strength meter text and style
        strengthMeter.innerHTML = `Password strength: ${strength.score}/4`;
        strengthMeter.className = `strength-${strength.score}`;
    });
</script>

@endpush

