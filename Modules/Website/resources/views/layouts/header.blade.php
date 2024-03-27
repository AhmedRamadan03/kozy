  <!-- Topbar Start -->
    @auth

        @php
            $cart_count = App\Models\Cart::where('user_id',auth()->user()->id)->where('country_id',session('country')->id)->sum('quantity');
        @endphp
    @endauth
  <div class="container-fluid bg-white shadow text-dark py-2 px-0 d-none d-lg-block">
      <div class="container">
          <div class="d-flex justify-content-between align-items-center">
              <div class="item d-flex gap-3">
                  <div class=" nav-item dropdown">
                      <a class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                          <span class="text-dark">
                            <img src="{{ asset(session('country')->image) }}" width="30" height="30" alt="">
                            {{ session('country')->currency }}
                        </span>
                      </a>
                      <div class="dropdown-menu p-0" style="min-width: 225px;top:0px;z-index: 9999">
                         @foreach ($countrieH as $item)
                            <a class="dropdown-item w3-border-bottom p-3" href="{{ route('front.updateSession') }}?country_id={{ $item->id }}">
                                <i>
                                    <img src="{{ asset($item->image) }}" width="30" height="30" alt="">
                                    {{ $item->currency }}
                                </i>
                            </a>
                         @endforeach

                      </div>
                  </div>
                  <div class=" nav-item dropdown">
                      <a class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                          <span class="text-dark"> {{ App::getLocale() == 'en' ? 'EN' : 'AR' }} </span>
                      </a>
                      <div class="dropdown-menu p-0" style="min-width: 225px;top:0px;z-index: 9999">
                          <a class="dropdown-item w3-border-bottom p-3" href="{{ route('front.lang') }}?lang=en">
                              <i>English</i>
                          </a>
                          <a class="dropdown-item p-3" href="{{ route('front.lang') }}?lang=ar">
                              <i>العربية</i>
                          </a>
                      </div>
                  </div>
                  <div class="contacts">
                      <div class="w3-round-xxlarge bg-white p-2">
                          <b class="main-color">{{ __('front.need_help') }}</b> <b
                              class="text-dark">{{ __('front.call_us') }} : </b> <a class="main-color "
                              href="tel:{{ getSettingValue('phone') }}"><b>{{ getSettingValue('phone') }}</b></a>
                      </div>
                  </div>
              </div>

              <div class="item d-flex gap-3">
                  @if (auth()->check())
                      <div class="nav-item dropdown">
                          <a class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                              <b class="text-dark">
                                  {{ auth()->user()->name }}
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                      viewBox="0 0 24 24" fill="#000" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"
                                      class="feather feather-user feather-20">
                                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                      <circle cx="12" cy="7" r="4"></circle>
                                  </svg>
                              </b>
                          </a>
                          <div class="dropdown-menu p-2" style="min-width: 225px;top:0px;z-index: 9999">
                              <a class="dropdown-item" href="{{ route('front.profile.index') }}">{{ __('front.profile') }}
                                <svg
                                      xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                      <circle cx="12" cy="7" r="4"></circle>
                                  </svg></a>
                              <hr style="margin: 5px 0 !important">
                              <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                  class="dropdown-item" href="{{ route('front.logout') }}"> {{ __('front.logout') }} <svg
                                      xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                      <polyline points="16 17 21 12 16 7"></polyline>
                                      <line x1="21" y1="12" x2="9" y2="12"></line>
                                  </svg></a>
                              <form id="logout-form" action="{{ route('front.logout') }}" method="POST"
                                  style="display: none;">
                                 @csrf
                              </form>

                          </div>
                      </div>
                  @else
                      <a href="{{ route('front.login') }}" class="text-dark">
                          <b>
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 0C8.01109 0 7.04439 0.293245 6.22215 0.842652C5.3999 1.39206 4.75904 2.17295 4.3806 3.08658C4.00216 4.00021 3.90315 5.00555 4.09607 5.97545C4.289 6.94536 4.7652 7.83627 5.46447 8.53553C6.16373 9.2348 7.05464 9.711 8.02455 9.90393C8.99445 10.0969 9.99979 9.99784 10.9134 9.6194C11.827 9.24096 12.6079 8.6001 13.1573 7.77785C13.7068 6.95561 14 5.98891 14 5C14 3.67392 13.4732 2.40215 12.5355 1.46447C11.5979 0.526784 10.3261 0 9 0ZM9 8C8.40666 8 7.82664 7.82405 7.33329 7.49441C6.83994 7.16476 6.45542 6.69623 6.22836 6.14805C6.0013 5.59987 5.94189 4.99667 6.05764 4.41473C6.1734 3.83279 6.45912 3.29824 6.87868 2.87868C7.29824 2.45912 7.83279 2.1734 8.41473 2.05764C8.99667 1.94189 9.59987 2.0013 10.1481 2.22836C10.6962 2.45542 11.1648 2.83994 11.4944 3.33329C11.8241 3.82664 12 4.40666 12 5C12 5.79565 11.6839 6.55871 11.1213 7.12132C10.5587 7.68393 9.79565 8 9 8ZM18 19V18C18 16.1435 17.2625 14.363 15.9497 13.0503C14.637 11.7375 12.8565 11 11 11H7C5.14348 11 3.36301 11.7375 2.05025 13.0503C0.737498 14.363 0 16.1435 0 18V19H2V18C2 16.6739 2.52678 15.4021 3.46447 14.4645C4.40215 13.5268 5.67392 13 7 13H11C12.3261 13 13.5979 13.5268 14.5355 14.4645C15.4732 15.4021 16 16.6739 16 18V19H18Z" fill="#403F3F"/>
                                </svg>

                              {{ __('front.sign_in') }}
                          </b>
                      </a>
                  @endif
                  <span style="width: 1px; height: 25px; background-color: white"></span>
                  <a href="{{ route('front.fav.index') }}" class="text-dark">
                      <b>

                        <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.6328 4.64686C20.3187 3.91944 19.8657 3.26026 19.2992 2.70624C18.7323 2.15055 18.064 1.70895 17.3305 1.40546C16.5699 1.08948 15.7541 0.927753 14.9305 0.929674C13.775 0.929674 12.6477 1.24608 11.668 1.84374C11.4336 1.98671 11.2109 2.14374 11 2.31483C10.7891 2.14374 10.5664 1.98671 10.332 1.84374C9.35234 1.24608 8.225 0.929674 7.06953 0.929674C6.2375 0.929674 5.43125 1.08905 4.66953 1.40546C3.93359 1.71014 3.27031 2.14842 2.70078 2.70624C2.13357 3.25963 1.68047 3.91897 1.36719 4.64686C1.04141 5.40389 0.875 6.2078 0.875 7.03514C0.875 7.81561 1.03438 8.62889 1.35078 9.45624C1.61563 10.1476 1.99531 10.8648 2.48047 11.589C3.24922 12.7351 4.30625 13.9305 5.61875 15.1422C7.79375 17.1508 9.94766 18.5383 10.0391 18.5945L10.5945 18.9508C10.8406 19.1078 11.157 19.1078 11.4031 18.9508L11.9586 18.5945C12.05 18.5359 14.2016 17.1508 16.3789 15.1422C17.6914 13.9305 18.7484 12.7351 19.5172 11.589C20.0023 10.8648 20.3844 10.1476 20.6469 9.45624C20.9633 8.62889 21.1227 7.81561 21.1227 7.03514C21.125 6.2078 20.9586 5.40389 20.6328 4.64686ZM11 17.0969C11 17.0969 2.65625 11.7508 2.65625 7.03514C2.65625 4.64686 4.63203 2.71092 7.06953 2.71092C8.78281 2.71092 10.2688 3.66717 11 5.06405C11.7312 3.66717 13.2172 2.71092 14.9305 2.71092C17.368 2.71092 19.3438 4.64686 19.3438 7.03514C19.3438 11.7508 11 17.0969 11 17.0969Z" fill="#403F3F"/>
                            </svg>

                          {{ __('front.wishlist') }}
                      </b>
                  </a>
                  <span style="width: 1px; height: 25px; background-color: white"></span>

                  <a href="{{ route('front.cart.cart') }}" class="text-dark position-relative">
                      <b>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.57359 3.3144C3.37169 3.29679 3.16889 3.29198 2.96639 3.3H1.19999C0.961293 3.3 0.732374 3.20518 0.563592 3.0364C0.394809 2.86761 0.299988 2.63869 0.299988 2.4C0.299988 2.16131 0.394809 1.93239 0.563592 1.7636C0.732374 1.59482 0.961293 1.5 1.19999 1.5H3.02639C3.34559 1.5 3.59399 1.5 3.82199 1.5312C4.47333 1.62232 5.08259 1.90599 5.57158 2.34581C6.06057 2.78562 6.40699 3.36152 6.56639 3.9996L19.6224 5.8428L19.7436 5.8596C20.3856 5.9496 20.8824 6.0192 21.2916 6.1956C21.8398 6.43236 22.3135 6.81345 22.6622 7.29823C23.0109 7.78302 23.2215 8.35334 23.2716 8.9484C23.31 9.3936 23.2188 9.8856 23.1 10.524L23.0772 10.644L23.0568 10.7568C22.9068 11.5704 22.8036 12.1284 22.5936 12.606C22.313 13.2462 21.8871 13.8123 21.3497 14.2592C20.8123 14.7062 20.1782 15.0219 19.4976 15.1812C18.99 15.3012 18.4224 15.3012 17.5944 15.3H8.46959C8.51639 15.5472 8.56079 15.7548 8.60999 15.9348C8.71079 16.308 8.80799 16.4796 8.90999 16.5936C9.00599 16.7024 9.11519 16.7952 9.23759 16.872C9.36719 16.9524 9.55199 17.0208 9.93719 17.0592C10.3392 17.0988 10.8636 17.1 11.6496 17.1H20.7996C21.0383 17.1 21.2672 17.1948 21.436 17.3636C21.6048 17.5324 21.6996 17.7613 21.6996 18C21.6996 18.2387 21.6048 18.4676 21.436 18.6364C21.2672 18.8052 21.0383 18.9 20.7996 18.9H11.6052C10.8744 18.9 10.2612 18.9 9.75839 18.8496C9.22919 18.7968 8.73839 18.6816 8.28239 18.3984C8.01433 18.2294 7.77153 18.0234 7.56119 17.7864C7.20599 17.3844 7.01159 16.9188 6.87239 16.4064C6.74039 15.918 6.63959 15.312 6.51959 14.5908L4.91159 4.9476C4.84559 4.5468 4.82519 4.4364 4.79879 4.3524C4.71393 4.08106 4.5537 3.83942 4.33678 3.65564C4.11986 3.47187 3.85518 3.35352 3.57359 3.3144ZM8.16239 13.5H17.4792C18.4668 13.5 18.8088 13.494 19.0872 13.428C19.4955 13.3325 19.8759 13.1432 20.1983 12.8751C20.5208 12.6071 20.7763 12.2676 20.9448 11.8836C21.06 11.622 21.1284 11.286 21.3072 10.3152C21.4584 9.5004 21.4932 9.2712 21.4788 9.0996C21.4559 8.82927 21.3601 8.57022 21.2016 8.35003C21.0431 8.12984 20.8279 7.95675 20.5788 7.8492C20.4216 7.7808 20.1924 7.7412 19.3716 7.6248L6.88799 5.8632L8.16239 13.5Z" fill="#403F3F"/>
                            <path d="M21.6 22.2C21.6 22.6774 21.4104 23.1352 21.0728 23.4728C20.7352 23.8104 20.2774 24 19.8 24C19.3226 24 18.8648 23.8104 18.5272 23.4728C18.1897 23.1352 18 22.6774 18 22.2C18 21.7226 18.1897 21.2648 18.5272 20.9272C18.8648 20.5896 19.3226 20.4 19.8 20.4C20.2774 20.4 20.7352 20.5896 21.0728 20.9272C21.4104 21.2648 21.6 21.7226 21.6 22.2ZM10.8 22.2C10.8 22.6774 10.6104 23.1352 10.2728 23.4728C9.93524 23.8104 9.4774 24 9.00001 24C8.52262 24 8.06479 23.8104 7.72722 23.4728C7.38965 23.1352 7.20001 22.6774 7.20001 22.2C7.20001 21.7226 7.38965 21.2648 7.72722 20.9272C8.06479 20.5896 8.52262 20.4 9.00001 20.4C9.4774 20.4 9.93524 20.5896 10.2728 20.9272C10.6104 21.2648 10.8 21.7226 10.8 22.2Z" fill="#403F3F"/>
                            </svg>



                          {{ __('front.cart') }}
                      </b>
                      <span class="position-absolute cart--count top-0 start-100 translate-middle badge rounded-pill bg-warning">{{ $cart_count??0 }}</span>
                  </a>

              </div>
          </div>
      </div>
  </div>
  <!-- Topbar End -->


  <!-- Navbar Start -->
  <div class="  mt-3 container">
      <div class="" style="    background-color: #F1F4F8;
      position: relative;
      z-index: 99;
      border-radius: 10px;
      padding: 0 10px;">
          <nav class="navbar navbar-expand-lg  sticky-top " >
              {{-- <div class="d-flex gap-2 justify-content-between align-items-center"> --}}
              <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                  data-bs-target="#navbarCollapse">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                  <h1 class="m-0"><img class="img-fluid me-3" style="width: 155px;height: 50px" height="74"
                          src="{{ asset(getSettingValue('logo')) }}" alt=""></h1>
              </a>


              {{-- </div> --}}
              <div class="collapse navbar-collapse" id="navbarCollapse">
                  <div class="navbar-nav mx-auto align-items-center rounded pe-4 py-3 py-lg-0">
                      <a href="{{ url('/') }}"
                          class="nav-item nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}">{{ __('front.home') }}</a>

                      <a href="{{ route('front.categories') }}"
                          class="nav-item nav-link {{ request()->routeIs('front.categories') ? 'active  ' : '' }}">{{ __('front.categories') }}</a>

                      <a href="{{ route('front.about-us') }}"
                          class="nav-link {{ request()->routeIs('front.about-us*') ? 'active' : '' }}">{{ __('front.about') }}</a>



                      <a href="{{ route('front.contact-us') }}"
                          class="nav-item nav-link {{ request()->routeIs('front.contact-us') ? 'active' : '' }}">{{ __('front.contact') }}</a>

                      @if (isMobile())
                          <div class=" nav-item dropdown">
                              <a class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                                  <span class=""> {{ App::getLocale() == 'en' ? 'EN' : 'AR' }} </span>
                              </a>
                              <div class="dropdown-menu p-0" style="min-width: 225px">
                                  <a class="dropdown-item w3-border-bottom p-3"
                                      href="{{ route('front.lang') }}?lang=en">
                                      <i>English</i>
                                  </a>
                                  <a class="dropdown-item p-3" href="{{ route('front.lang') }}?lang=ar">
                                      <i>العربية</i>
                                  </a>
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
              <div class="d-flex  gap-4">
                  <form action="{{ route('front.categories') }}" class="m-0">
                      <input type="hidden" name="_token" value="rnB7G02NZgDJkzAEpaDqqylQ3wy8IF0lyFHiCt5N">
                      <div class="input-group " style="direction: ltr">
                          <input type="text" name="search" value="{{ request('search') }}" class="form-control  w3-round-xlarge" placeholder=""
                              aria-label="Example text with button addon" aria-describedby="button-addon1">
                          <div class="input-group-apppend">
                              <button class="btn  border  bg-main" style="border-radius:  0px 20px  20px 0px"
                                  type="submit" id="button-addon1">
                                  <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path
                                          d="M17 17.1304L21 21.1304M3 11.1304C3 13.2521 3.84285 15.2869 5.34315 16.7872C6.84344 18.2875 8.87827 19.1304 11 19.1304C13.1217 19.1304 15.1566 18.2875 16.6569 16.7872C18.1571 15.2869 19 13.2521 19 11.1304C19 9.00864 18.1571 6.97381 16.6569 5.47352C15.1566 3.97323 13.1217 3.13037 11 3.13037C8.87827 3.13037 6.84344 3.97323 5.34315 5.47352C3.84285 6.97381 3 9.00864 3 11.1304Z"
                                          stroke="white" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                  </svg>

                              </button>
                          </div>
                      </div>
                  </form>
              </div>

          </nav>
      </div>
  </div>
  <!-- Navbar End -->
