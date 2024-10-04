<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        return response()->json([
            "status" => true,
            "data" => CartResource::make($cart)
        ]);
    }

    public function addProduct(Request $request)
    {
        $user = auth()->user();
        // validar datos
        $validator = validator()->make($request->all(), [
            "product_id" => "required|exists:products,id"

        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $cart = Cart::where('user_id',$user->id)->first();

        if(!$cart){
            $cart = Cart::create([
                "user_id"=>$user->id
            ]);
        }

        $product = Product::find($request->product_id);

        $cartProduct = $cart->products()->where('product_id',$product->id)->first();

        if($cartProduct){
            $newQuantity = $cartProduct->pivot->quantity + 1;
            $cart->products()->updateExistingPivot($product->id, [
                "quantity"=>$newQuantity
            ]);

        }else{

            $cart->products()->attach($product->id,[
                "quantity"=>1,
                "price"=>$product->price
            ]);

        }

        $cart->update([
            "total"=>$cart->total+$product->price
        ]);

        return response()->json([
            "status"=> true,
            "message"=>"product added"
        ]);
    }

}
