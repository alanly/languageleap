<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class VideoQuestion extends Eloquent {

	public    $timestamps = false;
	protected $table = 'videoquestion';
	protected $fillable   = ['video_id', 'question_id', 'quiz_id', 'is_custom'];
	protected $rules      = [
		'video_id'   			=> 'required|integer',
		'question_id'    		=> 'required|integer',
		'quiz_id'				=> 'required|integer',
		'is_custom'				=> 'required|boolean'
		];


	public function video()
	{
		return $this->belongsTo('LangLeap\Videos\Video');
	}

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
}
