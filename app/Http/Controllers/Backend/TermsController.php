<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Term\StoreTermRequest;
use App\Http\Requests\Term\UpdateTermRequest;
use App\Models\Term;
use App\Services\Content\ContentService;
use App\Services\TermService;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly TermService $termService
    ) {
    }

    public function index(Request $request, string $taxonomy)
    {
        $this->checkAuthorization(auth()->user(), ['term.view']);

        // Get taxonomy using service
        $taxonomyModel = $this->termService->getTaxonomy($taxonomy);

        if (!$taxonomyModel) {
            return redirect()->route('admin.posts.index')->with('error', __('Taxonomy not found'));
        }

        // Prepare filters
        $filters = [
            'taxonomy' => $taxonomy,
            'search' => $request->search
        ];

        // Get terms with pagination using service
        $terms = $this->termService->getTerms($filters);

        // Get parent terms for hierarchical taxonomies.
        $parentTerms = [];
        if ($taxonomyModel->hierarchical) {
            $parentTerms = Term::where('taxonomy', $taxonomy)
                ->orderBy('name', 'asc')
                ->get();
        }

        // Get term being edited if exists
        $term = null;
        if ($request->has('edit') && is_numeric($request->edit)) {
            $term = Term::findOrFail($request->edit);
        }

        return view('backend.pages.terms.index', compact('terms', 'taxonomy', 'taxonomyModel', 'parentTerms', 'term'))
            ->with([
                'breadcrumbs' => [
                    'title' => $taxonomyModel->label,
                ]
            ]);
    }

    public function store(StoreTermRequest $request, string $taxonomy)
    {
        // Get taxonomy using service
        $taxonomyModel = $this->termService->getTaxonomy($taxonomy);

        if (!$taxonomyModel) {
            return redirect()->route('admin.posts.index')->with('error', __('Taxonomy not found'));
        }

        // Create term using service
        $term = $this->termService->createTerm($request->validated(), $taxonomy);

        // Get taxonomy label for message
        $taxLabel = $this->termService->getTaxonomyLabel($taxonomy, true);

        return redirect()->route('admin.terms.index', $taxonomy)
            ->with('success', __(':taxLabel created successfully', ['taxLabel' => $taxLabel]));
    }

    public function update(UpdateTermRequest $request, string $taxonomy, string $id)
    {
        // Get taxonomy using service
        $taxonomyModel = $this->termService->getTaxonomy($taxonomy);

        if (!$taxonomyModel) {
            return redirect()->route('admin.posts.index')->with('error', __('Taxonomy not found'));
        }

        // Get term using service
        $term = $this->termService->getTermById((int)$id, $taxonomy);

        // Update term using service
        $this->termService->updateTerm($term, $request->validated());

        // Get taxonomy label for message
        $taxLabel = $this->termService->getTaxonomyLabel($taxonomy, true);

        return redirect()->route('admin.terms.index', $taxonomy)
            ->with('success', __(':taxLabel updated successfully', ['taxLabel' => $taxLabel]));
    }

    public function destroy(string $taxonomy, string $id)
    {
        $this->checkAuthorization(auth()->user(), ['term.delete']);

        // Get taxonomy using service
        $taxonomyModel = $this->termService->getTaxonomy($taxonomy);

        if (!$taxonomyModel) {
            return redirect()->route('admin.posts.index')->with('error', __('Taxonomy not found'));
        }

        // Get term using service
        $term = $this->termService->getTermById((int)$id, $taxonomy);

        // Get taxonomy label for messages
        $taxLabel = $this->termService->getTaxonomyLabel($taxonomy, true);

        // Check if term can be deleted
        $errors = $this->termService->canDeleteTerm($term);

        if (in_array('has_posts', $errors)) {
            return redirect()->route('admin.terms.index', $taxonomy)
                ->with('error', __('Cannot delete :taxLabel as it is associated with posts', ['taxLabel' => $taxLabel]));
        }

        if (in_array('has_children', $errors)) {
            return redirect()->route('admin.terms.index', $taxonomy)
                ->with('error', __('Cannot delete :taxLabel as it has child items', ['taxLabel' => $taxLabel]));
        }

        // Delete term using service
        $this->termService->deleteTerm($term);

        return redirect()->route('admin.terms.index', $taxonomy)
            ->with('success', __(':taxLabel deleted successfully', ['taxLabel' => $taxLabel]));
    }

    public function edit(string $taxonomy, string $term)
    {
        $this->checkAuthorization(auth()->user(), ['term.edit']);

        // Get taxonomy using service
        $taxonomyModel = $this->termService->getTaxonomy($taxonomy);

        if (!$taxonomyModel) {
            return redirect()->route('admin.posts.index')->with('error', __('Taxonomy not found'));
        }

        // Get term using service
        $term = $this->termService->getTermById((int)$term, $taxonomy);

        // Get parent terms for hierarchical taxonomies.
        $parentTerms = [];
        if ($taxonomyModel->hierarchical) {
            $parentTerms = Term::where('taxonomy', $taxonomy)
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('backend.pages.terms.edit', compact('taxonomy', 'taxonomyModel', 'term', 'parentTerms'))
            ->with('breadcrumbs', [
                'title' => __('Edit :taxLabel', ['taxLabel' => $taxonomyModel->label_singular]),
                'items' => [
                    [
                        'label' => $taxonomyModel->label,
                        'url' => route('admin.terms.index', $taxonomy)
                    ],
                ]
            ]);
    }
}
