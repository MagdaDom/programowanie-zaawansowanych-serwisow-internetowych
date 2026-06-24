<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Internal Events - All
    </title>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $title ?? "Laravel page" }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @yield('menu')
            </div>
        </div>
    </div>
    <hr>

    @yield('content')

    <script src="/js/bootstrap.min.js"></script>
</body>

</html>
