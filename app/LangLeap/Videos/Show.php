<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Show extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description', 'image_path', 'director'];
	protected $rules      = [
		'name'        => 'required',
		'description' => 'required',
	];

	public function seasons()
	{
		return $this->hasMany('LangLeap\Videos\Season');
	}

}
