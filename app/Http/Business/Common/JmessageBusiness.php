<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/6
 * Time: 18:59
 */

namespace App\Http\Business\Common;
use JMessage\JMessage;
use JMessage\IM\User;
use JMessage\IM\Friend;
use JMessage\IM\Resource;
use JMessage\IM\Report;
class JmessageBusiness
{
    public $appKey;
    public $masterSecret;
    public $jmessageClient;
    public $jmessageUser;
    public $jmessageFriend;
    public $jmessageResource;
    public $jmessageReport;
    public function __construct()
    {
        //聊天init
        $this->appKey = config('jmessage.appKey');
        $this->masterSecret = config('jmessage.masterSecret');
    }

    /***
     * 实例化客户端
     */
    public function  setClient()
    {
        $this->jmessageClient = new JMessage($this->appKey, $this->masterSecret);//客户端
    }
    /***
     * 实例化用户
     */
    public function setUser()
    {
        $this->jmessageUser = new User($this->jmessageClient);//用户
    }
    /***
     * 实例化好友
     */
    public function setFriend()
    {
        $this->jmessageFriend = new  Friend($this->jmessageClient);//好友
    }
    /***
     * 实例化资源
     */
    public function setResource()
    {
         $this->jmessageResource = new  Resource($this->jmessageClient);//Resource 媒体资源
    }
    /***
     * 实例化消息列表
     */
    public function setReport()
    {
        $this->jmessageReport = new  Report($this->jmessageClient);//Report 获取消息
    }
    /**
     * @return \stdClass
     * 初始化
     */
    public function getJmessageInIt()
    {
        $random_str = str_random(10);
        $timestamp = msecTime();
        $str ="appkey=".$this->appKey."&timestamp=".$timestamp."&random_str=".$random_str."&key=".$this->masterSecret;
        $signature = md5($str);
        $obj = new \stdClass();
        $obj->appkey = $this->appKey;
        $obj->random_str = $random_str;
        $obj->signature = $signature;
        $obj->timestamp = $timestamp;
        $obj->flag = 1;
        return $obj;

    }

    /***
     * 获取所有用户
     * @param $count
     * @param int $start
     */
    public function userGetalllist($count,$start=0){
        $this->setClient();
        $this->setUser();
       return  $this->jmessageUser->listAll($count,$start);
    }

    /**
     * 极光 - User 注册用户
     */
    public function userRegister($username,$pwd=null,$nickname=null,$extras=[])
    {
        $this->setClient();
        $this->setUser();
        $pwd=$pwd?$pwd:config('jmessage.defaultpwd');
        $faceimg=config('jmessage.defaultfaceimg');
        if(array_key_exists("faceimg",$extras))
        {
            $extras["faceimg"]=strlen(trim($extras["faceimg"]))>0?$extras["faceimg"]:$faceimg;
        }else{
            $extras["faceimg"]=$faceimg;
        }
        $jsonObj=(object)$extras;
        return $this->jmessageUser->register($username,$pwd,$nickname,$jsonObj);
    }

    /**
     * 极光 - User 获取用户信息
     */
    public function userShow($username)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->show($username);
    }
    /**
     * 极光 - User 更新用户信息
     * $username: 表示想要更新其信息的用户的用户名
    $options: 更新选项数组，表示需要更新的用户信息和值。支持 nickname、avatar、birthday、signature、gender、region、address 中的一个或多个
     * eg:$response = $user->update($username, ['nickname' => $nickname， 'gender' => 2]);
     */
    public function userUpdate($username,$options)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->update($username,$options);
    }

    /***
     * 查询用户在线状态
     * @param $username
     */
    public function userStat($username)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->stat($username);
    }

    /***
     * 修改密码
     * @param $username
     */
    public function userUpdatePassword($username,$password)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->updatePassword($username,$password);
    }

    /***
     * 删除用户
     * @param $username
     */
    public function userDelete($username)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->delete($username);
    }

    /***
     * 禁用用户
     * $username: 表示想要禁用的用户的用户名
    $enabled: true 表示禁用用户，false 表示取消禁用用户，即激活用户
     * @param $username
     */
    public function userForbidden($username,$enabled)
    {
        $this->setClient();
        $this->setUser();
        return $this->jmessageUser->forbidden($username,$enabled);
    }


    /***
     * 获取好友列表
     * $username: 表示要获取其好友列表的用户
     */
    public function friendListAll($username)
    {
        $this->setClient();
        $this->setFriend();
        return $this->jmessageFriend->listAll($username);
    }

    /***
     * 添加好友
     * $username: 表示要获取其好友列表的用户
     * eg:用户 'jiguang' 把用户 'username0', 'username1' 添加为好友
    $username = 'jiguang';
    $friends = ['username0', 'username1'];
     */
    public function friendAdd($username,$friends)
    {
        $this->setClient();
        $this->setFriend();
        return $this->jmessageFriend->add($username,$friends);
    }

    /***
     * 删除好友
     * @param $username
     * @param $friends eg：['username0', 'username1'];
     */
    public function friendRemove($username,$friends)
    {
        $this->setClient();
        $this->setFriend();
        return $this->jmessageFriend->remove($username,$friends);
    }

    /***
     * 更新好友备注
     * $username: 表示要更新好友备注的用户
    $options: 表示更新好友备注的选项数组
     * # 用户 'jiguang' 更新好友 'username0', 'username1' 的好友备注
    eg:  $user = 'jiguang';
    $options = [
    [
    'username' => 'username0',
    'note_name' => 'username0_alias',
    'others' => 'good friend'
    ], [
    'username' => 'username1',
    'note_name' => 'username1_alias',
    'others' => 'normal friend'
    ]
    ];
     */
    public function friendUpdateNotename($username,$options)
    {
        $this->setClient();
        $this->setFriend();
        return $this->jmessageFriend->remove($username,$options);
    }

    /***
     * 资源上传
     * $type: 表示要上传的资源类型，支持 'image' 、'voice' 和 'file' 三种资源类型
    $path: 表示要上传的资源的全路径
     * eg:
     * $path = '/home/user/www/jiguang.png';
    # 把图片 'jiguang.png' 作为图片上传
    $response = $resource->upload('image', $path);

    # 把图片 'jiguang.png' 作为文件上传
    $response = $resource->upload('file', $path);
     */
    public function resourceUpload($type,$path)
    {
        $this->setClient();
        $this->setResource();
        return $this->jmessageResource->upload($type, $path);
    }


    /***
     * 资源下载
     * $mediaId: 表示资源的 mediaId，包括用户的 avatar 字段，资源上传之后返回
     */
    public function resourceDownload($mediaId)
    {
        $this->setClient();
        $this->setResource();
        return $this->jmessageResource->download($mediaId);
    }


    /***
     * 获取用户的聊天消息
     * @param $username
     * @param $count
     * @param $beginTime
     * @param $endTime
     */
    public function userGetUserMessage($username,$count=100, $beginTime=null, $endTime=null)
    {
        $this->setClient();
        $this->setReport();
        $count=$count?$count:100;
        $beginTime=$beginTime?$beginTime:get_last_date();
        $endTime=$endTime?$endTime:get_today_date();
        return $this->jmessageReport->getUserMessages($username, $count, $beginTime, $endTime);
    }

}