<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Welcome', [
            'tweets' => Tweet::orderBy('id', 'desc')->get()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate(['file' => 'required|mimes:jpg,jpeg,png,mp4']);
            //get file's extension
            $extension = $file->getClientOriginalExtension();
            //creat a new name with upon extension
            $fileName = time() . '.' . $extension;
            //checking extension
            $extension === 'mp4' ? $path = '/videos/' : $path = '/pics/';
        }

        $tweet = new Tweet;

        $tweet->name = 'Pyae Sone Hein';
        $tweet->handle = '@pyaesone';
        //johnweeksdev's image
        $tweet->image = 'https://yt3.ggpht.com/e9o-24_frmNSSVvjS47rT8qCHgsHNiedqgXbzmrmpsj6H1ketcufR1B9vLXTZRa30krRksPj=s88-c-k-c0x00ffffff-no-rj-mo';
        $tweet->tweet = $request->input('tweet');
        //checking request has file or not
        if ($fileName) {
            $tweet->file = $path . $fileName;
            //??
            $tweet->is_video = $extension === 'mp4' ? true : false;
            $file->move(public_path() . $path, $fileName);
        }
        $tweet->comments = rand(5, 500);
        $tweet->retweets = rand(5, 500);
        $tweet->likes = rand(5, 500);
        $tweet->analytics = rand(5, 500);

        //create new data
        $tweet->save();
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destory($id)
    {
        $tweet = Tweet::find($id);

        //delete from local
        if (!is_null($tweet->file) && file_exists(public_path() . $tweet->file)) {
            //unlink is like delete
            unlink(public_path() . $tweet->file);
        }
        //delete from db
        $tweet->delete();

        return redirect()->route('tweets#index');
    }
}
