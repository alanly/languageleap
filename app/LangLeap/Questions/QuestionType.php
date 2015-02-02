<?php namespace LangLeap\Questions;

use Eloquent;

abstract class QuestionType extends Eloquent 
{
	abstract public function question();
	abstract public function type();
}
