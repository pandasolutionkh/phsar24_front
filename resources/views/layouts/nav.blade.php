<nav class="navbar navbar-expand-md navbar-light navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url(getLang()) }}">
            <span class="logo-table">
                <span class="logo-row">
                    <span class="logo-cell text-center">
                        <img width="150" src="/img/logo.png?v=1.0.6" alt="ផ្សារ២៤"/>
                    </span>
                </span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <div class="navbar-nav ml-auto">
                <div class="w-45vw">
                    @php
                        $_query = getQueryString(['s','p']);
                        $_url = "/";
                        
                        if(isset($category_slug)){
                            $_url = route('categories.index',['locale'=>getLang(),'slug'=>$category_slug]);
                        }
                        
                        if(isset($sub_category_slug)){
                            $_url = route('categories.sub',['locale'=>getLang(),'category_slug'=>$category_slug,'sub_category_slug'=>$sub_category_slug]);
                        }

                        $_url .= "?$_query";
                        $_s = ((isset($search) && $search) ? $search : ''); 
                    @endphp
                    <form method="get" action="{{ $_url }}"> 
                        <div class="top-search input-group">
                            {!! Form::text('s', $_s, array('placeholder' => __('Search'),'autocomplete'=>'off','class' => 'form-control form-control')) !!}
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <div class="dropdown dropdown-category">
                                        <a id="categoriesDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ __('All Categories') }}
                                            @if(isset($category_name) and $category_name) 
                                                <i class="fa fa-angle-right"></i>
                                                {{ $category_name }}
                                            @endif <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="categoriesDropdown">
                                            <ul class="menu-category">
                                                @foreach(getCategories() as $_entity)
                                                <li>
                                                    <a href="{{ route('categories.index',['locale'=>getLang(),'slug'=>$_entity->slug]) }}">{{ $_entity->name }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <div class="text-center">
                                                <a href="{{ route('home',getLang()) }}">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <button type="submit" class="btn input-group-text">
                                    <i class="fa fa-search text-grey" aria-hidden="true"></i>
                                </button>
                            </div>
                            @if(isset($c_id) && $c_id)
                            {!! Form::hidden('c', $c_id)!!}
                            @endif
                        </div>
                    </form>
                </div>
                
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto menu-auth top-menu-right">
                <li>
                    <a class="btn btn-secondary btn-sm" href="{{ changeLanguage() }}">
                        {{ __(getFullLanguage()) }}
                    </a>
                </li>
                @guest
                <li>
                    <a class="nav-link px-1" href="{{ route('login',getLang()) }}">
                        <i class="fa fa-sign-in"></i> {!! __('Login') !!}
                    </a>
                </li>
                <li><span class="nav-link disabled pl-0 pr-0">Or</span></li>
                <li>
                    <a class="nav-link px-1" href="{{ route('register',getLang()) }}">
                        <i class="fa fa-user"></i> {!! __('Register') !!}
                    </a>
                </li>

                <li>
                    <a class="btn btn-primary btn-sm" href="{{ route('products.create',getLang()) }}">
                        <i class="fa fa-edit"></i> {!! __('Post Product') !!}
                    </a>
                </li>
                
                @else
                    <li>
                        <a class="btn btn-primary btn-sm" href="{{ route('products.create',getLang()) }}">
                            <i class="fa fa-edit"></i> {!! __('Post Product') !!}
                        </a>
                    </li>
                    <li class="nav-item dropdown profile">
                        <div class="d-table">
                            <div class="d-table-row">
                                <div class="d-table-cell va-m">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        @php
                                        $_src = asset('images/profile.jpg');
                                        if($_photo = Auth::user()->photo){
                                            $_src = getUrlStorage("profiles/$_photo");
                                        }
                                        @endphp
                                        <img class="img-profile" src="{{ $_src }}" alt="" width="31" height="31" /> 
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right py-1 animate slideIn" aria-labelledby="navbarDropdown">
                                        <div class="dropdown-item">{{ __('Selling') }}</div>
                                        
                                        <div class="dropdown-divider my-1"></div>

                                        <a class="dropdown-item" href="{{ route('products.index',getLang()) }}">
                                            <i class="fa fa-fw fa-tag"></i> {!! __('Product') !!}
                                        </a>
                                        <div class="dropdown-divider my-1"></div>
                                        
                                        <div class="dropdown-item">{{ __('Buying') }}</div>
                                        
                                        <div class="dropdown-divider my-1"></div>

                                        <a class="dropdown-item" href="{{ route('favorites.index',getLang()) }}">
                                            <i class="fa fa-fw fa-heart-o"></i> {!! __('Favorite') !!}
                                        </a>
                                        <div class="dropdown-divider my-1"></div>

                                        <div class="dropdown-item">{{ __('My Account') }}</div>
                                        
                                        <div class="dropdown-divider my-1"></div>

                                        <a class="dropdown-item" href="{{ route('profile.index',getLang()) }}">
                                            <i class="fa fa-fw fa-user"></i> {!! __('Profile') !!}
                                        </a>
                                        
                                        <a class="dropdown-item" href="{{ route('profile.change_password',getLang()) }}">
                                            <i class="fa fa-fw fa-key"></i> {!! __('Change Password') !!}
                                        </a>
                                        
                                        <a class="dropdown-item" href="{{ route('profile.contact',getLang()) }}">
                                            <i class="fa fa-fw fa-phone"></i> {!! __('Contact Detail') !!}
                                        </a>

                                        <div class="dropdown-divider my-1"></div>
                                        
                                        <a class="dropdown-item" href="{{ route('logout',getLang()) }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-fw fa-sign-out"></i> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout',getLang()) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>