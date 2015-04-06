<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function(ModelNotFoundException $e)
{
	return Response::make('Not Found', 404);
});

App::missing(function($exception)
{
	return Response::view('errors.missing', [], 404);
});
