<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf=-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="description" content="">
    <meta keywords= "keywords">

    <meta property="og:title" content="Mango Farm - Blockchain Assets Made Easy">
    <meta property="og:description" content="Mango Farm makes creating and storing blockchain assets easy. Powered by Ravencoin.">
    <meta property="og:image" content="{{ url('/images/mangobird.png') }}" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/images/mangobird.png') }}">
    <link rel="stylesheet" href="{{ url('css/mango.min.css') }}">

    <script type="text/javascript" src="{{ url('/js/ajax.js') }}"></script>
</head>
<style>
  .termlist li{
    margin:20px 0;
  }
  .modalbox{
    padding:0 5%;
  }
  #terms_container{
    color: #eee;
    max-width: 1500px;
    margin: auto;
    padding: 25px;
    font-weight: 300;
    font-size: 1.1em
  }
</style>
<body>
<div id="main_container">
  @include('layouts.header')

    @yield('content')

  @include('layouts.footer')
</div>
</body>
</html>
