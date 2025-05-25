<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleRequest;
use App\Services\Modules\ModuleService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModulesController extends Controller
{
    public function __construct(private readonly ModuleService $moduleService)
    {
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['module.view']);

        return view('backend.pages.modules.index', [
            'modules' => $this->moduleService->getModules(),
        ]);
    }

    public function store(StoreModuleRequest $request): RedirectResponse
    {
        if (config('app.demo_mode', false)) {
            session()->flash('error', __('Module upload is restricted in demo mode. Please try on your local/live environment.'));
            return redirect()->route('admin.modules.index');
        }

        $this->checkAuthorization(auth()->user(), ['module.create']);

        try {
            $this->moduleService->uploadModule($request);

            session()->flash('success', __('Module uploaded successfully.'));
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }

        return redirect()->route('admin.modules.index');
    }

    public function toggleStatus(string $moduleName): JsonResponse
    {
        if (config('app.demo_mode', false)) {
            session()->flash('error', __('Module enabling/disabling is restricted in demo mode. Please try on your local/live environment.'));
            return response()->json(['success' => false, 'message' => 'Demo mode is enabled, you can not change module status.'], 403);
        }

        $this->checkAuthorization(auth()->user(), ['module.edit']);

        try {
            $newStatus = $this->moduleService->toggleModuleStatus($moduleName);
            return response()->json(['success' => true, 'status' => $newStatus]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 404);
        }
    }

    public function destroy(string $module)
    {
        if (config('app.demo_mode', false)) {
            session()->flash('error', 'Module deletion is restricted in demo mode. Please try on your local/live environment.');
            return redirect()->route('admin.modules.index');
        }

        $this->checkAuthorization(auth()->user(), ['module.delete']);

        try {
            $this->moduleService->deleteModule($module);
            session()->flash('success', __('Module deleted successfully.'));
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }

        return redirect()->route('admin.modules.index');
    }
}