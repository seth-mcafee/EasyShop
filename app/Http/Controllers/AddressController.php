<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id',$user->id)->get(); 
        return response()->json(AddressResource::collection($addresses));
    }

    // Crear una nueva dirección
    public function store(Request $request)
    {
        $user = auth()->user();
        // Validación de los datos
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
        ]);
        $request->request->add(["user_id"=>$user->id]);
        // Crear la dirección en la base de datos
        $address = Address::create($request->all());



        return response()->json(AddressResource::make($address), 201); // Respuesta con estado 201 (creado)
    }

    // Mostrar una dirección específica
    public function show($id)
    {
        $user = auth()->user();
        $address = Address::where('user_id',$user->id)->where('id',$id)->first();
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        return response()->json(AddressResource::make($address));
    }

    // Actualizar una dirección existente
    public function update(Request $request, $id)
    {

        $user = auth()->user();
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        if($user->id != $address->user_id){
            return response()->json(['message' => 'User not allowed'], 403);
        }
        // Validación de los datos
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
        ]);

        $request->request->add(["user_id"=>$user->id]);
        // Actualizar los datos
        $address->update($request->all());

        return response()->json(AddressResource::make($address));
    }

    // Eliminar una dirección
    public function destroy($id)
    {

        $user = auth()->user();
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        if($user->id != $address->user_id){
            return response()->json(['message' => 'User not allowed'], 403);
        }

        $address->delete();

        return response()->json(null, 204); // Respuesta con estado 204 (sin contenido)
    }
}
