<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FrontEndController extends Controller
{
    public function index(){

        $products = Product::orderBy('id','DESC')->paginate(3);
        return view('home')->with(compact('products'));
    }

    public function show($id){

        $display= Product::findOrFail($id);
        return view('detail')->with(compact('display'));
    }
}
