<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function add(Request $request) {
        $params = [
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
        ];

        DB::table('likes')->insert($params);

        return redirect('/posts');
    }

    public function delete(Request $request) {
        
        $post_id = $request->id;
        $user_id = Auth::id();

        DB::table('likes')->whereRaw('post_id = ? and user_id = ?',[$post_id, $user_id])->delete();

        return redirect('/posts');
    }

}
