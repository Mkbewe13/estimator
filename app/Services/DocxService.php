<?php

namespace App\Services;

use App\Models\QuotationData;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\SimpleType\Jc;

class DocxService
{
    public function prepareQuotationDataDocx(QuotationData $quotationData): PhpWord
    {
        $phpWord = new PhpWord();

        $phpWord->addTitleStyle(
            1,
            ['name' => 'Arial', 'size' => 15, 'color' => '000000', 'bold' => true],
            ['alignment' => Jc::START]
        );

        $paragraphStyleName = 'Paragraph';
        $phpWord->addParagraphStyle(
            $paragraphStyleName,
            ['indentation' => ['left' => 480]]
        );

        $section = $phpWord->addSection();
        $this->addTitleAndText($section,"Description",$quotationData->description);
        $this->addTitleAndText($section,"Userflow",$quotationData->userflow);
        $this->addTitleAndText($section,"Requirements",$quotationData->requirements);

        return $phpWord;

    }

    private function addTitleAndText($section, $title, $text): void
    {
        $section->addTitle($title);
        $text = '<br/>' . str_replace("\n", '<br/>', $text) . '<br/>';
        Html::addHtml($section, $text);
    }

}

