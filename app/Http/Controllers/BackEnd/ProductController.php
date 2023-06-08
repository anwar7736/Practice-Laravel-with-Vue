<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category, Size, Color};
use Validator, Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {   
        // return($req->query());

            $products = Product::with(['categories', 'sizes', 'colors'])
                                ->whereHas('categories', function($q) use ($req){
                                        $q->whereIn('categories.id', $req->categories);
                                    })                            
                                ->whereHas('sizes', function($q) use ($req){
                                        $q->whereIn('sizes.id', $req->sizes);
                                    })                            
                                ->whereHas('colors', function($q) use ($req){
                                        $q->whereIn('colors.id', $req->colors);
                                })
                                ->get();
    


        return response()->json([$products], 200);


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required','unique:products'],
            'price' => ['required','numeric'],
            'discount_type' => '',
            'discount' => '',
            'desc' => '',
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            $inputs = $req->only(['name','price', 'discount_type','discount', 'desc']);
            $inputs['sku'] = strtoupper(Str::random(3)).'-'.rand(111,999);
            if($image = $req->image)
            {
                $new_name = rand().'.'.$image->extension();
                $image->move(public_path('images/products'), $new_name);
                $inputs['image'] = $new_name;
            }

            if($discount = $req->discount)
            {
                $discount_amount = 0;
                if($req->discount_type == 'percentage')
                {
                    
                    $discount_amount = $inputs['discount_amount'] = ($inputs['price'] * $discount / 100);
                }
                else 
                {
                    $discount_amount = $inputs['discount_amount'] = $discount;
                }

                $inputs['price_after_discount'] = ($inputs['price'] - $discount_amount);

            }

            $product = Product::create($inputs);
            if($categories = $req->categories)
            {
                $product->categories()->attach($categories);
            }             
            
            if($sizes = $req->sizes)
            {
                $product->sizes()->attach($sizes);
            }   
                     
            if($colors = $req->colors)
            {
                $product->colors()->attach($colors);
            }

            return response()->json(['msg'=> 'Product created'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $product = Product::with(['categories', 'sizes', 'colors'])->findOrFail($id);

        return response()->json([$product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with(['categories', 'sizes', 'colors'])->findOrFail($id);

        return response()->json([$product], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required','unique:products,name,'.$id],
            'price' => ['required','numeric'],
            'discount_type' => '',
            'discount' => '',
            'desc' => '',
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            $inputs = $req->only(['name','price', 'discount_type','discount', 'desc']);
            // $inputs['sku'] = strtoupper(Str::random(3)).'-'.rand(111,999);
            $product = Product::findOrFail($id);
            if($image = $req->image)
            {
                $image_path = public_path('images/products/').$product->image;
                if(file_exists($image_path))
                {
                    unlink($image_path);
                }
                $new_name = rand().'.'.$image->extension();
                $image->move(public_path('images/products'), $new_name);
                $inputs['image'] = $new_name;
            }

            if($discount = $req->discount)
            {
                $discount_amount = 0;
                if($req->discount_type == 'percentage')
                {
                    
                    $discount_amount = $inputs['discount_amount'] = ($inputs['price'] * $discount / 100);
                }
                else 
                {
                    $discount_amount = $inputs['discount_amount'] = $discount;
                }

                $inputs['price_after_discount'] = ($inputs['price'] - $discount_amount);

            }

            $product->update($inputs);
            if($categories = $req->categories)
            {
                $product->categories()->sync($categories);
            }             
            
            if($sizes = $req->sizes)
            {
                $product->sizes()->sync($sizes);
            }   
                     
            if($colors = $req->colors)
            {
                $product->colors()->sync($colors);
            }

            return response()->json(['msg'=> 'Product updated'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {

            $product = Product::findOrFail($id);
            $image_path = public_path('images/products/').$product->image;
            if(file_exists($image_path))
            {
                unlink($image_path);
            }
            $product->delete();

            return response()->json(['msg'=> 'Product deleted'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }
    }

    public function get_category_size_color_list()
    {
        $categories = Category::withCount(['products'])->get();
        $sizes = Size::withCount(['products'])->get();
        $colors = Color::withCount(['products'])->get();

        return response()->json([
                        'categories'=> $categories, 
                        'sizes'=> $sizes, 
                        'colors'=> $colors
                    ], 200);
    }
}
