@extends('server.layout.content')
@section('title','新建项目')
@section('css')

@endsection
@section('content')
    <div class="main" style="margin-bottom: 100px;">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>新建项目</legend>
        </fieldset>
        <div class="fullForm">
            <div class="fullFormInner">
                <form class="layui-form"  id="layui-form" method="post" action="{{route('site.store')}}">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>门店</label>
                        <div class="layui-input-inline">
                            <select name="storeid" datatype="*" nullmsg="请选择门店">
                                @if( count($data->store) )
                                    @foreach( $data->store as $row )
                                        <option value="{{$row->id}}" @if(old('storeid') == $row->id ) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                @else
                                    <option value="0">暂无门店</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>详细地址</label>
                        <div class="layui-input-block">
                            <div class="layui-unselect layui-form-select layui-form-selected">
                                <div class="layui-select-title">
                                    <input type="text"  name="addr"  id="suggestId"  data-url="{{route('map-address')}}" value="{{old('addr')}}" class="layui-input layui-unselect" placeholder="请输入小区名称或者地址" datatype="*" nullmsg="请输入小区名称或者地址" errormsg="输入有误">
                                </div>
                                <dl id="seach" style="display: none">

                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>项目名称</label>
                        <div class="layui-input-block">
                            <input type="text"  name="name"  value="{{old('name')}}" class="layui-input newsName" placeholder="请输入项目名称" datatype="*" maxlength="255" nullmsg="请输入项目名称" errormsg="输入有误">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">门牌</label>
                        <div class="layui-input-block">
                            <input type="text" name="doornumber"  ignore="ignore" value="{{old('doornumber')}}" class="layui-input" placeholder="请输入门牌，例如5号楼808室" datatype="*1-20" nullmsg="请输入门牌号" errormsg="请输入正确的门牌号" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><i class="layui-icon" style="font-size: 12px; color: #FF5722;">*</i>阶段模板</label>
                        <div class="layui-input-inline">
                            <select name="stagetemplateid"  id="stagetemplateid" lay-filter="stagetemplate" datatype="*" nullmsg="请选择阶段模板">
                                <option value="">请选择阶段模板</option>
                                @foreach( $data->companyTemplate as $crow )
                                    <option value="{{$crow->id}}" data-type="0" data-url="{{route('site-template-tag')}}">{{$crow->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="forLineheight" style="color: #FF5722;">新建项目之后，阶段模板不可再修改</div>
                    </div>
                    <div class="layui-form-item layui-hide">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block" id="templateTag">

                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">房型</label>
                            <div class="layui-input-inline" style="width: 100px;">
                                <input type="number" name="room"   ignore="ignore"  value="{{old('room')}}" placeholder="室" min="1" max="9" maxlength="2" datatype="*1-2" nullmsg="请输入室" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">室</div>
                            <div class="layui-input-inline" style="width: 100px;">
                                <input type="number" name="office"  ignore="ignore"   value="{{old('office')}}"  placeholder="厅" min="1" max="9" maxlength="11"   datatype="*1-2" nullmsg="请输入厅" errormsg="请输入正确的房型" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">厅</div>
                            <div class="layui-input-inline" style="width: 100px;">
                                <input type="number" name="kitchen"  ignore="ignore"   value="{{old('kitchen')}}" placeholder="厨" min="1" max="9" maxlength="11"   datatype="*1-2" nullmsg="请输入厨" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">厨</div>
                            <div class="layui-input-inline" style="width: 100px;">
                                <input type="number" name="wei"   ignore="ignore"  value="{{old('wei')}}"  placeholder="卫" min="1" max="9" maxlength="11"  datatype="*1-2" nullmsg="请输入卫" errormsg="请输入正确的房型"  autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">卫</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">户型</label>
                        <div class="layui-input-inline">
                            <select name="roomtypeid"   ignore="ignore" datatype="*" nullmsg="请选择户型">
                                <option value="">请选择户型</option>
                                @foreach( $data->roomType as $row )
                                    <option value="{{$row->id}}" @if(old('roomtypeid') == $row->id ) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">面积</label>
                        <div class="layui-input-block">
                            <input type="number" name="acreage"   ignore="ignore"  value="{{old('acreage')}}" class="layui-input" placeholder="面积（㎡）" max="99999"  datatype="mj" nullmsg="请输入面积" errormsg="请输入正确的面积">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">装修风格</label>
                        <div class="layui-input-inline">
                            <select name="roomstyleid" ignore="ignore" datatype="*" nullmsg="请选择装修风格">
                                <option value="">请选择装修风格</option>
                                @foreach( $data->roomStyle as $row )
                                    <option value="{{$row->id}}" @if(old('roomstyleid') ==$row->id ) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">装修方式</label>
                        <div class="layui-input-inline">
                            <select name="renovationmodeid"   ignore="ignore"  datatype="*" nullmsg="请选择装修方式">
                                <option value="">请选择装修方式</option>
                                @foreach( $data->renovationMode as $row )
                                    <option value="{{$row->id}}" @if(old('renovationmodeid') == $row->id ) selected @endif>{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">预算</label>
                        <div class="layui-input-block">
                            <input type="number" name="budget"  ignore="ignore" value="{{old('budget')}}" class="layui-input" placeholder="预算（万元）"   maxlength="11"  datatype="n1-11" nullmsg="请输入预算" errormsg="请输入正确的数字">
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">项目封面</label>
                        <div class="layui-upload-drag" id="test10" style="float: left">
                            <i class="layui-icon"></i>
                            <p>请上传460px*430px的图片,最大{{config("configure.maxImgSize")}}（项目封面：建议上传效果图）</p>
                        </div>
                        <div class="uploadImg layui-inline fl" style="display: none;margin-left: 20px;"><img   id="src" style="max-width: 100%;max-height:135px;"></div>
                        <input type="hidden" name="photo" id="photo">
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否公开</label>
                        <div class="layui-input-block">
                            <input type="checkbox" checked="" name="isopen" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                        </div>
                    </div>
                    <div class="submitButWrap">
                        <button type="button" class="layui-btn" id="btn_submit">立即提交</button>
                    </div>
                    <input type="hidden" name="street" value="">
                    <input type="hidden" name="fulladdr" value="">
                    <input type="hidden" name="lng" value="">
                    <input type="hidden" name="lat" value="">
                    <input type="hidden" name="sitestagename" value="" id="sitestagename">
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="msg" value="{{session('msg')}}">
    @if( count($errors) > 0 )
        @foreach ($errors->all() as $K=>$error)
            <input type="hidden" id="error" value="{{$error}}">
        @endforeach
    @endif
@endsection
@section('js')
    <script type="text/javascript" src="{{pix_asset('server/plugins/validform/Validform_v5.3.2_min.js',false)}}"></script>
    <script type="text/javascript" src="{{pix_asset('server/js/site/site.js')}}"></script>
@endsection
