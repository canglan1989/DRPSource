<?php
/**
 * @fnuctional: 表 cm_customer 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-10-22 15:40:09
 */ 
/** 
 * cm_customer 表名及字段名
 */
class T_Customer
{
    /**
	* 表名
	*/
	const Name = "cm_customer";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_customer`.`customer_id`,`cm_customer`.`customer_no`,`cm_customer`.`customer_name`,`cm_customer`.`province_id`,`cm_customer`.`city_id`,`cm_customer`.`area_id`,`cm_customer`.`area_name`,`cm_customer`.`address`,`cm_customer`.`postcode`,`cm_customer`.`industry_pid`,`cm_customer`.`industry_id`,`cm_customer`.`industry_name`,`cm_customer`.`business_model`,`cm_customer`.`main_business`,`cm_customer`.`major_markets`,`cm_customer`.`company_profile`,`cm_customer`.`reg_date`,`cm_customer`.`business_scope`,`cm_customer`.`company_scope`,`cm_customer`.`annual_sales`,`cm_customer`.`reg_status`,`cm_customer`.`reg_capital`,`cm_customer`.`reg_place`,`cm_customer`.`check_status`,`cm_customer`.`check_remark`,`cm_customer`.`website`,`cm_customer`.`customer_from`,`cm_customer`.`net_extension_about`,`cm_customer`.`update_uid`,`cm_customer`.`update_user_name`,`cm_customer`.`update_time`,`cm_customer`.`create_uid`,`cm_customer`.`create_user_name`,`cm_customer`.`create_time`,`cm_customer`.`check_uid`,`cm_customer`.`check_user_name`,`cm_customer`.`check_time`,`cm_customer`.`is_del`,`cm_customer`.`assign_check_id`,`cm_customer`.`assign_check_name`,`cm_customer`.`legal_person_name`,`cm_customer`.`legal_person_id`,`cm_customer`.`business_license`,`cm_customer`.`customer_resource`,`cm_customer`.`history_check`,`cm_customer`.`pub_id`";
 }
 /**
 * cm_customer 数据实体
 */
class CustomerInfo
{
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 客户号
    */
    public $strCustomerNo = '';
    /**
    * 客户名称
    */
    public $strCustomerName = '';
    /**
    * 省份ID
    */
    public $iProvinceId = 0;
    /**
    * 城市ID
    */
    public $iCityId = 0;
    /**
    * 属所地区
    */
    public $iAreaId = 0;
    /**
    * 地区名称（全名路径）
    */
    public $strAreaName = '';
    /**
    * 客户地址
    */
    public $strAddress = '';
    /**
    * 邮政编码
    */
    public $strPostcode = '';
    /**
    * 1级行业ID
    */
    public $iIndustryPid = 0;
    /**
    * 所属行业
    */
    public $iIndustryId = 0;
    /**
    * 行业名称（全名路径）
    */
    public $strIndustryName = '';
    /**
    * 经营模式
    */
    public $strBusinessModel = '';
    /**
    * 主营业务
    */
    public $strMainBusiness = '';
    /**
    * 主要市场
    */
    public $strMajorMarkets = '';
    /**
    * 公司简介
    */
    public $strCompanyProfile = '';
    /**
    * 注册时间
    */
    public $strRegDate = '2000-01-01';
    /**
    * 经营范围
    */
    public $strBusinessScope = '';
    /**
    * 规模(人数)
    */
    public $strCompanyScope = '';
    /**
    * 年销售额
    */
    public $strAnnualSales = '';
    /**
    * 注册状态
    */
    public $strRegStatus = '';
    /**
    * 注册资金
    */
    public $strRegCapital = '';
    /**
    * 注册地区
    */
    public $strRegPlace = '';
    /**
    * 审核标识(客户添加审核) -2不提交审核 -1不通过审核 0提交审核 1通过审核
    */
    public $iCheckStatus = 0;
    /**
    * 审核备注
    */
    public $strCheckRemark = '';
    /**
    * 公司网址
    */
    public $strWebsite = '';
    /**
    * 客户来源 CSC网单 个人录入 系统资源 老客户介绍 录入时的字段
    */
    public $strCustomerFrom = '';
    /**
    * 网络推广情况
    */
    public $strNetExtensionAbout = '';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 更新人名称
    */
    public $strUpdateUserName = '';
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 添加人名称
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 审核人ID
    */
    public $iCheckUid = 0;
    /**
    * 最后一次审核人名称
    */
    public $strCheckUserName = '';
    /**
    * 审核时间
    */
    public $strCheckTime = '2000-01-01';
    /**
    * 删除 1表示客户请求删除 0表示没删除 2表示彻底删除（审核通过）
    */
    public $iIsDel = 0;
    /**
    * 指派审核人
    */
    public $iAssignCheckId = 0;
    /**
    * 审核指派人名称
    */
    public $strAssignCheckName = '';
    /**
    * 法人姓名
    */
    public $strLegalPersonName = '';
    /**
    * 法人身份证号
    */
    public $strLegalPersonId = '';
    /**
    * 营业执照号
    */
    public $strBusinessLicense = '';
    /**
    * 客户来源2.0:0-后台录入,1-拉取,2-其他,3-自动注册,4-厂商推荐,5-前台录入,6-Excel导入
    */
    public $iCustomerResource = 0;
    /**
    * 历史审核有通过该值为1
    */
    public $iHistoryCheck = 0;
    /**
    * 基础平台公共ID
    */
    public $iPubId = 0;
 }