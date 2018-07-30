<div class="layui-logo"><a href="{{route('index')}}"><img src="{{pix_asset('server/images/topMainLogo.png')}}"></a></div>
<ul class="layui-nav layui-layout-right">
    <li class="layui-nav-item" >
        <a href="http://showdoc.yygsoft.com/web/#/page/1" target="_blank" title="帮助中心" style="padding: 0 15px;"><img src="{{pix_asset('server/images/help.png')}}" width="32"></a>
    </li>
    <li class="layui-nav-item nav-menu" url="{{route('vip-index')}}">
        <a  title="会员中心" style="padding: 0 15px;"><img src="{{pix_asset('server/images/user.png')}}" width="32"></a>
    </li>
    <li class="layui-nav-item nav-menu" url="{{route('notice-index')}}">
        <a  title="通知消息" style="padding: 0 15px;" style="padding: 0 15px;"url="{{route('notice-listen',strtotime(date('Y-m-d H:i:s')))}}" id="notice-listen"><img src="{{pix_asset('server/images/notice.png')}}" width="32"><span class="layui-badge-dot" style=" top: 27px; left: 35px;"></span></a>
    </li>
    <li class="layui-nav-item"  >
        <a href="{{route("chat-index")}}"  target="_blank" title="咨询消息" style="padding: 0 15px;"><img src="{{pix_asset('server/images/message.png')}}" width="32"></a>
    </li>
    <li class="layui-nav-item" >
        <a href="javascript:;" style="padding: 0 15px;">
            <img src="{{pix_asset('server/images/default.png')}}" class="layui-nav-img" >{{session("userInfo")->username}}
        </a>
        <dl class="layui-nav-child">
            <dd class="nav-menu"  url="{{route('user-info')}}"><a>个人资料</a></dd>
            <dd class="nav-menu"  url="{{route('set-pass')}}"><a>修改密码</a></dd>
            <dd> <a href="{{route('signout')}}">退出系统</a></dd>
        </dl>
    </li>
</ul>
