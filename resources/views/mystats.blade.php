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
        <h1>Hello,
        <?php $name = $api->me()->display_name;
        echo $name;
        ?>
        </h1></br>

<div class="top-tracks"><h2>These are your top tracks:</h2></br>
    <div id="checkboxes">
<?php
$tracks = $api->getMyTop('tracks')->items;
shuffle($tracks);
foreach ($tracks as $track){

    echo "<li style=\"list-style-type:none; padding-left:15px;\" ><input type=\"checkbox\" value=\"" . $track->id . "\" id=\"checked\" onclick=\"check()\">" .$track->name . "</input> </li>";

}
?>
    </div>
</div>

    <h2><div class="spotify-button recommendations" id="getrecommendations" style="display: none;">Get Recommendations</div></h2>
@endsection

<script src="{{asset('js/recommendations.js')}}"></script>
{{--<script>function check() {
        document.getElementById('checkboxes').addEventListener('change', function (e) {
            var el = e.target;
            var inputs = document.getElementById('checkboxes').getElementsByTagName('input');
            for (i = 0; i < inputs.length; i += 1) {
                if (el[i].checked) {

                }
            </script>--}}
</body>
</html>