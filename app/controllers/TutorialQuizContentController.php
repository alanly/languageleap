 <?php
 
 use LangLeap\Quizzes\Question;
 use LangLeap\Quizzes\Answer;
 use LangLeap\Quizzes\VideoQuestion;
 
 class TutorialQuizContentController extends \BaseController {	
	public function getIndex()
	{
		dd("test");
		 $tutorialQuestions = Question::where('id', '<', 6)->get();
		 $tutorialAnswers = Answer::where('id', '<', 21)->get();
		
		if(!$tutorialQuestions)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		if(!$tutorialAnswers)
		{
			return $this->apiResponse(
				'error',
				"One or more questions do not exist.",
				404
			);
		}
		
		$tutorialData = [$tutorialQuestions, $tutorialAnswers];
		
		return $this->apiResponse(
			'success',
			$tutorialData,
			200
			/*$tutorialAnswers[1],
			$tutorialAnswers[2],
			$tutorialAnswers[3],
			$tutorialAnswers[4],
			
			$tutorialQuestions[2],
			$tutorialAnswers[5],
			$tutorialAnswers[6],
			$tutorialAnswers[7],
			$tutorialAnswers[8],
			
			$tutorialQuestions[3],
			$tutorialAnswers[9],
			$tutorialAnswers[10],
			$tutorialAnswers[11],
			$tutorialAnswers[12],
			
			$tutorialQuestions[4],
			$tutorialAnswers[13],
			$tutorialAnswers[14],
			$tutorialAnswers[14],
			$tutorialAnswers[16],
			
			$tutorialQuestions[5],
			$tutorialAnswers[17],
			$tutorialAnswers[18],
			$tutorialAnswers[19],
			$tutorialAnswers[20]*/
		);
	}
 }