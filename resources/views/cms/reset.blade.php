<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style>
    .form-gap {
        padding-top: 70px;
    }
</style>
<div class="form-gap"></div>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
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
                <div class="panel-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Change Password</h2>
                        <p>You can change your password here.</p>
                        <div class="panel-body">

                            <form id="register-form" role="form" autocomplete="off" class="form" method="post" action="{{route('cms-reset-password')}}">
                                {{csrf_field()}}
                                <div class="form-group">

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                        <input id="email" name="email" placeholder="Email" class="form-control"  type="email">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                        <input id="password" name="password" placeholder="Password" class="form-control"  type="password">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                        <input id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control"  type="password">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <input type="hidden" name="reset_token" value="{{ $token }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Change Password" type="submit">
                                </div>

                                <input type="hidden" class="hide" name="token" id="token" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>