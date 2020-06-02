@extends('../templates/auth')

@section('title', 'Registration')

@section('container')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Registration</h1>
    </div>
    <form class="user" action=" {{ url('/registration') }} " method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Full Name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-sm-6">
                <input type="password" class="form-control form-control-user @error('repassword') is-invalid @enderror" id="repassword" name="repassword" placeholder="Repeat Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
        Register
        </button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{ url('/forgotpassword') }}">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{ url('/') }}">Already have account? back!</a>
    </div>
@endsection