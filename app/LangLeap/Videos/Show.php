<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Payments\Billable;

class Show extends Eloquent implements Billable {

	public    $timestamps = false;
	protected $table      = 'shows';
	protected $fillable   = ['name', 'description', 'image_path', 'director'];

	public function seasons()
	{
		return $this->hasMany('LangLeap\Videos\Season');
	}

}
