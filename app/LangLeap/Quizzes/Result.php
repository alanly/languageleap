<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Result extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['videoquestion_id', 'is_correct', 'timestamp'];
	protected $rules      = [
		'videoquestion_id'    	=> 'required|integer',
		'is_correct'			=> 'required|boolean'
		];

	public function videoquestion()
	{
		return $this->belongsTo('LangLeap\Quizzes\VideoQuestion');
	}

}
