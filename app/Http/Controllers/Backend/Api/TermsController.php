<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Term\StoreTermRequest;
use App\Models\Term;
use App\Services\Content\ContentService;
use App\Services\TermService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TermsController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly TermService $termService
    ) {
    }

    /**
     * Store a new term via API
     */
    public function store(StoreTermRequest $request, string $taxonomy): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['term.create']);

        // Get taxonomy.
        $taxonomyModel = $this->contentService->getTaxonomies()->where('name', $taxonomy)->first();

        if (!$taxonomyModel) {
            return response()->json([
                'message' => __('Taxonomy not found')
            ], 404);
        }

        // Create term.
        $term = new Term();
        $term->name = $request->name;
        if ($request->slug) {
            $term->slug = $term->generateUniqueSlug($request->slug);
        }
        $term->taxonomy = $taxonomy;
        $term->description = $request->description;
        $term->parent_id = $request->parent_id ?: null;
        $term->save();

        // Get taxonomy label for message
        $taxLabel = $taxonomyModel->label_singular ?? Str::title($taxonomy);

        return response()->json([
            'message' => __(':taxLabel created successfully', ['taxLabel' => $taxLabel]),
            'term' => $term
        ], 201);
    }
}
