<?php namespace LangLeap\Quizes;

use Eloquent;
class Question extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'question';
	public $timestamps = false;
	/**
	*	This function returns the quiz that contains this question
	*
	*/
	public function quiz()
    	{
        	return $this->belongsTo('LangLeap\Quizzes\Quiz');
    	}
}
