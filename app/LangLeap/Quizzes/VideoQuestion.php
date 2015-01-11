<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoQuestion extends Eloquent {

	public    $timestamps = false;
	protected $table = 'videoquestions';
	protected $fillable   = ['video_id', 'question_id', 'is_custom'];

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
		return $this->belongsToMany('LangLeap\Quizzes\Quiz', 'videoquestion_quiz', 'videoquestion_id', 'quiz_id')->withPivot('is_correct')->withTimestamps();
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
