<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $category_id = $request->category_id;
        $products = Product::filterAdvancedProduct($search,$category_id)->paginate(25);


        return response()->json([
            "products"=>ProductCollection::make($products)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile("image")){
            $path = $request->file("image")->store("products","public");
            $request->request->add([
                "image_url"=> $path
            ]);
        }
        Product::create($request->all());

        return response()->json([
            "message"=>"product created"
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        return response()->json([
            "product" => ProductResource::make($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        if ($request->hasFile("image")) {
            // Delete old image if exists
            if ($product->image_url) {
                Storage::delete($product->image_url);
            }

            // Store the new image
            $path = Storage::putFile("products", $request->file("image"));
            $request->request->add([
                "image_url" => $path
            ]);
        }

        $product->update($request->all());

        return response()->json([
            "message" => "Product updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        // Delete the image if exists
        if ($product->image_url) {
            Storage::delete($product->image_url);
        }

        $product->delete();

        return response()->json([
            "message" => "Product deleted"
        ], 200);
    }
}
