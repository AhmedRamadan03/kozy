<header class="app-header" style="box-shadow: 0 0 9px -5px">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row m{{ isRtl()?'e':'s' }}-auto align-items-center justify-content-end">

            <li class="nav-item dropdown">
                <div class="translate_wrapper">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop-lang" data-bs-toggle="dropdown"
                    aria-expanded="false">
                            <div class="lang"><i class="flag-icon flag-icon-{{ App::getLocale() == 'en'? 'us' : 'sa' }}"></i>
                           <span class="lang-txt">{{ App::getLocale() }} </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop-lang">

                        <div class="message-body">
                             <a href="{{ route('admin.lang', '' )}}?lang=en" class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                            <div class="lang {{ (App::getLocale()  == 'en') ? 'selected' : ''}}" data-value="en"><i class="flag-icon flag-icon-us"></i> <span class="lang-txt">English</span><span> (US)</span></div>
                        </a>
                        <a href="{{ route('admin.lang' , '' )}}?lang=ar" class="{{ (App::getLocale()  == 'ar') ? 'active' : ''}}">
                            <div class="lang {{ (App::getLocale()  == 'ar') ? 'selected' : ''}}" data-value="ar"><i class="flag-icon flag-icon-sa"></i> <span class="lang-txt">العربية</span> <span> (AR)</span></div>
                        </a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{asset(auth('admin')->user()->image)}}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                    <a href="{{ route('admin.profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">{{ __('lang.profile') }}</p>
                    </a>

                    {{-- <a href="./authentication-login.html" >Logout</a> --}}
                    <a class="btn btn-outline-primary mx-3 mt-2 d-block" href="{{ url('admin-panel/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">  {{ __('lang.logout') }}</a>
                    <form id="logout-form" action="{{ url('admin-panel/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                </div>
            </li>
        </ul>
      </div>
    </nav>
  </header>
