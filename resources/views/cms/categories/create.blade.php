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
            Create a new Category
        </div>
        <div class="panel-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-defult">

                            <div class="card-body">
                                <form method="post"  action="{{route('categories.store')}}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        Name<input placeholder="" type="text" class="form-control" name="name" >
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success float-right" type="submit">Create Category</button>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection