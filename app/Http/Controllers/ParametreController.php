<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function parametreIndex() {
        
        return view('admin.parametres.index');
    }

}
