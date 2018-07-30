@extends('server.layout.content')
@section("title")找不到页面@endsection
@section('content')
    <div class="errorwrap">
        <img src="{{pix_asset('server/images/404.png')}}">
        <a href="{{route('index')}}" class="backindex">返回首页</a>
    </div>
@endsection