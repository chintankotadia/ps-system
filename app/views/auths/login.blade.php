<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.png">
        <title>login</title>
        {{ HTML::style('css/bootstrap.css')}}
        {{ HTML::style('css/style.css')}}
    </head>
    <body>
        <div class="container">
            {{ Form::open(['url' => URL::to('/login'), 'class' => 'form-signin']) }}
                @if(Session::has('message'))
                    <div class="row">
                        {{ alert_message('error', Session::get('message')) }}
                    </div>
                @endif
                <h2 class="form-signin-heading">Please sign in</h2>
                <div class="form-group">
                    {{ Form::text('username', '', ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username', 'autofocus' => '']) }}
                </div>
                <div class="form-group">
                    {{ Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password']) }}
                </div>
                <div class="checkbox">
                    <a href="javascript:void(0);">Forgot Password?</a>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            {{ Form::close() }}
        </div>
        {{ HTML::script('js/core.jquery.js')}}
    </body>
</html>