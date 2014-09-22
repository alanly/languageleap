<?php namespace LangLeap\Quizes;


class Question extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'question';

	/**
	*	This function returns the quiz that contains this question
	*
	*/
	public function quiz()
    	{
        	return $this->belongsTo('Quiz');
    	}
}
