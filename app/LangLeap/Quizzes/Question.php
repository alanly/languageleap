<?php namespace LangLeap\Quizzes;

use Eloquent;

class Question extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['quiz_id', 'definition_id', 'question'];


	public function quiz()
	{
		return $this->belongsTo('LangLeap\Quizzes\Quiz');
	}


	public function definition()
	{
		return $this->belongsTo('LangLeap\Words\Definition');
	}


	public function scopeUnanswered($query)
	{
		return $query->where('selected_id', null);
	}

}
