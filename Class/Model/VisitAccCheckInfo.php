<?php
/**
 * @fnuctional: 表 am_visit_acc_check 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     许丹丹
 * @date:       2012-04-24 16:27:18
 */ 
/** 
 * am_visit_acc_check 表名及字段名
 */
class T_VisitAccCheck
{
    /**
	* 表名
	*/
	const Name = "am_visit_acc_check";
    /**
	* 所有字段
	*/
	const AllFields = "`id`,`accoID`,`detial`,`check_time`,`check_statu`,`check_uid`";
 }
 /**
 * am_visit_acc_check 数据实体
 */
class VisitAccCheckInfo
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
    public $strDetial = '';
    /**
    * 
    */
    public $strCheckTime = '2000-01-01';
    /**
    * 
    */
    public $iCheckStatu = 0;
    /**
    * 
    */
    public $iCheckUid = 0;
 }