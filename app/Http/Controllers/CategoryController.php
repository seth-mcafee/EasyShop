<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "categories" => $categories,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $this->validateCategory($request);

        // Crear la nueva categoría
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Responder con la categoría creada
        return response()->json([
            'message' => 'Category created successfully!',
            'category' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar la categoría por id
        $category = Category::find($id);

        // Verificar si la categoría existe
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Responder con los datos de la categoría
        return response()->json([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        // Validar datos recibidos
        $this->validateCategory($request);

        // Buscar la categoria por Id
        $category = Category::findOrFail($id);

        // Actualizar los datos de la categoría
        $category->update($request->only('name'));

        // Responder con la categoría actualizada
        return response()->json([
            'message' => 'Category updated successfully!',
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la categoría por id
        $category = Category::find($id);

        // Verificar si la categoría existe
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Eliminar la categoría
        $category->delete();

        // Responder con un mensaje de éxito
        return response()->json(['message' => 'Category deleted successfully!']);
    }

    private function validateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    }
}
