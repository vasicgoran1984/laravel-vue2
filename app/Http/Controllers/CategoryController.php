<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy('id', 'desc')->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage'    => 'required',
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);

//        if ($create) {
//            return response()->json(['msg' => 'saved'], 201);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage'    => 'required',
        ]);

        $category = Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
        if ($category) {
            return response()->json(['msg' => 'saved'], 201);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $category = Category::where('id', $request->id)->delete();
        if ($category) {
            $this->deleteImage($request);
            return response()->json(['msg' => 'deleted'], 201);
        }
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);

        $image = time(). '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $image);
        return $image;
    }

    public function deleteImage(Request $request)
    {
        $file = $request->iconImage;
        $filePath = public_path().'/uploads/'.$file;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return 'done';
    }
}
