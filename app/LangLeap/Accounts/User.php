<?php namespace LangLeap\Accounts;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface
{

	use UserTrait, RemindableTrait;

	public    $timestamps = false;
	protected $fillable   = ['username', 'email', 'first_name', 'last_name', 'password'];
	protected $hidden     = ['password', 'remember_token'];
	protected $table      = 'users';

	public function invoices()
	{
		return $this->hasMany('LangLeap\Payments\Invoice');
	}

}
