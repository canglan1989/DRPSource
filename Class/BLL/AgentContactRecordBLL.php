<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 rpt_agent_contact_record 的类业务逻辑层
 * 表描述：代理商客服联系量统计 
 * 创建人：ryf
 * 添加时间：2012-10-23 17:31:52
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentContactRecordInfo.php';

class AgentContactRecordBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
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
			$sField = T_AgentContactRecord::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `rpt_agent_contact_record` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgentContactRecordInfo 对象
     * @return AgentContactRecordInfo 对象
     */
	public function getModelByID($agentId,$userId,$reportDate)
	{
		$objAgentContactRecordInfo = null;
		$arrayInfo = $this->select("*","agent_id = $agentId and user_id = $userId and report_date ='$reportDate'","");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentContactRecordInfo = new AgentContactRecordInfo();
        
            $objAgentContactRecordInfo->strReportDate = $arrayInfo[0]['report_date'];
            $objAgentContactRecordInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentContactRecordInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objAgentContactRecordInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objAgentContactRecordInfo->iUserId = $arrayInfo[0]['user_id'];
            $objAgentContactRecordInfo->strUserName = $arrayInfo[0]['user_name'];
            $objAgentContactRecordInfo->iRecordCount = $arrayInfo[0]['record_count'];
            $objAgentContactRecordInfo->iValidCount = $arrayInfo[0]['valid_count'];
            $objAgentContactRecordInfo->iValidRate = $arrayInfo[0]['valid_rate'];
            $objAgentContactRecordInfo->iVisitCount = $arrayInfo[0]['visit_count'];
            $objAgentContactRecordInfo->iChannelUid = $arrayInfo[0]['channel_uid'];
            $objAgentContactRecordInfo->strChannelUserName = $arrayInfo[0]['channel_user_name'];
            settype($objAgentContactRecordInfo->iAgentId,"integer");
            settype($objAgentContactRecordInfo->iUserId,"integer");
            settype($objAgentContactRecordInfo->iRecordCount,"integer");
            settype($objAgentContactRecordInfo->iValidCount,"integer");
            settype($objAgentContactRecordInfo->iValidRate,"float");
            settype($objAgentContactRecordInfo->iVisitCount,"integer");
            settype($objAgentContactRecordInfo->iChannelUid,"integer");
            
        }
		return $objAgentContactRecordInfo;
       
	}
    //后台客户管理begin
    //获取通联系量数据
    
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(*) from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.agent_id";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
        sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.agent_id $strOrder LIMIT $offset,$iPageSize";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        
        return  $arrayData;	
	}
    
    
    
    public function getTotalNum($strWhere)
    {
        $sql = "select sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        
        return  $arrayData[0];
        
    }
    
    /**
     * @functional 获取联系量导出数据列表
     * @author     ryf
     */
    public function exportContactRecordRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
        sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.agent_id $strOrder";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        
        return  $arrayData;
    }
    ///后台客户管理end
    
    //前台客户管理begin
    //获取通联系量数据
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
	public function selectPaged2($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
	{
	   $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
        if($bExportExcel == false)
        {
    		$sqlCount = "SELECT  COUNT(*) from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.user_id";
    
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.user_id,max(acr.user_name) as user_name,
        sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.user_id $strOrder LIMIT $offset,$iPageSize";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        return  $arrayData;
	}
  
    public function getFroTotalNum($strWhere)
    {        
        $sql = "select 
        sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        
        return  $arrayData[0];        
    }
    
    /**
     * @functional 获取联系量导出数据列表
     * @author     ryf
     */
    public function exportContactRecordFroRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.user_id,max(acr.user_name) as user_name,
        sum(acr.valid_count) as valid_count,sum(acr.record_count-acr.valid_count) as invalid_count,sum(acr.record_count) as record_count,
        0 as valid_rate,sum(acr.visit_count) as visit_count
         from rpt_agent_contact_record acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.user_id $strOrder";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        foreach($arrayData as $key => $value)
        {
            if($value["record_count"] != "" && $value["record_count"] > 0)
                $arrayData[$key]["valid_rate"]= $value["valid_count"]/$value["record_count"];
        }
        
        return  $arrayData;
    }
    
    //前台客户管理end
    
    
    
    /**
     * 插入一条记录操作，有则不插入
     * @author wzx
    */
    public function insertData($agentId,$userId,$reportDate)
    {
        $sql = "SELECT 1 FROM rpt_agent_contact_record where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(!(isset($arrayData) && count($arrayData) > 0))
        {
            $agent_no = "";
            $agent_name = "";
            $channel_uid = 0;//渠道经理ID
            $channel_name = "";
            
            $sql = "select am_agent_source.agent_no,am_agent_source.agent_name,am_agent_source.channel_uid,
            concat(sys_user.user_name,' ',sys_user.e_name) as channel_name from am_agent_source left join sys_user 
            on sys_user.user_id=am_agent_source.channel_uid where am_agent_source.agent_id=".$agentId;
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if(isset($arrayData) && count($arrayData) > 0)
            {
                $agent_no = $arrayData[0]["agent_no"];
                $agent_name = $arrayData[0]["agent_name"];
                $channel_uid = $arrayData[0]["channel_uid"];
                $channel_name = $arrayData[0]["channel_name"];
            }
            
            $user_name = "";
            $sql = "select concat(user_name,' ',e_name) as user_name from sys_user where user_id=".$userId;
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if(isset($arrayData) && count($arrayData) > 0)
                $user_name =$arrayData[0]["user_name"];
                
            $sql = "insert into rpt_agent_contact_record (report_date,agent_id,agent_no,agent_name,
                user_id,user_name,channel_uid,channel_user_name) 
                values('$reportDate',$agentId,'$agent_no','{$agent_name}',$userId,'{$user_name}',$channel_uid,'{$channel_name}')";
            //print_r($sql);
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
    }
    
    
    
}
		 