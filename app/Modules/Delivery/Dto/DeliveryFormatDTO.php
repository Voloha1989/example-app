<?php


namespace App\Modules\Delivery\Dto;


use Spatie\DataTransferObject\DataTransferObject;

class DeliveryFormatDTO extends DataTransferObject
{
    public float $price;
    public string $date;
    public string $error;
}
