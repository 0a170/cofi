<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allArt = Art::all();
        
        return response()->json($allArt);
    }

    /**
     * Display a listing of newest art.
     *
     * @return \Illuminate\Http\Response
     */
    public function recentArt() 
    {
        $recentArt = Art::latest()->take(9)->get();
        // dd($recentArt);
        return response()->json($recentArt);
    }
  
    /**
     * Like a piece of art.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request) 
    {
        $artworkToLike = Art::find($request->artId);
        $artworkToLike->likes->increment(1);
        $artworkToLike->save();

        return response()->json('204');
    }

    /**
     * Store a newly created piece of art in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->userId);

        $file = $request->file('file');
        $path = $user->name . '/art/' . $request->title;
        Storage::put($path, $file);

        $art = new Art;
        $art->title = $request->title;
        $art->description = $request->description;
        $art->src = $path;
        $art->owner_id = $user->id;
        $art->save();

        return response()->json('200');
    }

    /**
     * Display the specified piece of art.
     *
     * @param Art $id //id of art piece
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $art = Art::find($id);
        return response()->json($art);
    }

    /**
     * editing the specified piece of art.
     *
     * @param  int  $id
     * 
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
     * @param  int                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($request->userId);
        $art = Art::find($id);

        $oldPath = $user->name . '/art/' . $art->title;
        $newPath = $user->name . '/art/' . $request->title;
        Storage::delete($oldPath);
        Storage::put($newPath);

        $art->title = $request->title;
        $art->description = $request->description;
        $art->src = $newPath;
        $art->save();

        return response()->json('204');
    }

    /**
     * Remove the specified piece of art from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $art = Art::find($id);
        $art->delete();

        return response()->json('204');
    }
}
