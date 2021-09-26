<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Handle the admin index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.index');
    }

    /**
     * Handle the file manager page.
     *
     * @return \Illuminate\View\View
     */
    public function filesManager(): View
    {
        return view('admin.files-manager');
    }

    /**
     * Handle the change lang method
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLang(string $lang)
    {
        Cookie::queue('lang', $lang);
        return redirect()->back();
    }
}
