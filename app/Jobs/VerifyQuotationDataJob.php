<?php

namespace App\Jobs;

use App\Enums\QuotationStatus;
use App\Models\QuotationData;
use App\Models\VerificationResult;
use App\Services\DataVerificationService;
use App\Services\OpenAiCompletionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyQuotationDataJob implements ShouldQueue
{
    private int $quotationDataId;


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(int $quotationDataId)
    {
        $this->quotationDataId = $quotationDataId;
    }


    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(): void
    {
        $quotationData = QuotationData::find($this->quotationDataId);
        try {
            $verificationService = new DataVerificationService($quotationData->getProjectData(),$this->quotationDataId);
           $result = $verificationService->startVerification();
        } catch (\Exception $exception) {
            if ($this->attempts() > 3) {
                $verificationResult = new VerificationResult();
                $verificationResult->quotation_data_id =$this->quotationDataId;
                $verificationResult->result_data = "";
                $verificationResult->is_verified = false;
                $verificationResult->save();
                throw $exception;
            }

            $this->release(60);
            return;
        }
        if($result){
            $quotationData->status = QuotationStatus::ACCEPTED->value;
        }else{
            $quotationData->status  = QuotationStatus::REJECTED->value;
        }
        $quotationData->save();

    }
}
