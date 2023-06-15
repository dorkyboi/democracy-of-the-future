<?php

namespace App\Http\Controllers;

use App\API;
use App\Models\QuestionAnswer;
use App\OpenApiService;
use App\QuestionsService;
use Illuminate\Http\Request;

class ActsController extends Controller
{
    protected QuestionsService $questionsService;
    protected QuestionAnswer $questionAnswer;

    public function __construct()
    {
        $this->questionsService = new QuestionsService();
        $this->questionAnswer = new QuestionAnswer();
    }

    public function index()
    {
        $api = new API();
        $offset = 0;
        $limit = 50;
        $from = "2018-01-02T12:15:34"; // todo
        return view('main.main')->with([
            'acts' => $api->fetchChangedActs($from, $offset, $limit),
        ]);
    }

    public function detail(Request $request)
    {
        $apiService = new OpenApiService($request->get('title'));
        $questionAnswer = new QuestionAnswer();

        $exampleQuestions = [
            'Czego dotyczy ustawa'
        ];

        $titleHash = hash('md5', $request->get('title'));
        $params = $request->all();

        $output = [];

        foreach ($exampleQuestions as $question) {
            $output[] = $apiService->ask($question);
        }

        $output['actLink'] = 'http://api.sejm.gov.pl/eli/acts/' . $params['publisher'] . '/' . $params['year'] . '/' . $params['position'] . '/text.pdf';
        $output['search'] = $params['search'] ?? '';

        if(!$this->questionsService->isExist($titleHash,$exampleQuestions[0]))
        {
            $this->questionsService->store([
                'title_hash' => $titleHash,
                'question' =>  $exampleQuestions[0],
                'output' => $output[0]['output']
            ]);
        }

        return view('main.detail')->with([
            'details' => $output,
            'existAnswers' => $this->questionAnswer->where('title_hash', $titleHash)->get()
        ]);
    }

    public function search(Request $request)
    {
        $api = new API();

        return view('main.main')->with([
            'acts' => $api->searchActs([
                'title' => $request->search
            ])
        ]);
    }

    public function addQuestion(Request $request)
    {
        $apiService = new OpenApiService($request->get('title'));
        $titleHash = hash('md5', $request->get('title'));

        $params = $request->all();

        $question = $request->question;

        $output = [];

        $output[] = $apiService->ask($question);

        if(!$this->questionsService->isExist($titleHash,$question))
        {
            $this->questionsService->store([
                'title_hash' => $titleHash,
                'question' =>  $question,
                'output' => $output[0]['output']
            ]);
        }

        $output['prevOutput'] = $params['output'];
        $output[0]['queryQuestion'] = $params['queryQuestion'];
        $output['actLink'] = $params['actLink'];
        $output['search'] = $params['search'];

        return view('main.detail')->with([
            'details' => $output,
            'additionalDetails' => $output[0]['output'],
            'existAnswers' => $this->questionAnswer->where('title_hash', $titleHash)->get()
        ]);
    }
}
