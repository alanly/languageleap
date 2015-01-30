<?php namespace LangLeap\Questions;

use Eloquent;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['answer_id' => 'integer'];
	protected $rules      = [
		'question_id'   => 'required|integer',
		'question_type' => 'required'
	];


	public function questionType()
	{
		return $this->morphTo();
	}

	public function answers()
	{
		return $this->hasMany('LangLeap\Quizzes\Answer');
	}	

	public function answer()
	{
		return $this->belongsTo('LangLeap\Quizzes\Answer');
	}	

	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
	}
}
