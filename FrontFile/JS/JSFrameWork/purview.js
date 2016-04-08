//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：用户按钮权限设定（将按钮变灰或消失）
//
// 创建标识：林希胜     添加时间：2011-6-16 08:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------

(function ($, undefined) {
    var ps_frame = {
        setPurview: function () {
            var theModel = $.getUrlParamValue("a");
            var purview = Config.GetPurview();
            var modelPurviewDefault = purview[theModel]; //模块权限
            $("[ispurview=true]").each(function () {
                if (this.attributes['m'])//如果是其他模块的按钮
                {
                    var modelPurview = purview[this.attributes['m'].value]; //模块权限
                    setBtnPurview(modelPurview, this);
                }
                else {
                    setBtnPurview(modelPurviewDefault, this);
                }
            });
            function setBtnPurview(modelPurview, btn) { //设置按钮权限显示
                if ((modelPurview & btn.attributes['v'].value) == 0)//这里用 与和 判断是否有权限
                {
                    $.createProperty({style:{display:"none"}}, btn);
                    var iAllNoPurview=true;
                    //控制列表上面的按钮的总外框是否显示
                    if(btn.parentNode&&btn.parentNode.className.indexOf("list_link")>-1)//列表上面的按钮
                    {
                        for(var node_i=0;node_i<btn.parentNode.childNodes.length;node_i++)//有一个按钮有权限,就得显示
                        {
                            var nodeName=btn.parentNode.childNodes[node_i].nodeName;
                            if((nodeName=="DIV"||nodeName=="A")&&btn.parentNode.childNodes[node_i].style.display!="none"){
                                iAllNoPurview=false;
                            }
                        }
                        if(iAllNoPurview)
                        {
                            $.createProperty({style:{display:"none"}}, btn.parentNode);
                        }
                    }
                    //$.createProperty({ disabled: true }, btn);
                    //$.createProperty({ style: { display: "none"} }, btn);
                }
                if(!window.otherFunction&&typeof(window.otherFunction)=="function")
                {//页面上的其它函数，需要在这里执行的
                    window.otherFunction();
                }
            }
            return this;
        }
    }
    $.extend(ps_frame);
})(jQuery)
