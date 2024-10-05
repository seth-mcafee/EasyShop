<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    
    public function index()
    {
        $addresses = Address::all();
        return response()->json($addresses);
    }

    // Crear una nueva dirección
    public function store(Request $request)
    {
        // Validación de los datos
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
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

        // Crear la dirección en la base de datos
        $address = Address::create($validatedData);

        return response()->json($address, 201); // Respuesta con estado 201 (creado)
    }

    // Mostrar una dirección específica
    public function show($id)
    {
        $address = Address::findOrFail($id);
        return response()->json($address);
    }

    // Actualizar una dirección existente
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        // Validación de los datos
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
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

        // Actualizar los datos
        $address->update($validatedData);

        return response()->json($address);
    }

    // Eliminar una dirección
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return response()->json(null, 204); // Respuesta con estado 204 (sin contenido)
    }
}
