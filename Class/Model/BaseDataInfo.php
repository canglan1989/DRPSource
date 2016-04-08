<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_base_data的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-9 20:58:42
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_base_data表名及字段名
 */
class T_BaseData
{
	/**
	* 表名
	*/
	const Name = "sys_base_data";
	/**
	* 
	*/
	const d_id = "d_id";
	/**
	* 
	*/
	const d_value = "d_value";
	/**
	* 
	*/
	const d_no = "d_no";
	/**
	* 
	*/
	const d_name = "d_name";
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
	const d_remark = "d_remark";
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
	const AllFields = "`d_id`,`d_value`,`d_no`,`d_name`,`data_type`,`sort_index`,`is_lock`,`is_system`,`is_def`,`is_del`,`d_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`";
}

/**
 * sys_base_data数据实体
 */
class BaseDataInfo
{
	/**
	*
	*/
	public $idId = 0;
	/**
	*
	*/
	public $strdValue = '';
	/**
	*
	*/
	public $strdNo = '';
	/**
	*
	*/
	public $strdName = '';
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
	public $strdRemark = '';
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

/**
 * 基础数据表的数据类型
*/
class BaseDataTypes
{
    /**
     * 支付类型
     */
    const payType = "paytype";
}
?>
