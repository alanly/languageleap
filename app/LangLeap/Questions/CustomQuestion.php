<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class CustomQuestion extends QuestionType {

	public    $timestamps 		= false;
	protected $table 		= 'customquestions';
	protected $fillable 		= ['question'];
	protected $rules		= ['question' => 'required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function question()
	{
		return $this->question;
	}

	public function type()
	{
		return "multipleChoice";
	}
}
