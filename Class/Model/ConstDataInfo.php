<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_const_data的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-12 9:47:42
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_const_data表名及字段名
 */
class T_ConstData
{
	/**
	* 表名
	*/
	const Name = "sys_const_data";
	/**
	* 
	*/
	const c_id = "c_id";
	/**
	* 
	*/
	const c_value = "c_value";
	/**
	* 
	*/
	const c_no = "c_no";
	/**
	* 
	*/
	const c_name = "c_name";
	/**
	* 
	*/
	const data_type = "data_type";
	/**
	* 
	*/
	const sort_index = "sort_index";
	/**
	* 
	*/
	const is_lock = "is_lock";
	/**
	* 
	*/
	const is_system = "is_system";
	/**
	* 
	*/
	const is_def = "is_def";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const c_remark = "c_remark";
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
	const AllFields = "`c_id`,`c_value`,`c_no`,`c_name`,`data_type`,`sort_index`,`is_lock`,`is_system`,`is_def`,`is_del`,`c_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`";
}

/**
 * sys_const_data数据实体
 */
class ConstDataInfo
{
	/**
	*
	*/
	public $icId = 0;
	/**
	*
	*/
	public $strcValue = '';
	/**
	*
	*/
	public $strcNo = '';
	/**
	*
	*/
	public $strcName = '';
	/**
	*
	*/
	public $strDataType = '';
	/**
	*
	*/
	public $iSortIndex = 0;
	/**
	*
	*/
	public $iIsLock = 0;
	/**
	*
	*/
	public $iIsSystem = 0;
	/**
	*
	*/
	public $iIsDef = 0;
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $strcRemark = '';
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
