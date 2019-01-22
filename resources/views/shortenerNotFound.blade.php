<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{URL::asset('css/primitive.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/custom.css')}}">
<div class="small-container text-center">
    <h1>Sorrry, we couldn't find your shortened URL.</h1>
    <a href="{{url('/')}}"><button id="btn_gohome" class="round-button">So let's try again.</button></a>
</div>

