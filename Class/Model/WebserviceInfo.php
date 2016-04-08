<?php
/**
 * @fnuctional: 表 log_webservice 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-03-26 10:45:21
 */ 
/** 
 * log_webservice 表名及字段名
 */
class T_Webservice
{
    /**
	* 表名
	*/
	const Name = "log_webservice";
    /**
	* 所有字段
	*/
	const AllFields = "log_webservice_id,class_name,function_name,params,log_ip,create_uid,create_time";
 }
 /**
 * log_webservice 数据实体
 */
class WebserviceInfo
{
    /**
    * 
    */
    public $iLogWebserviceId = 0;
    /**
    * 
    */
    public $strClassName = '';
    /**
    * 
    */
    public $strFunctionName = '';
    /**
    * 
    */
    public $strParams = '';
    /**
    * 操作ip
    */
    public $strLogIp = '';
    /**
    * 操作人
    */
    public $iCreateUid = 0;
    /**
    * 操作时间
    */
    public $strCreateTime = '2000-01-01';
 }