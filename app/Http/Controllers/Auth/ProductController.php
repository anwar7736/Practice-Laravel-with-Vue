<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'unique:products'],
            'sku' => ['unique:products'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'image' => ['required', 'mimes:jpg,jpeg,png,gif,svg'],
        ], [
            '*.required' => 'This field is required!',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        
        try{
            $data = $request->except(['image']);
            $data['image'] = Util::uploadFile('products', $request->image);
            if(empty($data['sku']))
            {
                $data['sku'] = strtoupper(Str::random(6));
            }
            
            if(Product::create($data))
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product has been inserted!',
                ],200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'status' => 200,
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'unique:products,name,'.$product->id],
            'sku' => ['unique:products,sku,'.$product->id],
            'price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'image' => ['mimes:jpg,jpeg,png,gif,svg'],
        ], [
            '*.required' => 'This field is required!',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        
        try{
            $data = $request->except(['image']);
            if(!empty($request->image))
            {
                Util::deleteFile('products', $product->image);
                $data['image'] = Util::uploadFile('products', $request->image);
            }
            
            if($product->update($data))
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product has been updated!',
                ],200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product has been deleted!'
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
