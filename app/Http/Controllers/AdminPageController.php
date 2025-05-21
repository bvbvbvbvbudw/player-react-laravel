<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function index()
    {
        return view("admin.index");
    }

    public function genre()
    {
        $genres = Genre::all();
        return view("admin.genre", compact("genres"));
    }
}
