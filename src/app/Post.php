<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    public $guarded = [
        'id',
    ];

    public static $rules = [
        'title' => 'required',
        'content' => 'required|max:140',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
