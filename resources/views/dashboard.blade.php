<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    @vite(['resources/css/app.css'])
</head>

<body class="font-sans">
    <!-- Navigation Start -->
    <nav id="navbar-main" class="navbar is-fixed-top">
        <div class="navbar-brand">
            <a class="navbar-item mobile-aside-button">
                <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
            </a>
            <div class="navbar-item lg:ml-4">
                <span class="font-semibold">Dashboard</span>
            </div>
        </div>
        <div class="navbar-brand is-right">
            <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
                <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
            </a>
        </div>
        <div class="navbar-menu" id="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item dropdown has-divider has-user-avatar lg:min-w-[8rem]">
                    <a class="navbar-link">
                        <div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
                        <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
                    </a>
                    <div class="navbar-dropdown">
                        <a href="{{ route('profile.edit') }}" class="navbar-item">
                            <span class="icon"><i class="mdi mdi-account"></i></span>
                            <span>My Profile</span>
                        </a>
                        <hr class="navbar-divider">
                        <form method="POST" action="{{ route('logout') }}" class="navbar-item">
                          @csrf
                          <button title="Log out" class="" type="submit">
                            <span class="icon"><i class="mdi mdi-logout"></i></span>
                            <span>Log out</span>
                          </button>
                        </form>
                    </div>
                </div>
{{-- 
                <form method="POST" action="{{ route('logout') }}" class="navbar-item desktop-icon-only">
                  
                </form> --}}
            </div>
        </div>
    </nav>
    <!-- Navigation End -->

    <!-- Menu Start -->
    <aside class="aside is-placed-left is-expanded">
        <div class="aside-tools">
            <div>
                Admin <b class="font-black">{{ Auth::user()->name }}</b>
            </div>
        </div>
        <div class="menu is-menu-main">
            <!-- <p class="menu-label">General</p> -->
            <ul class="menu-list">
                <li class="{{ request()->RouteIs('companies.index') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}">
                        <span class="icon"><i class="mdi mdi-city"></i></span>
                        <span class="menu-item-label">Companies</span>
                    </a>
                </li>
                <li class="{{ request()->RouteIs('employees.index') ? 'active' : '' }}">
                    <a href="{{ route('employees.index') }}">
                        <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                        <span class="menu-item-label">Employees</span>
                    </a>
                </li>
            </ul>
            {{-- <p class="menu-label">Examples</p>
      <ul class="menu-list">
        <li class="--set-active-tables-html">
          <a href="tables.html">
            <span class="icon"><i class="mdi mdi-table"></i></span>
            <span class="menu-item-label">Tables</span>
          </a>
        </li>
        <li class="--set-active-forms-html">
          <a href="forms.html">
            <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
            <span class="menu-item-label">Forms</span>
          </a>
        </li>
        <li class="--set-active-profile-html">
          <a href="profile.html">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            <span class="menu-item-label">Profile</span>
          </a>
        </li>
        <li>
          <a href="login.html">
            <span class="icon"><i class="mdi mdi-lock"></i></span>
            <span class="menu-item-label">Login</span>
          </a>
        </li>
        <li>
          <a class="dropdown">
            <span class="icon"><i class="mdi mdi-view-list"></i></span>
            <span class="menu-item-label">Submenus</span>
            <span class="icon"><i class="mdi mdi-plus"></i></span>
          </a>
          <ul>
            <li>
              <a href="#void">
                <span>Sub-item One</span>
              </a>
            </li>
            <li>
              <a href="#void">
                <span>Sub-item Two</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <p class="menu-label">About</p>
      <ul class="menu-list">
        <li>
          <a href="https://justboil.me/tailwind-admin-templates/free-dashboard/" class="has-icon">
            <span class="icon"><i class="mdi mdi-help-circle"></i></span>
            <span class="menu-item-label">About</span>
          </a>
        </li>
        <li>
          <a href="https://github.com/justboil/admin-one-tailwind" class="has-icon">
            <span class="icon"><i class="mdi mdi-github-circle"></i></span>
            <span class="menu-item-label">GitHub</span>
          </a>
        </li>
      </ul> --}}
        </div>
    </aside>
    <!-- Menu End -->

    {{-- <section class="section main-section"> --}}
        @yield('content')
    {{-- </section> --}}

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css">
    {{-- <script type="text/javascript" src="js/main.min.js?v=1652870200386"></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
