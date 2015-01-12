<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['answer_id', 'question'];

	public function answer()
	{
		return $this->belongsTo('LangLeap\Quizzes\Answer');
	}

	public function answers()
	{
		return $this->hasMany('LangLeap\Quizzes\Answer');
	}
	
	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}

}
