<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CustomQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question' => 'string|required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}
}
