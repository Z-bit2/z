<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf=-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="description" content="">
    <meta keywords= "keywords">

    <meta property="og:title" content="Frexa">
    <meta property="og:description" content="Frexa">
    <!-- <meta property="og:image" content="{{ url('/images/x.png') }}" > -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="shortcut icon" href="{{ url('/images/x.png') }}"> -->
    <link rel="stylesheet" href="{{ url('css/mango.min.css') }}">

    <script type="text/javascript" src="{{ url('/js/ajax.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
