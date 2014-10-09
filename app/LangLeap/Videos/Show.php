<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Show extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'image_path', 'director'];
	protected $hidden     = ['episodes', 'seasons'];
	protected $rules      = [
		'name'        => 'required',
		'description' => 'required',
	];

	public function episodes()
	{
		return $this->hasManyThrough('LangLeap\Videos\Episode', 'LangLeap\Videos\Season');
	}

	public function seasons()
	{
		return $this->hasMany('LangLeap\Videos\Season');
	}

}
