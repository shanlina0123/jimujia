@extends('server.layout.content')
@section("title")用户管理@endsection

@section("css")
    <style>
        .popWrap .layui-form-label {
            width: 10%!important;
        }
        .popWrap .layui-form-item .layui-input-inline {
            width: 80%!important;
        }
    </style>
    @endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>用户列表</legend>
        </fieldset>
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <button type="button" class="layui-btn addBtn">新增用户</button>
            <div class="topSort layui-inline">
                <form class="layui-form " action="{{Request::url()}}" method="get"  id="searchForm">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">姓名筛选</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" name="nickname" id="nickname" value="{{$list["searchData"]["nickname"]}}">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">门店筛选</label>
                        <div class="layui-input-inline">
                            <select name="storeid" lay-verify="required" lay-search="" id="storeid">
                                 <option value="" @if($list["searchData"]["storeid"]==0) selected @endif>全部</option>
                                @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                                    <option value="{{$item->id}}" @if($list["searchData"]["storeid"]==$item->id) selected @endif>{{$item->name}}</option>
                                @endforeach  @endif
                            </select>
                        </div>
                    </div>
                    <button class="layui-btn searchBtn">查询</button>
                </form>
            </div>
        </div>
        <!--列表数据部分-->
        <form class="layui-form" action="{{route('admin-index')}}" method="get" id="listForm">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>账号</th>
                    <th>角色</th>
                    <th>门店</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list['userList']!=null) @foreach($list['userList'] as $index=>$item)
                <tr  class="listRow" uuid="{{$item->uuid}}" roleid="{{$item->roleid}}" storeid="{{$item->storeid}}">
                    <td>{{$index+1}}</td>
                    <td id="rowNickName">{{$item->nickname}}</td>
                    <td id="rowUserName">{{$item->username}}</td>
                    <td id="rowRoleName" >@if($item->dynamicToRole!=null){{$item->dynamicToRole->name}} @endif</td>
                    <td id="rowStoreName" >@if($item->dynamicToStore!=null){{$item->dynamicToStore->name}} @endif</td>
                    <td id="rowStatus" status="{{$item->status}}">
                        @if($item->isdefault==1)
                            默认
                        @else
                            @if($item->status==1)
                                <input type="checkbox"   name="status" lay-skin="switch" lay-text="ON|OFF" checked="checked" lay-filter="rowStatus" url="{{route('admin-setting','uuid')}}">
                            @else
                                <input type="checkbox"    name="status" lay-skin="switch" lay-text="ON|OFF" lay-filter="rowStatus" url="{{route('admin-setting','uuid')}}">
                            @endif
                        @endif
                    </td>
                    <td>@if($item->created_at!=null){{$item->created_at}} @endif</td>
                    <td>
                        @if($item->isdefault==1)
                            默认
                        @else
                            <div class="layui-btn-group">
                                <div class="layui-btn-group">
                                    <a type="button" class="layui-btn editBtn">编辑</a>
                                    <a type="button" class="layui-btn deleteBtn" url="{{route('admin-delete','uuid')}}">删除</a>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach @endif
            </table>
        </form>

        <div class="pageWrap">@if($list['userList']!=null){{ $list['userList']->links() }} @endif</div>
    </div>
@endsection
@section('other')
    <!--新增用户弹窗-->
    <div class="addWrap popWrap">
        <form class="layui-form"  id="addForm"  action="{{route('admin-store')}}" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="nickname" maxlength="100" minlength="1" size="100" >
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">角色</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="roleid">
                        @if($list['roleList']!=null)
                            <option value="0">请选择</option>
                            @foreach($list['roleList'] as $k=>$item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @else
                             <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">账号</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="username" maxlength="20" minlength="3"  size="20" placeholder="3-20位字符+数字">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">密码</label>
                <div class="layui-input-inline">
                    <input type="password" class="layui-input"  id="password"  maxlength="12" minlength="6" size="12" placeholder="请输入6-12位字母+数字(区分大小写)">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="storeid">
                        @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach @else
                            <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">状态</label>
                <div class="layui-input-inline">
                    <input type="radio"  id="status" name="status"  value="1" title="启用"  lay-filter="isLookCheck" checked>
                    <input type="radio"  id="status" name="status"  value="0" title="锁定"  lay-filter="isLookCheck">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn  ajaxSubmit" btn="addBtn">立即提交</button>
                <button type="button" class="layui-btn  channelBtn" >取消</button>
            </div>
        </form>
    </div>
    <!--编辑用户弹窗-->
    <div class="editWrap popWrap">
        <form class="layui-form" id="editForm"  action="{{route('admin-update','uuid')}}" method="put">
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input"  id="nickname" maxlength="100" minlength="1" size="100">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">角色</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="roleid">
                        @if($list['roleList']!=null) @foreach($list['roleList'] as $k=>$item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach @else
                            <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">账号</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input"  id="username" maxlength="20" minlength="3"  size="20" placeholder="3-20位字符+数字">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">密码</label>
                <div class="layui-input-inline">
                    <input type="password" class="layui-input"  id="password" maxlength="12" minlength="6"  size="12" placeholder="请输入6-12位字母+数字(区分大小写)">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">门店</label>
                <div class="layui-input-inline">
                    <select name="modules" lay-verify="required" lay-search="" id="storeid">
                        @if($list['storeList']!=null) @foreach($list['storeList'] as $k=>$item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach @else
                                <option value="0">请选择</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="font-size: 14px;">状态</label>
                <div class="layui-input-inline">
                    <input type="radio" id="status" name="status"  value="1" title="启用"  lay-filter="isLookCheck">
                    <input type="radio" id="status" name="status"  value="0" title="锁定"  lay-filter="isLookCheck">
                </div>
            </div>
            <div class="layui-form-item popSubmitBtn">
                <button type="button" class="layui-btn ajaxSubmit" btn="updateBtn">立即提交</button>
                <button type="button" class="layui-btn  channelBtn" >取消</button>
            </div>
        </form>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/js/admin/admin.js')}}"></script>
@endsection