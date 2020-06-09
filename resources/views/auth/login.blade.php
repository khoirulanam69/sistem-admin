@extends('templates.auth')

@section('title', 'Login')

@section('container')
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
  </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
  <form class="user" action="{{ url('/') }}" method="POST">
    @csrf
    <div class="form-group">
      <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email Address...">
      @error('email')
            <div class="invalid-feedback pl-3">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
      <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
      @error('password')
            <div class="invalid-feedback pl-3">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">
      Login
    </button>
  </form>
  <hr>
  <div class="text-center">
    <a class="small" href="{{ url('/forgotpassword') }}">Forgot Password?</a>
  </div>
  <div class="text-center">
    <a class="small" href="{{ url('/registration') }}">Create an Account!</a>
  </div>
@endsection
