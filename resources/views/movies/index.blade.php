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

    <div class="input-group">
        <form method="post"  action="{{route('search-movies')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <input placeholder="Search By Title" type="text" class="form-control" name="title" >
            </div>
            <br>
            <div class="form-group">
                <br>
                <button  type="submit" class="btn btn-primary">Search</button>
            </div>

        </form>
    </div>
    <br>

    <div class="panel panel-default">
        <div class="panel-heading">
            @if($movies->count() == 0)
                 No Movies
            @else
                Movies
        </div>
        <div class="panel-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card">
                    <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Rating</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = ($movies->currentpage()-1) * $movies->perpage() + 1; ?>
                                @foreach ($movies as $movie)
                                    <tr>
                                        <th> {{ $i  }} </th>
                                        <td>
                                            {{ $movie->title }}
                                        </td>
                                        <td>
                                            @if($movie->featuredPhoto)
                                                <img src="{{ asset( "storage/movies-medias/" . $movie->featuredPhoto->media_name) }}" width="90" height="110"/>
                                            @else
                                                <img src="{{ asset( "storage/movies-medias/avatar.png") }}" width="90" height="110"/>
                                            @endif
                                        </td>

                                        <td> @if($movie->rating_total != 0 && $movie->raters_count != 0) {{$movie->rating_total/$movie->raters_count}}/10 @else No Rating Yet @endif</td>
                                        <td class="white-space: nowrap">
                                            <a href="{{route('get-movie',$movie->id)}}" class="btn btn-primary btn-sm mx-2 float-right">Show</a>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $movies->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
        </div>
    </div>



@endsection
