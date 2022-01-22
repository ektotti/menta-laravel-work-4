@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($posts as $post)
            <div class="card">
                <div class="card-header text-center">
                    <h2>{{$post->title}}</h2>
                    <p>{{$post->content}}</p>
                </div>
                @if(isset($user) && $user->id == $post->user_id)
                <div class="card-header text-center">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="mr-2">投稿者 : {{$post->user->name}}</span>
                        <form class="mr-2" action="/post/{{$post->id}}/edit" method="GET">
                            @csrf
                            <input class="btn btn-primary" type="submit" value="編集する">
                        </form>
                        <form action="/post/{{$post->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-danger" type="submit" value="削除する">
                        </form>
                    </div>
                </div>
                @else
                <div class="card-header text-center">
                    <p>
                        <span>投稿者 : {{$post->user->name}}</span>
                    </p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection