@extends('layout')

@section('title', 'Articles project - search')

@section('center')
    <h3>Search result:</h3>
    @include('articles.approved_articles_list')
@endsection
