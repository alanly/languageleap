<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class DefinitionQuestion extends QuestionType {

	public    $timestamps 	= false;
	protected $table 		= 'definitionquestions';
	protected $fillable 	= ['question'];
	protected $rules 		= ['question' => 'required'];

	public function questionType()
	{
		return $this->morphMany('LangLeap\Questions\Question','question');
	}

	public function question()
	{
		return $this->question;
	}
}
