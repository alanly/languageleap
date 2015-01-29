<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DictDragDropQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question' => 'string|required', 'word' => 'string|required'];

	public function question()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}
}
