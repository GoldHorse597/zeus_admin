<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui">
		<meta name="description" content="{{ config('app.name') }}">
		<meta name="author" content="{{ config('app.name') }}">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Title -->
		<title>{{ config('app.name') }}</title>
        
		<!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

		<!-- Styles -->
		
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <link rel="stylesheet" href="{{ asset('css/typicon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <script type="text/javascript" src="{{ asset('js/libs/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/login.js') }}?v=1.1"></script>
        <script type="text/javascript" src="{{ asset('js/libs/axios.min.js') }}"></script>
        
    </head>
    
    <body id="particles-js"></body>
        <div class="animated bounceInDown">
        <div class="container">
            <span class="error animated tada" id="msg"></span>
            <form name="form1" class="box" >
                <h4>오토 <span>관리자페이지</span></h4>
                <h5>로그인하세요.</h5>
                <input type="text" name="id" placeholder="아이디" autocomplete="off">
                <i class="typcn typcn-eye" id="eye"></i>
                <input type="password" name="password" placeholder="비밀번호" id="pwd" autocomplete="off">
                <label>
                    <input type="checkbox" class="custom-control-input btn-remember-me" id="customCheck1">
                    <span></span>
                    <small class="rmb">아이디 저장</small>
                </label>            
                <input type="button" value="로그인" id="btnLogin" class="btn1">
            </form>
        </div>
    </body>
</html>