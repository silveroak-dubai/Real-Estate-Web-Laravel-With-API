@extends('layouts.auth')
@section('title',$siteTitle)
@section('content')
<div class="card-body">
    <img src="{{ asset('img') }}/logo1.png" class="mb-2" width="145" alt="">
    <h4 class="fw-bold mb-3">Login Here</h4>

    <div class="my-2">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <x-form.inputbox type="email" labelName="Email" name="email" placeholder="Enter Email" value="{{ old('email') }}"/>
            <x-form.inputbox type="password" labelName="Password" name="password" placeholder="Enter Password"/>
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check form-switch">
                    <input class="form-check-input shadow-none" name="remember" type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="remember">Remember Me</label>
                </div>
                <div class="text-end">
                    <a href="#">Forgot Password ?</a>
                </div>
            </div>

            <button type="submit" class="btn btn-sm rounded-0 w-100 btn-primary mt-2">Login</button>
        </form>
    </div>
</div>
@endsection
