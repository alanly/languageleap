<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Answer extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question_id', 'answer'];
	protected $rules      = [
		'question_id'   => 'required|integer',
		'answer'    	=> 'required|string'
		];


	public function question()
	{
		return $this->belongsTo('LangLeap\Quizzes\Question');
	}
}
