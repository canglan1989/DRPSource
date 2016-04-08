<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agent_pact的类业务逻辑层
 * 表描述：
 * 创建人：许亮
 * 添加时间：2011/7/15 8:58:55
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentPactInfo.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';

class AgentPactBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objAgentPactInfo  AgentPactInfo 实例
     * @return 
     */
	public function insert(AgentPactInfo $objAgentPactInfo)
	{
		$sql = "INSERT INTO `am_agent_pact`(`agent_id`,`cur_agent_name`,`product_id`,`reg_area_id`,`charge_area_id`,`agent_mode`,`agent_level`,`pre_deposit`,`cash_deposit`,`pact_sdate`,`pact_edate`,`area`,`company_name`,`area_id`,`address`,`postcode`,`legal_person`,`legal_person_ID`,`revenue_no`,`permit_reg_no`,`reg_capital`,`charge_person`,`charge_phone`,`charge_tel`,`pact_remark`,`pact_type`,`pact_status`,`bigregion_check`,`channel_check`,`contract_check`,`pact_number`,`pact_stage`,`create_uid`,`update_uid`,`create_time`,`update_time`,`renewal_check`,`remove_sign_uid`,`remove_sign_user_name`,`remove_sign_time`,`remove_sign_remark`,`pre_deposit_received`,`cash_deposit_received`,`received_date`) 
        values(".$objAgentPactInfo->iAgentId.",'".$objAgentPactInfo->strCurAgentName."','".$objAgentPactInfo->strProductId."',".$objAgentPactInfo->iRegAreaId.",".$objAgentPactInfo->iChargeAreaId.",".$objAgentPactInfo->iAgentMode.",'".$objAgentPactInfo->strAgentLevel."',".$objAgentPactInfo->iPreDeposit.",".$objAgentPactInfo->iCashDeposit.",'".$objAgentPactInfo->strPactSdate."','".$objAgentPactInfo->strPactEdate."','".$objAgentPactInfo->strArea."','".$objAgentPactInfo->strCompanyName."',".$objAgentPactInfo->iAreaId.",'".$objAgentPactInfo->strAddress."','".$objAgentPactInfo->strPostcode."','".$objAgentPactInfo->strLegalPerson."','".$objAgentPactInfo->strLegalPersonId."','".$objAgentPactInfo->strRevenueNo."','".$objAgentPactInfo->strPermitRegNo."','".$objAgentPactInfo->strRegCapital."','".$objAgentPactInfo->strChargePerson."','".$objAgentPactInfo->strChargePhone."','".$objAgentPactInfo->strChargeTel."','".$objAgentPactInfo->strPactRemark."',".$objAgentPactInfo->iPactType.",".$objAgentPactInfo->iPactStatus.",".$objAgentPactInfo->iBigregionCheck.",".$objAgentPactInfo->iChannelCheck.",".$objAgentPactInfo->iContractCheck.",'".$objAgentPactInfo->strPactNumber."','".$objAgentPactInfo->strPactStage."',".$objAgentPactInfo->iCreateUid.",".$objAgentPactInfo->iUpdateUid.",now(),now(),".$objAgentPactInfo->iRenewalCheck.",".$objAgentPactInfo->iRemoveSignUid.",'".$objAgentPactInfo->strRemoveSignUserName."','".$objAgentPactInfo->strRemoveSignTime."','".$objAgentPactInfo->strRemoveSignRemark."',".$objAgentPactInfo->iPreDepositReceived.",".$objAgentPactInfo->iCashDepositReceived.",'".$objAgentPactInfo->strReceivedDate."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgentPactInfo  AgentPactInfo 实例
     * @return
     */
	public function updateByID(AgentPactInfo $objAgentPactInfo)
	{
	   $sql = "update `am_agent_pact` set `agent_id`=".$objAgentPactInfo->iAgentId.",`cur_agent_name`='".$objAgentPactInfo->strCurAgentName."',`product_id`='".$objAgentPactInfo->strProductId."',`reg_area_id`=".$objAgentPactInfo->iRegAreaId.",`charge_area_id`=".$objAgentPactInfo->iChargeAreaId.",`agent_mode`=".$objAgentPactInfo->iAgentMode.",`agent_level`='".$objAgentPactInfo->strAgentLevel."',`pre_deposit`=".$objAgentPactInfo->iPreDeposit.",`cash_deposit`=".$objAgentPactInfo->iCashDeposit.",`pact_sdate`='".$objAgentPactInfo->strPactSdate."',`pact_edate`='".$objAgentPactInfo->strPactEdate."',`area`='".$objAgentPactInfo->strArea."',`company_name`='".$objAgentPactInfo->strCompanyName."',`area_id`=".$objAgentPactInfo->iAreaId.",`address`='".$objAgentPactInfo->strAddress."',`postcode`='".$objAgentPactInfo->strPostcode."',`legal_person`='".$objAgentPactInfo->strLegalPerson."',`legal_person_ID`='".$objAgentPactInfo->strLegalPersonId."',`revenue_no`='".$objAgentPactInfo->strRevenueNo."',`permit_reg_no`='".$objAgentPactInfo->strPermitRegNo."',`reg_capital`='".$objAgentPactInfo->strRegCapital."',`charge_person`='".$objAgentPactInfo->strChargePerson."',`charge_phone`='".$objAgentPactInfo->strChargePhone."',`charge_tel`='".$objAgentPactInfo->strChargeTel."',`pact_remark`='".$objAgentPactInfo->strPactRemark."',`pact_type`=".$objAgentPactInfo->iPactType.",`pact_status`=".$objAgentPactInfo->iPactStatus.",`bigregion_check`=".$objAgentPactInfo->iBigregionCheck.",`channel_check`=".$objAgentPactInfo->iChannelCheck.",`contract_check`=".$objAgentPactInfo->iContractCheck.",`pact_number`='".$objAgentPactInfo->strPactNumber."',`pact_stage`='".$objAgentPactInfo->strPactStage."',`update_uid`=".$objAgentPactInfo->iUpdateUid.",`update_time`= now(),`renewal_check`=".$objAgentPactInfo->iRenewalCheck.",`remove_sign_uid`=".$objAgentPactInfo->iRemoveSignUid.",`remove_sign_user_name`='".$objAgentPactInfo->strRemoveSignUserName."',`remove_sign_time`='".$objAgentPactInfo->strRemoveSignTime."',`remove_sign_remark`='".$objAgentPactInfo->strRemoveSignRemark."',`pre_deposit_received`=".$objAgentPactInfo->iPreDepositReceived.",`cash_deposit_received`=".$objAgentPactInfo->iCashDepositReceived.",`received_date`='".$objAgentPactInfo->strReceivedDate."' where aid=".$objAgentPactInfo->iAid;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }

    /**
     * @functional 取得去重后的记录条数
     * @author liujunchen
     */
    public function selectDistinctNum()
    {
        $sql = 'SELECT COUNT(DISTINCT agent_id) as num FROM am_agent_pact';
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 更新合同续签状态
     * @return int
     */
    public function updateRenewalCheck($pactId)
    {
        $sql = "update `am_agent_pact` set `renewal_check` = 1 where aid = " . $pactId . "";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查看某代理商是否已经在签约流程中了
     * @author liujunchen
     * @return array
     */
    public function selectIsPact($agentId)
    {
        $sql = "SELECT DISTINCT cur_agent_name as agent_name FROM am_agent_pact WHERE agent_id IN(" . $agentId . ") AND pact_type IN(1,2)";
        $arrResults = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $arrReturns = array();
        foreach ($arrResults as $arrResult)
        {
            $arrReturns[] = $arrResult['cur_agent_name'];
        }
        return $arrReturns;
    }

    /**
     * @functional 查看代理商是否签约
     * @author liujunchen
     * @return int
     */
    public function selectAgentIsPact($agentId)
    {
        $sql = "SELECT COUNT(agent_id) FROM am_agent_pact WHERE agent_id = " . $agentId . " AND is_check IN(1,2)";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查询某代理商是否签约成功
     * @author liujunchen
     */
    public function selectPactIsSuccess($agentId)
    {
        $sql = "SELECT COUNT(agent_id) FROM am_agent_source WHERE agent_id = " . $agentId . " AND agent_id = agent_no";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 根据产品生成递增序列号
     * @author liujunchen
     */
    public function getNumByProId($proId)
    {
        $sql = "SELECT COUNT(1) FROM am_agent_pact WHERE product_id = " . $proId . " AND (pact_status  = 2 or pact_status  = 3 or pact_status  = 4) AND pact_number !=''";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 查询某产品被代理的所有区域
     * @param $productId
     * @author liujunchen
     */
    public function selectProductIsPact($productId)
    {
        $sql = "SELECT area FROM am_agent_pact WHERE product_id = " . $productId . " AND pact_status = 2";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 查询某个代理商代理的某产品的所有区域
     * @param $agentId $productId
     * @author liujunchen
     */
    public function getAreaByAgentId($agentId, $productId, $pactId)
    {
        $sql = "SELECT area FROM am_agent_pact WHERE product_id IN ($productId) AND agent_id=" . $agentId 
        . " AND aid <> " . $pactId . " and pact_status not in(3,4)";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 查看某代理商是否已经签约某产品
     * @author liujunchen
     * 
     */
    public function selectExistsSign($agentId, $productId, $startTime, $endTime, $pactId = 0)
    {
        $sql = "SELECT COUNT(1) FROM am_agent_pact WHERE agent_id = " . $agentId . " AND product_id IN($productId) AND aid <> " . 
            $pactId . " AND pact_sdate = '" . $startTime . "' AND pact_edate = '" . $endTime 
            . "' AND pact_type not in(3,4) AND pact_status not in(3,4)";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    /**
     * @functional 获取代理商的所有合同信息
     * @author liujunchen
     */
    public function selectAllPact($agentId)
    {
        //$sql = "SELECT A.aid,A.agent_id,A.agent_mode,A.agent_level,A.product_id,A.area,A.pre_deposit,A.cash_deposit,A.pact_sdate,A.pact_edate,A.create_time,GROUP_CONCAT(B.product_type_name) AS product_type_name,C.user_id,C.user_name,C.e_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id LIKE CONCAT('%',B.aid,'%') JOIN sys_user C ON A.create_uid = C.user_id WHERE A.agent_id = " . $agentId;
        $sql = "SELECT A.aid,A.agent_id,A.agent_mode,A.agent_level,A.product_id,A.area,A.pre_deposit,A.cash_deposit,A.pact_sdate,A.pact_edate,A.pact_status,A.create_time,B.product_type_name,C.user_id,C.user_name,C.e_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id= B.aid JOIN sys_user C ON A.create_uid = C.user_id WHERE A.agent_id = " . $agentId;
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据合同Id查询合同提交人以及所属部门
     * @author liujunchen
     */
    public function getUserInfoByPactId($pactId)
    {
        $sql = "SELECT A.create_time,B.e_name,B.user_name,C.dept_fullname,C.dept_name FROM am_agent_pact A JOIN sys_user B ON A.create_uid = B.user_id JOIN v_hr_employee C ON B.e_uid = C.e_id AND A.aid = " . $pactId;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 更新合同号 签约类型 状态
     * @author liujunchen
     */
    public function UpdatePactNumber($pactId, $agentId, $pactNumber, $pactStage, $pactType, $pactStat)
    {
        $sql = "UPDATE am_agent_pact SET pact_number = '" . $pactNumber . "',pact_stage = '" . $pactStage . "',pact_type=" . $pactType . ",pact_status=".$pactStat." WHERE agent_id = " . $agentId . " AND aid = " . $pactId . "";
        $updateCount = $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        //更新代理商签约产品
        $sql ="update am_agent_source set pact_product_names = (select GROUP_CONCAT(product_type_name) from v_am_agent_pact_product where 
            v_am_agent_pact_product.agent_id=am_agent_source.agent_id order by product_type_name) where am_agent_source.agent_id=".$agentId;
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        return $updateCount;
    }

    /**
     * @functional 根据合同Id查询代理商产品
     * @author liujunchen
     */
    public function getProByPactId($pactId)
    {
        $sql = "SELECT A.agent_id,A.cash_deposit,A.product_id,B.product_type_name,B.product_type_no FROM am_agent_pact A JOIN sys_product_type B ON A.product_id = B.aid AND A.aid = " . $pactId;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
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
            $sField = T_AgentPact::AllFields;
        if ($sWhere != "")
            $sWhere = " where " . $sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_agent_pact` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

	/**
     * @functional 根据ID,返回一个 AgentPactInfo 对象
	 * @param int $id 
     * @return AgentPactInfo 对象
     */
	public function getModelByID($id,$agentID=0)
	{
		$objAgentPactInfo = null;
		$arrayInfo = $this->select("*","aid=".$id.(($agentID>0)?" and agent_id=$agentID":""),"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentPactInfo = new AgentPactInfo();
            		        
            $objAgentPactInfo->iAid = $arrayInfo[0]['aid'];
            $objAgentPactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentPactInfo->strCurAgentName = $arrayInfo[0]['cur_agent_name'];
            $objAgentPactInfo->strProductId = $arrayInfo[0]['product_id'];
            $objAgentPactInfo->iRegAreaId = $arrayInfo[0]['reg_area_id'];
            $objAgentPactInfo->iChargeAreaId = $arrayInfo[0]['charge_area_id'];
            $objAgentPactInfo->iAgentMode = $arrayInfo[0]['agent_mode'];
            $objAgentPactInfo->strAgentLevel = $arrayInfo[0]['agent_level'];
            $objAgentPactInfo->iPreDeposit = $arrayInfo[0]['pre_deposit'];
            $objAgentPactInfo->iCashDeposit = $arrayInfo[0]['cash_deposit'];
            $objAgentPactInfo->strPactSdate = $arrayInfo[0]['pact_sdate'];
            $objAgentPactInfo->strPactEdate = $arrayInfo[0]['pact_edate'];
            $objAgentPactInfo->strArea = $arrayInfo[0]['area'];
            $objAgentPactInfo->strCompanyName = $arrayInfo[0]['company_name'];
            $objAgentPactInfo->iAreaId = $arrayInfo[0]['area_id'];
            $objAgentPactInfo->strAddress = $arrayInfo[0]['address'];
            $objAgentPactInfo->strPostcode = $arrayInfo[0]['postcode'];
            $objAgentPactInfo->strLegalPerson = $arrayInfo[0]['legal_person'];
            $objAgentPactInfo->strLegalPersonId = $arrayInfo[0]['legal_person_ID'];
            $objAgentPactInfo->strRevenueNo = $arrayInfo[0]['revenue_no'];
            $objAgentPactInfo->strPermitRegNo = $arrayInfo[0]['permit_reg_no'];
            $objAgentPactInfo->strRegCapital = $arrayInfo[0]['reg_capital'];
            $objAgentPactInfo->strChargePerson = $arrayInfo[0]['charge_person'];
            $objAgentPactInfo->strChargePhone = $arrayInfo[0]['charge_phone'];
            $objAgentPactInfo->strChargeTel = $arrayInfo[0]['charge_tel'];
            $objAgentPactInfo->strPactRemark = $arrayInfo[0]['pact_remark'];
            $objAgentPactInfo->iPactType = $arrayInfo[0]['pact_type'];
            $objAgentPactInfo->iPactStatus = $arrayInfo[0]['pact_status'];
            $objAgentPactInfo->iBigregionCheck = $arrayInfo[0]['bigregion_check'];
            $objAgentPactInfo->iChannelCheck = $arrayInfo[0]['channel_check'];
            $objAgentPactInfo->iContractCheck = $arrayInfo[0]['contract_check'];
            $objAgentPactInfo->strPactNumber = $arrayInfo[0]['pact_number'];
            $objAgentPactInfo->strPactStage = $arrayInfo[0]['pact_stage'];
            $objAgentPactInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentPactInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgentPactInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgentPactInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgentPactInfo->iRenewalCheck = $arrayInfo[0]['renewal_check'];
            $objAgentPactInfo->iRemoveSignUid = $arrayInfo[0]['remove_sign_uid'];
            $objAgentPactInfo->strRemoveSignUserName = $arrayInfo[0]['remove_sign_user_name'];
            $objAgentPactInfo->strRemoveSignTime = $arrayInfo[0]['remove_sign_time'];
            $objAgentPactInfo->strRemoveSignRemark = $arrayInfo[0]['remove_sign_remark'];
            $objAgentPactInfo->iPreDepositReceived = $arrayInfo[0]['pre_deposit_received'];
            $objAgentPactInfo->iCashDepositReceived = $arrayInfo[0]['cash_deposit_received'];
            $objAgentPactInfo->strReceivedDate = $arrayInfo[0]['received_date'];
            settype($objAgentPactInfo->iAid,"integer");
            settype($objAgentPactInfo->iAgentId,"integer");
            settype($objAgentPactInfo->iRegAreaId,"integer");
            settype($objAgentPactInfo->iChargeAreaId,"integer");
            settype($objAgentPactInfo->iAgentMode,"integer");
            settype($objAgentPactInfo->iPreDeposit,"float");
            settype($objAgentPactInfo->iCashDeposit,"float");
            settype($objAgentPactInfo->iAreaId,"integer");
            settype($objAgentPactInfo->iPactType,"integer");
            settype($objAgentPactInfo->iPactStatus,"integer");
            settype($objAgentPactInfo->iBigregionCheck,"integer");
            settype($objAgentPactInfo->iChannelCheck,"integer");
            settype($objAgentPactInfo->iContractCheck,"integer");
            settype($objAgentPactInfo->iCreateUid,"integer");
            settype($objAgentPactInfo->iUpdateUid,"integer");
            settype($objAgentPactInfo->iRenewalCheck,"integer");
            settype($objAgentPactInfo->iRemoveSignUid,"integer");
            settype($objAgentPactInfo->iPreDepositReceived,"float");
            settype($objAgentPactInfo->iCashDepositReceived,"float");
            
        }

        return $objAgentPactInfo;
    }

    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;
        //组装sql语句
        $sqlCount = "SELECT COUNT(*) AS `counts` FROM `am_agent_pact` as A,`sys_area` as B,`sys_user` as C,`sys_product_type` as D ,`sys_user` as E, `am_agent_source` as F where $strWhere";
        $arrCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        $sqlData = "SELECT $strPageFields FROM `am_agent_pact` as A,`sys_area` as B,`sys_user` as C,`sys_product_type` as D ,`sys_user` as E, `am_agent_source` as F WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
        $iRecordCount = $arrCount;
        return $arrData;
    }

    public function updateIsCheck($sql)
    {
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function updateRemoveSign($pactID, $comment)
    {
        $sql = "update am_agent_pact set remove_sign='$comment' ,is_check=3 where aid=$pactID";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function delete($pactID)
    {
        $sql = "delete from am_agent_pact where aid=" . $pactID;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 取得合同号
     * @author liujunchen
     */
    public function getPactNO($pactId)
    {
        $sql = "SELECT pact_number FROM am_agent_pact WHERE aid = " . $pactId;
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 大区副总审核
     * @author liujunchen
     */
    public function bigBossCheck($agentId, $pactId, $checkStatus)
    {
        $sql = "UPDATE am_agent_pact SET bigregion_check = " . $checkStatus . " WHERE aid = " . $pactId . " AND agent_id = " . $agentId . "";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 渠道副总审核
     * @author liujunchen
     * 
     */
    public function bigCeoCheck($agentId, $pactId, $checkStatus)
    {
        $sql = "UPDATE am_agent_pact SET channel_check = " . $checkStatus . " WHERE aid = " . $pactId . " AND agent_id = " . $agentId . "";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 合同管理部审核
     * @author liujunchen
     */
    public function contractCheck($agentId, $pactId, $checkStatus)
    {
        $sql = "UPDATE am_agent_pact SET contract_check = " . $checkStatus . " WHERE aid = " . $pactId . " AND agent_id = " . $agentId . "";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 签约审核退回后重置为编辑状态
     * @author liujunchen
     */
    public function ReturnBackSign($pactId, $agentId)
    {
        $sql = "UPDATE am_agent_pact SET pact_status = 6 WHERE aid = " . $pactId . " AND agent_id = " . $agentId . "";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据合同Id取得合同信息
     * @author liujunchen
     */
    public function selectPactSingle($aid, $agentId=0)
    {
        $this->objMysqlDB->executeNonQuery(false, "set group_concat_max_len = 1024000000000;", null);
        $sql = "SELECT A.aid,A.agent_id,A.cur_agent_name,A.product_id,A.company_name,A.agent_mode,A.agent_level,A.area,A.pre_deposit,A.cash_deposit,A.pact_status,A.pact_sdate,A.pact_edate,A.create_time,A.pact_remark,A.pact_number,A.pact_stage,A.create_uid,A.contract_check,A.renewal_check,B.product_type_no,GROUP_CONCAT(B.product_type_name) AS product_type_name,C.user_id,C.user_name,C.e_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id LIKE CONCAT('%',B.aid,'%') JOIN sys_user C ON A.create_uid = C.user_id WHERE A.aid = " . $aid.($agentId>0?(" and A.agent_id=".$agentId):"");
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        //print_r($sql);
        if(isset($arrayData)&&count($arrayData)>0)
        {
            if($arrayData[0]["aid"] != "" || $arrayData[0]["aid"] != 0)
                return $arrayData[0];
        }
           
        
        exit("未找到对应数据！");
    }

    /**
     * @functional 取得合同号
     * @author liujunchen
     */
    public function selectPactInfo($pactId, $agentId)
    {
        $sql = "SELECT aid,agent_id,cur_agent_name,product_id,agent_mode,agent_level,pre_deposit,cash_deposit,pact_sdate,pact_edate,area,pact_number,pact_stage,pact_remark FROM am_agent_pact WHERE aid = " . $pactId . " and agent_id = " . $agentId . "";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    /**
     * @functional 取得部门签约审核列表
     * @author liujunchen
     */
    public function getPactCheckListData($strWhere = '')
    {
        $sql = "SELECT A.*,C.user_id,C.user_name,C.e_name,D.area_fullname,E.agent_no,'' as account_name 
        FROM (SELECT A.aid,A.cur_agent_name,A.agent_id,A.product_id,A.create_uid,A.reg_area_id,A.company_name,
        A.agent_level,A.pact_status,A.pact_type,A.create_time,A.bigregion_check,A.channel_check,A.contract_check,
        GROUP_CONCAT(B.product_type_name) AS product_type_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id 
        LIKE CONCAT('%',B.aid,'%')AND A.pact_status != 5 GROUP BY A.aid) A JOIN sys_user C ON A.create_uid = C.user_id 
        JOIN sys_area D ON A.reg_area_id = D.area_id JOIN am_agent_source E ON A.agent_id = E.agent_id 
         " . $strWhere . " ORDER BY A.aid ASC";
       
        $arrayPage = null;
        $arrayData = array();        
        $arrayPage = $this->getPageData($sql);
        if(isset($arrayPage["list"]) && count($arrayPage["list"]) > 0)
        {
            $arrayData = &$arrayPage["list"];
        }
                            
        $oldCreateUserID = 0;
        $tempAccountName = "";
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        foreach($arrayData as $key => $value)
        {
            if($arrayData[$key]["create_uid"] > 0)
            {
                if($oldCreateUserID != $arrayData[$key]["create_uid"])
                {
                    $tempAccountName = $objAccountGroupUserBLL->GetGroupNameByUserId($arrayData[$key]["create_uid"]);
                    $oldCreateUserID = $arrayData[$key]["create_uid"];
                }
                
                $arrayData[$key]["account_name"] = $tempAccountName;
            }
        }        
        
        return $arrayPage;
    }

    public function getMySignPageList($strWhere)
    {
        //$sql = "SELECT A.*,D.area_fullname,B.e_name,B.user_name,B.e_uid,E.agent_no,F.fr_id,F.fr_payment_id,F.fr_state,G.balance_money FROM (SELECT A.aid,A.agent_id,A.product_id,A.reg_area_id,A.company_name,A.agent_mode,A.pact_edate,A.pact_sdate,A.pact_number,A.pact_stage,A.pact_type,A.pact_status,A.create_time,A.create_uid,A.agent_level,GROUP_CONCAT(C.product_type_name) AS product_type_name FROM am_agent_pact AS A JOIN sys_product_type AS C ON A.product_id LIKE concat('%',C.aid,'%') GROUP BY A.aid) AS A LEFT JOIN sys_user B ON A.create_uid = B.user_id JOIN sys_area AS D ON A.reg_area_id = D.area_id JOIN am_agent_source AS E ON A.agent_id = E.agent_id LEFT JOIN fm_receivable_pay F ON A.aid = F.c_contract_id AND F.fr_type=1 AND F.fr_entry_type = 1 LEFT JOIN fm_agent_account AS G ON G.agent_id = A.agent_id AND G.account_type = 2 AND G.product_type_id = 0 WHERE 1=1 " . $strWhere;
        $sql = "SELECT A.*,D.area_fullname,B.e_name,B.user_name,B.e_uid,E.agent_no,
        if(F.post_money_id,F.post_money_id,0) as post_money_id,F.post_money_state FROM (
            SELECT A.aid,A.cur_agent_name,A.agent_id,
            A.product_id,A.reg_area_id,A.company_name,A.agent_mode,A.pact_edate,A.pact_sdate,A.pact_number,A.pact_stage,A.pact_type,
            A.pact_status,A.create_time,A.create_uid,A.agent_level,GROUP_CONCAT(C.product_type_name) AS product_type_name 
            FROM am_agent_pact AS A JOIN sys_product_type AS C ON A.product_id LIKE concat('%',C.aid,'%') GROUP BY A.aid
        ) AS A 
        LEFT JOIN sys_user B ON A.create_uid = B.user_id JOIN sys_area AS D ON A.reg_area_id = D.area_id 
        JOIN am_agent_source AS E ON A.agent_id = E.agent_id 
        LEFT JOIN fm_post_money F ON A.agent_id = F.agent_id AND F.post_entry_type = 1 AND F.is_del = 0 WHERE 1=1 " . $strWhere;        
        
        return  $this->getPageData($sql);
    }

    public function getSignDetailList($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount, $bExportExcel = false)
    {//when date_format(pact_edate,'%Y-%m-%d')<date_format(now(),'%Y-%m-%d') then '失效'
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex - 1) * $iPageSize;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;
        else
            $strOrder = " ORDER BY am_agent_pact.create_time DESC,am_agent_pact.pact_status ASC";
            
        $strWhere = " where 1=1 " . $strWhere;

        if($bExportExcel == false)
        {            
            $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM am_agent_pact INNER JOIN am_agent_source ON am_agent_source.agent_id = am_agent_pact.agent_id 
                inner join sys_product_type on sys_product_type.aid = am_agent_pact.product_id 
                INNER JOIN sys_user ON sys_user.user_id = am_agent_pact.create_uid $strWhere ";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        }
        
        $sqlData = "SELECT am_agent_pact.aid,am_agent_pact.agent_id,am_agent_pact.cur_agent_name,am_agent_pact.product_id,
                am_agent_pact.reg_area_id,am_agent_pact.charge_area_id,am_agent_pact.agent_mode,am_agent_pact.agent_level,
                am_agent_pact.pre_deposit,am_agent_pact.cash_deposit,am_agent_pact.pact_sdate,am_agent_pact.pact_edate,
                am_agent_pact.area,am_agent_pact.company_name,am_agent_pact.area_id,am_agent_pact.address,
                am_agent_pact.postcode,am_agent_pact.legal_person,am_agent_pact.legal_person_ID,am_agent_pact.revenue_no,
                am_agent_pact.permit_reg_no,am_agent_pact.reg_capital,am_agent_pact.charge_person,am_agent_pact.charge_phone,
                am_agent_pact.charge_tel,am_agent_pact.pact_remark,am_agent_pact.pact_type,am_agent_pact.pact_status,
                am_agent_pact.bigregion_check,am_agent_pact.channel_check,am_agent_pact.contract_check,am_agent_pact.pact_number,
                am_agent_pact.pact_stage,am_agent_pact.create_uid,am_agent_pact.update_uid,am_agent_pact.create_time,
                am_agent_pact.update_time,am_agent_pact.renewal_check,am_agent_pact.remove_sign_uid,am_agent_pact.remove_sign_user_name,
                am_agent_pact.remove_sign_time,am_agent_pact.remove_sign_remark,am_agent_pact.pre_deposit_received,
                am_agent_pact.cash_deposit_received,am_agent_pact.received_date,am_agent_pact.pact_ischange,am_agent_source.agent_no,
                am_agent_source.agent_name,am_agent_source.agent_reg_area_full_name,am_agent_source.pact_product_names,
                am_agent_source.channel_uid,am_agent_source.agent_channel_user_name,
                am_agent_source.charge_person,am_agent_source.charge_phone,am_agent_source.charge_tel,am_agent_source.charge_email,
                am_agent_source.agent_type,concat(sys_user.user_name,' ',sys_user.e_name) as create_user_name,
                sys_product_type.product_type_name as pact_product_name,
                case when date_format(am_agent_pact.pact_edate,'%Y-%m-%d')<date_format(now(),'%Y-%m-%d') then 'Q-1(失效)' 
                when am_agent_pact.pact_type=0 then '未签约' when am_agent_pact.pact_type=1 then 'Q-1(新签)' when am_agent_pact.pact_type=2 then '续签' 
                when am_agent_pact.pact_type=3 then '解除签约' else 'Q-1(失效)' end as export_pact_type,
                case am_agent_pact.agent_level when '0' then '无等级' when '1' then '金牌' else '银牌' end as export_agent_level,
                case am_agent_pact.agent_mode when 0 then '渠道代理' else '渠道商务' end as export_agent_mode,
                case  when am_agent_pact.pact_status=3 then '已解除签约'  when am_agent_pact.pact_status=0 then '未提交' when am_agent_pact.pact_status=1 then '流程中' 
                when am_agent_pact.pact_status=4 then '已失效' when am_agent_pact.pact_status=2 then '已签约'  when am_agent_pact.pact_status=5 then '保存' 
                 when am_agent_pact.pact_status=6 then '审核退回' else '合同未生效' end as export_pact_status,
                case when (am_agent_pact.pact_type<>0 and am_agent_pact.contract_check=1) then '已签约' else '流程中' end as export_liucheng_status
                FROM am_agent_pact INNER JOIN am_agent_source ON am_agent_source.agent_id = am_agent_pact.agent_id 
                inner join sys_product_type on sys_product_type.aid = am_agent_pact.product_id 
                INNER JOIN sys_user ON sys_user.user_id = am_agent_pact.create_uid $strWhere $strOrder LIMIT $offset,$iPageSize  ";

        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
        $createUserID = 0;
        $arrayCreateUserID = array();
        $tempAccountName = "";
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        foreach($arrayData as $key => $value)
        {
            $tempAccountName = "";
            $createUserID = $arrayData[$key]["channel_uid"];
            if($createUserID > 0)
            {
                if (array_key_exists($createUserID, $arrayCreateUserID))
                {
                    $tempAccountName = $arrayCreateUserID[$createUserID];
                }
                else
                {
                    $tempAccountName = $objAccountGroupUserBLL->GetGroupNameByUserId($arrayData[$key]["channel_uid"]);
                    $arrayCreateUserID[$arrayData[$key]["channel_uid"]]= $tempAccountName;
                }
            }
            $arrayData[$key]["account_name"] = $tempAccountName;
            $arrayData[$key]["agent_type_text"] = "";
            
            if($value["agent_type"] == 1)
                $arrayData[$key]["agent_type_text"] = "核心";
            else if($value["agent_type"] == 2)
                $arrayData[$key]["agent_type_text"] = "非核心";
            
            $arrayData[$key]["money_received"] = "";
            if($value["pact_type"]== 1&& ($value["pre_deposit"]+$value["cash_deposit"] > 0))
            {
                if($value["pre_deposit_received"]+$value["cash_deposit_received"] > 0)
                {
                    if($value["pre_deposit_received"]>=$value["pre_deposit"] && $value["cash_deposit_received"] >= $value["cash_deposit"])
                        $arrayData[$key]["money_received"] = "全部到账";
                    else
                        $arrayData[$key]["money_received"] = "部分到账";
                }
                else
                    $arrayData[$key]["money_received"] = "未到账";
            }
        }
        
        return $arrayData;
                    
    }

    /**
     * @functional 取得合同部签约审核列表
     * @author liujunchen
     * 
     */
    public function getContractListData($strWhere = '', $strOrder, $isDownload)
    {
        if ($strOrder == "")
            $strOrder = " A.contract_check ASC ";
        if ($strWhere == '')
        {
            $sql = "SELECT A.*,case A.agent_level when '0' then '无等级' when '1' then '金牌' else '银牌' end as level_stat,case A.contract_check when '0' then '未审核' when '1' then '审核通过' else '审核退回' end as check_stat,C.user_id,C.user_name,C.e_name,D.area_fullname,E.agent_no FROM (SELECT A.aid,A.agent_id,A.product_id,A.create_uid,A.reg_area_id,A.cur_agent_name,A.company_name,A.agent_level,A.pact_type,A.pact_sdate,A.pact_edate,A.create_time,A.cash_deposit,A.pre_deposit,A.bigregion_check,A.channel_check,A.contract_check,A.pact_number,A.pact_stage,GROUP_CONCAT(B.product_type_name) AS product_type_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id LIKE CONCAT('%',B.aid,'%') AND A.pact_status!=5 GROUP BY A.aid) A JOIN sys_user C ON A.create_uid = C.user_id JOIN sys_area D ON A.reg_area_id = D.area_id JOIN am_agent_source E ON A.agent_id = E.agent_id AND (CASE WHEN A.agent_level = '1' THEN A.bigregion_check = 1 AND A.channel_check = 1 WHEN A.agent_level = '2' THEN A.bigregion_check = 1 END) ORDER BY $strOrder";
        }
        else
        {
            $sql = "SELECT A.*,case A.agent_level when '0' then '无等级' when '1' then '金牌' else '银牌' end as level_stat,case A.contract_check when '0' then '未审核' when '1' then '审核通过' else '审核退回' end as check_stat,C.user_id,C.user_name,C.e_name,D.area_fullname,E.agent_no FROM (SELECT A.aid,A.agent_id,A.product_id,A.create_uid,A.reg_area_id,A.cur_agent_name,A.company_name,A.agent_level,A.pact_type,A.pact_sdate,A.pact_edate,A.create_time,A.cash_deposit,A.pre_deposit,A.bigregion_check,A.channel_check,A.contract_check,A.pact_number,A.pact_stage,GROUP_CONCAT(B.product_type_name) AS product_type_name FROM am_agent_pact A JOIN sys_product_type B ON A.product_id LIKE CONCAT('%',B.aid,'%') AND A.pact_status!=5 GROUP BY A.aid) A JOIN sys_user C ON A.create_uid = C.user_id JOIN sys_area D ON A.reg_area_id = D.area_id JOIN am_agent_source E ON A.agent_id = E.agent_id AND (CASE WHEN A.agent_level = '1' THEN A.bigregion_check = 1 AND A.channel_check = 1 WHEN A.agent_level = '2' THEN A.bigregion_check = 1 END) WHERE 1 = 1 " . $strWhere . " ORDER BY " . $strOrder;
        }
        
        if ($isDownload)
        {
            return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        }
        else
        {
            return $this->getPageData($sql);
        }
    }

    public function getCount($strWhere)
    {
        $sql = "SELECT if(sum(tbl.a),sum(tbl.a),0) AS A,if(SUM(tbl.b),SUM(tbl.b),0) as B,if(sum(tbl.c),sum(tbl.c),0) as C,
        if(sum(tbl.d),sum(tbl.d),0) as D,if(SUM(tbl.e),SUM(tbl.e),0) as E
        
                FROM(
                    SELECT 
                    CASE WHEN pact_type=1 THEN 1 ELSE 0 END AS 'a',
                    CASE WHEN pact_type=2 THEN 1 ELSE 0 END AS 'b',
                    CASE WHEN pact_type=4 and pact_status=4 THEN 1 ELSE 0 END AS 'c',
                    CASE WHEN pact_status=6 THEN 1 ELSE 0 end AS 'd',
                    CASE WHEN pact_type=3 and pact_status=3 THEN 1 ELSE 0 END AS 'e'
                    FROM am_agent_pact
                    $strWhere
                    ) AS tbl";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 取得代理商代理产品信息 wzx
     */
    public function GetAgentPact($agentID,$productTypeID=0)
    {
        $sWhere  = " WHERE `v_am_pact_product`.`agent_id`=$agentID ";
        if($productTypeID > 0)
            $sWhere .= " and `v_am_pact_product`.`product_type_id` = $productTypeID ";
            
        $sql = "SELECT am_agent_pact.aid as agent_pact_id,am_agent_pact.pact_number,am_agent_pact.pact_stage,
        am_agent_pact.pact_type,am_agent_pact.company_name,`am_agent_pact`.`agent_level`, `am_agent_pact`.`pact_status`,
          `am_agent_pact`.`pact_sdate`, `am_agent_pact`.`pact_edate` ,
          v_am_pact_product.`product_type_id`, `v_am_pact_product`.`product_type_no`, `v_am_pact_product`.`product_type_name`
          AS `product_type_name` 
        FROM 
          v_am_agent_pact_product as `v_am_pact_product` INNER JOIN 
          `am_agent_pact` ON `am_agent_pact`.`aid` = `v_am_pact_product`.`agent_pact_id` $sWhere 
          order by `am_agent_pact`.`pact_status`";
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 获取合同部未审核的签约数量
     * @author liujunchen
     */
    public function getSignUnCheckNum()
    {
        $sql = "SELECT COUNT(1) FROM am_agent_pact AS A WHERE (CASE WHEN A.agent_level = '1' THEN A.bigregion_check = 1 AND A.channel_check = 1 WHEN A.agent_level = '2' THEN A.bigregion_check = 1 END) AND A.contract_check = 0";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    /**
     * @functional 获取主合同合同产品号
     * @author JCL
     */
    public function selectProductID($pactId)
    {
        $sql = "select product_id from am_agent_pact where aid = $pactId";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    /**
     * @functional 获取当前审核合同时间
     * @author JCL
     */
    public function selectPactTime($pactId)
    {
        $sql = "select pact_sdate,pact_edate from am_agent_pact where aid = $pactId";
        $arrD =  $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return $arrD[0];
        
    }
    /**
     * @functional 获取主合同合同编号
     * @author JCL
     */
     public function selectMainNo($agentId,$productID)
     {
         $sql = "select pact_number from am_agent_pact where agent_id = $agentId and product_id = $productID  and pact_number != '' ";
         return $this->objMysqlDB->executeAndReturn(false, $sql, null);
     }
     
     /**
     * @functional 获取主合同合同编号出现次数
     * @author JCL
     */
     public function selectTIMEs($MainNo,$agentId)
     {
         $sql = "select count(pact_number) from am_agent_pact where agent_id = $agentId and pact_number = '$MainNo'";
         return $this->objMysqlDB->executeAndReturn(false, $sql, null);
     }
     
    /**
     * @functional 取得某代理商所代理的产品
     * @return array
     */
    public function getArrPidByAgent($agentId)
    {
        $sql = "SELECT product_id FROM am_agent_pact WHERE agent_id = $agentId AND pact_status!=3";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    /**
     * @functional 获取所有签约过的合同数据
     * @author liujunchen
    */
    public function getAllPactInfo()
    {
        $sql = "SELECT aid,pact_sdate,pact_edate FROM am_agent_pact WHERE contract_check = 1 AND pact_sdate!='' AND pact_edate!=''";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    /**
     * @functional 更改合同为失效状态
     * @author liujunchen
     * 
    */
    public function modPactOutTime($pactId)
    {
        $sql = "UPDATE am_agent_pact SET pact_status = 4,pact_type = 4 WHERE aid = " . $pactId . "";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    /**
     * @functional 取得合同的所有打款往来
     * @author liujunchen 
    */
    public function getMoneyStatList($strWhere)
    {
        $sql = "SELECT
          `fm_receivable_pay`.`fr_id`,`fm_receivable_pay`.`fr_type`,
          `fm_receivable_pay`.`fr_no`, `fm_receivable_pay`.`c_contract_id`,`fm_receivable_pay`.fr_payment_id,`fm_receivable_pay`.fr_rp_num,
          `fm_receivable_pay`.`c_contract_no`, `fm_receivable_pay`.`c_contract_type`,
          `fm_receivable_pay`.`c_contract_area`, `fm_receivable_pay`.`c_product_id`,
          `fm_receivable_pay`.`c_product_name`, fm_receivable_pay.fr_object_id,fm_receivable_pay.fr_object_name,
          `fm_receivable_pay`.`fr_rp_files`, `fm_receivable_pay`.`fr_peer_bank_id`,`fm_receivable_pay`.fr_payment_name,
          `fm_receivable_pay`.`fr_peer_bank_name`, `fm_receivable_pay`.`fr_rev_money`,`fm_receivable_pay`.`fr_peer_date`,
          `fm_receivable_pay`.`fr_pay_money`, `fm_receivable_pay`.`fr_money`,`fm_receivable_pay`.`fr_state`,
          `fm_receivable_pay`.`create_time` as post_time,
          `fm_receivable_pay`.`create_user_name` as post_user_name,`am_agent_source`.`agent_id`,
          `am_agent_source`.`agent_no`, `am_agent_source`.`agent_name`
        FROM 
          `fm_receivable_pay` LEFT JOIN 
          `am_agent_source` as am_agent_source ON `am_agent_source`.`agent_id` = `fm_receivable_pay`.`fr_object_id` 
        WHERE 1=1 $strWhere";
        //echo $sql;exit;
        return $this->getPageData($sql);
    }
    
    /**
     * @functional 每日任务，将续签合同select出来
     * @author JCL
    */
    public function getAddRenewal()
    {
        $sql = "select aid,pact_sdate,pact_edate,pact_number from am_agent_pact where pact_status = 7 and pact_number !=''" ;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    /**
     * @functional 每日任务，将续签合同之前的就合同状态置为已失效
     *                       开始生效的合同状态置为
     * @author JCL
     * $pact_number 合同号
     * $aid当前生效合同数据库自增id
    */
    public function changePactStatus($pact_number,$aid)
    {
        $sql = "update am_agent_pact set pact_status = 4 where pact_number = '$pact_number' and aid < $aid and pact_status = 2";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        $sql = "update am_agent_pact set pact_status = 2 where aid = $aid";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    /**
     * @functional 获得除开已解除签约合同以外的该代理商所有合同信息
     * @author Helen
     */
    public function getAllPactByAgent($agentId)
    {
    	$sql = "SELECT aid,agent_id,pact_type FROM am_agent_pact WHERE agent_id = $agentId AND pact_status!=3";
        
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    /**
     * @functional 更新合同转移标识
     * @author Helen
     */
    public function updateMoveStatus($aid)
    {
    	$sql = "update am_agent_pact set pact_ischange=1 where aid=$aid ";
    	return $this->objMysqlDB->executeNonQuery(false, $sql ,null);
    }
   
}
?>