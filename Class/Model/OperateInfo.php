<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表log_operate的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-4 15:37:16
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * log_operate表名及字段名
 */
class T_Operate
{
	/**
	* 表名
	*/
	const Name = "log_operate";
	/**
	* 
	*/
	const log_id = "log_id";
	/**
	* 
	*/
	const log_ip = "log_ip";
	/**
	* 
	*/
	const log_type = "log_type";
	/**
	* 
	*/
	const log_page = "log_page";
	/**
	* 
	*/
	const log_name = "log_name";
	/**
	* 
	*/
	const log_level = "log_level";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_time = "create_time";
	
	/**
	* 所有字段
	*/
	const AllFields = "`log_id`,`log_ip`,`log_type`,`log_page`,`log_name`,`log_level`,`create_uid`,`create_time`";
}

/**
 * log_operate数据实体
 */
class OperateInfo
{
	/**
	*
	*/
	public $iLogId = 0;
	/**
	*
	*/
	public $strLogIp = '';
	/**
	*
	*/
	public $iLogType = 0;
	/**
	*
	*/
	public $strLogPage = '';
	/**
	*
	*/
	public $strLogName = '';
	/**
	*
	*/
	public $iLogLevel = 0;
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateTime = '';
}
?>
