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
		return $this->belongsTo('LangLeap\Quizzes\Answer');
	}
}
