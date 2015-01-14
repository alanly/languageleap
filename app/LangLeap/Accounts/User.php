<?php namespace LangLeap\Accounts;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use LangLeap\Core\ValidatedModel;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 */
class User extends ValidatedModel implements UserInterface, RemindableInterface
{

	use UserTrait, RemindableTrait;

	public    $timestamps = false;
	protected $fillable   = ['username', 'email', 'first_name', 'last_name', 'password', 'is_confirmed', 'confirmation_code', 'language_id', 'is_admin'];
	protected $hidden     = ['password', 'remember_token'];
	protected $rules      = [
		'username'   => 'required|alpha_dash|unique:users,username,<id>',
		'email'      => 'required|email|unique:users,email,<id>',
		'password'   => 'required',
		'first_name' => 'required',
		'last_name'  => 'required',
		'language_id'=> 'required',
	];


	public function invoices()
	{
		return $this->hasMany('LangLeap\Payments\Invoice');
	}

	public function level()
	{
		return $this->belongsTo('LangLeap\Levels\Level');
	}
}
