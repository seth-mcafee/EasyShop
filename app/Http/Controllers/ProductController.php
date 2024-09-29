<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
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
            $path = Storage::putFile("products",$request->file("image"));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
