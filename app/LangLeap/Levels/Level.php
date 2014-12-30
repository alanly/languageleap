<?php namespace LangLeap\Levels;

use Eloquent;

class Level extends Eloquent
{
	public $timestamps = false;
	
	protected $fillable   = ['id', 'code', 'description'];
	protected $rules = [
		'id' => 'required',
		'code' => 'required',
		'description' => 'required',
	];
}

