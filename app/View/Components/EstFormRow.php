<?php

namespace App\View\Components;

use App\Enums\EstFormRowSize;
use App\Enums\QuotationStatus;
use App\Models\QuotationData;
use App\Models\VerificationResult;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\View;
use function Symfony\Component\String\b;

class EstFormRow extends Component
{

    public function __construct(
        public string $id,
        public string $label,
        public string $name,
        public int $quotationDataId,
        public string $value = '',
        public string $ordinalNumber = "0",
        public string $size = "medium",
        public string $textAreaRows = "4",
        public string $colWidthClass = "col-sm",
        public bool $isVerified = true,
        public string $rejectedVerificationMessage = "")
    {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        if($this->quotationDataId){
            $quotationData = QuotationData::find($this->quotationDataId);
            $this->value = $quotationData->{$this->name} ?? '';

            if($quotationData->status != QuotationStatus::PREPARING->value && $this->ordinalNumber != 0){
                $verificationResult =  VerificationResult::where('quotation_data_id', $this->quotationDataId)->first();
                $verificationResultDetails = $verificationResult->getVerificationDetailsArray();
                $this->isVerified = $verificationResultDetails[$this->ordinalNumber]['result'];
                $this->rejectedVerificationMessage =  !$this->isVerified ? $verificationResultDetails[$this->ordinalNumber]['message'] : '';

            }
        }



        switch ($this->size){
            case EstFormRowSize::SMALL->value:
                $this->textAreaRows='1';
                $this->colWidthClass = 'col-sm-7';
                break;
            case EstFormRowSize::MEDIUM->value:
                $this->textAreaRows='4';
                break;
            case EstFormRowSize::LARGE->value:
                $this->textAreaRows='8';
                break;
            default:
                break;

        }
        return view('components.est-form-row');
    }
}
