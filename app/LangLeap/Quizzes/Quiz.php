<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz extends Eloquent {

	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}
	
}
