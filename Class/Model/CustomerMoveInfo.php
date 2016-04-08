<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer_move的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * cm_customer_move表名及字段名 
 */
class T_CustomerMove
{
	/**
     * 表名 
     */
	const Name = "cm_customer_move";
	/**
     * 
     */
	const customer_move_id = "customer_move_id";
	/**
     * 
     */
	const customer_id = "customer_id";
	/**
     * 
     */
	const from_anget_id = "from_anget_id";
	/**
     * 
     */
	const to_anget_id = "to_anget_id";
	/**
     * 
     */
	const create_uid = "create_uid";
	/**
     * 
     */
	const create_time = "create_time";
        
        const product_name = "product_name";
		
	/**
     * 所有字段 
     */
	const AllFields = "`customer_move_id`,`customer_id`,`from_anget_id`,`to_anget_id`,`create_uid`,`create_time`,`product_name`";
}

/**
 * cm_customer_move数据实体
 */
class CustomerMoveInfo
{
	/**
     * 
     */
	public $iCustomerMoveId = 0;
	/**
     * 
     */
	public $iCustomerId = 0;
	/**
     * 
     */
	public $iFromAngetId = 0;
	/**
     * 
     */
	public $iToAngetId = 0;
	/**
     * 
     */
	public $iCreateUid = 0;
	/**
     * 
     */
	public $iCreateTime = 0;
        
        public $strProductName = '';

}

