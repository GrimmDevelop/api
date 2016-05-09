<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Grimmbriefwechsel &mdash; API</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
        body {
            padding-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" {!! (request()->is('docs')) ? ' class="active"' : ''  !!}><a href="{{ url('docs') }}">Home</a></li>
                <li role="presentation" {!! (request()->is('docs/first-steps')) ? ' class="active"' : ''  !!}><a href="{{ url('docs/first-steps') }}">Erste Schritte</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
