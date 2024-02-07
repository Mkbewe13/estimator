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
        public string $name,
        public string $status,
        public string $url,
        public string $displayCssClass ='list-item-status-in-progress')
    {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        switch ($this->status){
            case QuotationStatus::DONE->value:
                $this->status='Ready to download';
                $this->displayCssClass = 'list-item-status-done';
                break;
            case QuotationStatus::IN_PROGRESS->value:
                $this->status='In progress...';
                $this->displayCssClass = 'list-item-status-in-progress';
                break;
            case QuotationStatus::NEW->value:
                $this->status='New';
                $this->displayCssClass = 'list-item-status-new';
                break;
            default:
                $this->status='Wrong status';

        }
        return view('components.est-list-item');
    }
}
