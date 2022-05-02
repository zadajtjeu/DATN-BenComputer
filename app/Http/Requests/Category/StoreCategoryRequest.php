<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|min:3|max:191',
            'slug' => 'required|min:3|max:191|unique:categories',
            'parent_id' => 'exists:categories,id|nullable'
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
            'name' => $this->name,
            'slug' => empty($this->slug) ? Str::slug($this->name) : Str::slug($this->slug),
            'parent_id' => $this->parent_id == 0 ? null : $this->parent_id,
        ]);
    }
}
