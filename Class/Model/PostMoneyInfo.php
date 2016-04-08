<?php
/**
 * @fnuctional: 表 fm_post_money 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-06-25 11:12:20
 */ 
/** 
 * fm_post_money 表名及字段名
 */
class T_PostMoney
{
    /**
	* 表名
	*/
	const Name = "fm_post_money";
    /**
	* 所有字段
	*/
	const AllFields = "`fm_post_money`.`post_money_id`,`fm_post_money`.`post_money_no`,`fm_post_money`.`post_entry_type`,`fm_post_money`.`agent_id`,`fm_post_money`.`agent_no`,`fm_post_money`.`agent_name`,`fm_post_money`.`agent_pact_ids`,`fm_post_money`.`agent_pact_nos`,`fm_post_money`.`product_type_ids`,`fm_post_money`.`product_type_names`,`fm_post_money`.`post_date`,`fm_post_money`.`payment_id`,`fm_post_money`.`payment_name`,`fm_post_money`.`bank_id`,`fm_post_money`.`bank_name`,`fm_post_money`.`agent_bank_id`,`fm_post_money`.`rp_files`,`fm_post_money`.`post_remark`,`fm_post_money`.`agent_bank_name`,`fm_post_money`.`post_money_amount`,`fm_post_money`.`in_account_money`,`fm_post_money`.`post_money_state`,`fm_post_money`.`rp_num`,`fm_post_money`.`account_group_id`,`fm_post_money`.`create_uid`,`fm_post_money`.`create_user_name`,`fm_post_money`.`create_time`,`fm_post_money`.`update_uid`,`fm_post_money`.`update_user_name`,`fm_post_money`.`update_time`,`fm_post_money`.`is_del`";
 }
 /**
 * fm_post_money 数据实体
 */
class PostMoneyInfo
{
    /**
    * 
    */
    public $iPostMoneyId = 0;
    /**
    * 单据号
    */
    public $strPostMoneyNo = '';
    /**
    * 保证金提交入口 0为前台提交，1为后台提交
    */
    public $iPostEntryType = 0;
    /**
    * 
    */
    public $iAgentId = 0;
    /**
    * 代理商编号
    */
    public $strAgentNo = '';
    /**
    * 
    */
    public $strAgentName = '';
    /**
    * 合同ID
    */
    public $strAgentPactIds = '';
    /**
    * 
    */
    public $strAgentPactNos = '';
    /**
    * 产品ID (产品类别ID)
    */
    public $strProductTypeIds = '';
    /**
    * 
    */
    public $strProductTypeNames = '';
    /**
    * 对方收支日期
    */
    public $strPostDate = '2000-01-01';
    /**
    * 支付方式
    */
    public $iPaymentId = 0;
    /**
    * 
    */
    public $strPaymentName = '';
    /**
    * 盘石银行ID
    */
    public $iBankId = 0;
    /**
    * 盘石银行名称
    */
    public $strBankName = '';
    /**
    * 代理商银行ID
    */
    public $iAgentBankId = 0;
    /**
    * 支付票据附件
    */
    public $strRpFiles = '';
    /**
    * 备注
    */
    public $strPostRemark = '';
    /**
    * 代理商银行名称
    */
    public $strAgentBankName = '';
    /**
    * 打款总金额
    */
    public $iPostMoneyAmount = 0;
    /**
    * 入款金额
    */
    public $iInAccountMoney = 0;
    /**
    * 收支状态  -1:退回  0:未生效  1:待收 2:已收 3:红冲
    */
    public $iPostMoneyState = 0;
    /**
    * 支付凭证号
    */
    public $strRpNum = '';
    /**
    * 区域经理所属账号组ID
    */
    public $iAccountGroupId = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建人姓名
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 
    */
    public $strUpdateUserName = '';
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 删除标识1已删除
    */
    public $iIsDel = 0;
 }