<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function create()
    {
        return view("admin.genre_create");
    }
    public function store(Request $request)
    {
        $request->validate([
            "name" => "string|required|unique:genres",
        ]);
        $genre = Genre::create(["name" => $request["name"]]);
        $genre->save();
        return redirect()->route("admin.genre");
    }
}
