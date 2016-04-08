<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_bank_account的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-31 16:51:48
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_bank_account表名及字段名
 */
class T_BankAccount
{
	/**
	* 表名
	*/
	const Name = "fm_bank_account";
	/**
	* 
	*/
	const ba_account_id = "ba_account_id";
	/**
	* 
	*/
	const ba_account_name = "ba_account_name";
	/**
	* 
	*/
	const ba_account_no = "ba_account_no";
	/**
	* 
	*/
	const ba_account_path = "ba_account_path";
	/**
	* 
	*/
	const ba_isaccount = "ba_isaccount";
	/**
	* 
	*/
	const ba_init_balance = "ba_init_balance";
	/**
	* 
	*/
	const ba_bankacc_balance = "ba_bankacc_balance";
	/**
	* 
	*/
	const p_att_corp_id = "p_att_corp_id";
	/**
	* 
	*/
	const ba_account_created_time = "ba_account_created_time";
	/**
	* 
	*/
	const ba_account_type = "ba_account_type";
	/**
	* 
	*/
	const fa_area_id = "fa_area_id";
	/**
	* 
	*/
	const fa_datastate = "fa_datastate";
	
	/**
	* 所有字段
	*/
	const AllFields = "`ba_account_id`,`ba_account_name`,`ba_account_no`,`ba_account_path`,`ba_isaccount`,`ba_init_balance`,`ba_bankacc_balance`,`p_att_corp_id`,`ba_account_created_time`,`ba_account_type`,`fa_area_id`,`fa_datastate`";
}

/**
 * fm_bank_account数据实体
 */
class BankAccountInfo
{
	/**
	*
	*/
	public $iBaAccountId = 0;
	/**
	*
	*/
	public $strBaAccountName = '';
	/**
	*
	*/
	public $strBaAccountNo = '';
	/**
	*
	*/
	public $strBaAccountPath = '';
	/**
	*
	*/
	public $iBaIsaccount = 0;
	/**
	*
	*/
	public $iBaInitBalance = 0;
	/**
	*
	*/
	public $iBaBankaccBalance = 0;
	/**
	*
	*/
	public $ipAttCorpId = 0;
	/**
	*
	*/
	public $strBaAccountCreatedTime = '';
	/**
	*
	*/
	public $iBaAccountType = 0;
	/**
	*
	*/
	public $iFaAreaId = 0;
	/**
	*
	*/
	public $iFaDatastate = 0;
}
?>
