<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
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
            "categories" => CategoryCollection::make($categories),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validator = validator()->make($request->all(),["name"=>"required"]);

        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors()
            ]);
        }

        // Crear la nueva categoría
       Category::create([
            'name' => $request->name
        ]);

        // Responder con la categoría creada
        return response()->json([
            'message' => 'Category created successfully!'
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
            'category' => CategoryResource::make($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar datos recibidos
        $validator = validator()->make($request->all(),["name"=>"required"]);

        if($validator->fails()){
            return response()->json([
                "errors"=>$validator->errors()
            ]);
        }

        // Buscar la categoria por Id
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Actualizar los datos de la categoría
        $category->update($request->only('name'));

        // Responder con la categoría actualizada
        return response()->json([
            'message' => 'Category updated successfully!'
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

    
}
