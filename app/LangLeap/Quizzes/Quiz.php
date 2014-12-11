<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class Quiz extends Eloquent {

	public function videoQuestions()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuestion');
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
