@extends('layout')

@section('title', 'Admin panel - moderation')

@section('center')
    <h3>Articles on moderation:</h2>
    <div class='articles__filters'>
        <select onchange="window.location.href=this.value">
            <option value="{{request()->url()}}">All</option>
            <option value="?filter=canMod" {{ $filter === 'canMod' ? 'selected' : ''}}>Can moderate</option>
            <option value="?filter=doneMod" {{ $filter === 'doneMod' ? 'selected' : ''}}>Moderated</option>
            <option value="?filter=declined" {{ $filter === 'declined' ? 'selected' : ''}}>Declined</option>
        </select>
    </div>
    <div class='articles__info'>
        <h4>Votes info:</h3>
        <span><b>Approved article:</b> Sum >= 10 point <br/> <b>Declined article:</b> Sum <= -5 point
        <br/>
        <i>Sum = appr + decl (points)</i>
        </span>
        <span>
            <p>Each rank has his own points for appr/decl:</p>
            Moderator: +-3 <br/>
            Administrator: +-5
        </span>
    </div>
    <div class="articles__block">
        @if(isset($articles) && $articles->isNotEmpty())
            @foreach($articles as $article)
                <div class="articles__article">
                    <h3><b>Title:</b> {{$article->title}}</h3>
                    <p><b>Category: </b> {{$article->category->title}}</p>
                    <p><b>Short description:</b> {{$article->short_desc}}</p>
                    <p><b>Full description:</b> {{$article->full_desc}}</p>
                    <div class="article__additional">
                        <div class="author_block">
                            <small>Article id: {{$article->id}}</small>
                            <small>Author nick: {{$article->user->nick}}</small>
                            <small>Added: {{$article->created_at}}</small>
                        </div>
                    </div>
                    <div class="votes_block">
                        <p>Votes: <span style="color: green">{{$article->approvedVotes ?? 0}}</span> / <span style="color: red">{{$article->declinedVotes ?? 0}}</span></p>
                        <p>Sum: {{$article->sumVotes ?? 0}}</p>
                    </div>
                    <div class="mod_block">
                        @if($article->canVote || $article->user_id === auth()->user()->id || $filter === 'declined')
                            You can't moderate this article
                        @else
                            <form method="POST" action="/admin/api/articles/approve/{{$article->id}}" style="display:inline;">
                                @csrf
                                <button type="submit" class="approve">Approve</button>
                            </form>
                            /
                            <form method="POST" action="/admin/api/articles/decline/{{$article->id}}" style="display:inline;">
                                @csrf
                                <button type="submit" class="decline">Decline</button>
                            </form>
                        @endif
                    </div>
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