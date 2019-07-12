<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="{{route('frontend.index')}}" class="navbar-brand"><img src="{{asset('images/logo.png')}}" alt="ConneXuz" /></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="menu-tile">Menu</span>
                <span class="icon-bar top-bar"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! script('js/jquery-3.3.1.min.js') !!}
                
                {{-- html()->form('POST', route('frontend.index'))->class('col-md-4')->id('posts_search_header')->open() --}}
                <input class="form-control mr-sm-2 col-md-4 posts_search_header" type="search" name="posts_search_header" placeholder="Search My Post" value="" aria-label="Search" autocomplete="off">
                <a class="mypost_reset btn btn-sm" style="color:blue; float: right; display: none;"  >Reset</a>
                {{-- html()->form()->close() --}}
                
                <ul class="navbar-nav">
                    @auth
                        {{-- Interactions --}}
                        <li class="nav-item"><a href="{{route('frontend.index')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.index')) }}">@lang('navs.frontend.menu.interactions')</a></li>

                        {{-- Profile --}}
                        <li class="nav-item"><a href="{{route('frontend.user.account')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.account')) }}">@lang('navs.frontend.menu.profile')</a></li>

                        {{-- Networks --}}
                        <li class="nav-item"><a href="{{route('frontend.network.list')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.network.list')) }}">@lang('navs.frontend.menu.networks')</a></li>

                        {{-- Settings --}}
                        <li class="nav-item"><a href="{{route('frontend.user.settings')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.user.settings')) }}">@lang('navs.frontend.menu.settings')</a></li>

                        {{-- Help --}}
                        <li class="nav-item"><a href="{{route('frontend.help.list')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.help.list')) }}">@lang('navs.frontend.menu.help')</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$logged_in_user->first_name}}<i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu">
                                @if(auth()->user()->can('view backend'))
                                    <a href="{{route('admin.dashboard')}}" class="dropdown-item">Admin Dashboard</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a href="{{route('frontend.user.account')}}" class="dropdown-item">@lang('navs.frontend.menu.profile')</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('frontend.auth.logout')}}">Logout</a>
                            </div>
                        </li>

                    @endauth

                    @guest
                        <li class="nav-item"><a href="{{route('frontend.auth.login')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.login')) }}">@lang('navs.frontend.login')</a></li>

                        @if(config('access.registration'))
                            <li class="nav-item"><a href="{{route('frontend.auth.register')}}" class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">@lang('navs.frontend.register')</a></li>
                        @endif
                    @endguest

                </ul>
            </div>
        </div>
    </nav>
</header>
