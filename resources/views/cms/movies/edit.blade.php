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
            Update Movie
        </div>
        <div class="panel-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-defult">

                            <div class="card-body">
                                <form method="post"  action="{{route('movies.update',$movie->id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        Title<input placeholder="" type="text" class="form-control" name="title" value="{{$movie->title}}">
                                    </div>

                                    <div class="form-group">
                                        Description<textarea name="description" class="form-control">{{$movie->description}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        Categories<select class="form-control" name="categories[]" multiple>
                                            @foreach ($categories as $category)
                                                <option @if(in_array($category->id,$movie_categories)) selected @endif  value="{{ $category->id }}"> {{ $category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    Actors
                                    @foreach ($actors as $actor)
                                        <div class="checkbox form-inline">
                                            @if(array_key_exists($actor->id,$movie_actors))
                                                <label><input checked type="checkbox" name="actors[{{$loop->index}}]" value="{{$actor->id}}"> {{$actor->first_name}} </label>
                                                <input type="text" name="names_in_movie[{{$loop->index}}]"  placeholder="Name in Movie"  class="form-control ch_for" value="{{$movie_actors[$actor->id]}}">
                                            @else
                                                <label><input type="checkbox" name="actors[{{$loop->index}}]" value="{{$actor->id}}"> {{$actor->first_name}} </label>
                                                <input type="text" name="names_in_movie[{{$loop->index}}]" value="" placeholder="Name in Movie"  class="form-control ch_for hide">
                                            @endif
                                        </div>

                                    @endforeach



                                    <div class="form-group">
                                        Release Date<input placeholder="Release Date" type="date" class="form-control" name="release_date" value="{{$movie->release_date}}">
                                    </div>

                                    <div class="form-group">
                                        Production Date<input placeholder="Production Date" type="date" class="form-control" name="production_date" value="{{$movie->production_date}}">
                                    </div>



                                    @foreach ($medias as $media)
                                        @if($loop->index == 0)Movie's Current Media (check the ones you want to delete) @endif
                                        <div class="checkbox form-inline">
                                            <label><input type="checkbox" name="medias_to_delete_ids[{{$loop->index}}]" value="{{$media->id}}">
                                                @if($media->type == "image")<img src="{{ asset( "storage/movies-medias/" . $media->media_name) }}" width="120" height="120"/>@endif
                                                @if($media->type == "video")<video width="120" height="120" controls><source src="{{URL::asset( "storage/movies-medias/" . $media->media_name) }}" type="video/mp4">Your browser does not support the video tag.</video>@endif
                                            </label>
                                            <input type="text" name="medias_to_delete_names[{{$loop->index}}]" value="{{$media->media_name}}"   class="form-control  hide">
                                        </div>
                                    @endforeach

                                    <div class="form-group">
                                        Movie New Images (you can choose multiple images)<input multiple type="file" class="form-control" name="images[]" multiple/>
                                    </div>


                                    <div class="form-group">
                                        Movie New Videos (you can choose multiple videos)<input multiple type="file" class="form-control" name="videos[]" multiple/>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success float-right" type="submit">Update Movie</button>
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