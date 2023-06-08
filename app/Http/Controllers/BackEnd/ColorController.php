<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::with('products')->select(['id', 'name'])->get();

        return response()->json([$colors], 200);
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
            'name' => ['required','unique:colors'],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Color::create($validator->validated());
            return response()->json(['msg'=> 'Color created'], 200);
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
        $color = Color::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$color], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$color], 200);
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
            'name' => ['required','unique:colors,name,'.$id],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Color::findOrFail($id)->update($validator->validated());
            return response()->json(['msg'=> 'Color updated'], 200);
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
            Color::destroy($id);
            return response()->json(['msg'=> 'Color deleted'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }

       
    }
}
