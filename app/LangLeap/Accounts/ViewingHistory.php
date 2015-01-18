<?php namespace LangLeap\Accounts;

use Eloquent;

class ViewingHistory extends Eloquent
{
	public $timestamps = true;

	protected $table = "viewing_history";
	protected $fillable   = ['user_id', 'video_id', 'is_finished', 'current_time'];
	protected $rules = [
		'user_id' 	=> 'required',
		'video_id' 	=> 'required',
	];

	public function video()
	{
		return $this->hasOne('LangLeap\Videos\Video');
	}

	public function user()
	{
		return $this->belongsTo('LangLeap\Accounts\User');
	}
}

