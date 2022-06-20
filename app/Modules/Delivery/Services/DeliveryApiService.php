<?php


namespace App\Modules\Delivery\Services;


use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Modules\Delivery\Dto\DeliveryFormatDTO;
use App\Modules\Delivery\Dto\DeliveryRequestDTO;
use App\Modules\Delivery\Enums\DeliveryType;
use App\Modules\Delivery\Models\Delivery;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DeliveryApiService extends RemoteApiService
{
    /**
     * @param DeliveryRequestDTO $deliveryRequestDTO
     * @param int $deliveryType
     * @return Collection
     * @throws UnknownProperties
     */
    public function getDeliveryCalculation(DeliveryRequestDTO $deliveryRequestDTO, int $deliveryType): Collection
    {
        $listDeliveryData = new Collection();

        $listDeliveries = $this->getListDeliveries($deliveryType, $deliveryRequestDTO->companyName);

        foreach ($listDeliveries as $delivery) {
            try {
                $data = $this->sendRequestTransportCompanies($delivery->url, $deliveryRequestDTO->all());
            } catch (GuzzleException $e) {
                Log::error($e->getMessage());
                $data = (new TransportCompanyApiService())->getGeneratedResponse();
            }
            $listDeliveryData->add($this->getDeliveryDataFormat($delivery, $data));
        }

        return $listDeliveryData;
    }

    /**
     * @param int $deliveryType
     * @param string|null $companyName
     * @return Collection|Delivery[]
     */
    public function getListDeliveries(int $deliveryType, string $companyName = null): array|Collection
    {
        $listDeliveries = Delivery::whereType($deliveryType);

        if ($companyName) {
            $listDeliveries->where('company_name', $companyName);
        }

        return $listDeliveries->get();
    }

    /**
     * @param string $url
     * @param array $deliveryData
     * @return array
     * @throws GuzzleException
     */
    private function sendRequestTransportCompanies(string $url, array $deliveryData): array
    {
        $this->headers[] = 'application/json';

        $response = $this->client->get($url, [
            'data' => $deliveryData,
        ]);

        return json_decode((string)$response->getBody(), true)['data'];
    }

    /**
     * @param Delivery $delivery
     * @param array $data
     * @return DeliveryFormatDTO
     * @throws UnknownProperties
     */
    public function getDeliveryDataFormat(Delivery $delivery, array $data): DeliveryFormatDTO
    {
        return new DeliveryFormatDTO(
            [
                'price' => $delivery->type == DeliveryType::FAST ?
                    $data['price'] : $delivery->price * $data['coefficient'],
                'date' => $delivery->type == DeliveryType::FAST ?
                    Carbon::now()->addDays($data['period'])->format('Y-m-d') : $data['date'],
                'error' => $data['error']
            ]
        );
    }
}
