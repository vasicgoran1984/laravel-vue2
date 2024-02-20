<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('dd');
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
            'tagName' => 'required',
        ]);

        return Tag::create([
            'tagName' => $request->tagName,
        ]);

//        if ($create) {
//            return response()->json(['msg' => 'saved', 'tagName' => $request->tagName], 201);
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
    public function update(Request $request)
    {
//        $tag = TAg::findOrFail($request->id);
//        print_r($tag->id);
//        die('x');
//        return 'update';
    }

    public function editTag(Request $request)
    {
        $this->validate($request, [
            'tagName' => 'required',
        ]);

        $tag = Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
        if ($tag) {
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

        $tag = Tag::where('id', $request->id)->delete();
        if ($tag) {
            return response()->json(['msg' => 'deleted'], 201);
        }
    }
}
