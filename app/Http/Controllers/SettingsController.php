<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $settingService;
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index($tab= null)
    {
        return view('backend.pages.setting');
    }

    public function tabAdd(){
        return "";
    }

    public function store(Request $request)
    {
        $fields = $request->all();
        $uploadPath = 'uploads/settings';
    
        foreach ($fields as $fieldName => $fieldValue) {
            if ($request->hasFile($fieldName)) {
                deleteImageFromPublic((string) config($fieldName));
                $fileUrl = storeImageAndGetUrl($request, $fieldName, $uploadPath);
                $this->settingService->addSetting($fieldName, $fileUrl);
            } else {
                $this->settingService->addSetting($fieldName, $fieldValue);
            }
        }
    
        return redirect()->back()->with('success', 'Settings saved successfully.');
    }
    
    
}
