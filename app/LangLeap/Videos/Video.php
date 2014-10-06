<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Words\Script;

class Video extends Eloquent {


	public    $timestamps = false;
	protected $fillable   = ['path'];

	public function script()
	{
		return $this->hasOne('LangLeap\Words\Script');
	}

	public function viewable()
	{
		return $this->morphTo();
	}	


	public function toResponseArray($vid)
	{
		$script = $vid->script()->first();
		if($script != null)
			return array(
				'id' => $vid->id,
				'path' => $vid->path,
				'viewable_id' => $vid->viewable_id,
				'viewable_type' => $vid->viewable_type,
				'script' => array(
					'id' => $script->id,
					'text' => $script->text,
				),

			);
		else
			return null;
		
	}
}
