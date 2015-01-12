<?php namespace LangLeap\Rank;

use LangLeap\Accounts\User;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Question;

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


	public function __construct(Answer $answers, Question $questions)
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
		$this->performUserRanking($user, $questions);
		
		return $listener->userRanked($user);
	}


	protected function performUserRanking(User $user, array $questions)
	{
		$numberOfQuestions = count($questions);
		$numberOfCorrectAnswers = 0;

		foreach ($questions as $q)
		{
			// @NOTICE Laravel seems to default towards converting JSON data from the
			//         input, into an associative array by default. In order to deal
			//         with this, there are two approaches. Either we accept things as
			//         they are, in array form. Or we can convert things to objects.
			//         I am choosing to do the latter.
			$q = (object) $q;

			$question = $this->questions->find($q->id);
			$answer = $question->answer;

			if (intval($q->selected) === $answer->id) ++$numberOfCorrectAnswers;
		}

		// Distill things so that we're between a level of 1 and 3 based on the
		// number of correctly answered questions.
		$distillRatio   = $numberOfQuestions / 3;
		$distilledLevel = $numberOfCorrectAnswers / $distillRatio;

		// Round out the value to the next integer.
		$distilledLevel = intval(ceil($distilledLevel));

		// Update the user and return the result of the operation.
		$user->level_id = $distilledLevel;

		return $user->save();
	}

}
