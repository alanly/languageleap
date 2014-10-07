<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Commercial extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['name', 'description'];
	protected $rules      = [
		'name'        => 'required',
		'description' => 'alpha_dash',
	];
	
	public function videos()
	{
		return $this->morphMany('LangLeap\Videos\Video','viewable');
	}

}
