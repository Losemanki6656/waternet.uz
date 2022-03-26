@extends('layouts.app')


@section('content')
<div class="card">
    <div class="header">
        <p class="lead">Log in</p>
    </div>
    <div class="body">
        <form class="form-auth-small" action="{{route('login')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">Email</label>
                <input type="email" name="email" class="form-control" id="signin-email" placeholder="User Name">
            </div>
            <div class="form-group">
                <label for="signin-password" class="control-label sr-only">Password</label>
                <input type="password" name="password" class="form-control" id="signin-password" placeholder="Password">
            </div>
            <div class="form-group clearfix">
                <label class="fancy-checkbox element-left">
                    <input type="checkbox">
                    <span>Remember me</span>
                </label>								
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
            <div class="bottom">
                <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span>
                <span>Don't have an account? <a href="page-register.html">Register</a></span>
            </div>
        </form>
    </div>
</div>

@endsection
