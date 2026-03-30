@extends('layout')

@section('title', 'User registration')

@section('center')
    <form action='/user/api/reg' method="POST" class="user__reg-form">
        @csrf
        <label>
            <b>Nick:</b>
            <input type="text" name="nick" minlength="3" maxlength="64" value="{{ old('nick') }}" required>
        </label>
        <label>
            <b>Email:</b>
            <input type="email" name="email" maxlength="128" value="{{ old('email') }}" required>
        </label>
        <label>
            <b>Password:</b>
            <input type="password" name="password" minlength="4" maxlength="32" required>
        </label>
        <div class="user__login-btns">
            <button type="submit" class="btn-primary">Registration</button>
            <a href='/'><button type='button' class="btn-secondary">Back to Main</button></a>
        </div>
    </form>
@endsection