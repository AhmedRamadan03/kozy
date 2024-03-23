<div class="w3-light-gray p-3 w3-round-large">
    <ul class="w3-ul ">
       <li>
        <a href="{{ route('front.profile.index') }}" class="nav-link {{ request()->routeIs('front.profile.index') ? 'main-color' : 'text-muted' }}">
            {{ __('front.profile') }}
        </a>
       </li>

       <li>
            <a href="{{ route('front.profile.my-orders') }}" class="nav-link {{ request()->routeIs('front.profile.my-orders') ? 'main-color' : 'text-muted' }}">
                {{ __('front.my_orders') }}
            </a>
       </li>
       <li>
        <a href="{{ route('front.fav.index') }}" class="nav-link {{ request()->routeIs('front.fav.index') ? 'main-color' : 'text-muted' }}">{{ __('front.my_wishlist') }}</a>
       </li>

       <li>
        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
        class="nav-link text-muted" href="{{ route('front.logout') }}"> {{ __('front.logout') }} </a>
    <form id="logout-form" action="{{ route('front.logout') }}" method="POST"
        style="display: none;">
       @csrf
    </form>
       </li>
    </ul>
</div>
