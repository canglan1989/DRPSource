<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表om_audit_allolt的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-22 20:50:39
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * om_audit_allolt表名及字段名
 */
class T_AuditAllolt
{
	/**
	* 表名
	*/
	const Name = "om_audit_allolt";
	/**
	* 
	*/
	const audit_allolt_id = "audit_allolt_id";
	/**
	* 
	*/
	const order_id = "order_id";
	/**
	* 
	*/
	const audit_uid = "audit_uid";
	/**
	* 
	*/
	const allolt_remark = "allolt_remark";
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
	const is_del = "is_del";
	
	/**
	* 所有字段
	*/
	const AllFields = "`audit_allolt_id`,`order_id`,`audit_uid`,`allolt_remark`,`create_uid`,`create_time`,`is_del`";
}

/**
 * om_audit_allolt数据实体
 */
class AuditAlloltInfo
{
	/**
	*
	*/
	public $iAuditAlloltId = 0;
	/**
	*
	*/
	public $iOrderId = 0;
	/**
	*
	*/
	public $iAuditUid = 0;
	/**
	*
	*/
	public $strAlloltRemark = '';
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
	public $iIsDel = 0;
}
?>
