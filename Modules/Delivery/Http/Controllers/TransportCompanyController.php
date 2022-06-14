<?php


namespace Modules\Delivery\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

class TransportCompanyController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculationFastDelivery(Request $request): JsonResponse
    {
        return response()->json(
            ['data' => [
                'price' => floatval(rand() / 10),
                'period' => Carbon::now()->hour < 18 ? 1 : 0,
                'error' => 'false'
            ]]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculationSlowDelivery(Request $request): JsonResponse
    {
        return response()->json(
            ['data' => [
                'coefficient' => floatval(rand(0, 10) / 10),
                'date' => Carbon::now()->format('Y-m-d'),
                'error' => 'false'
            ]]);
    }
}
