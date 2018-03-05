<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topMenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="@yield('brandUrl')" class="brand navbar-brand">@yield('brandName')</a>
        </div>
        <div class="collapse navbar-collapse" id="topMenu">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="btn btn-sm" href="#" data-toggle="dropdown">
                        @yield('dropdownHeader')
                    </a>
                    <ul class="dropdown-menu">
                        @yield('dropdownItems')
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-@yield('navbarAlign','left')">
                @yield('navMenu')
            </ul>
        </div>
    </div>
</nav>