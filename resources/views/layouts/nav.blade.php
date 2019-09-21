<nav class="navbar navbar-expand-md navbar-light navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
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
                <div class="w-400px">
                    @php
                        $_query = getQueryString(['s','p']);
                        $_url = "/?$_query";
                        $_s = ((isset($search) && $search) ? $search : ''); 
                    @endphp
                    <form method="get" action="{{ $_url }}"> 
                        <div class="input-group top-search">
                            {!! Form::text('s', $_s, array('placeholder' => _t('Search'),'autocomplete'=>'off','class' => 'form-control form-control')) !!}
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text lighten-3">
                                    <i class="fa fa-search text-grey" aria-hidden="true"></i>
                                </button>
                            </div>
                            @if(isset($c_id) && $c_id)
                            {!! Form::hidden('c', $c_id)!!}
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="dropdown dropdown-category">
                    <a id="categoriesDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ _t('All Categories') }}
                        @if(isset($category_name) and $category_name) 
                            <i class="fa fa-angle-right"></i>
                            {{ $category_name }}
                        @endif <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <ul class="menu-category">
                            @foreach(getCategories() as $_entity)
                            <li>
                                <span>{{ $_entity->name }}</span>
                                <ul class="sub-category">
                                    @php
                                        $_query = getQueryString(['c','p']);
                                    @endphp
                                    @foreach($_entity->sub_categories as $_item)
                                    <li>
                                        @php
                                            $_id = $_item->id;
                                            $_url = "/?$_query";
                                            if($_query){
                                                $_url .= '&';
                                            }
                                            $_url .= "c=$_id";
                                        @endphp
                                        <a href="{{ $_url }}">{{ $_item->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('home') }}">View All</a>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto menu-auth top-menu-right">
                @guest
                <li><a class="btn btn-primary btn-sm" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> {!! _t('Login') !!}</a></li>
                <li><a class="btn btn-primary btn-sm" href="{{ route('register') }}"><i class="fa fa-edit"></i> {!! _t('Register') !!}</a></li>
                
                @else
                    <li>
                        <a class="nav-link" href="{{ route('favorites.index') }}">
                            <i class="fa fa-heart"></i> {!! _t('Favorite') !!}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <div class="d-table">
                            <div class="d-table-row">
                                <div class="d-table-cell va-m">
                                    <i class="fa fa-user-circle fa-2x"></i>
                                </div>
                                <div class="d-table-cell va-m">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <i class="caret"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item">{{ _t('My Account') }}</a>
                                        
                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{ route('profile.change_password') }}">
                                            <i class="fa fa-fw fa-key"></i> {!! _t('Change Password') !!}
                                        </a>
                                        
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="fa fa-fw fa-user"></i> {!! _t('Profile') !!}
                                        </a>
                                        
                                        <div class="dropdown-divider"></div>
                                        
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-fw fa-sign-out"></i> {{ _t('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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