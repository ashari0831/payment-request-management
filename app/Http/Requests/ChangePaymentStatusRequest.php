<?php

namespace App\Http\Requests;

use App\Models\PaymentRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePaymentStatusRequest extends FormRequest
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
            'payment_request_ids' => ['required', 'array', 'min:1'],
            'payment_request_ids.*' => ['uuid'],
            'status' => ['required', 'string', Rule::in(array_keys(PaymentRequest::CHANGEABLE_STATUS))],
            'comment' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
