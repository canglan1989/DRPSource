<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_receivable_pay的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-28 11:18:00
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_receivable_pay表名及字段名
 */
class T_ReceivablePay
{
	/**
	* 表名
	*/
	const Name = "fm_receivable_pay";
	/**
	* 
	*/
	const fr_id = "fr_id";
	/**
	* 
	*/
	const fr_no = "fr_no";
	/**
	* 
	*/
	const fr_type = "fr_type";
	/**
	* 
	*/
	const fr_entry_type = "fr_entry_type";
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
	const c_contract_area = "c_contract_area";
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
	const fr_object_id = "fr_object_id";
	/**
	* 
	*/
	const fr_object_name = "fr_object_name";
	/**
	* 
	*/
	const fr_payment_id = "fr_payment_id";
	/**
	* 
	*/
	const fr_payment_name = "fr_payment_name";
	/**
	* 
	*/
	const fr_bank_id = "fr_bank_id";
	/**
	* 
	*/
	const fr_bank_name = "fr_bank_name";
	/**
	* 
	*/
	const fr_rev_money = "fr_rev_money";
	/**
	* 
	*/
	const fr_pay_money = "fr_pay_money";
	/**
	* 
	*/
	const fr_money = "fr_money";
	/**
	* 
	*/
	const fr_rp_userid = "fr_rp_userid";
	/**
	* 
	*/
	const fr_rp_username = "fr_rp_username";
	/**
	* 
	*/
	const fr_rp_num = "fr_rp_num";
	/**
	* 
	*/
	const fr_rp_files = "fr_rp_files";
	/**
	* 
	*/
	const fr_peer_bank_id = "fr_peer_bank_id";
	/**
	* 
	*/
	const fr_peer_bank_name = "fr_peer_bank_name";
	/**
	* 
	*/
	const fr_peer_date = "fr_peer_date";
	/**
	* 
	*/
	const f_invoice_money = "f_invoice_money";
	/**
	* 
	*/
	const f_invoice_date = "f_invoice_date";
	/**
	* 
	*/
	const f_invoice_area = "f_invoice_area";
	/**
	* 
	*/
	const f_invoice_sourceid = "f_invoice_sourceid";
	/**
	* 
	*/
	const fr_state = "fr_state";
	/**
	* 
	*/
	const fr_corp_id = "fr_corp_id";
	/**
	* 
	*/
	const fr_source_id = "fr_source_id";
	/**
	* 
	*/
	const fr_typeid = "fr_typeid";
	/**
	* 
	*/
	const fr_rp_area = "fr_rp_area";
	/**
	* 
	*/
	const fr_from_platform = "fr_from_platform";
	/**
	* 
	*/
	const fr_remark = "fr_remark";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_user_name = "create_user_name";
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
	const update_user_name = "update_user_name";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const account_group_id = "account_group_id";
	
	/**
	* 所有字段
	*/
	const AllFields = "`fr_id`,`fr_no`,`fr_type`,`fr_entry_type`,`c_contract_id`,`c_contract_no`,`c_contract_type`,`c_contract_area`,`c_product_id`,`c_product_name`,`fr_object_id`,`fr_object_name`,`fr_payment_id`,`fr_payment_name`,`fr_bank_id`,`fr_bank_name`,`fr_rev_money`,`fr_pay_money`,`fr_money`,`fr_rp_userid`,`fr_rp_username`,`fr_rp_num`,`fr_rp_files`,`fr_peer_bank_id`,`fr_peer_bank_name`,`fr_peer_date`,`f_invoice_money`,`f_invoice_date`,`f_invoice_area`,`f_invoice_sourceid`,`fr_state`,`fr_corp_id`,`fr_source_id`,`fr_typeid`,`fr_rp_area`,`fr_from_platform`,`fr_remark`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`is_del`,`account_group_id`";
}

/**
 * fm_receivable_pay数据实体
 */
class ReceivablePayInfo
{
	/**
	*
	*/
	public $iFrId = 0;
	/**
	*
	*/
	public $strFrNo = '';
	/**
	*
	*/
	public $iFrType = 0;
	/**
	*
	*/
	public $iFrEntryType = 0;
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
	public $icContractArea = 0;
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
	public $iFrObjectId = 0;
	/**
	*
	*/
	public $strFrObjectName = '';
	/**
	*
	*/
	public $iFrPaymentId = 0;
	/**
	*
	*/
	public $strFrPaymentName = '';
	/**
	*
	*/
	public $iFrBankId = 0;
	/**
	*
	*/
	public $strFrBankName = '';
	/**
	*
	*/
	public $iFrRevMoney = 0;
	/**
	*
	*/
	public $iFrPayMoney = 0;
	/**
	*
	*/
	public $iFrMoney = 0;
	/**
	*
	*/
	public $iFrRpUserid = 0;
	/**
	*
	*/
	public $strFrRpUsername = '';
	/**
	*
	*/
	public $strFrRpNum = '';
	/**
	*
	*/
	public $strFrRpFiles = '';
	/**
	*
	*/
	public $iFrPeerBankId = 0;
	/**
	*
	*/
	public $strFrPeerBankName = '';
	/**
	*
	*/
	public $strFrPeerDate = '';
	/**
	*
	*/
	public $ifInvoiceMoney = 0;
	/**
	*
	*/
	public $strfInvoiceDate = '';
	/**
	*
	*/
	public $ifInvoiceArea = 0;
	/**
	*
	*/
	public $ifInvoiceSourceid = 0;
	/**
	*
	*/
	public $iFrState = 0;
	/**
	*
	*/
	public $iFrCorpId = 0;
	/**
	*
	*/
	public $iFrSourceId = 0;
	/**
	*
	*/
	public $iFrTypeid = 0;
	/**
	*
	*/
	public $iFrRpArea = 0;
	/**
	*
	*/
	public $iFrFromPlatform = 0;
	/**
	*
	*/
	public $strFrRemark = '';
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateUserName = '';
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
	public $strUpdateUserName = '';
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $iAccountGroupId = 0;
}
?>
