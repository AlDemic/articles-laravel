@if(isset($articles) && $articles->isNotEmpty())
    @foreach($articles as $article)
        <div class="articles__article">
            <h3><b>Title:</b> {{$article->title}}</h3>
            <p><b>Category:</b> {{$article->category->title}}</p>
            <p><b>Short description:</b> {{$article->short_desc}}</p>
            <div class="article__additional">
                <div class="author_block">
                    <small>Article id: {{$article->id}}</small>
                    <small>Author nick: {{$article->user->nick}}</small>
                    <small>Added: {{$article->created_at}}</small>
                </div>
                <a href="/articles/{{$article->id}}" class="read-full-btn">Read full</a>
            </div>
        </div>
    @endforeach
    <!--pagination block-->
    @include('articles.pagination')
@else
    <div class="articles__article">
        <b>No have any article</b> 
    </div>
@endif