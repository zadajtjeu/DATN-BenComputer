<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
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
            'title' => 'required|min:3|max:191',
            'slug' => 'required|min:3|max:191|unique:products',
            'quantity' => 'required|integer|digits_between:1,5',
            'price'=> 'required|numeric|digits_between:4,9',
            'promotion_price'=> 'numeric|max:' . $this->price . '|digits_between:4,9|nullable',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string|min:3',
            'specifications'=> 'required|string|min:3',
            'image' => 'required|min:1|max:5',
            'image.*'  => 'image|mimes:jpg,png,jpeg|max:2048',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => empty($this->slug) ? Str::slug($this->name) : Str::slug($this->slug),
            'promotion_price' => empty($this->promotion_price) ? null : $this->promotion_price
        ]);
    }
}
