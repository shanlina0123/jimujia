<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /***
     * 获取请求参数
     * @param $initKeys
     * @param $data
     * @return array
     */
    public function  getData($initKeys,$data)
    {
        $data=trimValue($data);//去空格
        $postKeys=array_keys($data);//请求的keys
        $unsetKeys=array_diff($postKeys,$initKeys);//未定义多余的keys
        //移除非定义的参数
        foreach($unsetKeys as $k=>$v)
        {
            unset($data[$v]);
        }
        //返回结果
        return $data;

    }


}
