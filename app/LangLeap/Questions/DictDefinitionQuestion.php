<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DictDefinitionQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['sentence' => 'string|required', 'word' => 'string|required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}
}
