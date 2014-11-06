@extends('layouts.base')

@section('head')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" />
	@yield('css')
@stop

@section('javascript')
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	@yield('javascript')
@stop
