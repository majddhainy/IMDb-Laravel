@extends('layout.app')
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    Welcome to IMDb
                </div>
                <div class="panel-body">
                    <h4>All guests can:</h4>
                    <br> -register new account , login , reset password.
                    <br> -view the list of movies paginated starting by the most recent ones.
                    <br> -search a movie by title
                    <br> -search for actor by name
                    <br> -view movie details
                    <br> -rate each movie from 1 to 10 - <b>(only if he/she is logged in)</b>
                </div>
            </div>

@endsection