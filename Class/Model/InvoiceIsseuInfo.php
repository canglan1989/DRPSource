<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_invoice_isseu的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-10-28 14:09:49
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_invoice_isseu表名及字段名
 */
class T_InvoiceIsseu
{
	/**
	* 表名
	*/
	const Name = "fm_invoice_isseu";
	/**
	* 
	*/
	const fii_id = "fii_id";
	/**
	* 
	*/
	const fii_no = "fii_no";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const c_contract_id = "c_contract_id";
	/**
	* 
	*/
	const c_contract_no = "c_contract_no";
	/**
	* 
	*/
	const c_contract_type = "c_contract_type";
	/**
	* 
	*/
	const c_product_id = "c_product_id";
	/**
	* 
	*/
	const c_product_name = "c_product_name";
	/**
	* 
	*/
	const f_type = "f_type";
	/**
	* 
	*/
	const fii_type = "fii_type";
	/**
	* 
	*/
	const f_invoice_type = "f_invoice_type";
	/**
	* 
	*/
	const f_invoice_title = "f_invoice_title";
	/**
	* 
	*/
	const f_invoice_apply_money = "f_invoice_apply_money";
	/**
	* 
	*/
	const f_r_money = "f_r_money";
	/**
	* 
	*/
	const f_r_money_area = "f_r_money_area";
	/**
	* 
	*/
	const f_money_istoaccount = "f_money_istoaccount";
	/**
	* 
	*/
	const f_money_date = "f_money_date";
	/**
	* 
	*/
	const f_money_sourceid = "f_money_sourceid";
	/**
	* 
	*/
	const f_receive_type = "f_receive_type";
	/**
	* 
	*/
	const f_invoice_state = "f_invoice_state";
	/**
	* 
	*/
	const f_invoice_money = "f_invoice_money";
	/**
	* 
	*/
	const f_open_userid = "f_open_userid";
	/**
	* 
	*/
	const f_opentime = "f_opentime";
	/**
	* 
	*/
	const f_issend = "f_issend";
	/**
	* 
	*/
	const f_senddate = "f_senddate";
	/**
	* 
	*/
	const f_isreceipt = "f_isreceipt";
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
	const f_receiptdate = "f_receiptdate";
	/**
	* 
	*/
	const f_source_id = "f_source_id";
	/**
	* 
	*/
	const f_invoice_area = "f_invoice_area";
	/**
	* 
	*/
	const fr_from_platform = "fr_from_platform";
	/**
	* 
	*/
	const f_remark = "f_remark";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const update_username = "update_username";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_username = "create_username";
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
	const AllFields = "`fii_id`,`fii_no`,`agent_id`,`c_contract_id`,`c_contract_no`,`c_contract_type`,`c_product_id`,`c_product_name`,`f_type`,`fii_type`,`f_invoice_type`,`f_invoice_title`,`f_invoice_apply_money`,`f_r_money`,`f_r_money_area`,`f_money_istoaccount`,`f_money_date`,`f_money_sourceid`,`f_receive_type`,`f_invoice_state`,`f_invoice_money`,`f_open_userid`,`f_opentime`,`f_issend`,`f_senddate`,`f_isreceipt`,`receipt_uid`,`receipt_user_name`,`f_receiptdate`,`f_source_id`,`f_invoice_area`,`fr_from_platform`,`f_remark`,`update_uid`,`update_username`,`update_time`,`create_uid`,`create_username`,`create_time`,`is_del`";
}

/**
 * fm_invoice_isseu数据实体
 */
class InvoiceIsseuInfo
{
	/**
	*
	*/
	public $iFiiId = 0;
	/**
	*
	*/
	public $strFiiNo = '';
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $icContractId = 0;
	/**
	*
	*/
	public $strcContractNo = '';
	/**
	*
	*/
	public $icContractType = 0;
	/**
	*
	*/
	public $icProductId = 0;
	/**
	*
	*/
	public $strcProductName = '';
	/**
	*
	*/
	public $ifType = 0;
	/**
	*
	*/
	public $iFiiType = 0;
	/**
	*
	*/
	public $ifInvoiceType = 0;
	/**
	*
	*/
	public $strfInvoiceTitle = '';
	/**
	*
	*/
	public $ifInvoiceApplyMoney = 0;
	/**
	*
	*/
	public $ifrMoney = 0;
	/**
	*
	*/
	public $ifrMoneyArea = 0;
	/**
	*
	*/
	public $ifMoneyIstoaccount = 0;
	/**
	*
	*/
	public $strfMoneyDate = '';
	/**
	*
	*/
	public $ifMoneySourceid = 0;
	/**
	*
	*/
	public $ifReceiveType = 0;
	/**
	*
	*/
	public $ifInvoiceState = 0;
	/**
	*
	*/
	public $ifInvoiceMoney = 0;
	/**
	*
	*/
	public $ifOpenUserid = 0;
	/**
	*
	*/
	public $strfOpentime = '';
	/**
	*
	*/
	public $ifIssend = 0;
	/**
	*
	*/
	public $strfSenddate = '';
	/**
	*
	*/
	public $ifIsreceipt = 0;
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
	public $strfReceiptdate = '';
	/**
	*
	*/
	public $ifSourceId = 0;
	/**
	*
	*/
	public $ifInvoiceArea = 0;
	/**
	*
	*/
	public $iFrFromPlatform = 0;
	/**
	*
	*/
	public $strfRemark = '';
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $strUpdateUsername = '';
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateUsername = '';
	/**
	*
	*/
	public $strCreateTime = '';
	/**
	*
	*/
	public $iIsDel = 0;
}

