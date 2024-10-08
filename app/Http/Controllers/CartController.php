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
            "data" => $cart?CartResource::make($cart):null
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
        if($product->quantity<=0){
            return response()->json([
                "status"=>false,
                "message"=>"no stock"
            ]);
        }

        $cartProduct = $cart->products()->where('product_id',$product->id)->where('cart_id',$cart->id)->first();

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

    public function removeProduct(Request $request){
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
            return response()->json([
                "status"=>false,
                "message"=>"the cart doesnt exist"
            ]);
        }
        $cartProduct = $cart->products()->where('product_id',$request->product_id)->where('cart_id',$cart->id)->first();
        if(!$cartProduct){
            return response()->json([
                "status"=>false,
                "message"=>"product not in cart"
            ]);
        }
        if($cartProduct->pivot->quantity <= 1){
            $cart->products()->detach($cartProduct->id);
        }else{
            $newQuantity = $cartProduct->pivot->quantity -1;
            
            $cart->products()->updateExistingPivot($cartProduct->id,[
                "quantity"=>$newQuantity
            ]);
        }

        $newTotal = $cart->total - $cartProduct->price;
        $cart->update([
            "total"=>$newTotal
        ]);

        return response()->json([
            "status"=>true,
            "message"=>"product deleted from cart"
        ]);
    }


    public function clearAndDelete(){
        $user = auth()->user();

        $cart = Cart::where('user_id',$user->id)->first();
        if(!$cart){
            return response()->json([
                "status"=>false,
                "message"=>"the cart doesnt exist"
            ]);
        }

        $cart->products()->detach();

        $cart->delete();

        return response()->json([
            "status"=>true,
            "message"=>"cart deleted"
        ]);


    }

}
