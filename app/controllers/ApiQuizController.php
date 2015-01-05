<?php

use LangLeap\Core\Collection;
use LangLeap\Quizzes\Question;
use LangLeap\Quizzes\Answer;
use LangLeap\Quizzes\VideoQuestion;
use LangLeap\Quizzes\Result;
use LangLeap\Quizzes\Quiz;
use LangLeap\QuizUtilities\QuizFactory;
use LangLeap\QuizUtilities\QuizInputValidation;
use LangLeap\Videos\Video;
use LangLeap\Words\Definition;

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
		$quizDecorator = new QuizInputValidation(QuizFactory::getInstance());

		// Generate all the questions.
		$response = $quizDecorator->response(Auth::user()->id, Input::all());
		return $this->apiResponse(
			$response[0],
			$response[1],
			$response[2]
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
		// Ensure that the Question exists, else return a 404.
		$videoquestion_id = Input::get('videoquestion_id');
		$videoquestion = VideoQuestion::find($videoquestion_id);

		if (! $videoquestion)
		{
			return $this->apiResponse(
				'error',
				"Question {$videoquestion_id} not found.",
				404
			);
		}

		// Ensure the selected definition exists, otherwise return a 404.
		$selectedId = Input::get("selected_id");
		
		if (! $selectedId)
		{
			return $this->apiResponse(
				'error',
				"The selected definition {$selectedId} is invalid",
				400
			);
		}
		
		$result = Result::join('videoquestions', 'results.videoquestion_id', '=', 'videoquestions.id')
			->where('videoquestions.id', '=', $videoquestion_id)
			->where('results.user_id', '=', Auth::user()->id)
			->orderBy('created_at', 'desc')->first();

		if (! $result)
		{
			return $this->apiResponse(
				'error',
				"No result for user for question {$videoquestion_id}",
				400
			);
		}

		$isCorrectAnswer = $videoquestion->question->answer_id.'' === $selectedId;

		if($isCorrectAnswer)
		{
			$result->is_correct = true;
			$result->save();
		}

		return $this->apiResponse(
			'success',
			[
				'is_correct'	=> $isCorrectAnswer
			]
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
		
		if(!$question || !$answers || count($answers) < 1)
		{
			$success = false;
			$message = 'Fields not filled in properly';
		}

		$question = Question::create([
			'question' 		=> $question,
			'answer_id'	=> -1
		]);
		
		// Shuffle the answers
		$answer_id = -1;
		while(count($answers) > 0)
		{
			$answer_key = array_rand($answers);
			$answer = Answer::create([
				'answer'			=> $answers[$answer_key],
				'question_id'	=> $question->id
			]);
			if($answer_key == 0)
			{
				$answer_id = $answer->id;
			}
			unset($answers[$answer_key]);
		}
		
		$question->answer_id = $answer_id;
		$question->save();
		
		$vq = VideoQuestion::create([
			'video_id'		=> $video_id,
			'question_id'	=> $question->id,
			'is_custom'	=> true
		]);
		
		return Redirect::to('admin/quiz/new')->with('success', $success)->with('message', $message);
	}
	
	public function getScore($quiz_id)
	{
		$quiz = Quiz::find($quiz_id);
		if(!$quiz)
		{
			return $this->apiResponse(
				'error',
				'Quiz {$quiz_id} not found',
				404
			);
		}
		
		return $this->apiResponse(
			'success',
			['score' => $quiz->score],
			200
		);
	}
}
