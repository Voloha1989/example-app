<?php


namespace App\Modules\Delivery\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Modules\Delivery\Enums\DeliveryType;
use App\Modules\Delivery\Http\Requests\DeliveryApiRequest;
use App\Modules\Delivery\Services\DeliveryApiService;
use App\Modules\Delivery\Dto\DeliveryRequestDTO;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DeliveryApiController extends Controller
{
    protected DeliveryApiService $deliveryApiService;

    /**
     * DeliveryApiController constructor.
     * @param DeliveryApiService $deliveryApiService
     */
    public function __construct(DeliveryApiService $deliveryApiService)
    {
        $this->deliveryApiService = $deliveryApiService;
    }

    /**
     * @param DeliveryApiRequest $deliveryApiRequest
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function fast(DeliveryApiRequest $deliveryApiRequest): JsonResponse
    {
        $deliveryRequestDTO = new DeliveryRequestDTO($deliveryApiRequest->validated());
        $res = $this->deliveryApiService->getDeliveryCalculation($deliveryRequestDTO, DeliveryType::FAST);
        return response()->json($res);
    }

    /**
     * @param DeliveryApiRequest $deliveryApiRequest
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function slow(DeliveryApiRequest $deliveryApiRequest): JsonResponse
    {
        $deliveryRequestDTO = new DeliveryRequestDTO($deliveryApiRequest->validated());
        $res = $this->deliveryApiService->getDeliveryCalculation($deliveryRequestDTO, DeliveryType::SLOW);
        return response()->json($res);
    }
}
