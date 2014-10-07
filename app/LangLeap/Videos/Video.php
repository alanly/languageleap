<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;

class Video extends ValidatedModel {

	public    $timestamps = false;
	protected $fillable   = ['path'];
	protected $rules      = [
		'path'          => 'required',
		'viewable_id'   => 'required|integer',
		'viewable_type' => 'required',
	];

	public function script()
	{
		return $this->hasOne('LangLeap\Words\Script');
	}

	public function viewable()
	{
		return $this->morphTo();
	}

}
