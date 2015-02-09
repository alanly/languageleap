<?php namespace LangLeap\Rank;

use LangLeap\Accounts\User;
use LangLeap\Quizzes\Answer as QuizAnswer;
use LangLeap\Questions\Question as QuizQuestion;

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


	public function __construct(QuizAnswer $answers, QuizQuestion $questions)
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

			if (! isset($q->selected)) return App::abort(400, 'Incomplete request.');

			if (intval($q->selected) == $answer->id) ++$numberOfCorrectAnswers;
		}

		// We have a choice of three-levels:
		//   - 2:Beginner
		//   - 3:Intermediate
		//   - 4:Advanced
		// We must pick between these based on how well the user performs.
		
		$resultRatio = $numberOfCorrectAnswers / $numberOfQuestions;

		if ($resultRatio >= 0.7) $user->level_id = 4;
		if ($resultRatio < 0.7 && $resultRatio > 0.4) $user->level_id = 3;
		if ($resultRatio <= 0.4) $user->level_id = 2;

		return $user->save();
	}

}
