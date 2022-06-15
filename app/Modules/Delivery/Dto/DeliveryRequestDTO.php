<?php


namespace App\Modules\Delivery\Dto;


use Spatie\DataTransferObject\DataTransferObject;

class DeliveryRequestDTO extends DataTransferObject
{
    public string $sourceKladr;
    public string $targetKladr;
    public float $weightFloat;
    public ?string $companyName = null;
}
