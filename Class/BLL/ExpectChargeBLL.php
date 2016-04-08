<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_expect_charge 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2012-11-27 15:15:37
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/ExpectChargeInfo.php';

class ExpectChargeBLL extends BLLBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objExpectChargeInfo  ExpectChargeInfo 实例
     * @return 
     */
    public function insert(ExpectChargeInfo $objExpectChargeInfo) {
        $sql = "INSERT INTO `am_expect_charge`(`agent_id`,`inten_level`,`expect_time`,`expect_money`,`expect_type`,`charge_percentage`,`create_time`,`create_uid`,`product_id`) 
        values(" . $objExpectChargeInfo->iAgentId . ",'" . $objExpectChargeInfo->strIntenLevel . "','" . $objExpectChargeInfo->strExpectTime . "'," . $objExpectChargeInfo->iExpectMoney . "," . $objExpectChargeInfo->iExpectType . "," . $objExpectChargeInfo->iChargePercentage . ",now()," . $objExpectChargeInfo->iCreateUid . ",{$objExpectChargeInfo->iProductId})";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objExpectChargeInfo  ExpectChargeInfo 实例
     * @return
     */
    public function updateByID(ExpectChargeInfo $objExpectChargeInfo) {
        $sql = "update `am_expect_charge` set `agent_id`=" . $objExpectChargeInfo->iAgentId . ",`inten_level`='" . $objExpectChargeInfo->strIntenLevel . "',`expect_time`='" . $objExpectChargeInfo->strExpectTime . "',`expect_money`=" . $objExpectChargeInfo->iExpectMoney . ",`expect_type`=" . $objExpectChargeInfo->iExpectType . ",`charge_percentage`=" . $objExpectChargeInfo->iChargePercentage . ",`product_id`={$objExpectChargeInfo->iProductId} where id=" . $objExpectChargeInfo->iId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "") {
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
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount) {
        if ($sField == "*" || $sField == "")
            $sField = T_ExpectCharge::AllFields;

        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_expect_charge` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 ExpectChargeInfo 对象
     * @param int $id 
     * @return ExpectChargeInfo 对象
     */
    public function getModelByID($id) {
        $objExpectChargeInfo = null;
        $arrayInfo = $this->select("*", "id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objExpectChargeInfo = new ExpectChargeInfo();


            $objExpectChargeInfo->iId = $arrayInfo[0]['id'];
            $objExpectChargeInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objExpectChargeInfo->strIntenLevel = $arrayInfo[0]['inten_level'];
            $objExpectChargeInfo->strExpectTime = $arrayInfo[0]['expect_time'];
            $objExpectChargeInfo->iExpectMoney = $arrayInfo[0]['expect_money'];
            $objExpectChargeInfo->iExpectType = $arrayInfo[0]['expect_type'];
            $objExpectChargeInfo->iChargePercentage = $arrayInfo[0]['charge_percentage'];
            $objExpectChargeInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objExpectChargeInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objExpectChargeInfo->iProductId = $arrayInfo[0]['product_id'];
            settype($objExpectChargeInfo->iId, "integer");
            settype($objExpectChargeInfo->iAgentId, "integer");
            settype($objExpectChargeInfo->iExpectMoney, "float");
            settype($objExpectChargeInfo->iExpectType, "integer");
            settype($objExpectChargeInfo->iChargePercentage, "integer");
            settype($objExpectChargeInfo->iCreateUid, "integer");
            settype($objExpectChargeInfo->iProductId, "integer");
        }
        return $objExpectChargeInfo;
    }

    /**
     * 根据代理商ID查找一条信息
     */
    public function getInfoByAgentId($agentId) {
        $sql = "select " . T_ExpectCharge::AllFields . "from am_expect_charge where agent_id =$agentId";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getExpectMoneyByAgentId($agentId) {
        $sql = "SELECT
                am_expect_charge.id,
                am_expect_charge.agent_id,
                am_expect_charge.inten_level,
                am_expect_charge.expect_time,
                am_expect_charge.expect_money,
                am_expect_charge.expect_type,
                am_expect_charge.charge_percentage,
                am_expect_charge.create_time,
                am_expect_charge.create_uid,
                am_expect_charge.product_id,
                am_agent_source.agent_name,
                sys_product_type.product_type_name,
                sys_user.e_name,
                sys_user.user_name
                FROM
                am_expect_charge
                LEFT JOIN am_agent_source ON am_agent_source.agent_id = am_expect_charge.agent_id
                LEFT JOIN sys_product_type ON am_expect_charge.product_id = sys_product_type.aid
                LEFT JOIN sys_user ON am_expect_charge.create_uid = sys_user.user_id
                where am_expect_charge.agent_id =$agentId";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
}

