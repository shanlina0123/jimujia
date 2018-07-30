<?php
use Illuminate\Support\Facades\Cache;
use \App\Http\Model\Sms\History;
class Sms
{

    private $appid = '';
    private $appkey = '';
    private $url = '';

    //定义发送短信的url
    /**
     * @param $phone 电话号码
     * @param $conent 短信内容
     * @return bool 返回真或者假
     */
    private function  GetSms( $phone, $conent )
    {

    }

    /**
     * @param $phone
     * @param $random
     * @param $time
     * @return string
     * 加密
     */
    private function sig(  $phone, $random, $time  )
    {
        return hash("sha256", "appkey=".$this->appkey."&random=".$random."&time=".$time."&mobile=".$phone);
    }

    /**
     * @param int $pw_length
     * @return string
     */
    static function create_code()
    {
        return rand(1000,9999);
    }


    /**
     * 发送请求
     *
     * @param string $url      请求地址
     * @param array  $dataObj  请求内容
     * @return string 应答json字符串
     */
    public function sendCurlPost($url, $dataObj)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($curl);
        if (false == $ret)
        {
            $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
        } else
        {
            $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp
                    . " " . curl_error($curl) ."\"}";
            } else {
                $result = $ret;
            }
        }
        curl_close($curl);
        return $result;
    }



    /**
     * @param $phone
     * @param $conent
     * @return int
     * 发送短信
     */
    static function SendSms( $phone, $conent )
    {

        if( config('configure.is_sms') == true )
        {
            $res = (new Sms())->GetSms( $phone, $conent );
            $res = json_decode( $res, true );
        }else
        {
            $res['result'] = 0;
        }

        if( $res['result'] == 0 )
        {
            return true;
        }else
        {
            return false;
        }
    }


    /**
     * @param $phone
     * @param $type
     * @return mixed
     *  发送短信公共方法
     */
    static function getCode( $phone, $type )
    {
        $reg = '/^1[345678]\d{9}$/';
        if( preg_match($reg, $phone)  == false )
        {
            responseData(StatusCode::ERROR,'手机号码验证失败');
        }
        $code = Sms::create_code();
        Cache::put('tel_'.$phone,$code,config('configure.sms_cache'));
        switch ( $type )
        {
            case "1":
                $content = "您本次的验证码是".$code."，请于10分钟内填写。请勿泄露。";
                break;
            case "2":
                $content = "您本次的验证码是".$code."，请于10分钟内填写。请勿泄露。";
                break;
            case "3":
                $content = "您本次的验证码是".$code."，请于10分钟内填写。请勿泄露。";
                break;
            case "4":
                $content = "您本次的验证码是".$code."，请于10分钟内填写。请勿泄露。";
                break;
            default:
                $content = "您本次的验证码是".$code."，请于10分钟内填写。请勿泄露。";
                break;
        }
        $res = Sms::SendSms( $phone, $content );
        if( $res )
        {
            $user = session('userInfo');
            $sms = new History();
            $sms->companyid = $user?$user->companyid:0;
            $sms->userid = $user?$user['id']:0;
            $sms->type = 1;
            $sms->content = $content;
            $sms->code = $code;
            $sms->phone = $phone;
            $sms->created_at = date("Y-m-d H:i:s");
            $sms->save();
            responseData(StatusCode::SUCCESS,'发送成功');

        }else
        {
            responseData(StatusCode::ERROR,'发送失败...');
        }
    }
}


