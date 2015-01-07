<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz extends Eloquent {

	protected $fillable = ['score', 'user_id'];
	
	public function videoQuestions()
	{
		return $this->belongsToMany('LangLeap\Quizzes\VideoQuestion', 'videoquestion_quiz', 'quiz_id', 'videoquestion_id')->withPivot('is_correct');
	}
	
	public function user()
	{
		return $this->belongsTo('LangLeap\Account\User');
	}
	
	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');
	}
	
	public function toResponseArray()
	{
		$response =  [
			'id'	=> $this->id,
			'video_questions'	=> []
		];
		
		foreach($this->videoQuestions as $vq)
		{
			array_push($response['video_questions'], $vq->toResponseArray());
		}
		return $response;
	}
}
