<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\ActionLogResource;
use App\Services\ActionLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionLogController extends ApiController
{
    public function __construct(private readonly ActionLogService $actionLogService)
    {
    }

    /**
     * Display a listing of the action logs.
     *
     * @tags Action Logs
     */
    public function index(Request $request): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['actionlog.view']);

        $filters = $request->only(['search', 'action_type', 'user_id', 'model_type']);
        $perPage = (int) ($request->input('per_page') ?? config('settings.default_pagination', 10));

        $actionLogs = $this->actionLogService->getPaginatedActionLogs($filters, $perPage);

        return $this->resourceResponse(
            ActionLogResource::collection($actionLogs)->additional([
                'meta' => [
                    'pagination' => [
                        'current_page' => $actionLogs->currentPage(),
                        'last_page' => $actionLogs->lastPage(),
                        'per_page' => $actionLogs->perPage(),
                        'total' => $actionLogs->total(),
                    ],
                ],
            ]),
            'Action logs retrieved successfully'
        );
    }

    /**
     * Display the specified action log.
     *
     * @tags Action Logs
     */
    public function show(int $id): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['actionlog.view']);

        $actionLog = $this->actionLogService->getActionLogById($id);

        if (! $actionLog) {
            return $this->errorResponse('Action log not found', 404);
        }

        return $this->resourceResponse(
            new ActionLogResource($actionLog),
            'Action log retrieved successfully'
        );
    }
}
