<?php
/**
 * @fnuctional: 表 am_agent_source 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-12-11 16:45:02
 */ 
/** 
 * am_agent_source 表名及字段名
 */
class T_AgentSource
{
    /**
	* 表名
	*/
	const Name = "am_agent_source";
    /**
	* 所有字段
	*/
	const AllFields = "`am_agent_source`.`agent_id`,`am_agent_source`.`agent_no`,`am_agent_source`.`operate_type`,`am_agent_source`.`agent_from`,`am_agent_source`.`agent_name`,`am_agent_source`.`province_id`,`am_agent_source`.`city_id`,`am_agent_source`.`area_id`,`am_agent_source`.`reg_province_id`,`am_agent_source`.`reg_city_id`,`am_agent_source`.`reg_area_id`,`am_agent_source`.`address`,`am_agent_source`.`legal_person`,`am_agent_source`.`legal_person_ID`,`am_agent_source`.`postcode`,`am_agent_source`.`intention_level`,`am_agent_source`.`final_contact_time`,`am_agent_source`.`contact_num`,`am_agent_source`.`agent_level`,`am_agent_source`.`sort_index`,`am_agent_source`.`agent_pid`,`am_agent_source`.`reg_capital`,`am_agent_source`.`company_scale`,`am_agent_source`.`reg_date`,`am_agent_source`.`sales_num`,`am_agent_source`.`telsales_num`,`am_agent_source`.`customer_num`,`am_agent_source`.`direction`,`am_agent_source`.`permit_reg_no`,`am_agent_source`.`revenue_no`,`am_agent_source`.`tech_num`,`am_agent_source`.`service_num`,`am_agent_source`.`annual_sales`,`am_agent_source`.`website`,`am_agent_source`.`charge_person`,`am_agent_source`.`charge_phone`,`am_agent_source`.`charge_tel`,`am_agent_source`.`charge_email`,`am_agent_source`.`charge_fax`,`am_agent_source`.`charge_positon`,`am_agent_source`.`charge_qq`,`am_agent_source`.`charge_msn`,`am_agent_source`.`charge_twitter`,`am_agent_source`.`charge_mark`,`am_agent_source`.`check_remark`,`am_agent_source`.`channel_uid`,`am_agent_source`.`is_lock`,`am_agent_source`.`is_del`,`am_agent_source`.`is_check`,`am_agent_source`.`update_uid`,`am_agent_source`.`update_time`,`am_agent_source`.`create_uid`,`am_agent_source`.`create_time`,`am_agent_source`.`check_uid`,`am_agent_source`.`check_time`,`am_agent_source`.`last_revisit_time`,`am_agent_source`.`industry`,`am_agent_source`.`agent_area_full_name`,`am_agent_source`.`agent_reg_area_full_name`,`am_agent_source`.`agent_channel_user_name`,`am_agent_source`.`agent_create_user_name`,`am_agent_source`.`agent_check_user_name`,`am_agent_source`.`pact_product_names`,`am_agent_source`.`in_sea_time`,`dynamics`";
 }
 /**
 * am_agent_source 数据实体
 */
