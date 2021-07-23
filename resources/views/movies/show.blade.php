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
            Movie Details
        </div>
        <div class="panel-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-defult">

                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <b>Title</b><input disabled placeholder="" type="text" class="form-control" value="{{$movie->title}}">
                                    </div>

                                    <div class="form-group">
                                      <b>Description</b><textarea disabled  class="form-control">{{$movie->description}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <b>Categories</b><select disabled class="form-control"  multiple>
                                            @foreach ($movie->categories as $category)
                                                <option    value="{{ $category->id }}"> {{ $category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <b>Actors => Name In The Movie</b>
                                    @foreach ($movie->actors as $actor)
                                        <div class="checkbox form-inline">
                                                <label><input disabled checked type="checkbox"  value="{{$actor->id}}"> {{$actor->first_name}} </label>
                                                <input  disabled type="text"   placeholder="Name in Movie"  class="form-control ch_for" value="{{$actor->pivot->name_in_movie}}">
                                        </div>

                                    @endforeach



                                    <div class="form-group">
                                        <b>Release Date</b><input disabled placeholder="Release Date" type="date" class="form-control"  value="{{$movie->release_date}}">
                                    </div>

                                    <div class="form-group">
                                        <b>Production Date</b> <input  disabled placeholder="Production Date" type="date" class="form-control"  value="{{$movie->production_date}}">
                                    </div>



                                    @foreach ($movie->medias as $media)
                                        <div class="form-group">
                                                @if($media->type == "image")<img src="{{ asset( "storage/movies-medias/" . $media->media_name) }}" width="300" height="300"/>@endif
                                                @if($media->type == "video")<video width="120" height="120" controls><source src="{{URL::asset( "storage/movies-medias/" . $media->media_name) }}" type="video/mp4">Your browser does not support the video tag.</video>@endif
                                        </div>

                                    @endforeach


                                    <div class="form-group">
                                        <b>Rating</b><input disabled placeholder="" type="text" class="form-control" value="@if($movie->rating_total != 0 && $movie->raters_count != 0) {{$movie->rating_total/$movie->raters_count}}/10 @else No Rating Yet @endif">
                                    </div>

                                </form>



                                    <form method="post"  action="{{route('rate-movie',$movie->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <b>Value</b><select name="value" class="form-control" >
                                                @for($i=1;$i<=10;$i++)
                                                    <option    value="{{ $i }}"> {{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success float-right" type="submit">Rate Movie</button>
                                        </div>
                                    </form>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

