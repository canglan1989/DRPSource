//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：系统公用javascript框架基础功能，基于jQuery 1.6.1版本实现，此文件已导入所有类别功能
//
// 创建标识：林希胜     添加时间：2011-5-31 17:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------
(function (undefined) {
    var ps_frame = {
        currentBasePath: "", // "http://localhost/",
        ///获取网站根url
        //如果currentBasePath值存在则返回该值
        currentBasePathGet: function () {
            return ps_frame.currentBasePath || function () {
                var strFullPath = window.document.location.href;
                var strPath = window.document.location.pathname;
                var pos = strFullPath.lastIndexOf(strPath);
                var prePath = strFullPath.substring(0, pos + 1);
                currentBasePath = prePath;
                return prePath;
            } ();
        },
        //只能适用于配置网站，不能是虚拟目录
        Import: function (path) {
            var basePath = ps_frame.currentBasePathGet();
            var fullPath = basePath + path;
            if (path.indexOf(".css") == path.length - 4) { //css file
                document.write("<link href='" + fullPath + "' rel='stylesheet' type='text/css'></link>");
            }
            else if (path.indexOf(".js") == path.length - 3) { //javascript file
                document.write("<script type='text/javascript' src='" + fullPath + "'></script>");
            }
        }
    };
    window.ps_frame = ps_frame; //ps_frame用于扩展到jQuery
    if (typeof (jQuery) != "undefined") {//如果已加载jQuery 
        jQuery.extend(window.ps_frame);
    }
    else {//未加载jQuery
        window.$ = window.ps_frame;
    }
})();

var Config = {
    evnFlag : 0,//系统环境标识  0开发 1测试 2正式
    provinces : null,
    areas : null,
    pIndustry : null,
    industry : null,
    purview : null,
    constData : null,
    provincesChannel : null,
    getData : function (pUrl) {
        var strReturn = "";
        $.ajax({
            async: false, //true 异步 默认true
            type: "POST",
            dataType: "text",
            url: pUrl,
            data: "",
            success: function (data) {
                //alert(data);
                strReturn = data + "";
            }
        });
    
        return strReturn;
    },
    GetProvinces :function(iAll){
        if(iAll)
        {
            if(Config.provincesAll == null)
            {
                Config.provincesAll = eval("("+Config.getData("/?d=Index&c=Index&a=GetProvinceJson&iAll=1")+")") ;
            }
            return Config.provincesAll;
        }
        else
        {
            if(Config.provinces == null)
            {
                Config.provinces = eval("("+Config.getData("/?d=Index&c=Index&a=GetProvinceJson&iAll=0")+")") ;
            }
            return Config.provinces;
        }
    },
    GetProvincesChannel :function(){
        if(Config.provincesChannel == null)
        {
            Config.provincesChannel = eval("("+Config.getData("/?d=Index&c=Index&a=GetProvinceChannelJson")+")") ;
        }
        return Config.provincesChannel;            
    },
    GetArea:function(){
        if(Config.areas == null)
        {
            //默认
            Config.areas = eval("("+Config.getData("/?d=Index&c=Index&a=GetAreaJson")+")");
        }
        return Config.areas;
    },
    GetPIndustry:function(){
        if(Config.pIndustry == null)
        {
            Config.pIndustry = eval("("+Config.getData("/?d=Index&c=Index&a=GetPIndustryJson")+")");
        }
        return Config.pIndustry;
    },
    GetIndustry:function(){
        if(Config.industry == null)
        {
            Config.industry = eval("("+Config.getData("/?d=Index&c=Index&a=GetIndustryJson")+")");
        }
        return Config.industry;
    },
    GetConstData:function(){
        if(Config.constData == null)
        {
            Config.constData = eval("("+Config.getData("/?d=Index&c=Index&a=GetRegistrStatus")+")");
        }
        return Config.constData;
    },
    GetPurview:function(){
        if(Config.purview == null)
        {
            Config.purview = eval("("+Config.getData("/?d=Index&c=Index&a=RightJoson")+")");
        }
        return Config.purview;
    }
};

//公用库
$.Import("FrontFile/JS/JSFrameWork/event.js");
//基本框架
//$.Import("FrontFile/JS/JSFrameWork/jquery.js"); //将覆盖刚刚注册的$对象
$.Import("FrontFile/JS/JSFrameWork/ps_frame_basic.js"); //导入ps_frame到jQuery
//其他功能导入
$.Import("FrontFile/JS/JSFrameWork/createDOM.js");
$.Import("FrontFile/JS/JSFrameWork/href.js");
$.Import("FrontFile/JS/JSFrameWork/purview.js");
//最后添加项目配置文件 与 JSFrameWork无关

//业务功能导入
$.Import("FrontFile/JS/CommonBusiness.js");
$.Import("FrontFile/JS/GetProduct.js");

//加权限验证
$(function () {
    $.setPurview();
})
