<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表log_login的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-4 15:37:16
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * log_login表名及字段名
 */
class T_Login
{
	/**
	* 表名
	*/
	const Name = "log_login";
	/**
	* 
	*/
	const login_id = "login_id";
	/**
	* 
	*/
	const user_name = "user_name";
	/**
	* 
	*/
	const login_ip = "login_ip";
	/**
	* 
	*/
	const login_time = "login_time";
	/**
	* 
	*/
	const login_page = "login_page";
	/**
	* 
	*/
	const is_success = "is_success";
	/**
	* 
	*/
	const err_msg = "err_msg";
	
	/**
	* 所有字段
	*/
	const AllFields = "`login_id`,`user_name`,`login_ip`,`login_time`,`login_page`,`is_success`,`err_msg`";
}

/**
 * log_login数据实体
 */
class LoginInfo
{
	/**
	*
	*/
	public $iLoginId = 0;
	/**
	*
	*/
	public $strUserName = '';
	/**
	*
	*/
	public $strLoginIp = '';
	/**
	*
	*/
	public $strLoginTime = '';
	/**
	*
	*/
	public $strLoginPage = '';
	/**
	*
	*/
	public $iIsSuccess = 0;
	/**
	*
	*/
	public $strErrMsg = '';
}
?>
