@extends('layout')

@section('title', 'Logout')

@section('center')
    <form action='/user/api/logout' method="POST" class="user__login-form">
        @csrf
        <h2>Are you sure to logout?</h2>
        <div class="user__login-btns">
            <button type="submit" class="btn-primary">Logout</button>
            <a href='/'><button type='button' class="btn-secondary">Back to Main</button></a>
        </div>
    </form>
@endsection