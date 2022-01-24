@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row px-3 justify-content-center">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif
        <form class="col-12" action="/posts/{{$selectedPost->id}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="mb-3 px-15 row justify-content-center flex-column">
                <label class="form-label" for="titile">タイトル</label>
                <input class="form-controll col-12" type="text" name="title" id="title" value="{{$selectedPost->title}}" >    
            </div>
            <div class="mb-3 px-15 row justify-content-center flex-column">
                <label class="form-label " for="content">コンテンツ</label>
                <textarea class="form-controll col-12" name="content" id="content" rows="10">{{$selectedPost->content}}</textarea>
            </div>
            <div class="mb-3 px-15 row">
                <input class="btn btn-success" type="submit" value="更新">
            </div>
        </form>
    </div>
</div>
@endsection