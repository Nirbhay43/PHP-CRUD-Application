<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class apiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = category::all();
        return response()->json(data: $data);
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'catname' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'catname.required' => 'Please enter category',
            'catname.min' => 'Atleast 3 character should be enter'
        ]);
        //img name generate
        $imgName = "img" . time() . "." . $request->image->extension();
        $request->image->move(public_path("catimages"), $imgName);
        $data = category::create([
            'catname' => $request->catname,
            'image' => $imgName
        ]);
        return response()->json([
            "msg"=>"Category save successfully."
        ]);
        
    }
    public function edit(string $id)
    {
        $categories = \App\Models\category::get();
        $data = \App\Models\category::find($id);
        return response()->json([
            "msg"=>"Category get Successfully.",
            'editdata' => $data]);
        // return view('category', [
        //     'editdata' => $data,
        //     'catdata' => $categories
        // ]);
    }
   
    public function update(Request $request, string $id)
    {
        $data = \App\Models\category::findOrFail($id);
        $img = $data->image;
        if ($request->image != null) {
            if (file_exists(public_path('catimages/' . $img))) {
                unlink(public_path('catimages/' . $img));
            }
            $imgName = "img" . time() . "." . $request->image->extension();
                $request->image->move(public_path("catimages"), $imgName);
            $img = $imgName;
        }
        $data->update([
            'catname' => $request->catname,
            'image' => $img
        ]);
        return response()->json([
            "msg"=>"Category Update Successfully."
        ]);
    }
    public function destroy(string $id)
    {
        $data = \App\Models\category::findOrFail($id);
        if (file_exists(public_path('catimages/' . $data->image))) {
            unlink(public_path('catimages/' . $data->image));
        }
        $data->delete();
        return response()->json([
            "msg"=>"Category delete Successfully."
        ]);
    }
}
