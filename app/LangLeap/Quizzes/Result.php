<?php namespace LangLeap\Quizzes;

use Eloquent;
/**
 * @author  Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class Result extends Eloquent {

	public    $timestamps = false;
	protected $fillable   = ['videoquestion_id', 'user_id', 'is_correct', 'timestamp'];
	protected $rules      = [
		'user_id'				=> 'required|integer',
		'videoquestion_id'   => 'required|integer',
		'is_correct'				=> 'required|boolean'
		];

	public function videoquestion()
	{
		return $this->belongsTo('LangLeap\Quizzes\VideoQuestion');
	}

	public function user()
	{
		return $this->belongsTo('LangLeap\Accounts\User');
	}
}