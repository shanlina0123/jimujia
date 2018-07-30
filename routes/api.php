<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('user/login', 'Common\WxApiLoginController@login');//登陆
Route::post('user/openid', 'Common\WxApiLoginController@getOpenid');//登陆
Route::get('participant/position-code', 'Store\ParticipantController@code');
Route::post('jmessage/init', 'Common\SystemMessageController@getJmessageInIt');//极光初始化

Route::group(['middleware'=>'ApiCheck'], function () {
    //权限验证
    Route::group(['middleware' =>'ApiAuthCheck'], function () {
        /**
         * --------------------------
         * B端
         * --------------------------
         */
        Route::group(['namespace' => 'Store'], function () {
            //工地
            Route::post('site/store', 'SiteController@store');//发布工地
            Route::get('site/site-list', 'SiteController@siteList');//工地列表
            Route::get('site/search-site-list', 'SiteController@searchSiteList');//工地检索
            Route::delete('site/site-destroy', 'SiteController@siteDestroy');//工地删除
            Route::put('site/is-open', 'SiteController@isOpen');//工地是否公开
            Route::put('site/is-finish', 'SiteController@isFinish');//工地是否完工
            Route::post('site/edit', 'SiteController@siteEdit');//工地修改数据
            Route::put('site/update', 'SiteController@siteUpdate');//工地修改
            Route::get('site/info', 'SiteController@siteInfo');//工地详情
            Route::get('site/dynamic', 'SiteController@siteDynamic');//工地详情动态
            Route::put('site/renew', 'SiteController@siteRenew');//工地更新动态
            Route::get('site/renew-info', 'SiteController@siteRenewInfo');//工地更新动态模板数据
            //门店
            Route::post('store/store-list', 'StoreController@storeList');//门店列表
            //模板
            Route::post('template/default-template', 'TemplateController@defaultTemplate');//添加工地默认模板
            Route::post('template/template-list', 'TemplateController@templateList');//添加工模板列表
            Route::post('template/template-set', 'TemplateController@templateSet');//模板设置默认
            Route::post('template/template-destroy', 'TemplateController@templateDestroy');//模板删除
            //图片上传
            Route::any('img/upload', 'PublicController@uploadImgToTemp');
            Route::get('img/del/{name}', 'PublicController@delImg');
            //周边地图
            Route::post('map/address', 'PublicController@getMapAddress');
            Route::post('map/seach-address', 'PublicController@seachMapAddress');
            //客户列表
            Route::get('client/client-list', 'ClientController@clientList');
            //成员列表
            Route::get('participant/participant-list', 'ParticipantController@participantList');
            //职位列表
            Route::get('participant/position-list', 'ParticipantController@positionList');
            //添加成员
            Route::post('participant/participant-save', 'ParticipantController@addParticipant');
            //删除成员
            Route::delete('participant/participant-del', 'ParticipantController@delParticipant');
            //参与者店铺列表
            Route::get('store/invitation-list', 'StoreController@invitationStoreList');
            //参与者切换门店
            Route::put('store/invitation-storeup', 'StoreController@invitationStoreUp');


        });

        /**
         * -----------------------------
         * C端
         * -----------------------------
         */
        Route::group(['namespace' => 'Client'], function () {
            //工地动态
            Route::get('client/dynamic-list', 'SiteDynamiController@getDynamicList');
            //删除动态
            Route::delete('client/dynamic-destroy', 'SiteDynamiController@destroyDynamic');
            //删除评论
            Route::delete('client/dynamic-comment-destroy', 'SiteDynamicCommentController@commentDestroy');
            //发布评论
            Route::post('client/dynamic-comment-add', 'SiteDynamicCommentController@commentAdd');
            //点赞
            Route::post('client/dynamic-fabulous', 'SiteDynamicStatisticsCommentController@Fabulous');
            //预约
            Route::post('client/appointment', 'ClientAppointmentController@Appointment');
            //我的关注项目
            Route::get('client/follow-record', 'ClientSiteFollowRecordController@followRecord');
            //关注
            Route::post('client/record-site', 'ClientSiteFollowRecordController@recordSite');
            //活动列表
            Route::get('client/activity-list', 'ClientActivityController@activityList');
            //活动详情
            Route::get('client/activity-info', 'ClientActivityController@activityInfo');
            //我的装修
            Route::get('client/site-invitation', 'ClientSiteInvitationController@siteInvitation');
            //公司信息
            Route::get('client/company-info', 'ClientCompanyController@companyInfo');
            //中奖列表
            Route::get('client/lucky-record', 'ClientActivityLuckyRecordController@luckyRecordList');
            //动态修改
            Route::match(['get', 'post'], 'client/dynamic-up', 'SiteDynamiController@dynamicUp');
            //业主评价详情页面
            Route::get('site/site-evaluate-info', 'SiteEvaluateController@evaluateInfo');
            //业主评价
            Route::post('site/owner-evaluate', 'SiteEvaluateController@ownerEvaluate');
            //删除评价
            Route::delete('site/evaluate-destroy', 'SiteEvaluateController@evaluateDestroy');
            //邀请业主二维码
            Route::get('site/evaluate-code', 'SiteEvaluateController@code');
            //C端数据筛选条件
            Route::get('site/screening-conditions', 'SiteController@siteScreeningConditions');
            //C端工地列表
            Route::get('site/site-screening', 'SiteController@siteList');
        });
    });
    /**
     * 问题反馈
     */
    Route::post('qa/feedback', 'Common\QaController@feedback');
    //消息通知
    Route::get('log/notice', 'Common\SystemMessageController@notice');
    Route::post('log/read-notice', 'Common\SystemMessageController@readNotice');
    //修改用户信息
    Route::post('user/set-user', 'Common\WxApiLoginController@setUserInfo');

    //抽奖
    Route::get('lucky/info', 'Common\LuckyController@luckyInfo');
    Route::get('lucky/my-luck', 'Common\LuckyController@myLucky');
    Route::get('lucky/draw', 'Common\LuckyController@lucyDraw');
    Route::post('lucky/client', 'Common\LuckyController@lucyClient');
    Route::get('lucky/draw-list', 'Common\LuckyController@lucyDrawList');

    /**
     * 极光推送
     */
    Route::post('jmessage/register', 'Common\SystemMessageController@jmessageRegister');//极光注册
    Route::get('jmessage/friend-list', 'Common\SystemMessageController@jmessageFriendList');//好友列表
    Route::post('jmessage/friend-add', 'Common\SystemMessageController@jmessageFriendAdd');//好友添加
    Route::post('jmessage/user-info', 'Common\SystemMessageController@jmessageGetUserInfo');//好友信息
    Route::post('jmessage/user-testing', 'Common\SystemMessageController@jmessageUserTesting');//好友信息

});


