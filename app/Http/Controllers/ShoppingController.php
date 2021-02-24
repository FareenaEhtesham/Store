<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class ShoppingController extends Controller
{
    public function Add_To_Cart($id){
        
        // dd(request()->all());

        $product=Product::findorFail($id);

        $cartItem = Cart::add(['id' => $product->id, 'name' => $product->name,
        'qty' => request()->quantity, 'price' => $product->price, 
        'weight' => 550]);

        // $cart = Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // dd($cart);

        Cart::associate($cartItem->rowId, 'App\Models\Product');
        return redirect()->route('cart');
       
    }

    public function display(){
        // Cart::destroy(); for destroy all items in cart
        return view('cart');
    }

    public function Remove_Cart($id){
        //this will remove an item from the cart
        //Cart::remove() and Cart::get() takes rowId as an argument so we pass 
        //rowId in cart.blade.php
        Cart::remove($id);
        return redirect()->route('cart');
    }
}
