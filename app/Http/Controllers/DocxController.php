<?php

namespace App\Http\Controllers;

use App\Models\QuotationData;
use App\Services\DocxService;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Mockery\Exception;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocxController extends Controller
{
    /**
     * Download generated docx file on the fly.
     *
     * @throws \Exception
     */
    public function download(Request $request): BinaryFileResponse
    {

        $validated = $request->validate([
            'id' => 'required|int',
        ]);

        $quotationData = QuotationData::find($validated['id']);

        if (!$quotationData) {
            throw new \Exception('Estimation data is not found by id');
        }


        $docxService = new DocxService();
        $phpWord = $docxService->prepareQuotationDataDocx($quotationData);

        try {
            $objWriter = IOFactory::createWriter($phpWord);
        }catch (\Exception $e){
            throw new \Exception('An error occured while generating docx file');
        }

        $fileName = $quotationData->name . '.docx';

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($fileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $objWriter->save('php://output');
        exit;
    }


}
