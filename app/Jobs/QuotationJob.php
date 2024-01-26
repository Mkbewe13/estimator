<?php

namespace App\Jobs;

use App\Models\QuotationData;
use App\Services\QuotationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class QuotationJob implements ShouldQueue
{
    public int $timeout = 400;
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
     */
    public function handle(): void
    {
        $quotationData =  QuotationData::find($this->quotationDataId);
        $quotationService = new QuotationService($quotationData);
       $quotationService->runQuotation();
    }

}
