<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.png">
        <title>Laravel</title>
        @section('css')
            {{ HTML::style('css/bootstrap.css')}}
            {{ HTML::style('css/style.css')}}
        @show
        <script>
            var urls = '{{ json_encode(array("base_url" => URL::to("/"))) }}';
        </script>   
    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::to('/') }}">Project name</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <div class="pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ URL::to('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div><!-- /.nav-collapse -->

            </div><!-- /.container -->
        </div>
        <div class="container">
            <div class="row row-offcanvas row-offcanvas-right">
                @yield('content')
            </div>
            <hr>
            <footer>
                <p>&copy; Company 2014</p>
            </footer>
        </div>

        @section('js')
            {{ HTML::script('js/core.jquery.js')}}
        @show
    </body>
</html>