<?php

namespace App\Http\Controllers\Server;

use App\Http\Business\Server\SiteTemplateBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteTemplateController extends ServerBaseController
{
    protected $template;
    protected $request;
    public function __construct( SiteTemplateBusiness $template,Request $request )
    {
        parent::__construct();
        $this->request = $request;
        $this->template = $template;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->template->getTemplateList( $this->userInfo, $this->request );
        return view('server.sitetemplate.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('server.sitetemplate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //表单验证
        $this->request->validate([
            'name'=>'required|string|max:10',
            'tag'=>'required|array',
        ]);
        $data = trimValue($this->request->all());
        if( count($data['tag']) < 3 || count($data['tag']) > 12 )
        {
            return redirect()->route('site-template.create')->withInput($this->request->all())->with('msg','阶段标签3-12个');
        }
        $data['companyid'] = $this->userInfo->companyid;
        $res = $this->template->templateSave( $data );
        if( $res == true )
        {
            Cache::tags(['siteTemplate'.$data['companyid'],'templateListHome'.$data['companyid'],'defaultTemplateHome'.$data['companyid']])->flush();
            return redirect()->route('site-template.index')->with('msg','添加成功');
        }else
        {
            return redirect()->route('site-template.create')->withInput($this->request->all())->with('msg','添加失败');
        }
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
        //$type = $this->request->input('type');
        $companyId = $this->userInfo->companyid;
        $data = $this->template->editTemplate( $companyId, $id );
        if( $data )
        {
            if( $data->stageTemplateToSite()->count() )
            {
                return redirect()->back()->with('msg','模板已被使用不能修改');
            }
        }else
        {
            return redirect()->back()->with('msg','未查询到信息');
        }
        return view('server.sitetemplate.edit',compact('data','type'));
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
        //验证
        $this->request->validate([
            'name'=>'required|string|max:10',
            'tag'=>'required|array',
        ]);
        $data = trimValue($this->request->all());
        if( count($data['tag']) < 3 || count($data['tag']) > 12 )
        {
            return redirect()->back()->withInput($this->request->all())->with('msg','阶段标签3-12个');
        }
        $data = trimValue($this->request->all());
        $data['companyid'] = $this->userInfo->companyid;
        $res = $this->template->updateTemplate( $data, $id );
        if( $res->ststus )
        {
            Cache::tags(['siteTemplate'.$data['companyid'],'templateListHome'.$data['companyid'],'defaultTemplateHome'.$data['companyid']])->flush();
            return redirect()->route('site-template.index')->with('msg','修改成功');
        }else
        {
            return redirect()->back()->withInput($this->request->all())->with('msg',$res->msg );
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
        $companyId = $this->userInfo->companyid;
        $res = $this->template->templateDel( $companyId, $id );
        if( $res->status == 1 )
        {
            Cache::tags(['siteTemplate'.$companyId,'templateListHome'.$companyId,'defaultTemplateHome'.$companyId])->flush();
        }
        return json_encode($res);
    }


    /**
     * @param $id
     * @return string
     * 设置默认
     */
    public function templateDefault( $id )
    {
        $companyId = $this->userInfo->companyid;
        $res = $this->template->templateDefault( $companyId, $id );
        if( $res->status  )
        {
            Cache::tags(['siteTemplate'.$companyId,'templateListHome'.$companyId,'defaultTemplateHome'.$companyId])->flush();
        }
        return json_encode($res);
    }

    /**
     * @return string
     * 添加使用系统模板
     */
    public function addDefaultTemplate()
    {
        $companyId = $this->userInfo->companyid;
        $id = $this->request->input('id');
        $res = $this->template->addDefaultTemplate( $companyId, $id );
        if( $res->status  )
        {
            Cache::tags(['siteTemplate'.$companyId,'templateListHome'.$companyId,'defaultTemplateHome'.$companyId])->flush();
        }
        return json_encode($res);
    }
}
