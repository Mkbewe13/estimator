<?php

namespace App\Services;

use App\Models\QuotationData;
use App\Models\QuotationResult;
use Exception;
use Illuminate\Support\Facades\Log;

class QuotationService
{
    private QuotationData $quotationData;
    private OpenAiCompletionService $frontendQuotation;

    private OpenAiCompletionService $backendQuotation;


    public function __construct(QuotationData $quotationData){
            $this->quotationData = $quotationData;
            $this->frontendQuotation = new OpenAiCompletionService();
            $this->backendQuotation = new OpenAiCompletionService();
    }


    public function runQuotation(){
        $this->backendQuotation->prepareMessages('system',$this->getSystemPrompt('backend'));
        $this->backendQuotation->prepareMessages('user',$this->getApplicationDataPrompt() . "\n" . $this->getEstimationStartPrompt('mid','backend'));
        $backendResponse = $this->backendQuotation->getResponse();

        $this->frontendQuotation->prepareMessages('system',$this->getSystemPrompt('frontend'));
        $this->frontendQuotation->prepareMessages('user',$this->getApplicationDataPrompt() . "\n" . $this->getEstimationStartPrompt('mid','frontend'));
        $frontendResponse = $this->frontendQuotation->getResponse();

        $this->processBackendQuotation($backendResponse);
        $this->processFrontendQuotation($frontendResponse);

    }


    private function prepareModels(){


    }

    private function prepareFrontendModel(){

    }

    private function prepareBackendModel(){

    }

    private function getApplicationDataPrompt(): string
    {
        return sprintf(
            "
    \n
    ###
    Description of the application:
    %s
    ###
    \n
    ###
    Userflow:
    %s
    ###
    \n
    ###
    Application requirements:
    %s
    ###
    \n
    ",
    $this->quotationData->getAttribute('description'),
    $this->quotationData->getAttribute('userflow'),
    $this->quotationData->getAttribute('requirements'));
    }


    private function getEstimationStartPrompt(string $experienceLevel,string $projectSide){
        $jsonExample = '[
{
	"description": "Initializing the Laravel project, installing necessary packages, configuring environments.",
	"min": 3,
	"max": 4
},
{
	"description": "Creating data models (Entity Relationship Diagram), and migrations for sectors, product ranges, products, product properties, etc.",
	"min": 10,
	"max": 12
},
 {
	"description": "Creating authentication system, defining roles and permissions.",
	"min": 8,
	"max": 10
}
  ... etc.
  ]';

        return sprintf("Your task is to describe every thing that needs to be done on %s side to complete this project.
        For each task, estimate the time needed to complete it, in the form of a minimum-maximum range.
        Take into account that the team working on this project will have %s developer experience.
        \n
        # How to respond to this prompt
        - Your response MUST be a JSON array
        - No other text, just the JSON array please
        - Without json header and footer
        Answer should look like that:
        %s
        \n
        Be as accurate as possible, this is a very important task for a very important client of our company.",
            $projectSide,$experienceLevel,$jsonExample
        );
    }


    private function getSystemPrompt(string $projectSide){
        $jsonExample = '[
{
	"description": "Initializing the Laravel project, installing necessary packages, configuring environments.",
	"min": 3,
	"max": 4
},
{
	"description": "Creating data models (Entity Relationship Diagram), and migrations for sectors, product ranges, products, product properties, etc.",
	"min": 10,
	"max": 12
},
 {
	"description": "Creating authentication system, defining roles and permissions.",
	"min": 8,
	"max": 10
}
  ... etc.
  ]';
        return sprintf("Act like senior %s developer.
        You are specialist in creating project estimates for clients.
        You are very accurate and effective in estimating the number of hours needed to complete a task.
        \n
        # How to respond to this prompt
        - Your response MUST be a JSON array
        - No other text, just the JSON array please
        - Without json header and footer
        Answer should look like that:
        %s
        ",$projectSide,$jsonExample);
    }

    private function getAdditionalSystemPromptInfo(){
        "When creating an estimate, take into account the following:
    - the team doesn't spend much time writing unit tests. The team tests mainly manually and unit tests are written only for a few key functionalities
    - the team takes a specific approach to meetings with clients and tries not to waste too much time on them and focuses mainly on code development.
    - in each project, the team creates local, staging and production environments.";
    }

    private function processBackendQuotation(bool|string $response)
    {
        try {
            $processedResponse = $this->processResponse($response);

            $quotationResult = new QuotationResult();
            $quotationResult->result = json_encode($processedResponse);
            $quotationResult->project_side = 'backend';
            $quotationResult->quotation_data_id = $this->quotationData->id;
            $quotationResult->save();

            $this->markQuotationDataAsDone();
            Log::info('Backend quotation processed successfully for Q_Data ID:' . $this->quotationData->id);
        }catch (Exception $e){
            switch ($e->getCode()){
                case 1:
                    Log::info('Backend Error ID:' . $e->getCode());
                    break;
                case 2:
                    Log::info('Backend Error ID:' . $e->getCode());
                    break;
                case 3:
                    Log::info('Backend Error ID:' . $e->getCode());
                    break;
            }
        }

    }

    private function processFrontendQuotation(bool|string $response)
    {

        try {
        $processedResponse = $this->processResponse($response);

        $quotationResult = new QuotationResult();
        $quotationResult->result = json_encode($processedResponse);
        $quotationResult->project_side = 'frontend';
        $quotationResult->quotation_data_id = $this->quotationData->id;
        $quotationResult->save();

        $this->markQuotationDataAsDone();
        Log::info('Frontend quotation processed successfully for Q_Data ID:' . $this->quotationData->id);

        }catch (Exception $e){
            switch ($e->getCode()){
                case 1:
                    Log::info('Frontend Error ID:' . $e->getCode());
                    break;
                case 2:
                    Log::info('Frontend Error ID:' . $e->getCode());
                    break;
                case 3:
                    Log::info('Frontend Error ID:' . $e->getCode());
                    break;
                default:
                    Log::info($e->getMessage());
            }

        }



    }


    /**
     * @throws Exception
     */
    private function processResponse($response){
        Log::info($response);
        if(!$response){
            throw new Exception('No response from model.',1);
        }

        $response = json_decode($response);


        if (!$response){
            throw new Exception('Wrong response format.',2);
        }

        $processedResponse = [];
        $iterator = 1;
        foreach ($response as $task){
            if(
                !isset($task->description) ||
                !isset($task->min) ||
                !isset($task->max)
            ){
                throw new Exception('Missing data in processing',3);
            }

            $processedResponse[$iterator]['description'] = $task->description;
            $processedResponse[$iterator]['min'] = $task->min;
            $processedResponse[$iterator]['max'] = $task->max;
            $iterator++;
        }

        return $processedResponse;

    }

    private function markQuotationDataAsDone(){
        $this->quotationData->status = 'done';
        $this->quotationData->save();
    }

}
