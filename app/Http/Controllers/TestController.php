<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function storeInPublic(Request $r)
    {
        $r->validate([
            'image'=>'required|mimes:png,jpg,jpeg,gif',
    ]);
        $path = $r->file("image")->store("sortOfName","public");
    
        return response()->json(['path'=>$path], 201);
    }
}
