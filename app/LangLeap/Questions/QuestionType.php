<?php namespace LangLeap\Questions;

use Eloquent;

abstract class QuestionType extends Eloquent 
{
	abstract public function question();
	abstract public function type();
	
	/**
	 * This function dictates whether or not the question stores wordbank items.
	 * 
	 * @return boolean
	 */
	abstract public function isBankable();
}
