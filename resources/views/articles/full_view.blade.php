@extends('layout')

@section('title')
    {{$article->title}} - view
@endsection

@section('center')
    <div class="articles__block">
        <div class="articles__article">
            <h3><b>Title:</b> {{$article->title}}</h3>
            <p><b>Category: </b> {{$article->category->title}}</p>
            <p><b>Short description:</b> {{$article->short_desc}}</p>
            <p><b>Full description:</b> {{$article->full_desc}}</p>
            <p><b>Article status:</b> {{$article->status}}</p>
            <div class="article__additional">
                <div class="author_block">
                    <small>Article id: {{$article->id}}</small>
                    <small>Author nick: {{$article->user->nick}}</small>
                    <small>Added: {{$article->created_at}}</small>
                </div>
            </div>
        </div>
    </div>

    <!--Comments block-->
    <div class="articles__pagination">
        @include('articles.pagination', ['articles' => $comments])
    </div>
    <div class="articles__comments">
        <div class="comments__block">
            @if(isset($comments) && $comments->isNotEmpty())
                @foreach($comments as $comment)
                    <div class="comments__comment">
                        <div class="comment__author">
                            <p>{{$comment->user->nick}}</p>
                            <span>{{$comment->created_at}}</span>
                        </div>
                        <div class="comment__block">
                            <p>{{$comment->msg}}</p>
                        </div>
                        <div class="comment__admin">
                            @can('delete-comment')
                            <form action="/comments/{{$comment->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Del</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            @else
                <span>No have any comments</span>
            @endif
        </div>
        <div class="addComment">
            @auth
                <form action="/articles/{{$article->id}}/comments" method="POST" name="addComment">
                    @csrf
                    <textarea name="msg" minlength="3" maxlength="1024" required placeholder="min 3, max 1024 symbols">{{ old('msg') }}</textarea>
                    <button type="submit">Add</button>
                </form>
            @endauth
            @guest
                <p>Login to write comments</p>
            @endguest
        </div>
    </div>
@endsection
