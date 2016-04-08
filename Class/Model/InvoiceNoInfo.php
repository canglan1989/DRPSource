<?php
/**
 * @fnuctional: 表 fm_invoice_no 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-06-26 17:58:07
 */ 
/** 
 * fm_invoice_no 表名及字段名
 */
class T_InvoiceNo
{
    /**
	* 表名
	*/
	const Name = "fm_invoice_no";
    /**
	* 所有字段
	*/
	const AllFields = "`fm_invoice_no`.`invoice_id`,`fm_invoice_no`.`invoice_no`,`fm_invoice_no`.`is_used`,`fm_invoice_no`.`create_uid`,`fm_invoice_no`.`create_user_name`,`fm_invoice_no`.`create_time`,`fm_invoice_no`.`update_uid`,`fm_invoice_no`.`update_user_name`,`fm_invoice_no`.`update_time`";
 }
 /**
 * fm_invoice_no 数据实体
 */
class InvoiceNoInfo
{
    /**
    * 
    */
    public $iInvoiceId = 0;
    /**
    * 
    */
    public $strInvoiceNo = '';
    /**
    * 删除标识1已删除
    */
    public $iIsUsed = 0;
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
 }