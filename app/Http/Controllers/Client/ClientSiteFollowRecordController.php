<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 10:32
 */

namespace App\Http\Controllers\Client;
use App\Http\Business\Client\ClientSiteFollowRecord;
use App\Http\Controllers\Common\ClientBaseController;
class ClientSiteFollowRecordController extends ClientBaseController
{
    public $siteFollow;
    public function __construct(ClientSiteFollowRecord $siteFollow)
    {
        parent::__construct();
        $this->siteFollow = $siteFollow;
    }


    /**
     * 我的关注项目
     */
    public function followRecord()
    {
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $where['userid'] = $user->id;
        $res = $this->siteFollow->followRecord( $where, $this->request );
        responseData(\StatusCode::SUCCESS,'我的关注项目',$res);
    }

    /**
     * 取消或者关注
     */
    public function recordSite(){
        $user = $this->apiUser;
        $where['companyid'] = $user->companyid;
        $where['siteid'] = (int)$this->request->input('siteid');
        $where['userid'] = $user->id;
        $res = $this->siteFollow->recordSite( $where,$user, $this->request );
        if( $res ){

            responseData(\StatusCode::SUCCESS,'关注成功');
        }
        responseData(\StatusCode::ERROR,'关注失败',$res);
    }
}