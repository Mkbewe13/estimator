<?php

namespace App\View\Components;

use App\Enums\EstFormRowSize;
use App\Enums\QuotationStatus;
use Illuminate\Http\Client\Request;
use Illuminate\View\Component;
use Illuminate\View\View;
use function Symfony\Component\String\b;

class EstFormRow extends Component
{

    public function __construct(
        public string $id,
        public string $label,
        public string $ordinalNumber = "1",
        public string $size = "medium",
        public string $textAreaRows = "4",
        public string $colWidthClass = "col-sm")
    {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
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
