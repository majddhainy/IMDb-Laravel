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
        <form method="post"  action="{{route('search-actors')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <input placeholder="Search By Name" type="text" class="form-control" name="name" >
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
            @if($actors->count() == 0)
                No Actors
            @else
                Actors
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Date Of Birth</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($actors->currentpage()-1) * $actors->perpage() + 1; ?>
                                    @foreach ($actors as $actor)
                                        <tr>
                                            <th> {{ $i  }} </th>
                                            <td>
                                                {{ $actor->first_name . " " . $actor->last_name }}
                                            </td>
                                            <td>
                                                @if($actor->image_name)
                                                    <img src="{{ asset( "storage/actors-images/" . $actor->image_name) }}" width="90" height="110"/>
                                                @else
                                                    <img src="{{ asset( "storage/actors-images/avatar.png") }}" width="90" height="110"/>
                                                @endif
                                            </td>

                                            <td> {{ $actor->gender }} </td>
                                            <td> {{ $actor->date_of_birth }} </td>

                                        </tr>
                                        <?php $i++ ?>
                                    @endforeach

                                    </tbody>
                                </table>
                                @endif
                            </div>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center">
                                {!! $actors->links() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
