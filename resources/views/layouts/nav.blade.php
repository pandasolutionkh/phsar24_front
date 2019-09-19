<nav class="navbar navbar-expand-md navbar-light navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <span class="logo-table">
                <span class="logo-row">
                    <span class="logo-cell text-center">
                        <img width="150" src="/img/logo.png" alt="Globalive"/>
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
                <div class="input-group w-400px top-search">
                    {!! Form::text('search', '', array('placeholder' => 'Search','autocomplete'=>'off','class' => 'form-control form-control')) !!}
                    <div class="input-group-append">
                        <span class="input-group-text lighten-3">
                            <i class="fa fa-search text-grey" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto menu-auth top-menu-right">
                @guest
                <li><a class="btn btn-primary btn-sm" href="{{ route('register') }}"><i class="fa fa-edit"></i> {!! _t('Register') !!}</a></li>
                <li><a class="btn btn-primary btn-sm" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> {!! _t('Login') !!}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item">My Account</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile.change_password') }}">
                                <i class="fa fa-fw fa-key"></i> {!! _t('Change Password') !!}
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fa fa-fw fa-user"></i> {!! _t('Profile') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-sign-out"></i> {{ _t('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>