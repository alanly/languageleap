<?php namespace LangLeap\Accounts;

use Eloquent;

class User_Progress extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_progress';
	public $timestamps = false;
	/**
	 * The function returns the user that this progress belongs to.
	 *
	 */
	public function user()
	{
		return $this->belongsTo('LangLeap\Accounts\User');
	}

}
