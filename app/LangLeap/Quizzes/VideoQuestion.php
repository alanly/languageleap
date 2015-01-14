<?php namespace LangLeap\Quizzes;

use Eloquent;
use LangLeap\Core\Collection;

/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoQuestion extends Eloquent {

	public    $timestamps = false;
	protected $table = 'videoquestions';
	protected $fillable   = ['video_id', 'question_id', 'is_custom'];

	public function question()
	{
		return $this->belongsTo('LangLeap\Quizzes\Question', 'question_id');
	}
	
	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');
	}
	
	public function quiz()
	{
		return $this->belongsToMany(
		              'LangLeap\Quizzes\Quiz', 'videoquestion_quiz',
		              'videoquestion_id', 'quiz_id'
		            )
		            ->withPivot('is_correct', 'attempted');
	}
	
	public function toResponseArray()
	{
		$response = [
			'id'	=> $this->id,
			'question'	=> $this->question->question,
			'answers'	=> []
		];
		
		$answers = new Collection($this->question->answers->all());
		while($answers->count() > 0)
		{
			$a = $answers->pullRandom();
			array_push($response['answers'], ['id' => $a->id, 'answer' => $a->answer]);
		}
		
		return $response;
	}

}
