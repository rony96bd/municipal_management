<?php

namespace App\Http\Controllers\developers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevelopersController extends Controller
{
    public function css(){
        return view('developers.classes');
    }
}
