<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DragAndDropQuestion extends Eloquent {

	public    $timestamps 	= false;
	protected $table 		= 'draganddropquestions';
	protected $fillable 	= ['sentence'];
	protected $rules    	= ['sentence' => 'required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function question()
	{
		return $this->sentence;
	}
}
