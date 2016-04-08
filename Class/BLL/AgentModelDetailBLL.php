<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_agent_model_detail 的类业务逻辑层
 * 表描述：代理商充值销奖比例设置 
 * 创建人：温智星
 * 添加时间：2012-09-14 16:15:51
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentModelDetailInfo.php';

class AgentModelDetailBLL extends BLLBase
{
    const maxMoneyValue = 999999999;
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objAgentModelDetailInfo  AgentModelDetailInfo 实例
     * @return 
     */
	public function insert(AgentModelDetailInfo $objAgentModelDetailInfo)
	{
		$sql = "INSERT INTO `sys_agent_model_detail`(`agent_model_id`,`agent_id`,`data_index`,`range`,`money`,`rate`) 
        values(".$objAgentModelDetailInfo->iAgentModelId.",".$objAgentModelDetailInfo->iAgentId.",".$objAgentModelDetailInfo->iDataIndex.",".$objAgentModelDetailInfo->iRange.",".$objAgentModelDetailInfo->iMoney.",".$objAgentModelDetailInfo->iRate.")";

        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgentModelDetailInfo  AgentModelDetailInfo 实例
     * @return
     */
	public function updateByID(AgentModelDetailInfo $objAgentModelDetailInfo)
	{
	   $sql = "update `sys_agent_model_detail` set `agent_model_id`=".$objAgentModelDetailInfo->iAgentModelId.",`agent_id`=".$objAgentModelDetailInfo->iAgentId.",`data_index`=".$objAgentModelDetailInfo->iDataIndex.",`range`=".$objAgentModelDetailInfo->iRange.",`money`=".$objAgentModelDetailInfo->iMoney.",`rate`=".$objAgentModelDetailInfo->iRate." where agent_model_detail_id=".$objAgentModelDetailInfo->iAgentModelDetailId;      
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
			$sField = T_AgentModelDetail::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_agent_model_detail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgentModelDetailInfo 对象
	 * @param int $id 
     * @return AgentModelDetailInfo 对象
     */
	public function getModelByID($id)
	{
		$objAgentModelDetailInfo = null;
		$arrayInfo = $this->select("*","agent_model_detail_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentModelDetailInfo = new AgentModelDetailInfo();
            		        
            $objAgentModelDetailInfo->iAgentModelDetailId = $arrayInfo[0]['agent_model_detail_id'];
            $objAgentModelDetailInfo->iAgentModelId = $arrayInfo[0]['agent_model_id'];
            $objAgentModelDetailInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentModelDetailInfo->iDataIndex = $arrayInfo[0]['data_index'];
            $objAgentModelDetailInfo->iRange = $arrayInfo[0]['range'];
            $objAgentModelDetailInfo->iMoney = $arrayInfo[0]['money'];
            $objAgentModelDetailInfo->iRate = $arrayInfo[0]['rate'];
            settype($objAgentModelDetailInfo->iAgentModelDetailId,"integer");
            settype($objAgentModelDetailInfo->iAgentModelId,"integer");
            settype($objAgentModelDetailInfo->iAgentId,"integer");
            settype($objAgentModelDetailInfo->iDataIndex,"integer");
            settype($objAgentModelDetailInfo->iRange,"integer");
            settype($objAgentModelDetailInfo->iMoney,"float");
            settype($objAgentModelDetailInfo->iRate,"float");
            
        }
		return $objAgentModelDetailInfo;
       
	}
    /**
     * @functional 代理商返点比例明细
    */
    public function GetUnitSaleRewardDetail($agentID)
    {
        return $this->select("*","agent_id=".$agentID,"data_index");
    }
    
    
    public function UpdateUnitSaleRewardModel($agentID,$iUnitSaleRewardModelID,$aRange,$aMoney,$aRate)
    {
        $sql = "delete from sys_agent_model_detail where agent_id=".$agentID;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        $objAgentModelDetailInfo = new AgentModelDetailInfo();
        $objAgentModelDetailInfo->iAgentModelId = $iUnitSaleRewardModelID;
        $objAgentModelDetailInfo->iAgentId = $agentID;
        $rateCount = count($aRate);
        foreach($aRate as $key => $value)
        {                
            $objAgentModelDetailInfo->iDataIndex = $key;
            $objAgentModelDetailInfo->iRate = $value;
            if($key == $rateCount-1)//为最后一个的时候
            {                        
                $objAgentModelDetailInfo->iRange = 0;
                $objAgentModelDetailInfo->iMoney = AgentModelDetailBLL::maxMoneyValue;
            }
            else
            {
                $objAgentModelDetailInfo->iRange = $aRange[$key];
                $objAgentModelDetailInfo->iMoney = $aMoney[$key];
            }
            $this->insert($objAgentModelDetailInfo);
        }
        
        return true;
    }
    

    /**
     * @functional  返点金额
    */
    public function GetUnitSaleRewardMoney($agentID,$postMoney)
    {
        if($postMoney<=0)
            return 0;
        
        $arrayData = $this->GetUnitSaleRewardDetail($agentID);
        //print_r($arrayData);
        $arrayLength = count($arrayData);
        if($arrayLength == 0)
            return 0;
            
        $perRange = 1;
        $perMoney = 0;
        $sql = "select ";
        for($i=0;$i<$arrayLength;$i++)
        {
            $sql .= "if($perMoney".($perRange==1?"<":"<=").$postMoney." and $postMoney".($arrayData[$i]["range"]==0?"<":"<=").$arrayData[$i]["money"].",".$arrayData[$i]["rate"].",";
            
            $perRange = $arrayData[$i]["range"];
            $perMoney = $arrayData[$i]["money"];
        }
        
        $sql .= "0";
        for($i=0;$i<$arrayLength;$i++)
        {
            $sql .= ")";
        }
        $sql .= " as rate";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
		if (isset($arrayData)&& count($arrayData)>0)
            return round($postMoney*$arrayData[0]["rate"]/100,2);
            
        return 0;
    }
}
		 