<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz extends Eloquent {

	public function questions()
	{
		return $this->belongsToMany('Question');
	}


	public function user()
	{
		return $this->belongsTo('User');
	}
	
}
