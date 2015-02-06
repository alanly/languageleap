<?php namespace LangLeap\Questions;

use Eloquent;
use App;

/**
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 * @author Alan Ly <hello@alan.ly>
 */
class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['answer_id' => 'integer'];

	public function questionType()
	{
		return $this->morphTo('question', 'question_type', 'question_id');
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
