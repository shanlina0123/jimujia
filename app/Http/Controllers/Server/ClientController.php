<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ClientBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientController extends ServerBaseController
{

    protected $client;
    protected $request;
    public function __construct( ClientBusiness $client, Request $request )
    {
        parent::__construct();
        $this->request = $request;
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = $this->client->getClientStatus();
        $data = $this->client->getClientList( $this->userInfo, $this->request );
        $where['k'] = $this->request->input('k');
        $where['status'] = $this->request->input('status');
        return view('server.client.index',compact('data','status',"lookuser",'where'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLuckyClient()
    {
        $status = $this->client->getClientStatus();
        $data = $this->client->getLuckyClient( $this->userInfo, $this->request );
        $where['k'] = $this->request->input('k');
        $where['status'] = $this->request->input('status');
        $where['iswin'] = $this->request->input('iswin');
        return view('server.client.lucky',compact('data','status','where'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLuckyClientLog( $id )
    {
        $row = $this->client->getLuckyClientLog( $this->userInfo, $id );
        return view('server.client.luckylog',compact('row'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->client->editClient( $this->userInfo, $id );
        if( $data )
        {
            responseData(\StatusCode::SUCCESS,'跟进记录',$data);
        }else
        {
            responseData(\StatusCode::ERROR,'跟进记录',[]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //表单验证
        $this->request->validate([
            'followstatusid'=>'required|numeric',
            'followcontent'=>'present|max:255',
        ]);
        $data = trimValue($this->request->all());
        $res = $this->client->updateClient( $data, $this->userInfo, $id );
        if( $res == true )
        {
            Cache::tags(['client'.$this->userInfo->companyid,'luckyClient'.$this->userInfo->companyid])->flush();
            return redirect()->back()->with('msg','跟进成功');
        }else
        {
            return redirect()->back()->with('msg','跟进失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userInfo;
        $res = $this->client->destroyClient( $user, $id );
        if( $res == true )
        {
            Cache::tags(['client'.$user->companyid,'luckyClient'.$user->companyid])->flush();
            return 'success';
        }else
        {
            return 'fail';
        }
    }
}
