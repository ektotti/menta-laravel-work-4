@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($posts as $post)
                <div class="card">
                        {{-- 投稿のメイン内容部分 --}}
                        <div class="card-header text-center">
                            <h2>{{$post->title}}</h2>
                            <p>{{$post->content}}</p>
                        </div>

                        {{-- 投稿に対する情報部分　ログイン中のユーザーとログインしてないユーザーで表示の出し分け --}}
                        <div class="card-header text-center">
                            @if(Auth::check())
                                <div class="d-flex justify-content-center align-items-center">
                                <span class="mr-2">投稿者 : {{$post->user->name}}</span>
                                
                                {{-- ログインしている且つログインしているユーザーの投稿用 --}}
                                @if(Auth::id() == $post->user_id)
                                    <form class="mr-2" action="/posts/{{$post->id}}/edit" method="GET">
                                        @csrf
                                        <input class="btn btn-primary" type="submit" value="編集する">
                                    </form>
                                    <form action="/posts/{{$post->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-danger" type="submit" value="削除する">
                                    </form>
                                @endif
                                    
                                    <form action="/posts/{{$post->id}}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                        <input type="hidden" name="title" value="{{$post->title}}">
                                        <input type="hidden" name="content" value="{{$post->content}}">

                                        {{-- ログイン中ユーザーがその投稿に対して"いいね"しているか確認
                                            中間テーブルにレコードが存在するか確認している。 --}}
                                        @if($post->usersFavoriteThis()->where('user_id', '=', Auth::id())->get()->all())
                                            <input type="hidden" name="removeFavorite" value="1">
                                            <input type="submit" class="fa bg-transparent border-0" value="&#xf004;">
                                        @else
                                            <input type="hidden" name="addFavorite" value="1">
                                            <input type="submit" name="removeFavorite" class="far bg-transparent border-0" value="&#xf004;">
                                        @endif
                                        <span>{{count($post->usersFavoriteThis)}}</span>
                                    </form>
                                </div>
                            @else
                                <span>投稿者 : {{$post->user->name}}</span>
                                <i class="far fa-heart"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection