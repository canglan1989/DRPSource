<?php
/**
 * @fnuctional: 表 am_agent_pact 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-08-09 10:22:46
 */ 
/** 
 * am_agent_pact 表名及字段名
 */
class T_AgentPact
{
    /**
	* 表名
	*/
	const Name = "am_agent_pact";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_pact`.`aid`,`am_agent_pact`.`agent_id`,`am_agent_pact`.`cur_agent_name`,`am_agent_pact`.`product_id`,`am_agent_pact`.`reg_area_id`,`am_agent_pact`.`charge_area_id`,`am_agent_pact`.`agent_mode`,`am_agent_pact`.`agent_level`,`am_agent_pact`.`pre_deposit`,`am_agent_pact`.`cash_deposit`,`am_agent_pact`.`pact_sdate`,`am_agent_pact`.`pact_edate`,`am_agent_pact`.`area`,`am_agent_pact`.`company_name`,`am_agent_pact`.`area_id`,`am_agent_pact`.`address`,`am_agent_pact`.`postcode`,`am_agent_pact`.`legal_person`,`am_agent_pact`.`legal_person_ID`,`am_agent_pact`.`revenue_no`,`am_agent_pact`.`permit_reg_no`,`am_agent_pact`.`reg_capital`,`am_agent_pact`.`charge_person`,`am_agent_pact`.`charge_phone`,`am_agent_pact`.`charge_tel`,`am_agent_pact`.`pact_remark`,`am_agent_pact`.`pact_type`,`am_agent_pact`.`pact_status`,`am_agent_pact`.`bigregion_check`,`am_agent_pact`.`channel_check`,`am_agent_pact`.`contract_check`,`am_agent_pact`.`pact_number`,`am_agent_pact`.`pact_stage`,`am_agent_pact`.`create_uid`,`am_agent_pact`.`update_uid`,`am_agent_pact`.`create_time`,`am_agent_pact`.`update_time`,`am_agent_pact`.`renewal_check`,`am_agent_pact`.`remove_sign_uid`,`am_agent_pact`.`remove_sign_user_name`,`am_agent_pact`.`remove_sign_time`,`am_agent_pact`.`remove_sign_remark`,`am_agent_pact`.`pre_deposit_received`,`am_agent_pact`.`cash_deposit_received`,`am_agent_pact`.`received_date`";
 }
 /**
 * am_agent_pact 数据实体
 */
class AgentPactInfo
{
    /**
    * 自增ID
    */
    public $iAid = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 当前代理商名称
    */
    public $strCurAgentName = '';
    /**
    * 签约产品ID(产品类别ID)
    */
    public $strProductId = '';
    /**
    * 代理商注册区域
    */
    public $iRegAreaId = 0;
    /**
    * 渠道经理所属战区ID
    */
    public $iChargeAreaId = 0;
    /**
    * 合作模式：0渠道代理，1渠道商务
    */
    public $iAgentMode = 0;
    /**
    * 代理商等级:0无等级，1为金牌，2为银牌
    */
    public $strAgentLevel = '';
    /**
    * 预存款
    */
    public $iPreDeposit = 0;
    /**
    * 保证金
    */
    public $iCashDeposit = 0;
    /**
    * 合同开始时间
    */
    public $strPactSdate = '2000-01-01';
    /**
    * 合同终止日期
    */
    public $strPactEdate = '2000-01-01';
    /**
    * 代理区域
    */
    public $strArea = '';
    /**
    * 代理商名称
    */
    public $strCompanyName = '';
    /**
    * 代理商联系地区
    */
    public $iAreaId = 0;
    /**
    * 详细地址
    */
    public $strAddress = '';
    /**
    * 单位地址
    */
    public $strPostcode = '';
    /**
    * 法人姓名
    */
    public $strLegalPerson = '';
    /**
    * 法人身份证号
    */
    public $strLegalPersonId = '';
    /**
    * 企业税号
    */
    public $strRevenueNo = '';
    /**
    * 营业证注册号
    */
    public $strPermitRegNo = '';
    /**
    * 注册资金
    */
    public $strRegCapital = '';
    /**
    * 代理商负责人姓名
    */
    public $strChargePerson = '';
    /**
    * 负责人手机号码
    */
    public $strChargePhone = '';
    /**
    * 负责人固定电话
    */
    public $strChargeTel = '';
    /**
    * 考察小记
    */
    public $strPactRemark = '';
    /**
    * 签约类型:0未签约,1新签,2续签,3解除签约,4失效
    */
    public $iPactType = 0;
    /**
    * 签约状态:0未提交，1流程中，2已签约，3已解除签约，4已失效，5保存，6审核退回，7合同未开始生效
    */
    public $iPactStatus = 0;
    /**
    * 渠道大区审核:0未审核，1已审核，2审核退回
    */
    public $iBigregionCheck = 0;
    /**
    * 渠道副总审核:0未审核，1已审核，2审核退回
    */
    public $iChannelCheck = 0;
    /**
    * 合同部审核状态：0未审核，1已审核，2审核退回
    */
    public $iContractCheck = 0;
    /**
    * 合同基本号
    */
    public $strPactNumber = '';
    /**
    * 签约阶段,如Q-1,Q-2等
    */
    public $strPactStage = '';
    /**
    * 创建人ID
    */
    public $iCreateUid = 0;
    /**
    * 编辑人ID
    */
    public $iUpdateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 编辑时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 合同续签判断:0未进行续签,1已进行续签
    */
    public $iRenewalCheck = 0;
    /**
    * 解除签约操作人
    */
    public $iRemoveSignUid = 0;
    /**
    * 
    */
    public $strRemoveSignUserName = '';
    /**
    * 
    */
    public $strRemoveSignTime = '2000-01-01';
    /**
    * 解除签约备注
    */
    public $strRemoveSignRemark = '';
    /**
    * 预存款已收
    */
    public $iPreDepositReceived = 0;
    /**
    * 保证金已收
    */
    public $iCashDepositReceived = 0;
    /**
    * 保证金和预存款到帐时间
    */
    public $strReceivedDate = '2000-01-01';
 }