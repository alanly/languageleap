<?php namespace LangLeap\Payments;

use LangLeap\TestCase;
use App;

class InvoiceTest extends TestCase {

	/**
	 * Testing getting all seasons for a particular show.
	 *
	 * @return void
	 */
	public function testUserRelation()
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
		$this->assertCount(1, $invoice->user()->get());			
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
