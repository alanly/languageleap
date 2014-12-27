<?php namespace LangLeap\Levels;

class Level extends ValidateModel
{
	public $timestamps = false;
	
	protected $fillable   = ['id', 'code', 'description'];
	protected $rules = [
		'id' => 'required',
		'code' => 'required',
		'description' => 'required',
	];
}

