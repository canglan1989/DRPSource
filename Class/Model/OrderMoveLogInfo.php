<?php
/**
 * @fnuctional: 表 om_order_move_log 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-11-30 15:18:45
 */ 
/** 
 * om_order_move_log 表名及字段名
 */
class T_OrderMoveLog
{
    /**
	* 表名
	*/
	const Name = "om_order_move_log";
    /**
	* 所有字段
	*/
	const AllFields = "`om_order_move_log`.`order_move_id`,`om_order_move_log`.`order_id`,`om_order_move_log`.`to_agent_id`,`om_order_move_log`.`from_agent_id`,`om_order_move_log`.`create_time`,`om_order_move_log`.`create_uid`,`om_order_move_log`.`create_user_name`,`new_order_id`,`remark`,`order_no`,`new_order_no`,`to_agent_name`,`from_agent_name`";
 }
 /**
 * om_order_move_log 数据实体
 */
class OrderMoveLogInfo
{
    /**
    * 订单转移记录表ID
    */
    public $iOrderMoveId = 0;
    /**
    * 订单号
    */
    public $iOrderId = 0;
    /**
    * 转移后的代理商ID
    */
    public $iToAgentId = 0;
    /**
    * 转移前的代理商ID
    */
    public $iFromAgentId = 0;
    /**
    * 操作时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 操作人ID
    */
    public $iCreateUid = 0;
    /**
    * 操作人
    */
    public $strCreateUserName = '';
    /**
     * 新增订单的订单号
     */
    public $iNewOrderId = 0;
    /**
     * 转移备注
     */
    public $strRemark = '';
    /**
     * 原订单编号
     */
    public $strOrderNo = '';
    /**
     * 新订单号
     */
    public $strNewOrderNo = '';
    /**
     * 转入代理商名称
     */
    public $strToAgentName = '';
    /**
     * 原代理商名称
     */
    public $strFromAgentName = '';
 }