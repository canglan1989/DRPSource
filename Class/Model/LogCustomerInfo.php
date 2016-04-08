<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_log_customer的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * cm_log_customer表名及字段名 
 */
class T_LogCustomer
{
	/**
     * 表名 
     */
	const Name = "cm_log_customer";
	/**
     * 
     */
	const log_customer_id = "log_customer_id";
	/**
     * 
     */
	const customer_id = "customer_id";
	/**
     * 
     */
	const change_values = "change_values";
	/**
     * 
     */
	const create_time = "create_time";
	/**
     * 
     */
	const create_uid = "create_uid";
		
	/**
     * 所有字段 
     */
	const AllFields = "`log_customer_id`,`customer_id`,`change_values`,`create_time`,`create_uid`";
}

/**
 * cm_log_customer数据实体
 */
class LogCustomerInfo
{
	/**
     * 
     */
	public $iLogCustomerId = 0;
	/**
     * 
     */
	public $iCustomerId = 0;
	/**
     * 
     */
	public $strChangeValues = '';
	/**
     * 
     */
	public $iCreateTime = 0;
	/**
     * 
     */
	public $iCreateUid = 0;

}

