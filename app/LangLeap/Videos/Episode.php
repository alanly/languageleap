<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Episode extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['season_id', 'number', 'name', 'description'];
	protected $rules      = [
		'season_id'   => 'required|integer',
		'number'      => 'required|integer',
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($episode)
		{
			$episode->vdeos()->delete();
		});

	}

	public function season()
	{
		return $this->belongsTo('LangLeap\Videos\Season');
	}

	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
