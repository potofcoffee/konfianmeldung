<?php

namespace App\Http\Controllers;

use App\Models\Church;

class FrontendController extends Controller
{

    public function form(Church $church)
    {
        $church->load('groups');
        dd($church);
    }

}
