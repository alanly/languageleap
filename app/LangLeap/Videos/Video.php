<?php namespace LangLeap\Videos;

use Eloquent;
use LangLeap\Words\Script;
class Video extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'videos';
	public $timestamps = false;		
	
	/**
	* This function returns the script that is associated with this video
	*/
	public function script()
	{
		return $this->hasOne('LangLeap\Words\Script');
	}
	
	/**
	* This function defines the polymorphic relationships
	*/

	public function viewable()
	{
		return $this->morphTo();
	}	


	public function toResponseArray($vid)
    {
    	$script = $vid->script();
    	//dd($script);
    	$video = array(
    		'id' => $vid->id,
    		'viewable_id' => $vid->viewable_id,
    		'viewable_type' => $vid->viewable_type,
    		'path' => $vid->path,
    		'script' => array(
    			'id' => $script->id,
    			'text' => $script->text,
    		),
    	);
    }
}
