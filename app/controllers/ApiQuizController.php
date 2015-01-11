<?php

use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Quiz;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\QuizUtilities\QuizAnswerUpdate;
use LangLeap\QuizUtilities\QuizAnswerValidation;
use LangLeap\QuizUtilities\QuizCreationValidation;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\Videos\Video;

/**
 * @author Thomas Rahn <thomas@rahn.ca>
 * @author Alan Ly <hello@alan.ly>
 * @author Dror Ozgaon <Dror.Ozgaon@gmail.com>
 */
class ApiQuizController extends \BaseController {

	/**
	 * This function will generate a json response that will contain, the quiz 
	 * (new or old depending if there has been a quiz for this video and user), 
	 * a question and its ID as well as all the possible answers for the
	 * question.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		$quizDecorator = new QuizCreationValidation(QuizFactory::getInstance());

		// Generate all the questions.
		$response = $quizDecorator->response(Auth::user()->id, Input::all());

		return $this->apiResponse(
			$response[0], $response[1], $response[2]
		);
	}

	/**
	 * This function will be used to answer a question. It will increase the
	 * users quiz score if he selected the proper answer.
	 * 
	 * @return Response
	 */
	public function putIndex()
	{
		$answerDecorator = new QuizAnswerValidation(new QuizAnswerUpdate());
		
		// Run validation and update the quiz score if validation passes
		$response = $answerDecorator->response(Auth::user()->id, Input::all());
		
		return $this->apiResponse(
			$response[0], $response[1], $response[2]
		);
	}
	
	public function putCustomQuestion()
	{
		$video_id = Input::get('video_id');
		$question = Input::get('question');
		$answers = Input::get('answer');
		
		$message = 'Custom question saved successfully';
		$success = true;

		$video = Video::find($video_id);

		if (! $video)
		{
			$success = false;
			$message = 'Video not found in database';
		}
		
		if(! $question || ! $answers || count($answers) < 1)
		{
			$success = false;
			$message = 'Fields not filled in properly';
		}

		$question = Question::create([
			'question'  => $question,
			'answer_id' => -1
		]);
		
		// Shuffle the answers
		$answer_id = -1;
		while (count($answers) > 0)
		{
			$answer_key = array_rand($answers);

			$answer = Answer::create([
				'answer'      => $answers[$answer_key],
				'question_id' => $question->id
			]);

			if ($answer_key == 0)
			{
				$answer_id = $answer->id;
			}

			unset($answers[$answer_key]);
		}
		
		$question->answer_id = $answer_id;
		$question->save();
		
		$vq = VideoQuestion::create([
			'video_id'    => $video_id,
			'question_id' => $question->id,
			'is_custom'   => true
		]);
		
		return Redirect::to('admin/quiz/new')
		               ->with('success', $success)
		               ->with('message', $message);
	}
	
	public function getScore($quiz_id)
	{
		$quiz = Quiz::find($quiz_id);
		if (! $quiz)
		{
			return $this->apiResponse('error', "Quiz {$quiz_id} not found", 404);
		}
		
		if ( ($quiz->user_id != Auth::user()->id) && (! Auth::user()->is_admin) )
		{
			return $this->apiResponse(
				'error',
				"Not authorized to view quiz {$quiz_id}",
				401
			);
		}
		
		return $this->apiResponse('success', ['score' => $quiz->score], 200);
	}
	
	public function getReminder()
	{
		$user = Auth::user();
		if(!$user)
		{
			return $this->apiResponse(
				'error',
				'Must be logged in to get reminder quizzes',
				401
			);
		}
		
		// Find the video questions that were attempted and are wrong by this user
		$videoQuestions = VideoQuestion::select(array('videoquestions.*', 'videoquestion_quiz.updated_at', DB::raw('count(videoquestions.id) as attempts')))
			->join('videoquestion_quiz', 'videoquestion_quiz.videoquestion_id', '=', 'videoquestions.id')->join('questions', 'questions.id', '=', 'videoquestions.question_id')->join('quizzes', 'quizzes.id', '=', 'videoquestion_quiz.quiz_id')
			->where('videoquestions.is_custom', '=', false)->where('videoquestion_quiz.created_at', '<>', 'videoquestion_quiz.updated_at')->where('videoquestion_quiz.is_correct', '=', false)->where('quizzes.user_id', '=', Auth::user()->id)
			->groupBy('videoquestions.id')->orderBy('attempts', 'desc')->orderBy('videoquestion_quiz.updated_at', 'desc')->get();
		
		if($videoQuestions && $videoQuestions->count() > 0)
		{
			$quiz = Quiz::create([
				'user_id' => $user->id
			]);
			
			while($videoQuestions->count() > 0 && $quiz->videoQuestions()->count() < 5)
			{
				$vq = $videoQuestions->shift();
				$quiz->videoQuestions()->attach($vq->id);
			}
			$quiz->save();
			
			return $this->apiResponse(
				'success',
				['quiz_id' => $quiz->id]
			);
		}
		
		return $this->apiResponse(
			'success',
			['quiz_id' => -1]
		);
	}
}
