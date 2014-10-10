<?php namespace LangLeap\Quizzes;

use Eloquent;
class Question extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';
	public $timestamps = false;
	/**
	*	This function returns the quiz that contains this question
	*
	*/
	public function quiz()
    	{
        	return $this->belongsTo('LangLeap\Quizzes\Quiz');
    	}

	public function script_word()
	{
		return $this->belongsTo('LangLeap\Words\Script_Word');
	}
}
