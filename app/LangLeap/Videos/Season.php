<?php namespace LangLeap\Videos;

use LangLeap\Core\ValidatedModel;
use LangLeap\Payments\Billable;

class Season extends ValidatedModel implements Billable {

	public    $timestamps = false;
	protected $fillable   = ['show_id', 'number', 'description'];
	protected $hidden     = ['episodes'];
	protected $rules      = [
		'show_id' => 'required|integer|exists:shows,id',
		'number'  => 'required|integer',
	];

	public function show()
	{
		return $this->belongsTo('LangLeap\Videos\Show');
	}

	public function episodes()
	{
		return $this->hasMany('LangLeap\Videos\Episode');
	}

}
