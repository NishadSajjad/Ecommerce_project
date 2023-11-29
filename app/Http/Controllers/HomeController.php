<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index(){
        $allProduct = product::latest()->get();
        return view('user_template.layouts.home',compact('allProduct'));
    }
}
