//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：系统公用javascript框架基本架构
//
// 创建标识：林希胜     添加时间：2011-5-31 17:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------
(function ($, undefined) {
    var ps_frame = {
        testFunction: function () { alert("this is a test function."); }
    };
    var ps_frame_fn = {
        showMessage: function () {
            alert($(this).attr("id"));
        }
    };
    $.extend(window.ps_frame);
    $.extend(ps_frame);
    $.fn.extend(ps_frame_fn);
    BaseListener.apply($.fn); //继承监听类
})(jQuery)