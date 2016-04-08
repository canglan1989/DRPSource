<?php
/**
 * @fnuctional: 表 fm_receivable_pay_state 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-08-02 15:53:17
 */ 
/** 
 * fm_receivable_pay_state 表名及字段名
 */
class T_ReceivablePayState
{
    /**
	* 表名
	*/
	const Name = "fm_receivable_pay_state";
    /**
	* 所有字段
	*/
	const AllFields = "`fm_receivable_pay_state`.`fr_state_id`,`fm_receivable_pay_state`.`fr_id`,`fm_receivable_pay_state`.`fr_state`,`fm_receivable_pay_state`.`back_uid`,`fm_receivable_pay_state`.`back_user_name`,`fm_receivable_pay_state`.`back_remark`,`fm_receivable_pay_state`.`fr_money`,`fm_receivable_pay_state`.`receivable_uid`,`fm_receivable_pay_state`.`receivable_user_name`,`fm_receivable_pay_state`.`receivable_time`,`fm_receivable_pay_state`.`receivable_remark`,`fm_receivable_pay_state`.`bank_id`,`fm_receivable_pay_state`.`bank_name`,`fm_receivable_pay_state`.`received_uid`,`fm_receivable_pay_state`.`received_user_name`,`fm_receivable_pay_state`.`received_time`,`fm_receivable_pay_state`.`received_remark`,`fm_receivable_pay_state`.`income_uid`,`fm_receivable_pay_state`.`income_user_name`,`fm_receivable_pay_state`.`income_time`,`fm_receivable_pay_state`.`income_money`,`fm_receivable_pay_state`.`income_remark`,`fm_receivable_pay_state`.`check_in_account_uid`,`fm_receivable_pay_state`.`check_in_account_user_name`,`fm_receivable_pay_state`.`check_in_account_time`,`fm_receivable_pay_state`.`erp_banck_record_id`,`fm_receivable_pay_state`.`check_in_account_remark`,`fm_receivable_pay_state`.`is_del`,`fm_receivable_pay_state`.`back_time`,`fm_receivable_pay_state`.`received_date`,`fm_receivable_pay_state`.`erp_post_object`";
 }
 /**
 * fm_receivable_pay_state 数据实体
 */
class ReceivablePayStateInfo
{
    /**
    * 
    */
    public $iFrStateId = 0;
    /**
    * 款项ID
    */
    public $iFrId = 0;
    /**
    * 收支状态 -1取消充值 1:底单入款 2:到账 3:已充值
    */
    public $iFrState = 0;
    /**
    * 退回人ID
    */
    public $iBackUid = 0;
    /**
    * 
    */
    public $strBackUserName = '';
    /**
    * 退回备注
    */
    public $strBackRemark = '';
    /**
    * 相关金额
    */
    public $iFrMoney = 0;
    /**
    * 底单入款操作人ID
    */
    public $iReceivableUid = 0;
    /**
    * 底单入款操作人
    */
    public $strReceivableUserName = '';
    /**
    * 底单入款时间
    */
    public $strReceivableTime = '2000-01-01';
    /**
    * 
    */
    public $strReceivableRemark = '';
    /**
    * 收款银行ID
    */
    public $iBankId = 0;
    /**
    * 收款银行名称
    */
    public $strBankName = '';
    /**
    * 到账操作人ID
    */
    public $iReceivedUid = 0;
    /**
    * 到账操作人
    */
    public $strReceivedUserName = '';
    /**
    * 到账时间
    */
    public $strReceivedTime = '2000-01-01';
    /**
    * 
    */
    public $strReceivedRemark = '';
    /**
    * 入款(充值)操作人ID
    */
    public $iIncomeUid = 0;
    /**
    * 入款(充值)操作人
    */
    public $strIncomeUserName = '';
    /**
    * 入款(充值)时间
    */
    public $strIncomeTime = '2000-01-01';
    /**
    * 充值金额
    */
    public $iIncomeMoney = 0;
    /**
    * 充值备注
    */
    public $strIncomeRemark = '';
    /**
    * 认领操作人ID
    */
    public $iCheckInAccountUid = 0;
    /**
    * 认领操作人
    */
    public $strCheckInAccountUserName = '';
    /**
    * 认领时间
    */
    public $strCheckInAccountTime = '2000-01-01';
    /**
    * ERP银行到帐记录ID
    */
    public $strErpBanckRecordId = '';
    /**
    * 认领备注
    */
    public $strCheckInAccountRemark = '';
    /**
    * 是否删除 1是 0否
    */
    public $iIsDel = 0;
    /**
    * 退回时间
    */
    public $strBackTime = '2000-01-01';
    /**
    * 到账时间
    */
    public $strReceivedDate = '2000-01-01';
    /**
    * ERP中打款对象
    */
    public $strErpPostObject = '';
 }