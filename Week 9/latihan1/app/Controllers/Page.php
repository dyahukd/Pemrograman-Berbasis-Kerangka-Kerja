<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('pages/about', [
            'title' => 'About Us'
        ]);
    }

    public function contact()
    {
        return view('pages/contact', [
            'title' => 'Contact Us'
        ]);
    }

    public function dashboard()
    {
        return view('admin/dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}