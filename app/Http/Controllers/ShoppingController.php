<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use Stripe;
use Mail;
use Session;

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
        Session::flash('success','Product added in cart');
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
        Session::flash('success','Successfully Removed');
        return redirect('cart');
    }

    public function increment($id,$qty){

        Cart::update($id,$qty+1);
        return redirect()->back();
    }

    public function decrement($id,$qty){

        Cart::update($id,$qty-1);
        return redirect()->back();
    }

    public function single_Cart($id){

        $product=Product::findorFail($id);

        $cartItem = Cart::add(['id' => $product->id, 'name' => $product->name,
        'qty' => 1, 'price' => $product->price, 
        'weight' => 550]);

        Cart::associate($cartItem->rowId, 'App\Models\Product');
        Session::flash('success','Product added in cart');
        return redirect()->route('cart');

    }

    public function Checkout(){
        return view('checkout');
    }

    public function payment(){
        // dd(request()->all());
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        Stripe\Charge::create ([
                "amount" => Cart::total()* 100,
                "currency" => "usd",
                "source" => request()->stripeToken,
                "description" => "Purchase Books in a reasonable price" 
        ]);
        //we have to destroy the cart as all items have been purchased    
        Cart::destroy();
        Mail::to(request()->stripeEmail)->send(new \App\Mail\SendMail);
        Session::flash('success','Purchase Successfully! Kindly check your mail');
        return redirect('/');
            
    }
}
