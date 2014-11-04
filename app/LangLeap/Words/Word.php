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
	
	public function toResponseArray()
	{
		return array(
			'id' => $this->id,
			'word' => $this->word,
			'pronouciation' => $this->pronouciation,
			'definition' => $this->definition,
			'full_definition' => $this->full_definition
		);
	}
}
