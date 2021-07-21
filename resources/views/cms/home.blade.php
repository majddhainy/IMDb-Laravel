@extends('cms.layout.app')
@section('content')


            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                </div>
                <div class="panel-body">
                    <h4>The cms user can:</h4>
                     - Manage the categories of the movies (get/add/edit/delete) like horror, romance, animation...
                    <br> - Add actors to the systems where each one has a first name, last name, gender, image, dob,country...
                    <br> - Manage the movies (get/add/edit/delete), where each movie has a title, description, images, videos(trailers), actors and what is the name of each actor in the movie, categories(where each movie has a multiple categories),release date, production date...
                </div>
            </div>

@endsection