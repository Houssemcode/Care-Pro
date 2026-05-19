<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            session()->put('locale', $locale);
        }
        return back();
    }
}
