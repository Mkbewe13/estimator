<?php

namespace App\Http\Controllers;

use App\Exports\QuotationResultExport;
use App\Models\QuotationData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class XlsController extends Controller
{

    /**
     * @throws \Exception
     */
    public function download(Request $request){

        $validated = $request->validate([
            'id' => 'required|int',
            'projectSide' => 'required|string'
        ]);

        $quotationData = QuotationData::find($validated['id']);

        if(!$quotationData){
            throw new \Exception('Estimation data is not found by id');
        }

        if($validated['projectSide'] == 'frontend'){
            $quotationResult = $quotationData->frontQuotationResult();
        }elseif($validated['projectSide'] == 'backend'){
            $quotationResult = $quotationData->backQuotationResult();
        }else{
            throw new \Exception('Project side information is not defined');
        }

        $result = json_decode($quotationResult->result,true);

        return Excel::download(new QuotationResultExport($result),$this->getFilename($quotationData->name,ucfirst($validated['projectSide'])));

    }


    private function getFilename(string $projectName, string $projectSide): string
    {
        return $projectName . '-' . $projectSide . '.xls';
    }
}
