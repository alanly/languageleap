<?php namespace LangLeap\Quizzes;

use Eloquent;

/**
 * @author Quang Tran <tran.quang@live.com>
 */
abstract class QuizCategory extends Eloquent {

	public abstract function questionAnswered();
}
