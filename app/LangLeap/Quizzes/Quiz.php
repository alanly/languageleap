<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz extends Eloquent {

	public function questions()
	{
		return $this->belongsToMany('LangLeap\Quizzes\Question');
	}


	public function user()
	{
		return $this->belongsTo('LangLeap\Accounts\User');
	}
	
}
