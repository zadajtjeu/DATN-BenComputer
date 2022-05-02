<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Repositories\Category\CategoryRepositoryInterface;

class UpdateCategoryRequest extends FormRequest
{
    protected $categoryRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
    }

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
            'slug' => [
                'required',
                'string',
                Rule::unique('categories')->ignore($this->category),
            ],
            'parent_id' => [
                'numeric',
                'exists:categories,id',
                'nullable',
                Rule::notIn($this->categoryRepo->getChildrenCategoriesID($this->category)),
            ]
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
