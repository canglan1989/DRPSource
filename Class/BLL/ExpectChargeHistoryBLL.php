<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_expect_charge_history 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2012-11-27 15:15:39
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ExpectChargeHistoryInfo.php';

class ExpectChargeHistoryBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objExpectChargeHistoryInfo  ExpectChargeHistoryInfo 实例
     * @return 
     */
	public function insert(ExpectChargeHistoryInfo $objExpectChargeHistoryInfo)
	{
		$sql = "INSERT INTO `am_expect_charge_history`(`agent_id`,`inten_level`,`expect_time`,`expect_money`,`expect_type`,`charge_percentage`,`create_time`,`create_uid`,`operate_time`,`operate_uid`,`product_id`) 
        values(".$objExpectChargeHistoryInfo->iAgentId.",'".$objExpectChargeHistoryInfo->strIntenLevel."','".$objExpectChargeHistoryInfo->strExpectTime."',".$objExpectChargeHistoryInfo->iExpectMoney.",".$objExpectChargeHistoryInfo->iExpectType.",".$objExpectChargeHistoryInfo->iChargePercentage.",'" . $objExpectChargeHistoryInfo->strCreateTime . "'," . $objExpectChargeHistoryInfo->iCreateUid . ",now()," . $objExpectChargeHistoryInfo->iOperateUid . ",{$objExpectChargeHistoryInfo->iProductId})";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objExpectChargeHistoryInfo  ExpectChargeHistoryInfo 实例
     * @return
     */
	public function updateByID(ExpectChargeHistoryInfo $objExpectChargeHistoryInfo)
	{
	   $sql = "update `am_expect_charge_history` set `agent_id`=".$objExpectChargeHistoryInfo->iAgentId.",`inten_level`='".$objExpectChargeHistoryInfo->strIntenLevel."',`expect_time`='".$objExpectChargeHistoryInfo->strExpectTime."',`expect_money`=".$objExpectChargeHistoryInfo->iExpectMoney.",`expect_type`=".$objExpectChargeHistoryInfo->iExpectType.",`charge_percentage`=".$objExpectChargeHistoryInfo->iChargePercentage.",`operate_time`='".$objExpectChargeHistoryInfo->strOperateTime."',`operate_uid`=".$objExpectChargeHistoryInfo->iOperateUid.",`product_id`={$objExpectChargeHistoryInfo->iProductId} where id=".$objExpectChargeHistoryInfo->iId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
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
		if($sField == "*" || $sField == "")
			$sField = T_ExpectChargeHistory::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_expect_charge_history` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 ExpectChargeHistoryInfo 对象
	 * @param int $id 
     * @return ExpectChargeHistoryInfo 对象
     */
	public function getModelByID($id)
	{
		$objExpectChargeHistoryInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objExpectChargeHistoryInfo = new ExpectChargeHistoryInfo();
            		        
            $objExpectChargeHistoryInfo->iId = $arrayInfo[0]['id'];
            $objExpectChargeHistoryInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objExpectChargeHistoryInfo->strIntenLevel = $arrayInfo[0]['inten_level'];
            $objExpectChargeHistoryInfo->strExpectTime = $arrayInfo[0]['expect_time'];
            $objExpectChargeHistoryInfo->iExpectMoney = $arrayInfo[0]['expect_money'];
            $objExpectChargeHistoryInfo->iExpectType = $arrayInfo[0]['expect_type'];
            $objExpectChargeHistoryInfo->iChargePercentage = $arrayInfo[0]['charge_percentage'];
            $objExpectChargeHistoryInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objExpectChargeHistoryInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objExpectChargeHistoryInfo->strOperateTime = $arrayInfo[0]['operate_time'];
            $objExpectChargeHistoryInfo->iOperateUid = $arrayInfo[0]['operate_uid'];
            $objExpectChargeHistoryInfo->iProductId = $arrayInfo[0]['product_id'];
            settype($objExpectChargeHistoryInfo->iId,"integer");
            settype($objExpectChargeHistoryInfo->iAgentId,"integer");
            settype($objExpectChargeHistoryInfo->iExpectMoney,"float");
            settype($objExpectChargeHistoryInfo->iExpectType,"integer");
            settype($objExpectChargeHistoryInfo->iChargePercentage,"integer");
            settype($objExpectChargeHistoryInfo->iCreateUid,"integer");
            settype($objExpectChargeHistoryInfo->iOperateUid,"integer");
            settype($objExpectChargeHistoryInfo->iProductId,"integer");
            
        }
		return $objExpectChargeHistoryInfo;
       
	}
    
    
    
    /**
     * @functional 分页数据
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount,$bExportExcel = false)
    {
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
            $strOrder = " ORDER BY `am_expect_charge_history`.id desc";
            
        if($bExportExcel == false)
        {            
            $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM 
                am_expect_charge_history
                INNER JOIN am_agent_source ON am_expect_charge_history.agent_id = am_agent_source.agent_id
                INNER JOIN sys_account_group_user ON am_agent_source.channel_uid = sys_account_group_user.user_id
                INNER JOIN sys_account_group ON sys_account_group_user.account_group_id = sys_account_group.account_group_id
                where 
                sys_account_group_user.is_del=0 and 
                sys_account_group.is_del=0 and length(sys_account_group.account_no)=2 $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        }
        
        $sqlData = "SELECT am_expect_charge_history.id,
                am_expect_charge_history.agent_id,
                am_expect_charge_history.inten_level,
                date(am_expect_charge_history.expect_time) as expect_time,
                am_expect_charge_history.expect_money,
                am_expect_charge_history.expect_type,
                concat(am_expect_charge_history.charge_percentage,'%') as charge_percentage,
                am_expect_charge_history.create_time,
                am_expect_charge_history.create_uid,
                am_agent_source.agent_no,
                am_agent_source.agent_name,
                am_agent_source.channel_uid,
                am_agent_source.agent_channel_user_name,
                sys_account_group.account_name,CONCAT(sys_user.user_name,'(',sys_user.e_name,')') as create_user_name 
                FROM 
                am_expect_charge_history 
                INNER JOIN am_agent_source ON am_expect_charge_history.agent_id = am_agent_source.agent_id 
                INNER JOIN sys_account_group_user ON am_agent_source.channel_uid = sys_account_group_user.user_id 
                INNER JOIN sys_account_group ON sys_account_group_user.account_group_id = sys_account_group.account_group_id 
                INNER JOIN sys_user ON sys_user.user_id = am_expect_charge_history.create_uid 
                where 
                sys_account_group_user.is_del=0 and 
                sys_account_group.is_del=0 and length(sys_account_group.account_no)=2 
                $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

}
		 