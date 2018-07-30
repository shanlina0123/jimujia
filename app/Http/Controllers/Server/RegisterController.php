<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\BusinessServerRegiste;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\Conf\Pc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RegisterController extends ServerBaseController
{

    protected $user;
    public function __construct(BusinessServerRegiste $user)
    {
        $this->user = $user;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 注册页面
     */
    public function register( Request $request )
    {
        return view('server.userentrance.login');

    }
}