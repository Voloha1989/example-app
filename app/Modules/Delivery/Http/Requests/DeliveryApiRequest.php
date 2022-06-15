<?php


namespace App\Modules\Delivery\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class DeliveryApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sourceKladr' => 'required|string',
            'targetKladr' => 'required|string',
            'weightFloat' => 'required|numeric',
            'companyName' => 'string'
        ];
    }
}
