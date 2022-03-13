<?php

namespace App\Http\Requests\api\transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'sub_category_id' => ['sometimes', 'nullable', 'integer', Rule::exists('sub_categories', 'id')],
            'amount' => ['required', 'numeric'],
            'due_on' => ['required', 'date'],
            'vat' => ['required', 'numeric'],
            'is_vat_inclusive' => ['required', 'in:true,false'],
            'status' => ['string', 'in:overdue,outstanding,paid']
        ];
    }
}
