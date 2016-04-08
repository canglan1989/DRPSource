<?php
/**
 * @fnuctional: 表 sys_intention_rating 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-10-22 15:40:38
 */ 
/** 
 * sys_intention_rating 表名及字段名
 */
class T_IntentionRating
{
    /**
	* 表名
	*/
	const Name = "sys_intention_rating";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_intention_rating`.`rating_id`,`sys_intention_rating`.`rating_name`,`sys_intention_rating`.`sort_index`,`sys_intention_rating`.`remark`,`sys_intention_rating`.`is_money_time`,`sys_intention_rating`.`is_report`,`sys_intention_rating`.`is_del`,`sys_intention_rating`.`create_uid`,`sys_intention_rating`.`create_time`,`sys_intention_rating`.`update_uid`,`sys_intention_rating`.`update_time`";
 }
 /**
 * sys_intention_rating 数据实体
 */
class IntentionRatingInfo
{
    /**
    * 
    */
    public $iRatingId = 0;
    /**
    * 网盟意向评级名称
    */
    public $strRatingName = '';
    /**
    * 显示顺序
    */
    public $iSortIndex = 0;
    /**
    * 备注
    */
    public $strRemark = '';
    /**
    * 是否需要填写预计到账金额和时间 0-否 1-是
    */
    public $iIsMoneyTime = 0;
    /**
    * 是否纳入统计报表 0-否 1-是
    */
    public $iIsReport = 0;
    /**
    * 是否删除 0-否 1-是
    */
    public $iIsDel = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
 }