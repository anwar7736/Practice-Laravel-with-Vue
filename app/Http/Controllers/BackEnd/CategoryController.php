<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('products')->select(['id', 'name'])->get();

        return response()->json([$categories], 200);
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
            'name' => ['required','unique:categories'],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Category::create($validator->validated());
            return response()->json(['msg'=> 'Category created'], 200);
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
        $category = Category::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$category], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$category], 200);
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
            'name' => ['required','unique:categories,name,'.$id],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Category::findOrFail($id)->update($validator->validated());
            return response()->json(['msg'=> 'Category updated'], 200);
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
            Category::destroy($id);
            return response()->json(['msg'=> 'Category deleted'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }

       
    }
}
