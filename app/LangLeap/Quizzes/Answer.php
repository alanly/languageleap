<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Answer extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['question_id', 'answer'];

	public function question()
	{
		return $this->belongsTo('LangLeap\Quizzes\Question');
	}
}
