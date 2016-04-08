//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：涉及地址栏参数功能
//
// 创建标识：林希胜     添加时间：2011-6-16 09:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------
(function ($, undefined) {
    var ps_frame = {
        //返回url参数对应值 无则返回undefined
        getUrlParamValue: function (name) {
            var href = document.location.href;
            var indexOfName = href.indexOf(name + "=");
            if (indexOfName > -1) {
                var lastIndexOfValue = href.indexOf("&", indexOfName);
                lastIndexOfValue = lastIndexOfValue <= -1 ? undefined : lastIndexOfValue;
                var rtn_value = href.substring(indexOfName + (name + "=").length, lastIndexOfValue);
                return rtn_value.replace("#","");
            }
            return undefined;
        },
        //返回设置过的url值 未对document.location.href 赋值
        setUrlParam: function (name, value, href) {
            if (!name) return;
            var href = href || document.location.href;
            var indexOfName = href.indexOf(name + "=");
            if (indexOfName > -1) {//存在该参数
                var old_name_value = name + "=" + $.getUrlParamValue(name);
                var new_name_value = name + "=" + value;
                href = href.replace(old_name_value, new_name_value);
            }
            else {//不存在该参数
                if (href.indexOf("?") > -1) {//有参数
                    href += "&" + name + "=" + value;
                }
                else {//无参数
                    href += "?" + name + "=" + value;
                }
            }
            return href;
        },
        submit: function (href) {
            document.forms[0].action = document.forms[0].action;
            document.forms[0].method = "post";
            document.forms[0].submit();
        }
    };
    $.extend(ps_frame);
})(jQuery)