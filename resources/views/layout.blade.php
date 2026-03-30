<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles / Scripts -->
        @vite('resources/css/styles.css')
    </head>
    <body>
        <div class="layout">
            <header>
                <h1><a href='/'>Articles Project</a></h1>
            </header>
            <main class="main">
                <section class='categories'>
                    <form action="/articles" method="GET">
                        <input type="text" name="search" minlength="2" placeholder="Search content" value="{{ old('search') }}">
                        <button type="submit"><img src="/storage/search.png" alt="Search" /></button>
                    </form>
                    @if(isset($categories) && $categories->isNotEmpty())
                        <ul class='categories__list'>
                            <a href="/"><li>All</li></a>
                            @foreach($categories as $category)
                                <a href="/cat/{{ $category->url }}"><li>{{ $category->title }}</li></a>
                            @endforeach
                        </ul>
                    @else
                        <span>No have any category in db</span>
                    @endif
                </section>   
                <!--center block with articles-->
                <div class='articles'>
                    <div class="msg-info">
                        @if(session('msg'))
                            <span style="color: green">{{ session('msg') }}</span>
                        @elseif($errors->any())
                            <span style="color: red">{{ $errors->first() }}</span>
                        @elseif(session('error')) 
                            <span style="color: red">{{ session('error') }}</span>
                        @endif
                    </div>
                    @yield('center')
                </div>
                <!--user block(right sidebar)-->
                <section class='user'>
                    @include('user_block')
                </section>
        </main>
        </div>
    
    @yield('scripts')
    </body>
</html>