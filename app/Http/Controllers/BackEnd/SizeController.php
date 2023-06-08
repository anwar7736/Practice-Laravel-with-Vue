<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::with('products')->select(['id', 'name'])->get();

        return response()->json([$sizes], 200);
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
            'name' => ['required','unique:sizes'],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Size::create($validator->validated());
            return response()->json(['msg'=> 'Size created'], 200);
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
        $size = Size::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$size], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::with('products')->select(['id', 'name'])->findOrFail($id);

        return response()->json([$size], 200);
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
            'name' => ['required','unique:sizes,name,'.$id],
        ]);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }
        try{
            Size::findOrFail($id)->update($validator->validated());
            return response()->json(['msg'=> 'Size updated'], 200);
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
            Size::destroy($id);
            return response()->json(['msg'=> 'Size deleted'], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }

       
    }
}
