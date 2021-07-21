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
            Create a new Movie
        </div>
        <div class="panel-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-defult">

                            <div class="card-body">
                                <form method="post"  action="{{route('movies.store')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        Title<input placeholder="" type="text" class="form-control" name="title" >
                                    </div>

                                    <div class="form-group">
                                        Description<textarea name="description" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group">
                                        Categories<select class="form-control" name="categories[]" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    Actors
                                    @foreach ($actors as $actor)
                                    <div class="checkbox form-inline">
                                        <label><input type="checkbox" name="actors[{{$loop->index}}]" value="{{$actor->id}}"> {{$actor->first_name}} </label>
                                        <input type="text" name="names_in_movie[{{$loop->index}}]" value="" placeholder="Name in Movie"  class="form-control ch_for hide">
                                    </div>

                                    @endforeach



                                    <div class="form-group">
                                        Release Date<input placeholder="Release Date" type="date" class="form-control" name="release_date" >
                                    </div>

                                    <div class="form-group">
                                        Production Date<input placeholder="Production Date" type="date" class="form-control" name="production_date" >
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success float-right" type="submit">Create Movie</button>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        $('.checkbox input:checkbox').on('click', function(){
            $(this).closest('.checkbox').find('.ch_for').toggleClass('hide');
        })
        $(document).ready(function () {
            $('.checkbox input:checkbox').on('click', function(){
                //alert("ok");
                $(this).closest('.checkbox').find('.ch_for').show();
            })
        });
    </script>

@endsection