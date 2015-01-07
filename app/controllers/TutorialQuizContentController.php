 <?php
 
 use LangLeap\Quizzes\Question;
 use LangLeap\Quizzes\Answer;
 use LangLeap\Quizzes\VideoQuestion;
 
 class TutorialQuizContentController extends \BaseController
 {	
	public function getQuestions()
	{
		 $tutorialQuestions = Question::where('id', '<', 6)->get();
		
		if(!$tutorialQuestions)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		return $this->apiResponse(
			'success',
			$tutorialQuestions,
			201
		);
	}
	
	public function getAnswers()
	{
		$tutorialAnswers = Answer::where('id', '<', 21)->get();
		
		if(!$tutorialAnswers)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		return $this->apiResponse(
			'success',
			$tutorialAnswers,
			201
		);
	}
 }