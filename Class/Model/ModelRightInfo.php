<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_model_right的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-12 8:48:36
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_model_right表名及字段名
 */
class T_ModelRight
{
	/**
	* 表名
	*/
	const Name = "sys_model_right";
	/**
	* 
	*/
	const right_id = "right_id";
	/**
	* 
	*/
	const model_id = "model_id";
	/**
	* 
	*/
	const right_name = "right_name";
	/**
	* 
	*/
	const right_value = "right_value";
	/**
	* 
	*/
	const right_remark = "right_remark";
	/**
	* 
	*/
	const is_lock = "is_lock";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_time = "create_time";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const update_time = "update_time";
	
	/**
	* 所有字段
	*/
	const AllFields = "`right_id`,`model_id`,`right_name`,`right_value`,`right_remark`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`";
}

/**
 * sys_model_right数据实体
 */
class ModelRightInfo
{
	/**
	*
	*/
	public $iRightId = 0;
	/**
	*
	*/
	public $iModelId = 0;
	/**
	*
	*/
	public $strRightName = '';
	/**
	*
	*/
	public $iRightValue = 0;
	/**
	*
	*/
	public $strRightRemark = '';
	/**
	*
	*/
	public $iIsLock = 0;
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateTime = '';
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $strUpdateTime = '';
}
?>
