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


	public function answer()
	{
		return $this->hasMany('LangLeap\Quizzes\Answer');
	}
	
	public function videoQuestion()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}
}
