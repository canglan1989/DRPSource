<?php
/**
 * @fnuctional: 表 cm_customer_ex 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-10-31 16:42:58
 */ 
/** 
 * cm_customer_ex 表名及字段名
 */
class T_CustomerEx
{
    /**
	* 表名
	*/
	const Name = "cm_customer_ex";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_customer_ex`.`customer_id`,`cm_customer_ex`.`agent_id`,`cm_customer_ex`.`record_count`,`cm_customer_ex`.`last_record_time`,`cm_customer_ex`.`last_record_content`,`cm_customer_ex`.`intention_rating`,`cm_customer_ex`.`intention_rating_name`,`cm_customer_ex`.`last_to_sea_time`,`cm_customer_ex`.`buy_product_ids`,`cm_customer_ex`.`buy_product_name`,`cm_customer_ex`.`to_sea_time`,`cm_customer_ex`.`shield_uid`,`cm_customer_ex`.`shield_time`,`cm_customer_ex`.`defend_state`";
 }
 /**
 * cm_customer_ex 数据实体
 */
class CustomerExInfo
{
    /**
    * 客户ID
    */
    public $iCustomerId = 0;
    /**
    * 代理商ID
    */
    public $iAgentId = 0;
    /**
    * 联系小记次数(细到代理商)
    */
    public $iRecordCount = 0;
    /**
    * 最后一次联系时间
    */
    public $strLastRecordTime = '0000-00-00';
    /**
    * 最后一次联系记录内容
    */
    public $strLastRecordContent = '';
    /**
    * 意向评级0-A,1-B,2-C,3-D,4-E
    */
    public $iIntentionRating = 0;
    /**
    * 网盟意向评级
    */
    public $strIntentionRatingName = '';
    /**
    * 最后踢出时间
    */
    public $strLastToSeaTime = '0000-00-00';
    /**
    * 购买的产品ID
    */
    public $strBuyProductIds = '';
    /**
    * 购买的产品名称
    */
    public $strBuyProductName = '';
    /**
    * 到公海时间
    */
    public $strToSeaTime = '0000-00-00';
    /**
    * 屏蔽操作人ID
    */
    public $iShieldUid = 0;
    /**
    * 屏蔽时间
    */
    public $strShieldTime = '0000-00-00';
    /**
    * 保护状态 1电话客户 2保护客户 3自录客户 4正式客户 
    */
    public $iDefendState = 0;
 }