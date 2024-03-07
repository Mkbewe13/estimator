<?php

namespace App\Services;

use CurlHandle;
use Illuminate\Support\Facades\Log;

class OpenAiCompletionService
{
    const OPENAI_API_URL = 'https://api.openai.com/v1/chat/completions';

    private CurlHandle $curlHandle;
    private string $model;

    public array $messages = [];
    public function __construct($model = null)
    {
        $this->curlHandle = curl_init();
        $this->model = $model ?? 'gpt-4-1106-preview';
    }

    private function postRequest($url, string $data)
    {
        // Initialize a cURL session
        $this->curlHandle = curl_init();

        // Set the URL of the request
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);

        // Set the option to return the response as a string instead of outputting it
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);

        // Set the request method to POST
        curl_setopt($this->curlHandle, CURLOPT_POST, 1);

        // Set the POST fields to the JSON-encoded data
        curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $data);

        // Set the headers for the request
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_ENV["OPENAI_API_KEY"],
        );
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $headers);

        // Execute the cURL session
        $response = curl_exec($this->curlHandle);

        // Close the cURL session
        curl_close($this->curlHandle);

        // Return the response
        return $response;
    }


    public function sendMessageGetResponse(string $message)
    {
        return $this->postRequest(self::OPENAI_API_URL, $message);
    }

    public function getResponse(): bool|string
    {
        $requestData = json_encode([
            "messages" => $this->messages, "model" => $this->model]);
        $response = $this->postRequest(self::OPENAI_API_URL, $requestData);
        Log::info(json_encode($response));
        $response = isset(json_decode($response)->choices[0]->message->content) ? json_decode($response)->choices[0]->message->content : false;

        if(!$response){
            Log::info('test ret false0');
            return false;
        }

        $this->messages[] = ['role' => 'assistant','content' => $response];
        return $response;

    }

    public function prepareMessages(string $nextMessageRole, string $nextMessage,?array $messages = null)
    {
        if($messages){
            $this->messages = $messages;
        }
        $this->messages[] = ['role' => $nextMessageRole, 'content' => $nextMessage];

        $data = array(
            "messages" => $this->messages,
            "model" => $this->model
        );
        return json_encode($data);
    }
}
