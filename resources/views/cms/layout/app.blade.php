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
                IMDb Admin Panel
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
{{--            <form class="navbar-form navbar-left" method="GET" role="search">--}}
{{--                <div class="form-group">--}}
{{--                    <input type="text" name="q" class="form-control" placeholder="Search">--}}
{{--                </div>--}}
{{--                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>--}}
{{--            </form>--}}
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                       <b> {{auth()->user()->username}} </b>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
{{--                        <li class=""><a href="#">Other Link</a></li>--}}
{{--                        <li class=""><a href="#">Other Link</a></li>--}}

                        <li><a href="{{ route('cms-logout') }}">Logout</a></li>
                    </ul>
                </li>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid main-container">
    <div class="col-md-2 sidebar">
        <ul class="nav nav-pills nav-stacked">
            <li class="{{ Request::segment(2) === 'home' ? 'active' : '' }}"><a href="{{ route('cms-home') }}">Home</a></li>
            <li class="{{ Request::segment(2) === 'movies' ? 'active' : '' }}"><a href="{{ route('movies.index') }}">Movies</a></li>
            <li class="{{ Request::segment(2) === 'categories' ? 'active' : '' }}"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="{{ Request::segment(2) === 'actors' ? 'active' : '' }}"><a href="{{ route('actors.index') }}">Actors</a></li>
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