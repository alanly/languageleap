<?php namespace LangLeap\Payments;

use Eloquent;
class Invoice extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'invoices';
	public $timestamps = false		
	
	/**
	* This function returns the user that this invoice belongs to
	*/
	public function user()
	{
		return $this->hasOne('LangLeap\Accounts\User');
	}	
}
