<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表om_order_website的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-19 15:34:42
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * om_order_website表名及字段名
 */
class T_OrderWebsite
{
	/**
	* 表名
	*/
	const Name = "om_order_website";
	/**
	* 
	*/
	const order_id = "order_id";
	/**
	* 
	*/
	const website_provider = "website_provider";
	/**
	* 
	*/
	const website_name = "website_name";
	
	/**
	* 所有字段
	*/
	const AllFields = "`order_id`,`website_provider`,`website_name`";
}

/**
 * om_order_website数据实体
 */
class OrderWebsiteInfo
{
	/**
	*
	*/
	public $iOrderId = 0;
	/**
	*
	*/
	public $strWebsiteProvider = '';
	/**
	*
	*/
	public $strWebsiteName = '';
}
?>
