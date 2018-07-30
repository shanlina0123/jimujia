<?php
return [

    /****
     * B端权限
     * 例如user=>["companySetting","userAuthorize"];
     */
    //需要权限验证的工地控制器
    "SiteController"=>[
        "funcid"=>2,//菜单id,对应表filter_function中pid=0的菜单中主键id
        "user"=>['store','siteList','siteDestroy','isOpen','isFinish','siteEdit','siteUpdate','siteInfo','siteDynamic'],//pc端的非管理员
        "invitation"=>[],//B端的参与者，成员
    ],
    "SiteDynamiController"=>[
        "funcid"=>2,//菜单id,对应表filter_function中pid=0的菜单中主键id
        "user"=>['getDynamicList','destroyDynamic'],//pc端的非管理员
        "invitation"=>[],//B端的参与者，成员
    ]

];