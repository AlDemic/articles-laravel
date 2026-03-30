@extends('layout')

@section('title', 'Login')

@section('center')
    <form action='/user/api/login' method="POST" class="user__login-form">
        @csrf
        <label>
            <b>Email:</b>
            <input type="email" name="email" maxlength="128" value="{{ old('email') }}" required>
        </label>
        <label>
            <b>Password:</b>
            <input type="password" name="password" minlength="4" maxlength="32" required>
        </label>
        <div class="user__login-btns">
            <button type="submit" class="btn-primary">Login</button>
            <a href='/'><button type='button' class="btn-secondary">Back to Main</button></a>
        </div>
    </form>
@endsection