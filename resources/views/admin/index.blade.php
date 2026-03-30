@extends('layout')

@section('title', 'Admin panel')

@section('center')
    <div class="admin__menu">
        <h3>Admin panel</h3>
        <a href='admin/category/create'>Create category</a>
        <a href='admin/articles/moderation'>Moderation</a>

        <a href='/' class="admin-btn">Back to Main</a>
    </div>
@endsection