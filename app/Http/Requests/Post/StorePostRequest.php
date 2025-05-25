<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->checkAuthorization(Auth::user(), ['post.create']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return ld_apply_filters('post.store.validation.rules', [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,publish,pending,future,private',
            'featured_image' => 'nullable|file|image|max:5120',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
        ]);
    }
}
