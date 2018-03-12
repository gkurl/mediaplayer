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
        <h1>Hello,
        <?php $name = $api->me()->display_name;
        echo $name;
        ?>
        </h1></br>

<div><h2>These are your top tracks:</h2></br>

<?php
$tracks = $api->getMyTop('tracks')->items;
shuffle($tracks);
foreach ($tracks as $track){

   echo "<li style=\"list-style-type:none; padding-left:15px;\">" .$track->name . "</li>";
}
?>
</div>

    <h2><div class="spotify-button recommendations" id="getrecommendations" style="">Get Recommendations</div></h2>
@endsection






</body>
</html>