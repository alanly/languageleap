<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoQuestion extends Eloquent {

	public    $timestamps = false;
	protected $table = 'videoquestions';
	protected $fillable   = ['video_id', 'question_id', 'is_custom'];
	protected $rules     = [
		'video_id'		=> 'required|integer',
		'question_id'	=> 'required|integer',
		'is_custom'	=> 'required|boolean'
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
		return $this->belongsToMany('LangLeap\Quizzes\Quiz', 'videoquestion_quiz', 'videoquestion_id', 'quiz_id');
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
