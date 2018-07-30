@extends('server.layout.content')
@section('title','个人资料')
@section('css')
    <link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>个人资料</legend>
        </fieldset>
        <div class="fullForm userMessageForm">
            <form class="layui-form" phone="{{$user->phone}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->nickname}}" class="layui-input" readonly  style="width: 25%;float:left;">
                        <a href="javascript:;" style="line-height:38px;color: #01AAED" class="changeNickname" >
                            修改姓名 |
                        </a>
                        @if($user->wechatopenid)
                            <a href="javascript:;" style="line-height:38px;"  >已绑定</a>
                        @else
                            <a href="javascript:;" style="line-height:38px;color: #01AAED" class="binwx" url="{{route('user-wxcode')}}" data-check="{{route('check-openid')}}">绑定微信</a>
                        @endif
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">账号</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->username}}" class="layui-input" readonly>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-block clearfix">
                        <input type="text" value="{{$user->phone}}" class="layui-input messagePhone fl" readonly>
                        <a href="javascript:;" class="changePhone fl" title="@if($user->phone)更换手机@else 绑定手机 @endif">@if($user->phone)更换手机@else 绑定手机 @endif</a>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$user->status?'正常':'禁用'}}" class="layui-input" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('other')
    <!--更换手机弹窗-->
    <div class="popWrap userInfoPop" style="display: none">
        <form class="layui-form" id="layui-form" action="{{route('user-info')}}" method="post">
            {{csrf_field()}}
            <div class="layui-form-item">
                <input type="text" name="phone" value="" id="phone" datatype="m" nullmsg="请输入手机号码" errormsg="手机号码不正确"
                       autocomplete="off" placeholder="手机号" class="layui-input">
            </div>
            <div class="layui-form-item clearfix">
                <input type="text" name="code" autocomplete="off" datatype="n4-4" nullmsg="请输入验证码" errormsg="验证码不正确"
                       placeholder="短信验证码" class="layui-input codeInput fl" style="width:72%">
                <button type="button" class="layui-btn msgUncode fr" data-url="{{route('sms-code')}}" data-type="2" style="width: 27%">
                    发送验证码
                </button>
            </div>
            <div class="layui-form-item loginBtn">
                <button type="button" class="layui-btn loginButton" id="btn_submit">立即提交</button>
            </div>
        </form>
    </div>
    <!--修改姓名-->
    <div class="popWrap userNicknamePop" style="display: none">
        <form class="layui-form" id="layui-nickname-form" action="{{route('user-nickname')}}" method="post">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layui-form-label">旧姓名</label>
                <input type="text" class="layui-input readonly"  value="{{$user->nickname}}" readonly="readonly" disabled="disabled" style="width:70%">
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新姓名</label>
                <input type="text" name="nickname" value="" id="nickname" datatype="*" nullmsg="请输入新姓名" errormsg="新姓名格式错误"
                       autocomplete="off" placeholder="请输入姓名" class="layui-input" style="width:70%">
            </div>
            <div class="layui-form-item loginBtn">
                <button type="button" class="layui-btn loginButton" id="btn_nickname_submit">立即提交</button>
            </div>
        </form>
    </div>
    <!--二维码弹窗-->
    <div class="erweimapop" style="display: none;" >
        <div class="erweima">
            @if($user->sourcecode==7)
                <div class="erweimatext">小程序为发布成功，暂不能进行微信绑定</div>
            @endif
        </div>
        <p class="poptext">扫描二维码认证您的身份</p>
    </div>
    <!--错误 -->
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@endsection


@section('js')
    <script type="text/javascript"
            src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/user/info.js')}}"></script>
@endsection