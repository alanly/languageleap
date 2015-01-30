<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question_id' => 'required|integer', 'question_type' => 'required', 'answer_id' => 'integer'];

	public function question()
	{
		return $this->morphTo();
	}

	public function answer()
	{
		return $this->hasOne('LangLeap\Quizzes\Answer');
	}	

}
