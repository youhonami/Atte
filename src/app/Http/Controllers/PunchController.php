<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PunchController extends Controller
{
    public function punch()
    {
        return view('punch');
    }
}
