<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebHook extends Controller
{
    
    public function saweria(Request $req)
    {
        dd($req->all());
    }

}
