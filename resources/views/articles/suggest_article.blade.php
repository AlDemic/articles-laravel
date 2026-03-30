@extends('layout')

@section('title', 'User - suggest article')

@section('center')
    <h3>Create article:</h2>
    <form action="/user/articles/suggest" method="POST" id="suggest-article">
        @csrf
        <label>
            <b>Title(min 5 / max 128):</b><br/>
            <input type="text" name="title" minlength="5" maxlength="128" value="{{ old('title') }}" required>
        </label>
        <br/>
        <label>
            <b>Category:</b><br/>
            @if(isset($categories) && $categories->isNotEmpty())
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>      
            @else
                <b>No have any category in db</b>
            @endif      
        </label>
        <br/>
        <label>
            <b>Short description(max - 255):</b><br/>
            <textarea name="short_desc" rows="5" cols="33" maxlength="255" value="{{ old('short_desc') }}" placeholder="If empty - auto generation(takes first 255 symbols from full description"></textarea>
        </label>
        <br/>
        <label>
            <b>Full description(min - 100, max - 2025):</b><br/>
            <textarea name="full_desc" rows="5" cols="33" minlength="100" maxlength="2025" value="{{ old('full_desc') }}" placeholder="Full text of article"></textarea>
        </label>
        <br/>
        <button type='submit' class="article-suggest-btn">Suggest</button>
    </form>
@endsection
