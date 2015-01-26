<?php namespace LangLeap\Accounts;

use LangLeap\TestCase;
use App;

class UserTest extends TestCase {

	/**
	 * Testing getting invoices for a particular user.
	 *
	 * @return void
	 */
	public function testInvoiceRelation()
	{
		$user = $this->getUserInstance();
		$user->email = '';
		$user->username = '';
		$user->password = '';
		$user->first_name = '';
		$user->last_name = '';
		$user->save();
	
		$invoice = $this->getInvoiceInstance();
		$invoice->user_id = $user->id;
		$invoice->amount = 0;
		$invoice->save();
		$this->assertCount(1, $user->invoices()->get());			
	}
	protected function getUserInstance()
	{
		return App::make('LangLeap\Accounts\User');
	}
	protected function getInvoiceInstance()
	{
		return App::make('LangLeap\Payments\Invoice');
	}
	

}
