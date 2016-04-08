//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：创建DOM元素功能
//
// 创建标识：林希胜     添加时间：2011-6-16 08:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------
(function ($, undefined) {
    var ps_frame = {
        removeAllChildNode: function (dom) {
            while (dom.firstChild) {
                dom.removeChild(dom.firstChild);
            }
        },
        createIframe: function (properties, dom) {
            var iframe = dom || document.createElement("iframe");
            $.createProperty(properties, iframe);
            return iframe;
        },
        createDiv: function (properties, dom) {
            var div = dom || document.createElement("div");
            $.createProperty(properties, div);
            return div;
        },
        createInput: function (properties, dom) {
            var input = dom || document.createElement("input");
            $.createProperty(properties, input);
            return input;
        },
        createA: function (properties, dom) {
            var a = dom || document.createElement("a");
            $.createProperty(properties, a);
            return a;
        },
        createSpan: function (properties, dom) {
            var span = dom || document.createElement("span");
            $.createProperty(properties, span);
            return span;
        },
        createSelect: function (properties, dom) {
            var select = dom || document.createElement("select");
            if (properties.options) {//select 数据
                ps_frame.removeAllChildNode(select);
                for (var option in properties.options) select.appendChild($.createOptions(properties.options[option]));
                delete properties.options; //删除option 防止createProperty因option格式不正确报错
            }
            $.createProperty(properties, select);
            return select;
        },
        createOptions: function (properties, dom) {//{ value: value_i, innerText: "第" + value_i + "页" }
            var option = dom || document.createElement("option");
            $.createProperty(properties, option);
            return option;
        },
        //添加或修改DOM属性
        createProperty: function (properties, dom) {
            for (var property in properties) {
                if (property == "disabled" && properties[property]) {
                    if (dom.nodeName == "A")
                        dom.style.color = "#ccf"; //在firefox下 disabled失效 智能设置与disabled相同的字体颜色
                    if (dom.nodeName == "INPUT") {
                        dom.style.backgroundColor = "#ccf";
                    }
                    dom.onclick = function () { return false; }
                }
                if (property == "style") {
                    for (style_property in properties.style) {
                        dom.style[style_property] = properties.style[style_property];
                    }
                }
                else {
                    if (property == "onload" && dom.attachEvent) {
                        dom.attachEvent("onload", properties[property]);
                    }
                    else
                        dom[property] = properties[property];
                }
            }
        }
    };
    $.extend(ps_frame);
})(jQuery)
