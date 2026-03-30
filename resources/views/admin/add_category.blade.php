@extends('layout')

@section('title', 'Admin panel - add category')

@section('center')
    <form action="/admin/api/category/create" method="POST" class="user__reg-form">
        @csrf
        <label>
            <b>Category title:</b>
            <input type="text" name="title" minlength="3" maxlength="24" value="{{ old('title') }}" required/>
        </label>
        <button type="submit">Create</button>
    </form>


    <div class="user__login-btns">
        <a href='/admin' class="btn-secondary">Back to admin panel</a>
        <a href='/' class="btn-secondary">Back to Main</a>
    </div>
@endsection