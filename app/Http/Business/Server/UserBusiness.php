<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\User\User;
use App\Http\Model\Wx\SmallProgram;

class UserBusiness extends ServerBase
{

    /**
     * @param $data
     * @param $where
     * @return mixed
     * 修改手机号码
     */
     public function setPhone( $data, $where )
     {
        return User::where($where)->update( $data );
     }


    /**
     * @param $data
     * @param $where
     * @return mixed
     * 修改密码
     */
     public function setPass( $data, $where )
     {
         return User::where($where)->update( $data );
     }

    /***
     * 修改昵称
     * @param $data
     * @param $where
     * @return mixed
     */
     public function  setNickname( $data, $where )
     {
         return User::where($where)->update( $data );
     }
    /**
     * @param $user
     * @return mixed
     * 认证信息
     */
     public function getAuthorizeStatus( $user )
     {
         return SmallProgram::where('companyid',$user->companyid)->first();
     }
}