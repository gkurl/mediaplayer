@extends('layouts.app')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <title>My Stats</title>
</head>
<body>

@section('content')
    <!-- Main heading area !-->
        <h1>Hello,
        <?php $name = $api->me()->display_name . "!";
        echo $name;
        ?>
        </h1></br>

    <!-- End main heading area !-->


    <!-- Top track section !-->

    <div class="top-tracks"><h2>Your top tracks are just below</h2></br>
        <h4><strong>Select up to five tracks</strong></h4></br>
    <div id="checkbox">
        <ul id="checkboxes">
<?php
$tracks = $api->getMyTop('tracks')->items;
shuffle($tracks);
foreach ($tracks as $track){

    echo "<li style=\"list-style-type:none;\" ><input class=\"checkbox-class\" type=\"checkbox\" name=\"checkbox\" value=\"" . $track->id . "\" id=\"checked\" onclick=\"check()\">" .$track->name . "</input> </li>";

}
?>

        </ul>
    </div>
</div>
    <!-- End top track section !-->

</br> <h4>Start building your custom lists from the suggestions here</h4>

    <h2><div class="spotify-button recommendations" id="getrecommendations" onclick="" style="display: none;">Get Recommendations</div></h2>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('js/recommendations.js')}}"></script>
</body>
</html>