@extends('frontend.layouts.master')
@section('main-content')

<style>
    .wrapper {
        width: 450px;
        background-color: #FFFFFF;
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        padding: 30px;
        margin: auto
    }

    .input-field {
        width: 100%;
        height: 45px;
        border: none;
        padding: 10px;
        background-color: #eeeeee;
        color: gray;
        outline: none;
        font-size: 15px;
        margin-bottom: 20px;
        transition: .5s;
        border-radius: 5px;
    }

    .heading {
        color: #3B3663;
        margin-bottom: 20px;
    }

    .heading p {
        color: #AAA8BB;
    }

    button {
        width: 100%;
        height: 45px;
        border: none;
        color: #FFFFFF;
        background-color: #31285C;
        border-radius: 5px;
        font-size: 17px;
        font-weight: 500;
        transition: 0.3s;
    }

    button:hover {
        background-color: #31283B;
    }

</style>

<div class="login-form my-5">
    <div class="wrapper">
        <div class="heading">
            <h2>Admin Login!</h2>
            <p>Sign In to your account</p>
        </div>
        <form action="{{ route('frontend.loginCheck') }}" method="post">
            @csrf
            <div class="input-group">
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="Username">
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" class="input-field" placeholder="Password">
            </div>
            <div class="input-group">
                <button type="submit">Login </button>
            </div>
        </form>
    </div>
</div>
@endsection
