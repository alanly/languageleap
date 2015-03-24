<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Words\Script;
use Auth, URL;

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
			'name'            => $this->viewable->name,
			'script'        	=> ['id' => $script->id, 'text' => $script->text],
			'timestamps_json'	=> $this->timestamps_json,
			'score'        		=> $this->getUserScore(Auth::user()),
		];
	}
	
	public function getVideoPath()
	{
		return URL::action('VideoContentController@getVideo', ['id' => $this->id]);
	}

	private function getUserScore($user)
	{
		if (! $user) return 0;

		$highScore = 0;

		// Get all the video quizzes, eager-loading the associated quiz instances
		// that belong to the specified user.
		$videoQuizzes = $this->videoQuizzes()
		                     ->with(['quiz' => function($query) use($user)
			                     {
				                     	$query->where('user_id', '=', $user->id);
			                     }])
		                     ->get();

		// Determine what is the max score across all quizzes.
		foreach ($videoQuizzes as $vq)
		{
			// Check if this pivot has an associated quiz (filtered above by user).
			// Determien if the associated quiz has a higher score than our current
			// tracking value.
			if (($quiz = $vq->quiz) && $quiz->score > $highScore)
			{
				$highScore = $quiz->score;
			}
		}

		return $highScore;
	}

}
