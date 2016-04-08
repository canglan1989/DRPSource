<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_model_group的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-10-12 13:54:40
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_model_group表名及字段名
 */
class T_ModelGroup
{
	/**
	* 表名
	*/
	const Name = "sys_model_group";
	/**
	* 
	*/
	const mgroup_id = "mgroup_id";
	/**
	* 
	*/
	const mgroup_no = "mgroup_no";
	/**
	* 
	*/
	const mgroup_name = "mgroup_name";
	/**
	* 
	*/
	const mgroup_code = "mgroup_code";
	/**
	* 
	*/
	const mgroup_remark = "mgroup_remark";
	/**
	* 
	*/
	const sort_index = "sort_index";
	/**
	* 
	*/
	const is_agent = "is_agent";
	/**
	* 
	*/
	const product_type_ids = "product_type_ids";
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
	const AllFields = "`mgroup_id`,`mgroup_no`,`mgroup_name`,`mgroup_code`,`mgroup_remark`,`sort_index`,`is_agent`,`product_type_ids`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`";
}

/**
 * sys_model_group数据实体
 */
class ModelGroupInfo
{
	/**
	*
	*/
	public $iMgroupId = 0;
	/**
	*
	*/
	public $strMgroupNo = '';
	/**
	*
	*/
	public $strMgroupName = '';
	/**
	*
	*/
	public $strMgroupCode = '';
	/**
	*
	*/
	public $strMgroupRemark = '';
	/**
	*
	*/
	public $iSortIndex = 0;
	/**
	*
	*/
	public $iIsAgent = 0;
	/**
	*
	*/
	public $strProductTypeIds = '';
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
