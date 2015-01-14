<?php namespace LangLeap\Rank;

/**
 * @author Alan Ly <hello@alan.ly>
 */
interface QuizCreationListener {
	
	/**
	 * Handles the created ranking quiz.
	 * @param  LangLeap\Rank\Quiz  $quiz
	 * @return mixed
	 */
	public function quizCreated(Quiz $quiz);

}
