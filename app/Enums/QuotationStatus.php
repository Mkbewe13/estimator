<?php

namespace App\Enums;

enum QuotationStatus: string
{
    case PREPARING = 'preparing';
    case WAITING_FOR_ACCEPT = 'waiting_for_accept';
    case ACCEPTATION_IN_PROGRESS = 'acceptation_in_progress';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
    case ESTIMATION_IN_PROGRESS = 'estimation_in_progress';
    case DONE = 'done';


    public static function getStatusDescription(string $statusEnumValue){
        switch ($statusEnumValue){
            case QuotationStatus::PREPARING->value:
                return "Data object is created, but not complete.";
            case QuotationStatus::WAITING_FOR_ACCEPT->value:
                return "Data object is complete, but not verified.";
            case QuotationStatus::ACCEPTATION_IN_PROGRESS->value:
                return "Data for estimation is verified for completeness and security";
            case QuotationStatus::REJECTED->value:
                return "Data was rejected during verification.";
            case QuotationStatus::ACCEPTED->value:
                return "Data was accepted during verification. Ready to run estimation process.";
            case QuotationStatus::ESTIMATION_IN_PROGRESS->value:
                return "Your estimation is in progress.";
            case QuotationStatus::DONE->value:
                return "Your estimation is ready!";
            default:
                return "Wrong status check ENUM";
        }
    }

    public static function getStatusColorClass(string $statusEnumValue): string
    {
        return match ($statusEnumValue) {
            QuotationStatus::PREPARING->value => "list-item-status-preparing",
            QuotationStatus::WAITING_FOR_ACCEPT->value => "list-item-status-waiting",
            QuotationStatus::ESTIMATION_IN_PROGRESS->value, QuotationStatus::ACCEPTATION_IN_PROGRESS->value => "list-item-status-in-progress",
            QuotationStatus::REJECTED->value => "list-item-status-rejected",
            QuotationStatus::ACCEPTED->value => "list-item-status-accepted",
            QuotationStatus::DONE->value => "list-item-status-done",
            default => "",
        };
    }

    public static function getStatusNicename(string $statusEnumValue): string
    {
        return match ($statusEnumValue) {
            QuotationStatus::PREPARING->value => "Preparing",
            QuotationStatus::WAITING_FOR_ACCEPT->value => "Waiting for data verification",
            QuotationStatus::ACCEPTATION_IN_PROGRESS->value => "Verification in progress...",
            QuotationStatus::REJECTED->value => "Rejected",
            QuotationStatus::ACCEPTED->value => "Data accepted",
            QuotationStatus::ESTIMATION_IN_PROGRESS->value => "Estimation in progress...",
            QuotationStatus::DONE->value => "Ready to download",
            default => "",
        };
    }

}
