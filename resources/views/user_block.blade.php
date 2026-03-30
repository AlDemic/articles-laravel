<div class="user__avatar">
    <img src="/storage/{{ auth()->user()->avatar ?? 'avatars/user.png' }}" width="48" height="48" alt="User avatar"/>
    <a href="/user/avatar"><img src="/storage/avatars/arrows.png" alt="Change avatar" /></a>
</div>
@auth
    <div class="user__menu">
        <h3>Hello, {{auth()->user()->nick}}!</h2>   
        <h4>That's main info about you:</h3>
        <p>id: {{auth()->user()->id}} </p>
        <p>email:  {{auth()->user()->email}}</p>
        <p>rank: {{auth()->user()->rank->title}} </p>
        <a href='/user/articles/suggest' class="btn-primary">Suggest article</a>
        <a href='/user/articles/own'>My articles</a>
        <a href='/user/promotion'>Promotion panel</a>
                
        <a href='/admin'>Admin panel</a>
            
        <a href='/user/logout'>Log out</a>
    </div>
@endauth

@guest
    <h3>Hello, guest!</h2>  
    <div class="user__login-btns">
        <a href='/user/login' class="btn-primary">Log in</a>
        <a href='/user/reg' class="btn-secondary">Registration</a>
    </div>
@endguest