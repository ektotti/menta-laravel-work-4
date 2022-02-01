<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likesThis(){
        return $this->belongsToMany('App\User', 'likes', 'post_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function judgeHavingThisUser($id) {
        $users = $this->likesThis->toArray();
        return in_array($id, array_column($users, "id"));
    }

    public function countLikesAmount() {
        return count($this->likesThis);
    }
}
