<?php

namespace App;

use Illuminate\Support\Facades\Log;
use OpenAI\Client;

class OpenApiService
{
    protected Client $client;
    protected string $actTitle;

    public function __construct(string $actTitle = '')
    {
        $this->actTitle = $actTitle;
        $yourApiKey = getenv('YOUR_API_KEY');
        $this->client = \OpenAI::client($yourApiKey);
    }

    public function ask(string $question):array
    {
        $queryQuestion = $question . ' w dokumencie '. $this->actTitle ;

        $output = [
            "actTitle" => $this->actTitle,
            'initQuestion' => $question,
            'queryQuestion' => $queryQuestion,
            'output' => ''
        ];

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $queryQuestion],
            ],
        ]);

        foreach ($response->choices as $result) {
                        $output['output'] .= $result->message->content;
        }

        return $output;
    }

}
