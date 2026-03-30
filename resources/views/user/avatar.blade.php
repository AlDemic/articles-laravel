@extends('layout')

@section('title')
    {{auth()->user()->nick}} - avatar
@endsection

@section('center')
    <div class="avatar-select">
        <p>Your current avatar is:</p>
        <img src="/storage/{{ auth()->user()->avatar ?? 'avatars/user.png' }}"  width="48" height="48" alt="User avatar"/>
        <!--avatar actions block-->
        <form action="/user/avatar" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="file" name="avatar" />
            <button type="submit">Change avatar</button>
        </form>
    </div>
@endsection