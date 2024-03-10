<?php

namespace App\View\Components;

use App\Enums\QuotationStatus;
use Illuminate\Http\Client\Request;
use Illuminate\View\Component;
use Illuminate\View\View;
use function Symfony\Component\String\b;

class EstListItem extends Component
{

    public function __construct(
        public int $id,
        public string $name,
        public string $status,
        public ?string $url,
        public string $displayCssClass ='list-item-status-in-progress',
        public string $displayStatus = '')

    {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $this->displayStatus = QuotationStatus::getStatusNicename($this->status);
        $this->displayCssClass = QuotationStatus::getStatusColorClass($this->status);
        return view('components.est-list-item');
    }
}
