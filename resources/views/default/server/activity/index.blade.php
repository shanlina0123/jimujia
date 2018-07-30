@extends('server.layout.content')
@section("title")促销活动@endsection
@section('content')
    <div class="main">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>促销活动列表</legend>
        </fieldset>
        <div style="display: none" id="errorMsg" content="{{$errorMsg}}"></div>
        <!--新增和筛选部分-->
        <div class="addBtnWrap">
            <a class="layui-btn addBtn" url="{{route('activity-create')}}">新建促销活动</a>
            <div class="topSort layui-inline">
                <form class="layui-form " action="{{Request::url()}}" method="get"  id="searchForm">
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">活动名称</label>
                        <div class="layui-input-inline">
                            <input type="text" class="layui-input" id="title" name="title" value="{{$list["searchData"]["title"]}}">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">活动状态</label>
                        <div class="layui-input-inline">
                            <select name="isonline" lay-verify="required" lay-search=""  id="isonline" >
                                <option value="" @if($list["searchData"]["isonline"]=="") selected @endif>全部</option>
                                <option value="1" @if($list["searchData"]["isonline"]==1) selected @endif>上线</option>
                                <option value="2" @if($list["searchData"]["isonline"]==2) selected @endif>下线</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label" style="font-size: 14px;">门店</label>
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
        <h1 class="pageTitle">活动列表</h1>
        <!--列表数据部分-->
        <form class="layui-form">
            <table class="layui-table">
                <thead>
                <tr>
                    <th>活动编号</th>
                    <th>活动名称</th>
                    <th>活动门店</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>创建人</th>
                    <th>上线/下线</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($list['activityList']!=null) @foreach($list['activityList'] as $index=>$item)
                    <tr id="{{$item->id}}">
                        <td>{{$index+1}}</td>
                        <td>{{$item->title}}</td>
                        <td>@if($item->ActivityToStore){{$item->ActivityToStore->name}}@endif</td>
                        <td>{{$item->startdate}}</td>
                        <td>{{$item->enddate}}</td>
                        <td>@if($item->ActivityToUser){{$item->ActivityToUser->nickname}} @endif</td>
                        <td id="rowIsOnline" isonline="{{$item->isonline}}">
                            @if($item->isonline==1)
                                <input type="checkbox" name="isonline" lay-skin="switch" lay-text="ON|OFF" value="1"
                                       checked="checked" lay-filter="rowIsOnline" url="{{route('activity-setting',$item->id)}}">
                            @else
                                <input type="checkbox" name="isonline" lay-skin="switch" lay-text="ON|OFF" value="0"
                                       lay-filter="rowIsOnline" url="{{route('activity-setting','id')}}">
                            @endif
                        </td>
                        <td>
                            <div class="layui-btn-group">
                                <a type="button" class="layui-btn seeBtn" url="{{route('activity-edit',$item->id)}}"
                                   @if($item->isonline==0)style="display: none;"@endif>查看</a>
                                <a type="button" class="layui-btn editBtn" url="{{route('activity-edit',$item->id)}}"
                                   @if($item->isonline==1)style="display: none;"@endif >编辑</a>
                                <a type="button" class="layui-btn deleteBtn" url="{{route('activity-delete',$item->id)}}"
                                        @if($item->isonline==1)style="display: none;"@endif >删除
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach @endif
            </table>
        </form>

        <div class="pageWrap">@if($list['activityList']!=null){{ $list['activityList']->links() }} @endif</div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{pix_asset('server/plugins/html2canvas/0.4.1/html2canvas.js')}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/activity/activity.js')}}"></script>
@endsection