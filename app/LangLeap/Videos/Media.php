<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

abstract class Media extends ValidatedModel{

	private $fields = ['name', 'description', 'level_id'];
	private $fieldRules  = [
						'name'	=> 'required',
						'level_id' => 'required'
						];

	public function getFillable()
	{
		return $this->fields;
	}

	public function getRules()
	{
		return $this->fieldRules;
	}

	public function level()
	{
		return $this->belongsTo('LangLeap\Levels\Level');
	}

	abstract public function videos();
}
