<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_post_right的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 19:23:44
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_post_right表名及字段名
 */
class T_PostRight
{
	/**
	* 表名
	*/
	const Name = "sys_post_right";
	/**
	* 
	*/
	const aid = "aid";
	/**
	* 
	*/
	const post_id = "post_id";
	/**
	* 
	*/
	const right_id = "right_id";
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
	const AllFields = "`aid`,`post_id`,`right_id`,`create_uid`,`create_time`";
}

/**
 * sys_post_right数据实体
 */
class PostRightInfo
{
	/**
	*
	*/
	public $iAid = 0;
	/**
	*
	*/
	public $iPostId = 0;
	/**
	*
	*/
	public $iRightId = 0;
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
