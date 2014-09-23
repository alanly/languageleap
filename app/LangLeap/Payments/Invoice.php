<?php namespace LangLeap\Payments;


class Invoice extends Eloquent
{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'invoices';
		
	
	/**
	* This function returns the user that this invoice belongs to
	*/
	public function user()
	{
		return $this->hasOne('User');
	}	
}
