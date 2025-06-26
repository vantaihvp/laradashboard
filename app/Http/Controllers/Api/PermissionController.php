<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends ApiController
{
    public function __construct(private readonly PermissionService $permissionService)
    {
    }

    /**
     * Display a listing of the permissions.
     *
     * @tags Permissions
     */
    public function index(Request $request): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['permission.view']);

        $search = $request->input('search');
        $groupName = $request->input('group_name');

        $permissions = $this->permissionService->getAllPermissionsWithFilters($search, $groupName);

        return $this->resourceResponse(
            PermissionResource::collection($permissions),
            'Permissions retrieved successfully'
        );
    }

    /**
     * Display the specified permission.
     *
     * @tags Permissions
     */
    public function show(int $id): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['permission.view']);

        $permission = $this->permissionService->getPermissionById($id);

        if (! $permission) {
            return $this->errorResponse('Permission not found', 404);
        }

        return $this->resourceResponse(
            new PermissionResource($permission),
            'Permission retrieved successfully'
        );
    }

    /**
     * Get permissions grouped by group name.
     *
     * @tags Permissions
     */
    public function groups(): JsonResponse
    {
        $this->checkAuthorization(Auth::user(), ['permission.view']);

        $groups = $this->permissionService->getDatabasePermissionGroups();

        return $this->successResponse($groups, 'Permission groups retrieved successfully');
    }
}
