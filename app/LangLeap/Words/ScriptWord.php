<?php namespace LangLeap\Words;

use Eloquent;

class ScriptWord extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'script_words';
	public $timestamps = false;		
	/**
	* This function returns the script that this particular word belongs to
	*/
	public function script()
	{
		return $this->belongsTo("LangLeap\Words\Script");
	}	
	public function word()
	{
		return $this->belongsTo("LangLeap\Words\Word");
	}

}
