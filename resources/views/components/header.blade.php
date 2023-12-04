<header class="main_header_arae">
    <div class="topbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <ul class="topbar-list">
                        <li>
                            <a href="{{setting('facebook')}}" target="_blank"><i class="fab fa-facebook"></i></a>
                            <a href="{{setting('twitter')}}" target="_blank"><i class="fab fa-twitter-square"></i></a>
                            <a href="{{setting('instagram')}}" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="{{setting('linkedin')}}" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </li>
                        <li><a href="tel:{{setting('phone')}}"><span>{{setting('phone')}}</span></a></li>
                        <li><a href="mailto:{{setting('email')}}"><span>{{setting('email')}}</span></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6">
                    <ul class="topbar-others-options d-flex justify-content-end align-items-center">
                        @if($languages->count() > 0)
                            <li>
                                <div class="dropdown language-option">
                                    <button class="dropdown-toggle d-flex justify-content-center align-items-center"
                                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <img
                                            src="{{asset('storefront/assets/img/flags/'.strtoupper($current_language->code).'.svg')}}"
                                            style="margin-right: 10px">
                                        <span class="lang-name"> {{strtoupper($current_language->code)}}</span>
                                    </button>
                                    <div class="dropdown-menu language-dropdown-menu">
                                        @foreach($languages as $language)
                                            <a class="dropdown-item"
                                               href="{{route('changeLocale', [$language->code])}}">
                                                <img
                                                    src="{{asset('storefront/assets/img/flags/'.strtoupper($language->code).'.svg')}}">
                                                {{strtoupper($language->code)}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar Bar -->
    <div class="navbar-area">
        <div class="main-responsive-nav">
            <div class="container">
                <div class="main-responsive-menu">
                    <div class="logo">
                        <a href="{{route('home', $current_language->code)}}">
                            <img src="{{setting('site_light_logo_url')}}" style="width: 186px;"
                                 alt="{{__('site_name')}}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-navbar">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{route('home', $current_language->code)}}">
                        <img src="{{setting('site_light_logo_url')}}" style="width: 186px;" alt="{{__('site_name')}}">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            @foreach($top_menus as $menu)
                                <li class="nav-item">
                                    <a href="{{$menu->url}}"
                                       @if($menu->target_blank === 1)
                                           target="_blank"
                                       @endif class="nav-link {{"/".request()->path() === $menu->url ? 'active' : ''}}">
                                        {{$menu->title}}
                                        @if($menu->items->count())
                                            <i class="fas fa-angle-down"></i>
                                        @endif
                                    </a>
                                    @if($menu->items->count())
                                        <ul class="dropdown-menu">
                                            @foreach($menu->items as $submenu)
                                                <li class="nav-item">
                                                    <a href="{{$submenu->url}}"
                                                       @if($submenu->target_blank === 1)
                                                           target="_blank"
                                                       @endif
                                                       class="nav-link {{"/".request()->path() === $submenu->url ? 'active' : ''}}">
                                                        {{$submenu->title}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
