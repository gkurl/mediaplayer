@extends('layouts.app')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Stats</title>
</head>
<body>
@section('content')

<h1>Hello, <?php
        $name = get_object_vars($api->me());
        print_r($name['display_name']);
        ?></h1></br></br>

<h2>These are your top tracks:</h2></br>



<?php

/*$tracks = $api->getMyTop('tracks') = $getMyTop->items;*/

?>
@endsection






</body>
</html>