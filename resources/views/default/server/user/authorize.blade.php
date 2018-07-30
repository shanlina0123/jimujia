@extends('server.layout.content')
@section('title','小程序授权')
@section('css')
<link rel="stylesheet" href="{{pix_asset('server/css/login.css')}}">
@endsection
@section('content')
<div class="main">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>小程序授权</legend>
    </fieldset>
    <div class="changepWrap">
        <form class="layui-form changeForm" id="layui-form"  action="{{route('user-authorize')}}" method="post">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label style="display: block;margin-bottom: 8px;"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">* </i>小程序APPID</label>
                <input type="text" name="authorizer_appid" @if(!$res || $res->authorizer_appid_secret == false ) datatype="*" @endif  value="{{$res?$res->authorizer_appid:''}}"  nullmsg="请输入AppID(小程序APPID)" errormsg="AppID(小程序APPID)"  autocomplete="off" placeholder="AppID(小程序APPID)"  @if( $res && $res->authorizer_appid_secret ) class="layui-input layui-btn-disabled" readonly @else class="layui-input" @endif>
            </div>
            <div class="layui-form-item">
                <label style="display: block;margin-bottom: 8px;"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">* </i>小程序密钥</label>
                <input @if($res && $res->authorizer_appid_secret) type="password" @else type="text" @endif name="authorizer_appid_secret" datatype="*" value="{{$res?$res->authorizer_appid_secret:''}}" placeholder="AppSecret(小程序密钥)"  nullmsg="请输入AppSecret(小程序密钥)" errormsg="AppSecret(小程序密钥)不正确"autocomplete="off" placeholder="AppSecret(小程序密钥)"  class="layui-input"  >
            </div>
            <div class="layui-form-item loginBtn">
                @if( $res && $res->authorizer_appid_secret )
                    <button class="layui-btn loginButton" type="button"  id="btn_submit" >已授权</button>
                @else
                    <button class="layui-btn loginButton" type="button"  id="btn_submit" >确认授权</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
<input type="hidden" id="msg" value="{{session('msg')}}">
@if( count($errors) > 0 )
@foreach ($errors->all() as $K=>$error)
<input type="hidden" id="error" value="{{$error}}">
@endforeach
@endif
@section('js')
<script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
<script type="text/javascript">
    var layer;
    layui.use(['layer','form'], function() {
        layer = layui.layer;
        var msg = $("#msg").val();
        if( msg )
        {
            layer.msg($("#msg").val());
        }
    });
    /**
     * 表单验证
     */
    if( $(".changeForm").length )
    {
        $(".changeForm").Validform({
            btnSubmit: '#btn_submit',
            tiptype: 1,
            postonce: true,
            showAllError: false,
            tiptype: function (msg, o, cssctl) {
                if (!o.obj.is("form")) {
                    if (o.type != 2) {
                        var objtip = o.obj.parents('.layui-form-item').find(".layui-input");
                        objtip.addClass('layui-form-danger');
                        cssctl(objtip, o.type);
                        layer.msg(msg, {icon: 5, time: 2000, shift: 6});
                    }
                }
            }
        });
    }
</script>
@endsection