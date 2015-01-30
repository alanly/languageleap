<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DragAndDropQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['sentence' => 'string|required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}
}
