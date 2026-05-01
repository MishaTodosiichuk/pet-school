<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            [
                'title'  => 'Головна',
                'link'   => '#',
                'active' => true,
            ]
        ];
        return view('admin.pages.index', compact('breadcrumbs'));
    }
}
