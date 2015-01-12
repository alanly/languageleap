<?php namespace LangLeap\Rank;

use LangLeap\Accounts\User;
use LangLeap\Quizzes\Answers;
use LangLeap\Quizzes\Questions;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class UserRanker {

	/**
	 * @var LangLeap\Quizzes\Answers
	 */
	protected $answers;

	/**
	 * @var LangLeap\Quizzes\Questions
	 */
	protected $questions;


	public function __construct(Answers $answers, Questions $questions)
	{
		// Hold onto injected dependencies.
		$this->answers = $answers;
		$this->questions = $questions;
	}

	/**
	 * Ranks the given user for the ranking listener. The questions are given as
	 * an associated array where the key is the question ID and the value is the
	 * answer ID.
	 * @param  RankingListener $listener  
	 * @param  User            $user      
	 * @param  array           $questions
	 * @return mixed
	 */
	public function rank(RankingListener $listener, User $user, array $questions)
	{
		// @TODO perform ranking for $user
		$this->performUserRanking($user, $questions);
		
		return $listener->userRanked($user);
	}

	protected function performUserRanking(User $user, array $questions)
	{
		$numberOfQuestions = count($questions);
		$numberOfCorrectAnswers = 0;

		foreach ($questions as $q => $a)
		{
			$question = $this->questions->find($q);
			$answer = $question->answer;

			if ($a === $answer->id) ++$numberOfCorrectAnswers;
		}

		// Distill things so that we're between a level of 1 and 3 based on the
		// number of correctly answered questions.
		$distillRatio   = $numberOfQuestions / 3
		$distilledLevel = $numberOfCorrectAnswers / $distillRatio;

		// Round out the value to the next integer.
		$distilledLevel = intval(ceil($distilledLevel));

		// Update the user and return the result of the operation.
		$user->level_id = $distilledLevel;

		return $user->save();
	}

}
