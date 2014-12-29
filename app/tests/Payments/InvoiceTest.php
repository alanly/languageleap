<?php namespace LangLeap\Payments;

use LangLeap\TestCase;
use LangLeap\Accounts\User;
use App;

class InvoiceTest extends TestCase {

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
		$this->seed();
		return User::first();
	}

	protected function getInvoiceInstance()
	{
		return App::make('LangLeap\Payments\Invoice');
	}

}
