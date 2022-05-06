<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:191',
            'slug' => 'required|min:3|max:191|unique:posts',
            'content' => 'required|string|min:3',
            'description' => 'string|nullable',
            'post_type_id' => 'required|exists:post_types,id',
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
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
            'user_id' => Auth::id(),
        ]);
    }
}
