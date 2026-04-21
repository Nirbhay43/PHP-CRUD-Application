<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = category::all();
        $categories= category::get();
        $editdata='';
        return view('category',[
            'catdata'=> $categories,
            'editdata'=> $editdata]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'catname'=>'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ],[
            'catname.required'=>'Please enter category',
            'catname.min'=>'Atleast 3 character should be enter'
        ]);
       //img name generate
        $imgName = "img".time().".".$request->image->extension();
        $request->image->move(public_path("catimages"), $imgName);
        $data = category::create(['catname'=>$request->catname,
            'image'=>$imgName    
        ]);
        return redirect('/category')->with('success','Category save successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = category::get();
        $data = category::find($id);
        return view('category',[
            'editdata'=> $data,
            'catdata'=> $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = category::findOrFail($id);

        $img = $data->image;
        if($request->image != null){
        if(file_exists(public_path('catimages/'.$img))){
            unlink(public_path('catimages/'.$img));
        }
        $imgName = 'img'.time().'.'.$request->image->extension();
        $request->image->move(public_path('catimages'), $imgName);
        $img = $imgName;
    }

        $data->update(['catname'=>$request->catname, 'image'=>$img]);
        return redirect('/category')->with('success',value:'Category Update successfully');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = category::findorfail($id);
        if(file_exists(\public_path('catimages/'.$data->image))){
            unlink(public_path('catimages/'.$data->image));
        }
        $data-> delete();
        return redirect('/category')->with('success','Category Delete successfully');;
    }
}
