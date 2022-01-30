<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->with('usersFavoriteThis')->get();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::check();
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        $form = $request->all();
        unset($form['_token']);
        $post->fill($form)->save();

        return redirect('/posts');
    
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
            $selectedPost = Post::find($id);
            return view('post.edit', compact('selectedPost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        /**
         * 中間テーブルへのレコード挿入をここに記載したので、
         * 投稿自体の更新処理と分ける目的で、アクセス元のパスを使って条件分岐
         */
        $previousPath = parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH);

        if(str_contains($previousPath, 'edit')) {
            
            $editedpost = Post::find($id);
            $form = $request->all();
            unset($form['_token']);
            $editedpost->fill($form)->save();
            
            return redirect('/posts');
        
        } else {

            $editedPost = Post::find($id);
            $userId = Auth::id();
            
            if(isset($request->addFavorite)) {
                $editedPost->usersFavoriteThis()->attach($userId);
            } elseif(isset($request->removeFavorite)) {
                $editedPost->usersFavoriteThis()->detach($userId);
            }
            
            return redirect('/posts');

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
        $selectedPost = Post::find($id);
        $selectedPost->delete();

        return redirect('/posts');
    }
}
