<?php


namespace Modules\Delivery\Services;


use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Delivery\Dto\DeliveryFormatDTO;
use Modules\Delivery\Dto\DeliveryRequestDTO;
use Modules\Delivery\Enums\DeliveryType;
use Modules\Delivery\Models\Transportation;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DeliveryService extends RemoteApiService
{
    /**
     * @param DeliveryRequestDTO $deliveryRequestDTO
     * @param int $deliveryType
     * @return Collection
     * @throws UnknownProperties
     */
    public function getDeliveryCalculation(DeliveryRequestDTO $deliveryRequestDTO, int $deliveryType): Collection
    {
        $listDeliveries = new Collection();

        $listTransportation = $this->getListTransportation($deliveryType, $deliveryRequestDTO->companyName);

        foreach ($listTransportation as $transportation) {
            try {
                $data = $this->sendRequestTransportCompanies($transportation->url, $deliveryRequestDTO->all());
                $listDeliveries->add($this->getDeliveryDataFormat($transportation, $data));
            } catch (GuzzleException $e) {
                Log::error($e->getMessage());
                $data = (new TransportCompanyService())->getGeneratedResponse();
                $listDeliveries->add($this->getDeliveryDataFormat($transportation, $data));
            }
        }

        return $listDeliveries;
    }

    /**
     * @param int $deliveryType
     * @param string|null $companyName
     * @return Collection|Transportation[]
     */
    public function getListTransportation(int $deliveryType, string $companyName = null): array|Collection
    {
        $listTransportation = Transportation::whereType($deliveryType);

        if ($companyName) {
            $listTransportation->where('company_name', $companyName);
        }

        return $listTransportation->get();
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
     * @param Transportation $transportation
     * @param array $data
     * @return DeliveryFormatDTO
     * @throws UnknownProperties
     */
    public function getDeliveryDataFormat(Transportation $transportation, array $data): DeliveryFormatDTO
    {
        return new DeliveryFormatDTO(
            [
                'price' => $transportation->type == DeliveryType::FAST ?
                    $data['price'] : $transportation->price * $data['coefficient'],
                'date' => $transportation->type == DeliveryType::FAST ?
                    Carbon::now()->addDays($data['period'])->format('Y-m-d') : $data['date'],
                'error' => $data['error']
            ]
        );
    }
}
