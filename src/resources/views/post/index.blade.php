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
                                    
                                        {{-- ログイン中ユーザーがその投稿に対して"いいね"しているか確認
                                            中間テーブルにレコードが存在するか確認している。 --}}
                                        @if($post->judgeHavingThisUser(AUTH::id()))
                                        <a href="/likes/delete?post_id={{$post->id}}&user_id={{Auth::id()}}"><i class="fa fa-heart"></i></a>
                                        @else
                                        <a href="/likes/add?post_id={{$post->id}}&user_id={{Auth::id()}}"><i class="far fa-heart"></i></a>
                                        @endif
                                        <span>{{$post->countLikesAmount()}}</span>
                                    </form>
                                </div>
                            @else
                                <span>投稿者 : {{$post->user->name}}</span>
                                <i class="far fa-heart"></i>
                                <span>{{$post->countLikesAmount()}}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection