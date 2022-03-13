<?php

namespace App\Http\Requests\api\subCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
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
            'name' => ['string', 'required', Rule::unique('sub_categories', 'name')->ignore($this->sub_category->id)]
        ];
    }
}
