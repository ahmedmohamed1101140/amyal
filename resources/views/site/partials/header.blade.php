<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet"  href="{{asset("assets/")}}/css/bootstrap.css"  type="text/css"/>
    <link rel="stylesheet"  href="{{asset("assets/")}}/css/style.css"  type="text/css"/>
    <link rel="stylesheet"  href="{{asset("assets/")}}/css/font-awesome.css" >
    <link rel="stylesheet" type="text/css" href="{{asset("assets/")}}/css/bootsnav.css" />
    <link rel="stylesheet" type="text/css" href="{{asset("assets/")}}/css/jquery.datetimepicker.css" />
    @yield('css')
</head>

<body>

