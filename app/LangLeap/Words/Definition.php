<?php namespace LangLeap\Words;

use Eloquent;

class Definition extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'definitions';
	public $timestamps = false;
	
	public function toResponseArray()
	{
		return array(
			'id' => $this->id,
			'definition' => $this->definition,
			'full_definition' => $this->full_definition,
			'pronunciation' => $this->pronunciation
		);
	}
}
