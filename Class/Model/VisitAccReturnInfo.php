<?php
/**
 * @fnuctional: 表 am_visit_acc_return 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     许丹丹
 * @date:       2012-04-24 15:33:08
 */ 
/** 
 * am_visit_acc_return 表名及字段名
 */
class T_VisitAccReturn
{
    /**
	* 表名
	*/
	const Name = "am_visit_acc_return";
    /**
	* 所有字段
	*/
	const AllFields = "`id`,`accoID`,`content`,`return_time`,`add_time`,`add_user_id`";
 }
 /**
 * am_visit_acc_return 数据实体
 */
class VisitAccReturnInfo
{
    /**
    * 
    */
    public $iId = 0;
    /**
    * 
    */
    public $iAccoid = 0;
    /**
    * 
    */
    public $strContent = '';
    /**
    * 
    */
    public $strReturnTime = '2000-01-01';
    /**
    * 
    */
    public $strAddTime = '2000-01-01';
    /**
    * 
    */
    public $iAddUserId = 0;
 }