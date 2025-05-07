<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    public function switch($lang)
    {
        session()->put('locale', $lang);
        App::setLocale(session()->get('locale'));
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return redirect()->back();
    }


}
