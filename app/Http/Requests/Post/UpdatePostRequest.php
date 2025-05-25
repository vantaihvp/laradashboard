<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->checkAuthorization(Auth::user(), ['post.edit']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $postId = $this->route('id');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $postId,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,publish,pending,future,private',
            'featured_image' => 'nullable|file|image|max:5120',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
            'remove_featured_image' => 'nullable|boolean',
        ];
    }
}
