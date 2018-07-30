<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Common\WxAlone;
use App\Http\Business\Common\WxAuthorize;
use App\Http\Business\Server\PublicBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\Data\City;
use App\Http\Model\Data\Country;
use App\Http\Model\Data\Province;
use App\Http\Model\User\User;
use App\Http\Model\Wx\SmallProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
ini_set('max_execution_time', '0');
class PublicController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $public_business;
    protected $request;
    public function __construct(Request $request)
    {
        $this->public_business =  new PublicBusiness($request);
        $this->request = $request;
    }

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        $obj = new \stdClass();
        $src = new \stdClass();
        if( $request->file('file') == false ) return '';
        try {
            //检验大小
            $fileSize=$request->file('file')->getSize();
            if(!$request->file('file')->getSize() || $fileSize>config("configure.maxImgSizeByte"))
            {
                $obj->code = 0;
                $obj->msg = $fileSize."图片大小不能低于0或超过".config("configure.maxImgSize");;
                $obj->data = '';
                return response()->json($obj, 200);
            }

            //检验文件类型
            $fileTypes = array('image/jpeg','image/png','video/mp4');
            if(!in_array($request->file('file')->getMimeType(),$fileTypes)) {
                $obj->code = 0;
                $obj->msg =  '文件格式不合法'.$request->file('file')->getMimeType();
                $obj->data = '';
                return response()->json($obj, 200);
            }

            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $obj->code = 1;
            $obj->msg = '上传成功';
            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $src->name = $name;
            $obj->data = $src;
            return response()->json($obj, 200);
        } catch (Exception $e)
        {
            $obj->code = 0;
            $obj->msg = '上传失败';
            $obj->data = '';
            return response()->json($obj, 200);
        }
    }

    /**
     *  获取腾讯地图搜索的地址
     */
    public function getMapAddress( Request $request )
    {
        $keyword = $request->input('keyword');
        if( $keyword )
        {
            $url = 'https://apis.map.qq.com/ws/place/v1/suggestion/?filter%3Dcategory%3D%E5%B0%8F%E5%8C%BA&keyword='.$keyword.'&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = file_get_contents($url);
            return $data;

        }else
        {
            return response()->json('', 200);
        }
    }


    /**
     * @param $phone
     * @param $type
     * 发送短息
     */
    public function sendSms()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,
            [
                'phone'=>'bail|regex:/^1[34578][0-9]{9}$/',
                'type'=>'bail|required|numeric',//类型
            ],[
                'phone.regex'=>'手机号码不正确',
                'type.numeric'=>'类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        switch ( (int)$data['type'] )
        {
            case 1: //注册
                $validator = Validator::make(
                    $data,
                    [
                        'phone'=>'unique:user',
                    ],[
                        'phone.unique'=>'手机号码已存在',
                    ]
                );
                if ($validator->fails())
                {
                    $messages = $validator->errors()->first();
                    responseData(\StatusCode::CHECK_FORM,$messages);
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;
            case 2: //修改手机号码
                $validator = Validator::make(
                    $data,
                    [
                        'phone'=>'unique:user',
                    ],[
                        'phone.unique'=>'手机号码已存在',
                    ]
                );
                if ($validator->fails())
                {
                    $messages = $validator->errors()->first();
                    responseData(\StatusCode::CHECK_FORM,$messages);
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;
            case 3: //修改密码
                $user = session('userInfo');
                if( $user->phone != $data['phone'] )
                {
                    responseData(\StatusCode::ERROR,'电话号码与实际注册的不符');
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;
            case 4: //密码登陆 忘记密码
                $where['type'] = 0;
                $where['isinvitationed'] = 0;
                $where['isadminafter'] = 1;
                $where['phone'] = $data['phone'];
                $user = User::where($where)->first();
                if( !$user )
                {
                    responseData(\StatusCode::ERROR,'账号不存在');
                }
                if( $user->status != 1 )
                {
                    responseData(\StatusCode::ERROR,'账号已冻结');
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;

        }
        responseData(\StatusCode::ERROR,'发送失败');
    }


    /**
     * 删除临时图片
     */
    public function delTempImg($name)
    {
        @unlink(public_path().'/temp/'.$name);
    }

    /*public function city()
    {

        $json = file_get_contents('default/server/json/city.json');
        $json = json_decode($json);
        foreach ( $json as $key=>$row )
        {
            //省
            $Province = new Province;
            $Province->id = trim($key);
            $Province->name = trim($row->name);
            $Province->status = 1;
            $Province->created_at = date("Y-m-d H:i:s");
            $Province->save();
            //市
            foreach ( $row->child as $ck=>$cv )
            {
                $city = new City;
                $city->id = trim($ck);
                $city->name = trim($cv->name);
                $city->provinceid = trim($key);
                $city->status = 1;
                $city->created_at = date("Y-m-d H:i:s");
                $city->save();
                //区县
                foreach ( $cv->child as $ak=>$av )
                {
                    $area = new Country;
                    $area->id = trim($ak);
                    $area->name = trim($av);
                    $area->cityid = trim($ck);
                    $area->status = 1;
                    $area->created_at = date("Y-m-d H:i:s");
                    $area->save();
                }

            }
        }
        dd( $json  );
    }*/


    /****
     * 获取微信二维码图片
     * //?type=ddd&scene=&width=
     */
    public function  getWxCodeImg( Request $request )
    {
        $companyid= session('userInfo')->companyid;
        $sourcecode = 1;//SmallProgram::where("companyid",$companyid)->value("sourcecode");
        if($sourcecode!=1)
        {
            echo "";
        }else{
            $type  = $request->type?$request->type:null;
            $scene = $request->scene?$request->scene:null;
            $width = $request->width?$request->width:null;
            //1单独部署
            if( config('wxtype.type') == 1 )
            {
                $wx = new WxAlone();
            }else
            {
                $wx = new WxAuthorize();
            }
            $wx->createWxappCode($companyid,$type, $scene,$width);
        }
    }

    /**
     * 小程序体验二维码
     */
    public function getWxExperienceCodeImg()
    {
        $companyid = session('userInfo')->companyid;
        $wx = new WxAuthorize();
        $wx->getWxExperienceCodeImg($companyid);
    }

    /***
     * 获取session。控制iframe
     */
    public function  getFrameSesion()
    {
        $userInfo=session("userInfo");
        $data["companyid"]=$userInfo->companyid;
        $data["isadmin"]=$userInfo->isadmin;
        $data["phone"]=$userInfo->phone;
        responseData(\StatusCode::SUCCESS, "获取成功",$data);
    }
}