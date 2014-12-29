<?php namespace LangLeap\Core;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 */
class Language extends ValidatedModel {

	public $timestamps = false;
	protected $fillable   = ['code', 'description'];
	protected $rules      = [
		'code'          => 'required',
		'description'   => 'required',
	];
}