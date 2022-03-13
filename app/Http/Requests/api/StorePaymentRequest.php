<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $transaction = $this->route('transaction');
        $total = $transaction->payments()->pluck('amount')->sum();
        $max_to_paid = $transaction->amount - $total;

        return [
            'amount' => ['required', 'numeric', 'max:'.$max_to_paid],
            'details' => ['sometimes', 'nullable', 'string'],
            'payment_method' => ['sometimes', 'nullable', 'in:cash,visa']
        ];
    }
}
