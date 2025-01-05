<?php

namespace App\Http\Requests;

use App\Models\PaymentRequest;
use App\Rules\CheckShebaNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_category_id' => ['required', 'uuid', Rule::exists('payment_categories', 'id')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:1000'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:2048'],
            'sheba_number' => ['required', 'string', 'regex:/^(?=.{24}$)[0-9]*$/i', new CheckShebaNumber],
            'national_code' => ['required', 'string', 'regex:/^([0-9]){10}$/i', Rule::exists('users', 'national_code')],
        ];
    }
}
