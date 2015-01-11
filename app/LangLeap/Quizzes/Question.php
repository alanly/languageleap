<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['answer_id', 'question'];

	public function answers()
	{
		return $this->hasMany('LangLeap\Quizzes\Answer');
	}
	
	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}
}
