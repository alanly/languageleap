<?php namespace LangLeap\Words;

use Eloquent;

class Word extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'words';
	public $timestamps = false;
}
