<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoQuestion extends Eloquent {

	public    $timestamps = false;
	protected $table = 'videoquestions';
	protected $fillable   = ['question_id', 'quiz_id', 'is_custom'];
	protected $rules     = [
		'question_id'    		=> 'required|integer',
		'quiz_id'				=> 'required|integer',
		'is_custom'				=> 'required|boolean'
		];

	public function question()
	{
		return $this->belongsTo('LangLeap\Quizzes\Question');
	}

	public function results()
	{
		return $this->hasMany('LangLeap\Quizzes\Result');
	}
	
	public function quiz()
	{
		return $this->belongsTo('LangLeap\Quizzes\Quiz');
	}
	
	public function toResponseArray()
	{
		$response = [
			'id'	=> $this->id,
			'question'	=> $this->question->question,
			'answers'	=> []
		];
		
		foreach($this->question->answers as $a)
		{
			array_push($response['answers'], ['id' => $a->id, 'answer' => $a->answer]);
		}
		
		return $response;
	}
}
