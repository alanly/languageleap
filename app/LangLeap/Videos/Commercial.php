<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

class Commercial extends ValidatedModel {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description'];
	protected $rules      = [
		'name'        => 'required',
	];
	
	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
