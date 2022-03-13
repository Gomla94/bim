<?php

namespace App\Http\Requests\api\subCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubCategory extends FormRequest
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
            'name' => ['string', 'required', Rule::unique('sub_categories', 'name')],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')]
        ];
    }
}
