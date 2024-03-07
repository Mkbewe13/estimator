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
        switch ($this->status){
            case QuotationStatus::DONE->value:
                $this->displayStatus='Ready to download';
                $this->displayCssClass = 'list-item-status-done';
                break;
            case QuotationStatus::ESTIMATION_IN_PROGRESS->value:
                $this->displayStatus='Estimation in progress...';
                $this->displayCssClass = 'list-item-status-in-progress';
                break;
            case QuotationStatus::WAITING_FOR_ACCEPT->value:
                $this->displayStatus='Waiting for data verification';
                $this->displayCssClass = 'list-item-status-waiting';
                break;
            case QuotationStatus::ACCEPTATION_IN_PROGRESS->value:
                $this->displayStatus='Verification in progress...';
                $this->displayCssClass = 'list-item-status-in-progress';
                break;
            case QuotationStatus::REJECTED->value:
                $this->displayStatus='Rejected';
                $this->displayCssClass = 'list-item-status-rejected';
                break;
            case QuotationStatus::ACCEPTED->value:
                $this->displayStatus='Data accepted';
                $this->displayCssClass = 'list-item-status-accepted';
                break;
            case QuotationStatus::PREPARING->value:
                $this->displayStatus='Preparing data';
                $this->displayCssClass = 'list-item-status-preparing';
                break;
            default:
                $this->status='Wrong status';

        }
        return view('components.est-list-item');
    }
}
