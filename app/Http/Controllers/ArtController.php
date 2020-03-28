<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        //$recentArt = Art::latest()->take(9)->get();
        $recentArt = Art::latest()->paginate(9);
        return response()->json($recentArt);
    }


    /**
     * Return filtered art by filter type
     *
     * @return \Illuminate\Http\Response
     */
    public function filterArt(Request $request) 
    {
        if ($request->get('filterType') == 'Recent') {
            $artList = Art::latest()->get();
        } else if ($request->get('filterType') == 'Highest Rated') {
            $artList = Art::orderBy('likes', 'desc')->get();
        } else if ($request->get('filterType') == 'Lowest Rated') {
            $artList = Art::orderBy('likes', 'asc')->get();
        }

        return response()->json($artList);
    }
  
    /**
     * Like a piece of art.
     *
     * @param UUID $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function like($id, Request $request) 
    {   
        $artworkToLike = Art::find($id);

        if ($request->params['vote'] == true) {
            $artworkToLike->increment('likes');
            $artworkToLike->save();
            DB::table('likes')->insert([
                'art_id' => $id,
                'user_id' => Auth::user()->id,
                'liked' => true
            ]);
        } else {
            $artworkToLike->decrement('likes');
            DB::table('likes')->where('art_id', $artworkToLike->id)
                ->where('user_id', Auth::user()->id)
                ->delete();
        }
        return response()->json($artworkToLike->likes);
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
     * Editing the specified piece of art.
     *
     * @param int $id //art id
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
