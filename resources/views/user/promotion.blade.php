@extends('layout')

@section('title', 'Promotion page')

@section('center')
    <div class='articles__info'>
        <h2>Promotion info</h2>
        <p>To increase your user's rank you should release articles that will be approved by administration group. <br/>
            <b>Requirement:</b><br/>
            <i>Moderator:</i> 3 approved article.<br/>
            <i>Administrator:</i> 5 approved article.<br/>
            Since you'll reach neccessary amounts - button for rank up will be appeared. 
        </p>
        <div class='articles__stats'>
            <p><b>Approved:</b> {{ $approvedCounter ?? 0 }}</p>
            <p><b>Declined:</b> {{ $declinedCounter ?? 0 }}</p>
            <p><b>On moderation:</b> {{ $onModCounter ?? 0 }}</p>

            <div class="articles__status">
                <span style="color:{{ $canPromote ? 'green' : 'red' }}">{{$msg}}</span>
            </div>
            <!--promotion button-->
            @if($canPromote)
            <form action="/user/promotion" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Get promotion</button>
            </form>
            @endif
        </div>
    </div>
@endsection