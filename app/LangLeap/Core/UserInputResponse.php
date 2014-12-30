<?php namespace LangLeap\Core;

/**
 * An interface that hides operations for user input response
 *
 * @author Quang Tran <tran.quang@live.com>
 */
interface UserInputResponse
{
	public function response($user_id, $input);
}