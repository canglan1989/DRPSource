//--------------------文件说明--------------------------------------
// Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。 
//
// 文件功能描述：添加事件监听器基础类
//
// 创建标识：林希胜     添加时间：2011-6-1 09:22
//
// 修改标识：     修改时间：
// 修改描述：
//
//--------------------文件说明结束----------------------------------
function BaseListener() {
    this.listener = {
        "eventName": {}
    }
    //funName--如对象函数体相同可特意区别的如用对象id（重载addEventListener专门针对函数体相同的情况区分）
    this.addEventListener2 = function (eventName, fun, param, funName) {//事件名称,监听器函数
        if (!this.listener[eventName]) {
            this.listener[eventName] = {};
        }
        var funKey = fun;
        if (funName != undefined) {
            funKey = funName;
        }
        if (!this.listener[eventName][funKey]) {
            this.listener[eventName][funKey] = {};
        }
        this.listener[eventName][funKey].fun = fun;
        this.listener[eventName][funKey].param = Array.prototype.slice.call(arguments, 2);
    }
    //增加监听器
    //eventName--添加到的事件名称,fun--函数体,param--参数
    this.addEventListener = function (eventName, fun, param) {//事件名称,监听器函数
        if (!this.listener[eventName]) {
            this.listener[eventName] = {};
        }
        if (!this.listener[eventName][fun]) {
            this.listener[eventName][fun] = {};
        }
        this.listener[eventName][fun].fun = fun;
        this.listener[eventName][fun].param = Array.prototype.slice.call(arguments, 2);
    }
    this.removeEventListener2 = function (eventName, fun, funName) {
        var funKey = fun;
        if (funName != undefined) {
            funKey = funName;
        }
        if (this.listener[eventName]) {
            delete this.listener[eventName][fun];
        }
    }
    this.removeEventListener = function (eventName, fun) {
        if (this.listener[eventName]) {
            delete this.listener[eventName][fun];
        }
    }
    //在类函数中添加该函数
    //param--执行事件传入的参数 在所有参数最后面
    this.execEventListener = function (eventName, param) {
        var paramFromExec = Array.prototype.slice.call(arguments, 1);
        for (var fun_i in this.listener[eventName]) {
            var funObj = this.listener[eventName][fun_i];
            if (funObj.fun && typeof (funObj.fun) == "function") {
                var _param = funObj.param === undefined ? new Array() : funObj.param;
                if (paramFromExec) {
                    _param = _param.concat(paramFromExec);
                }
                funObj.fun.apply(null, _param);
            }
        }
    }
}