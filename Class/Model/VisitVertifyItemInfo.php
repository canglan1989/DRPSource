<?php
/**
 * @fnuctional: 表 am_visit_vertify_item 的类模型
 * @copyright:  Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2013-01-10 14:45:51
 */ 
/** 
 * am_visit_vertify_item 表名及字段名
 */
class T_VisitVertifyItem
{
    /**
	* 表名
	*/
	const Name = "am_visit_vertify_item";
    /**
	* 所有字段
	*/
	const AllFields = "`am_visit_vertify_item`.`item_id`,`am_visit_vertify_item`.`item_name`,`am_visit_vertify_item`.`item_result`,`am_visit_vertify_item`.`sort_index`,`am_visit_vertify_item`.`check_b`";
 }
 /**
 * am_visit_vertify_item 数据实体
 */
class VisitVertifyItemInfo
{
    /**
    * 质检选项ID
    */
    public $iItemId = 0;
    /**
    * 质检选项
    */
    public $strItemName = '';
    /**
    * 质检结果
    */
    public $strItemResult = '';
    /**
    * 排序，越低越靠前
    */
    public $iSortIndex = 0;
 }