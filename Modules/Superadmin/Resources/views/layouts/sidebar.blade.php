<div style="    box-shadow: 0 0 9px -5px">
    <div class="brand-logo d-flex align-items-center border-bottom justify-content-center">
      <a href="{{ route('admin.home') }}" class="text-nowrap logo-img text-center">
        <img height="100%" width="90" src="{{ asset(optional($settings->where('key','logo'))->first()->value ?? '' )}}" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <br>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        @if (auth()->user()->isAbleTo('admin_read-dashboard'))
        <li class="sidebar-item">
          <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.home') ? 'active':'' }}" href="{{ route('admin.home') }}" aria-expanded="false">
            <div>
                <img width="40px" src="{{ asset('icons/home.png') }}" alt="">
            </div>
            <div class="hide-menu main-color ">{{ __('lang.dashboard') }}</div>
          </a>
        </li>
        @endif
        @if (auth()->user()->isAbleTo('admin_read-products') || auth()->user()->isAbleTo('admin_read-brands') || auth()->user()->isAbleTo('admin_read-categories') || auth()->user()->isAbleTo('admin_read-subcategories')|| auth()->user()->isAbleTo('admin_read-colors')|| auth()->user()->isAbleTo('admin_read-sizes')|| auth()->user()->isAbleTo('admin_read-offers'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.product*')||request()->routeIs('admin.brand*') ||request()->routeIs('admin.category*')||request()->routeIs('admin.subcat*') ? 'active':'' }}" href="{{ route('admin.mainPageForProducts') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/cat.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.product_categories') }}</div>
            </a>
          </li>
        @endif
        @if (auth()->user()->isAbleTo('admin_read-orders'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{request()->routeIs('admin.order*') ? 'active':'' }}" href="{{ route('admin.order.index') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/order.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.orders') }} ({{ $orders_count }})</div>
            </a>
          </li>
          @endif
          @if (auth()->user()->isAbleTo('admin_read-todos'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{request()->routeIs('admin.todo*') ? 'active':'' }}" href="{{ route('admin.todo.index') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/task.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.todos') }}</div>
            </a>
          </li>
          @endif
        @if (auth()->user()->isAbleTo('admin_read-admins') || auth()->user()->isAbleTo('admin_read-roles'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.security')||request()->routeIs('admin.role.*')||request()->routeIs('admin.admin.*') ? 'active':'' }}" href="{{ route('admin.security') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/security.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.security') }}</div>
            </a>
          </li>
        @endif
        @if (auth()->user()->isAbleTo('admin_read-orders_report') || auth()->user()->isAbleTo('admin_read-products_report'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.PageOfReport') ? 'active':'' }}" href="{{ route('admin.PageOfReport') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/report.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.reports') }}</div>
            </a>
          </li>
        @endif
          @if (auth()->user()->isAbleTo('admin_read-about-us') || auth()->user()->isAbleTo('admin_read-sliders') || auth()->user()->isAbleTo('admin_read-features') )

          <li class="sidebar-item">
              <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.websiteSettings')||request()->routeIs('admin.slider.*') ||request()->routeIs('admin.about.*') ? 'active':'' }}" href="{{ route('admin.websiteSettings') }}" aria-expanded="false">
                <div>
                    <img width="40px" src="{{ asset('icons/site.png') }}" alt="">
                </div>
                <div class="hide-menu main-color ">{{ __('lang.website_settings') }}</div>
              </a>
            </li>
          @endif
        @if (auth()->user()->isAbleTo('admin_read-settings'))

        <li class="sidebar-item">
            <a class="sidebar-link main-color  p-1 {{ request()->routeIs('admin.GlobalSettings')||request()->routeIs('admin.city.*') ||request()->routeIs('admin.country.*') ||request()->routeIs('admin.level.*') ? 'active':'' }}" href="{{ route('admin.GlobalSettings') }}" aria-expanded="false">
              <div>
                  <img width="40px" src="{{ asset('icons/setting.png') }}" alt="">
              </div>
              <div class="hide-menu main-color ">{{ __('lang.settings') }}</div>
            </a>
          </li>
        @endif

      </ul>

    </nav>
    <!-- End Sidebar navigation -->
  </div>
