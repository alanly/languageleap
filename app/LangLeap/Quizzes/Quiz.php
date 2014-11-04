<?php namespace LangLeap\Quizzes;

use Eloquent;

class Quiz extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'quizzes';
	public $timestamps = false;
	/**
	*	This function returns the use that is associated with this quiz
	*
	*/
	public function user()
    	{
        	return $this->belongsTo('LangLeap\Accounts\User');
    	}


	/**
	*	This function returns all the questions related to this quiz
	*
	*/	
	public function questions()
	{
		return $this->hasMany('LangLeap\Quizzes\Question');
	}
}
