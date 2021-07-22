@extends('cms.layout.app')

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
            @if($movies->count() == 0)
                 No Movies Yet
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
                                    <th scope="col">Release Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1 ?>
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

                                        <td> {{ $movie->release_date }} </td>
                                        <td class="white-space: nowrap">
                                            <button class="btn btn-danger btn-sm float-right" onClick="handleDelete({{ $movie->id }})">Delete</button>
                                            <a href="{{route('movies.edit',$movie->id)}}" class="btn btn-primary btn-sm mx-2 float-right">Edit</a>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach

                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                {{-- use {{ route ('routename')}} instead of static one so helpful if u wanna change any path/name  --}}
                {{-- u can set a name using ->name('create'); in (routes) as the first one for home check it --}}
                {{-- or bring the name using php artisan route:list  --}}
                <a href="{{ route('movies.create') }}" class="btn btn-success float-right my-2">Add Movie</a>

                {{-- <!-- Modal --> --}}
                <form id="deletecatform" action="" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModal">Delete Movie</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this Movie ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        function handleDelete(id){
            // console.log('deleting' , id)
            var form = document.getElementById('deletecatform');
            //console.log(form);
            form.action = 'movies/' + id;
            // Display the Modal
            $('#deleteModal').modal('show');
            // return is not necessary but u should use it to let this function work in FIREFOX/.. BROWSERS ...
            return true;
        }
    </script>
@endsection