<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表om_order_website的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-19 15:34:42
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/OrderWebsiteInfo.php';

class OrderWebsiteBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param OrderWebsiteInfo $objOrderWebsiteInfo  OrderWebsite实例
     * @return 
     */
    public function insert(OrderWebsiteInfo $objOrderWebsiteInfo)
    {
        $sql = "INSERT INTO `om_order_website`(`order_id`,`website_provider`,`website_name`)"
                . " values(" . $objOrderWebsiteInfo->iOrderId . ",'" . $objOrderWebsiteInfo->strWebsiteProvider . "','" . $objOrderWebsiteInfo->strWebsiteName . "')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 新增一条记录
     * @param OrderWebsiteInfo $objOrderWebsiteInfo  OrderWebsite实例
     * @return 
     */
    public function insertData($iOrderId, $strWebsiteProvider, $strWebsiteName)
    {
        $sql = "INSERT INTO `om_order_website`(`order_id`,`website_provider`,`website_name`)"
                . " values(" . $iOrderId . ",'" . $strWebsiteProvider . "','" . $strWebsiteName . "')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    public function DeleteByOrderID($orderID)
    {
        $sql = "delete from `om_order_website` where `order_id`=" . $orderID;
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function SelectDataByOrderID($orderID)
    {
        return $this->select("*", "order_id=" . $orderID, "`website_provider`,`website_name`");
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    }

    /**
     * @functional 返回TOP数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @param string $sGroup group  by 关键字的分组
     * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
        if ($sField == "*" || $sField == "")
            $sField = T_OrderWebsite::AllFields;
        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `om_order_website` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个om_order_website对象
     * @param int $id 
     * @return om_order_website对象
     */
    public function getModelByID($id)
    {
        $objOrderWebsiteInfo = null;
        $arrayInfo = $this->select("*", "order_website_id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objOrderWebsiteInfo = new OrderWebsiteInfo();
            $objOrderWebsiteInfo->iOrderId = $arrayInfo[0]['order_id'];
            $objOrderWebsiteInfo->strWebsiteProvider = $arrayInfo[0]['website_provider'];
            $objOrderWebsiteInfo->strWebsiteName = $arrayInfo[0]['website_name'];

            settype($objOrderWebsiteInfo->iOrderWebsiteId, "integer");
            settype($objOrderWebsiteInfo->iOrderId, "integer");
        }

        return $objOrderWebsiteInfo;
    }

    public function getInfoStatus($order_id)
    {
        $sql = "SELECT website_provider,website_name,customer_name
                from om_order_website as A LEFT JOIN om_order as B on A.order_id=B.order_id 
                WHERE A.order_id=$order_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    /**
     * @functional 根据订单ID 取得域名
     * @param int $orderID 订单ID 
     * @return 所属性这个订单的数组对象
     */
    public function GetWebSites($orderID)
    {
        $sql = "SELECT `website_provider`, `website_name` FROM `om_order_website` where `order_id` =$orderID order by `website_provider`, `website_name`";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

}

?>
