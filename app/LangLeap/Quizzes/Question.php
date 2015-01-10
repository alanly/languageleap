<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['answer_id', 'question'];
	protected $rules      = [
		'question'    => 'required|string'
		];


	public function answers()
	{
		return $this->hasMany('LangLeap\Quizzes\Answer');
	}
	
	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}
	
	/*public function toResponseArray()
	{
		return [
			'question'	=>	$this->question,
			'answers'	=>	$this->answers(),
		];
	}*/
}
