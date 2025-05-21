<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }

    public function genre()
    {
        $test = false;
        return view("admin.genre", compact("test"));
    }
}
