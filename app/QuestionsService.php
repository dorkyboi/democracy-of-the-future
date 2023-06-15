<?php

namespace App;

use App\Models\QuestionAnswer;

class QuestionsService
{

    protected QuestionAnswer $model;

    public function __construct()
    {
        $this->model = new QuestionAnswer();
    }

    public function isExist(string $titleHash, $question): bool
    {
        return  !is_null($this->model->where('title_hash', $titleHash)
            ->where('question', $question)->first());
    }

    public function store(array $params = [])
    {
        if (isset($params['title_hash']) && isset($params['question']) && isset($params['question'])) {
            $this->model->title_hash = $params['title_hash'];
            $this->model->question = $params['question'];
            $this->model->answers = $params['output'];
            $this->model->save();
        }


    }
}
