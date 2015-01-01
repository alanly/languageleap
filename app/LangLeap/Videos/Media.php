<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

abstract class Media extends ValidatedModel {

	protected $fillable = ['name', 'description', 'level_id'];
	protected $rules    = ['name' => 'required'];

	public function level()
	{
		return $this->belongsTo('LangLeap\Levels\Level');
	}

	abstract public function videos();

}
