<?php

namespace App\Http\Model\Site;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'site';
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联店铺
     */
    public function siteToStore()
    {
        return $this->belongsTo('App\Http\Model\Store\Store','storeid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联系统阶段值
     */
    public function siteToDataTag()
    {
        return $this->belongsTo('App\Http\Model\Data\StageTemplateTag','stageid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联公司阶段值
     */
    public function siteToCommpanyTag()
    {
        return $this->belongsTo('App\Http\Model\Company\CompanyStageTemplateTag','stageid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联数据统计
     */
    public function siteToDynamicStatistics()
    {
        return $this->belongsTo('App\Http\Model\Dynamic\DynamicStatistics','id','siteid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联观光团关注的工地
     */
    public function siteToFolloWrecord()
    {
        return $this->hasMany('App\Http\Model\Site\SiteFollowrecord','siteid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联装修方式
     */
    public function siteToRenovationMode()
    {
        return $this->belongsTo('App\Http\Model\Data\RenovationMode','renovationmodeid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联户型
     */
    public function siteToRoomType()
    {
        return $this->belongsTo('App\Http\Model\Data\RoomType','roomtypeid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联风格
     */
    public function siteToRoomStyle()
    {
        return $this->belongsTo('App\Http\Model\Data\RoomStyle','roomstyleid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联公司
     */
    public function siteToCompany()
    {
        return $this->belongsTo('App\Http\Model\Company\Company','companyid','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联工地
     */
    public function siteToUser()
    {
        return $this->belongsTo('App\Http\Model\User\User','createuserid','id');
    }

    /**
     * 关联评价
     */
    public function siteToEvaluate()
    {
        return $this->hasMany('App\Http\Model\Site\SiteEvaluate','siteid','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联城市
     */
    public function siteToCity()
    {
        return $this->belongsTo('App\Http\Model\Data\City','cityid','id');
    }

}
