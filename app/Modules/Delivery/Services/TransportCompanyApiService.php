<?php


namespace App\Modules\Delivery\Services;


use Carbon\Carbon;

class TransportCompanyApiService
{
    /**
     * @return array
     */
    public function getGeneratedResponse(): array
    {
        return [
            'price' =>  floatval(rand() / 10),
            'period' => Carbon::now()->hour < 18 ? 1 : 0,
            'coefficient' => floatval(rand(0, 10) / 10),
            'date' => Carbon::now()->format('Y-m-d'),
            'error' => 'true'
        ];
    }
}
