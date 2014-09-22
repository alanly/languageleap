<?php namespace LangLeap\Quizes;


class Quiz extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'quiz';

	/**
	*	This function returns the use that is associated with this quiz
	*
	*/
	public function user()
    	{
        	return $this->belongsTo('User');
    	}


	/**
	*	This function returns all the questions related to this quiz
	*
	*/	
	public function questions()
	{
		return $this->hasMany('Question');
	}
}
