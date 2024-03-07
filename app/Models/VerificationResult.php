<?php

namespace App\Models;

use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Model;

class VerificationResult extends Model
{
    public function quotationData()
    {
        return $this->belongsTo(QuotationData::class, 'quotation_data_id');
    }


    public function getVerificationDetailsArray(): array
    {
        $details = $this->result_data;
        $result = [];
        $details = json_decode($details);
        foreach ($details as $detail){
            $result[$detail->field_number] = [
                'result' => $detail->result,
                'message' => $detail->msg,
            ];
        }
        return $result;
    }

    public static function checkIfFieldIsVerified(int $quotationDataId,int $fieldNumber): bool
    {
        $quotationData = QuotationData::find($quotationDataId);
        if($quotationData->status != QuotationStatus::REJECTED->value && $quotationData->status != QuotationStatus::ACCEPTED->value){
            return true;
        }

        $verificationResult = VerificationResult::where('quotation_data_id', $quotationDataId)->first();

        $verificationDetails = $verificationResult->getVerificationDetailsArray();

        return (bool)$verificationDetails[$fieldNumber]['result'];
    }



}
