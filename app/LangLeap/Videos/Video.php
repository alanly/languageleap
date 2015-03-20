<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Words\Script;
use URL;

class Video extends ValidatedModel {

	public    $timestamps = false;
	protected $fillable   = ['path', 'timestamps_json'];
	protected $rules      = [
		'path'          => 'required',
		'viewable_id'   => 'required|integer',
		'viewable_type' => 'required',
		'language_id'   => 'required'
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($video)
		{
			$video->script()->delete();
		});
	}


	public function script()
	{
		return $this->hasOne('LangLeap\Words\Script');
	}


	public function viewable()
	{
		return $this->morphTo();
	}	

	public function videoQuizzes()
	{
		return $this->hasMany('LangLeap\Quizzes\VideoQuiz');
	}
	
	/**
	 * This function will return the next video in the sequence or null if there is none.
	 *
	 * @return Video 		The next video in the sequence
	 */
	public function nextVideo()
	{
		return Video::where('viewable_id', $this->viewable_id)
							->where('viewable_type', $this->viewable_type)
							->where('video_number', $this->video_number + 1)
							->get()
							->first();

	}

	public function toResponseArray()
	{
		$script = $this->script;

		if (! $script) return null;

		return [
			'id'            	=> $this->id,
			'path'          	=> $this->getVideoPath(),
			'viewable_id'   	=> $this->viewable_id,
			'viewable_type' 	=> $this->viewable_type,
			'script'        	=> ['id' => $script->id, 'text' => $script->text],
			'timestamps_json'	=> $this->timestamps_json,
			'score'        		=> $this->getUserScore(\Auth::user()),
		];
	}
	
	public function getVideoPath()
	{
		return URL::action('VideoContentController@getVideo',
			['id' => $this->id]);
	}

	private function getUserScore($user)
	{
		$score = 0;
		if($user)
		{
			$videoQuizzes = $this->videoQuizzes;
			
			foreach($videoQuizzes as $videoQuiz)
			{
				if($videoQuiz->quiz->user_id == $user->id && $videoQuiz->quiz->score > $score)
				{
					$score = $videoQuiz->quiz->score;
				}
			}
		}
		return $score;
	}

}