class AgentSourceInfo
{
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 代理商编号
    */
    public $strAgentNo = '';
    /**
    * 操作类型:0为新增，1为修改，2为删除
    */
    public $iOperateType = 0;
    /**
    * 客户来源:0自己添加，1自动注册，2上级分配
    */
    public $iAgentFrom = 0;
    /**
    * 代理商名称
    */
    public $strAgentName = '';
    /**
    * 省份ID
    */
    public $iProvinceId = 0;
    /**
    * 城市ID
    */
    public $iCityId = 0;
    /**
    * 区域ID
    */
    public $iAreaId = 0;
    /**
    * 注册省份
    */
    public $iRegProvinceId = 0;
    /**
    * 注册城市
    */
    public $iRegCityId = 0;
    /**
    * 注册地区
    */
    public $iRegAreaId = 0;
    /**
    * 注册地址
    */
    public $strAddress = '';
    /**
    * 法人
    */
    public $strLegalPerson = '';
    /**
    * 法人身份证号
    */
    public $strLegalPersonId = '';
    /**
    * 邮编
    */
    public $strPostcode = '';
    /**
    * 意向评级：A、B、C、D、E五个等级
    */
    public $strIntentionLevel = '';
    /**
    * 最后联系时间
    */
    public $strFinalContactTime = '0000-00-00';
    /**
    * 代理商联系次数
    */
    public $iContactNum = 0;
    /**
    * 代理商等级0无等级 1金牌 2银牌 以实际签的合同中的等级为准
    */
    public $iAgentLevel = 0;
    /**
    * 排序
    */
    public $iSortIndex = 0;
    /**
    * 上级代理商ID（目前不用，只有在使用二级代理时才使用此字段 2011.07.04）
    */
    public $iAgentPid = 0;
    /**
    * 注册资金
    */
    public $strRegCapital = '';
    /**
    * 公司规模
    */
    public $strCompanyScale = '';
    /**
    * 公司注册时间
    */
    public $strRegDate = '0000-00-00';
    /**
    * 公司销售人数
    */
    public $strSalesNum = '';
    /**
    * 互联网电话营销人数
    */
    public $strTelsalesNum = '';
    /**
    * 企业客户数
    */
    public $strCustomerNum = '';
    /**
    * 企业业务方向
    */
    public $strDirection = '';
    /**
    * 营业执照注册号
    */
    public $strPermitRegNo = '';
    /**
    * 企业税号
    */
    public $strRevenueNo = '';
    /**
    * 售前技术支持
    */
    public $strTechNum = '';
    /**
    * 客服人数
    */
    public $strServiceNum = '';
    /**
    * 年销售额
    */
    public $strAnnualSales = '';
    /**
    * 网站地址
    */
    public $strWebsite = '';
    /**
    * 负责人信息
    */
    public $strChargePerson = '';
    /**
    * 负责人手机号码
    */
    public $strChargePhone = '';
    /**
    * 负责人电话号码
    */
    public $strChargeTel = '';
    /**
    * 负责人电子邮箱
    */
    public $strChargeEmail = '';
    /**
    * 负责人传真号码
    */
    public $strChargeFax = '';
    /**
    * 负责人职务
    */
    public $strChargePositon = '';
    /**
    * 负责人QQ号码
    */
    public $iChargeQq = '';
    /**
    * 负责人MSN帐号
    */
    public $strChargeMsn = '';
    /**
    * 负责人微博账号
    */
    public $strChargeTwitter = '';
    /**
    * 负责人备注
    */
    public $strChargeMark = '';
    /**
    * 审核备注
    */
    public $strCheckRemark = '';
    /**
    * 渠道经理ID
    */
    public $iChannelUid = 0;
    /**
    * 0启用,1停用
    */
    public $iIsLock = 0;
    /**
    * 0正常,1删除,2彻底删除
    */
    public $iIsDel = 0;
    /**
    * 是否审核:0未审核，1为已审核，2审核不通过
    */
    public $iIsCheck = 0;
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '0000-00-00';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '0000-00-00';
    /**
    * 审核人ID
    */
    public $iCheckUid = 0;
    /**
    * 审核时间
    */
    public $strCheckTime = '0000-00-00';
    /**
    * 最近回访时间
    */
    public $strLastRevisitTime = '0000-00-00';
    /**
    * 所属行业
    */
    public $iIndustry = 0;
    /**
    * 
    */
    public $strAgentAreaFullName = '';
    /**
    * 
    */
    public $strAgentRegAreaFullName = '';
    /**
    * 
    */
    public $strAgentChannelUserName = '';
    /**
    * 
    */
    public $strAgentCreateUserName = '';
    /**
    * 
    */
    public $strAgentCheckUserName = '';
    /**
    * 签约产品
    */
    public $strPactProductNames = '';
    /**
    * 踢入公海时间
    */
    public $strInSeaTime = '0000-00-00';
    /**
     * 行业动态
     */
    public $strDynamics = '';
 }