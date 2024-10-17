<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'vat' => 'nullable|string|max:20',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cp' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'save' => 'required|boolean'
        ]);
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return response()->json([
                "status" => false,
                "message" => "the cart doesnt exist"
            ]);
        }



        $order = Order::create([
            "user_id" => $user->id,
            "total" => $cart->total
        ]);

        foreach ($cart->products as $cartProduct) {
            // TODO: validar si hay existencias de ese producto

            $order->products()->attach($cartProduct->id, [
                "quantity" => $cartProduct->pivot->quantity,
                "price" => $cartProduct->pivot->price

            ]);
        }

        if ($request->save) {
            $request->request->add(["user_id" => $user->id]);
            Address::create($request->all());
        }

        $request->request->add(["order_id" => $order->id]);
        OrderAddress::create($request->all());

        //TO-DO: Iniciar pago stripe
        Stripe::setApiKey(config("services.stripe.secret"));
        $paymentIntent = PaymentIntent::create([
            "amount" => (100 * $order->total),
            "currency" => "EUR",
            "payment_method_types" => ["card"],
            "description" => "carrito easyshop",
            "shipping" => [
                "name" => $request->name,
                "address" => [
                    "line1" => $request->address,
                    "city" => $request->city,
                    "country" => "ES",
                    "postal_code" => $request->cp
                ]
            ]

        ]);
        Payment::create([
            "user_id" => $user->id,
            "order_id" => $order->id,
            "method" => "stripe",
            "amount" => $order->total
        ]);

        $cart->products()->detach();

        $cart->delete();



        return response()->json([
            "status" => true,
            "message" => "pedido created",
            "key"=>$paymentIntent->client_secret
        ]);
    }

    public function index(){
        $user = auth()->user();
        $orders =Order::where('user_id', $user->id)->get();

        return response()->json(OrderResource::collection($orders));
    }

    public function refund($id){

        $user = auth()->user();

        $order = Order::where('id', $id)->where('user_id',$user->id)->first();

        if(!$order){
            return response()->json([
                "status"=>false,
                "message"=>"order not found"
            ]);
        }

        
        if($order->status!="delivered" && $order->delivered_at->diffInDays(now())>15){
            return response()->json([
                "status"=>false,
                "message"=>"refund period expired"
            ]);
        }

        Refund::create([
            "order_id" => $order->id
        ]);

        return response()->json([
            "status"=>true,
            "message"=>"Successfull"
        ]);
    }
}
