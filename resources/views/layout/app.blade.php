<html>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


<!------ Include the above in your HEAD tag ---------->
<style>
    h1.page-header {
        margin-top: -5px;
    }
    .sidebar {
        padding-left: 0;
    }
    .main-container {
        background: #FFF;
        padding-top: 15px;
        margin-top: -20px;
    }
    .footer {
        width: 100%;
    }
    .hide{
        display: none;
    }
</style>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">
                IMDb
            </a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                @if(auth()->user())
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <b> {{auth()->user()->username}} </b>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid main-container">
    <div class="col-md-2 sidebar">
        <ul class="nav nav-pills nav-stacked">
            <li class=" @if( Request::segment(1) === 'login' || Request::segment(1) === 'register' || Request::segment(1) === 'forgot-password' || Request::segment(1) === 'reset-password')   active  @endif"><a href="{{ route('get-login') }}">Login/Register</a></li>
            <li class="{{ Request::segment(1) === 'home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
            <li class="{{ Request::segment(1) === 'movies' ? 'active' : '' }}"><a href="{{ route('get-movies') }}">Movies</a></li>
            <li class="{{ Request::segment(1) === 'actors' ? 'active' : '' }}"><a href="{{ route('get-actors') }}">Actors</a></li>
        </ul>
    </div>
    <div class="col-md-10 content">
        @yield('content')
    </div>
    <footer class="pull-left footer">
        <p class="col-md-12">
        <hr class="divider">
        Copyright &COPY; 2021 <a href="#">IMDb</a>
        </p>
    </footer>
</div>

@yield('scripts')

</html>