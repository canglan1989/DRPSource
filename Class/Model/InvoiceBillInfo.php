<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_invoice_bill的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-11-3 15:51:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_invoice_bill表名及字段名
 */
class T_InvoiceBill
{
	/**
	* 表名
	*/
	const Name = "fm_invoice_bill";
	/**
	* 
	*/
	const invoice_bill_id = "invoice_bill_id";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const invoice_no = "invoice_no";
	/**
	* 
	*/
	const invoice_title = "invoice_title";
	/**
	* 
	*/
	const financial_platform = "financial_platform";
	/**
	* 
	*/
	const invoice_money = "invoice_money";
	/**
	* 
	*/
	const invoice_state = "invoice_state";
	/**
	* 
	*/
	const open_uid = "open_uid";
	/**
	* 
	*/
	const open_user_name = "open_user_name";
	/**
	* 
	*/
	const open_time = "open_time";
	/**
	* 
	*/
	const open_remark = "open_remark";
	/**
	* 
	*/
	const receipt_state = "receipt_state";
	/**
	* 
	*/
	const receipt_uid = "receipt_uid";
	/**
	* 
	*/
	const receipt_user_name = "receipt_user_name";
	/**
	* 
	*/
	const receipt_time = "receipt_time";
	
	/**
	* 所有字段
	*/
	const AllFields = "`invoice_bill_id`,`agent_id`,`invoice_no`,`invoice_title`,`financial_platform`,`invoice_money`,`invoice_state`,`open_uid`,`open_user_name`,`open_time`,`open_remark`,`receipt_state`,`receipt_uid`,`receipt_user_name`,`receipt_time`";
}

/**
 * fm_invoice_bill数据实体
 */
class InvoiceBillInfo
{
	/**
	*
	*/
	public $iInvoiceBillId = 0;
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $strInvoiceNo = '';
	/**
	*
	*/
	public $strInvoiceTitle = '';
	/**
	*
	*/
	public $iFinancialPlatform = 0;
	/**
	*
	*/
	public $iInvoiceMoney = 0;
	/**
	*
	*/
	public $iInvoiceState = 0;
	/**
	*
	*/
	public $iOpenUid = 0;
	/**
	*
	*/
	public $strOpenUserName = '';
	/**
	*
	*/
	public $strOpenTime = '';
	/**
	*
	*/
	public $strOpenRemark = '';
	/**
	*
	*/
	public $iReceiptState = 0;
	/**
	*
	*/
	public $iReceiptUid = 0;
	/**
	*
	*/
	public $strReceiptUserName = '';
	/**
	*
	*/
	public $strReceiptTime = '';
}

