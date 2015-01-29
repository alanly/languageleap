<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class CustomQuestion extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question' => 'string|required', 'answer_id' => 'required'];

	public function question()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function answer()
	{
		return $this->hasOne('LangLeap\Quizzes\Answer');
	}
}
