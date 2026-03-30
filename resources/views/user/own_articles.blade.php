@extends('layout')

@section('title', 'My articles')

@section('center')
    <div class='articles__filters'>
        <select onchange="window.location.href=this.value">
            <option value="{{ request()->url() }}">All</option>
            <option value="?filter=approved" {{ $filter === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="?filter=onMod" {{ $filter === 'onMod' ? 'selected' : '' }}>On moderation</option>
            <option value="?filter=declined" {{ $filter === 'declined' ? 'selected' : '' }}>Declined</option>
        </select>
    </div>
    <div class="articles__block">
        @if(isset($articles) && $articles->isNotEmpty())
            @foreach($articles as $article)
                <div class="articles__article">
                    <h3><b>Title:</b> {{$article->title}}</h3>
                    <p><b>Category: </b> {{$article->category->title}}</p>
                    <p><b>Short description:</b> {{$article->short_desc}}</p>
                    <p><b>Full description:</b> {{$article->full_desc}}</p>
                    <p><b>Article status:</b> {{$article->status}}</p>
                </div>
            @endforeach
            <!--pagination block-->
            @include('articles.pagination')
        @else
            <div class="articles__article">
                <b>No have any article for current filter</b> 
            </div>
        @endif
    </div>
@endsection