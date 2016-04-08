<?php

/**
 * @fnuctional: 表 agent_map 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     许亮
 * @date:       2012-03-26 10:22:40
 */

/**
 * agent_map 表名及字段名
 */
class T_Map
{
    /**
     * 表名
     */

    const Name = "agent_map";
    /**
     * 所有字段
     */
    const AllFields = "id,agent_name,area,product_name,deadline,ensure_money,deposits,sign_name,status,visit_rate,visit_num,real_visit,adhai_online_num,signed_customer,new_customer,follow_customer,coordinate,group_center_coordinate,group_name,group_coordinate";

}

/**
 * agent_map 数据实体
 */
class MapInfo
{

    /**
     * 主键
     */
    public $iId = 0;

    /**
     * 代理商名称
     */
    public $strAgentName = '';

    /**
     * 
     */
    public $strArea = '';

    /**
     * 
     */
    public $strProductName = '';

    /**
     * 
     */
    public $strDeadline = '2000-01-01';

    /**
     * 
     */
    public $iEnsureMoney = 0;

    /**
     * 
     */
    public $iDeposits = 0;

    /**
     * 
     */
    public $strSignName = '';

    /**
     * 
     */
    public $strStatus = '';

    /**
     * 
     */
    public $strVisitRate = '';

    /**
     * 
     */
    public $iVisitNum = 0;

    /**
     * 
     */
    public $iRealVisit = 0;

    /**
     * 
     */
    public $iAdhaiOnlineNum = 0;

    /**
     * 
     */
    public $strSignedCustomer = '';

    /**
     * 
     */
    public $strNewCustomer = '';

    /**
     * 
     */
    public $strFollowCustomer = '';

    /**
     * 
     */
    public $strCoordinate = '';

    /**
     * 
     */
    public $strGroupCenterCoordinate = '';

    /**
     * 
     */
    public $strGroupName = '';

    /**
     * 
     */
    public $strGroupCoordinate = '';

}