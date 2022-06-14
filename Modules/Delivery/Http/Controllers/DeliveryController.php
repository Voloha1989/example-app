<?php

namespace Modules\Delivery\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Delivery\Dto\DeliveryRequestDTO;
use Modules\Delivery\Enums\DeliveryType;
use Modules\Delivery\Http\Requests\DeliveryRequest;
use Modules\Delivery\Services\DeliveryService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DeliveryController extends Controller
{
    protected DeliveryService $deliveryService;

    /**
     * DeliveryController constructor.
     * @param DeliveryService $deliveryService
     */
    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * @param DeliveryRequest $deliveryRequest
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function fast(DeliveryRequest $deliveryRequest): JsonResponse
    {
        $deliveryRequestDTO = new DeliveryRequestDTO($deliveryRequest->validated());
        $res = $this->deliveryService->getDeliveryCalculation($deliveryRequestDTO, DeliveryType::FAST);
        return response()->json($res);
    }

    /**
     * @param DeliveryRequest $deliveryRequest
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function slow(DeliveryRequest $deliveryRequest): JsonResponse
    {
        $deliveryRequestDTO = new DeliveryRequestDTO($deliveryRequest->validated());
        $res = $this->deliveryService->getDeliveryCalculation($deliveryRequestDTO, DeliveryType::SLOW);
        return response()->json($res);
    }
}
