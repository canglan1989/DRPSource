<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 rpt_agent_intention_rating 的类业务逻辑层
 * 表描述：代理商客服网盟意向等级统计 
 * 创建人：任一峰
 * 添加时间：2012-10-30 09:46:48
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentIntentionRatingInfo.php';

class AgentIntentionRatingBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    /*
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
			$sField = T_AgentIntentionRating::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `rpt_agent_intention_rating` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgentIntentionRatingInfo 对象
     * @return AgentIntentionRatingInfo 对象
     */
	public function getModelByID($agentId,$userId,$reportDate)
	{
		$objAgentIntentionRatingInfo = null;
		$arrayInfo = $this->select("*","agent_id = $agentId and user_id = $userId and report_date ='$reportDate'","");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentIntentionRatingInfo = new AgentIntentionRatingInfo();
            		        
            $objAgentIntentionRatingInfo->strReportDate = $arrayInfo[0]['report_date'];
            $objAgentIntentionRatingInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentIntentionRatingInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objAgentIntentionRatingInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objAgentIntentionRatingInfo->iUserId = $arrayInfo[0]['user_id'];
            $objAgentIntentionRatingInfo->strUserName = $arrayInfo[0]['user_name'];
            $objAgentIntentionRatingInfo->iChannelUid = $arrayInfo[0]['channel_uid'];
            $objAgentIntentionRatingInfo->strChannelUserName = $arrayInfo[0]['channel_user_name'];
            $objAgentIntentionRatingInfo->iOrderCount = $arrayInfo[0]['order_count'];
            $objAgentIntentionRatingInfo->iIncomeMoney = $arrayInfo[0]['income_money'];
            $objAgentIntentionRatingInfo->iChargeCount = $arrayInfo[0]['charge_count'];
            $objAgentIntentionRatingInfo->iChargeMoney = $arrayInfo[0]['charge_money'];
            $objAgentIntentionRatingInfo->iDe2a = $arrayInfo[0]['de2a'];
            $objAgentIntentionRatingInfo->iBm2a = $arrayInfo[0]['bm2a'];
            $objAgentIntentionRatingInfo->iDe2bp = $arrayInfo[0]['de2bp'];
            $objAgentIntentionRatingInfo->iBm2bp = $arrayInfo[0]['bm2bp'];
            $objAgentIntentionRatingInfo->iBm2de = $arrayInfo[0]['bm2de'];
            $objAgentIntentionRatingInfo->iDe2bm = $arrayInfo[0]['de2bm'];
            $objAgentIntentionRatingInfo->iBp2bm = $arrayInfo[0]['bp2bm'];
            $objAgentIntentionRatingInfo->iBp2a = $arrayInfo[0]['bp2a'];
            $objAgentIntentionRatingInfo->iBp2de = $arrayInfo[0]['bp2de'];
            $objAgentIntentionRatingInfo->iA2bp = $arrayInfo[0]['a2bp'];
            $objAgentIntentionRatingInfo->iA2bm = $arrayInfo[0]['a2bm'];
            $objAgentIntentionRatingInfo->iA2de = $arrayInfo[0]['a2de'];
            $objAgentIntentionRatingInfo->iRating1 = $arrayInfo[0]['rating_1'];
            $objAgentIntentionRatingInfo->iRating2 = $arrayInfo[0]['rating_2'];
            $objAgentIntentionRatingInfo->iRating3 = $arrayInfo[0]['rating_3'];
            $objAgentIntentionRatingInfo->iRating4 = $arrayInfo[0]['rating_4'];
            $objAgentIntentionRatingInfo->iRating5 = $arrayInfo[0]['rating_5'];
            $objAgentIntentionRatingInfo->iRating6 = $arrayInfo[0]['rating_6'];
            $objAgentIntentionRatingInfo->iRating7 = $arrayInfo[0]['rating_7'];
            settype($objAgentIntentionRatingInfo->iAgentId,"integer");
            settype($objAgentIntentionRatingInfo->iUserId,"integer");
            settype($objAgentIntentionRatingInfo->iChannelUid,"integer");
            settype($objAgentIntentionRatingInfo->iOrderCount,"integer");
            settype($objAgentIntentionRatingInfo->iIncomeMoney,"float");
            settype($objAgentIntentionRatingInfo->iChargeCount,"integer");
            settype($objAgentIntentionRatingInfo->iChargeMoney,"float");
            settype($objAgentIntentionRatingInfo->iDe2a,"integer");
            settype($objAgentIntentionRatingInfo->iBm2a,"integer");
            settype($objAgentIntentionRatingInfo->iDe2bp,"integer");
            settype($objAgentIntentionRatingInfo->iBm2bp,"integer");
            settype($objAgentIntentionRatingInfo->iBm2de,"integer");
            settype($objAgentIntentionRatingInfo->iDe2bm,"integer");
            settype($objAgentIntentionRatingInfo->iBp2bm,"integer");
            settype($objAgentIntentionRatingInfo->iBp2a,"integer");
            settype($objAgentIntentionRatingInfo->iBp2de,"integer");
            settype($objAgentIntentionRatingInfo->iA2bp,"integer");
            settype($objAgentIntentionRatingInfo->iA2bm,"integer");
            settype($objAgentIntentionRatingInfo->iA2de,"integer");
            settype($objAgentIntentionRatingInfo->iRating1,"integer");
            settype($objAgentIntentionRatingInfo->iRating2,"integer");
            settype($objAgentIntentionRatingInfo->iRating3,"integer");
            settype($objAgentIntentionRatingInfo->iRating4,"integer");
            settype($objAgentIntentionRatingInfo->iRating5,"integer");
            settype($objAgentIntentionRatingInfo->iRating6,"integer");
            settype($objAgentIntentionRatingInfo->iRating7,"integer");
            
        }
		return $objAgentIntentionRatingInfo;
       
	}
    
    /**
     * 插入一条记录操作，有则不插入
     * @author wzx
    */
    public function insertData($agentId,$userId,$reportDate)
    {
        $sql = "SELECT 1 FROM rpt_agent_intention_rating where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'";
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
                
            $sql = "insert into rpt_agent_intention_rating (report_date,agent_id,agent_no,agent_name,
                user_id,user_name,channel_uid,channel_user_name) 
                values('$reportDate',$agentId,'$agent_no','{$agent_name}',$userId,'{$user_name}',$channel_uid,'{$channel_name}')";
            //print_r($sql);
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
    }
    
    
    //后台管理begin
    //获取网盟意向统计数据
    
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
    		$sqlCount = "SELECT  COUNT(acr.agent_id) AS `recordCount` from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere ";
    
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
         sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,
         sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7,sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,
         sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.agent_id $strOrder LIMIT $offset,$iPageSize";
         // print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    //获取网盟意向总计数据
    public function getIntentionTotalNum($strWhere)
    {
        $sql = "select sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,
        sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
                
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取网盟意向等级统计导出数据列表
     * @author     ryf
     */
    public function exportIntentionRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
         sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,
         sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7,sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,
         sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.agent_id $strOrder";
                
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    //获取预计到账统计数据
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
    		$sqlCount = "SELECT COUNT(acr.agent_id) AS `recordCount` from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
    
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
            sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.agent_id $strOrder LIMIT $offset,$iPageSize";
         // print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}


    //获取预计到账总计数据
    public function getEstimateTotalNum($strWhere)
    {
        $sql = "select sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere ";
        
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取预计到账导出数据列表
     * @author     ryf
     */
    public function exportEstimateRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
            sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.agent_id $strOrder";
             
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    //获取转化率数据
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
	public function selectPaged3($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
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
    		$sqlCount = "SELECT  COUNT(acr.agent_id) AS `recordCount` 
             from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere ";
    
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
        sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a,
        sum(acr.a2bp) as a2bp,sum(acr.a2bm) as a2bm,sum(acr.a2de) as a2de,sum(acr.bp2bm) as bp2bm,sum(acr.bp2de) as bp2de,sum(acr.bm2de) as bm2de
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.agent_id $strOrder LIMIT $offset,$iPageSize";
         // print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    //获取转化率总计数据
    public function getConversionTotalNum($strWhere)
    {
       
        $sql = "select avg(tb.de2bm) as de2bm,avg(tb.de2bp) as de2bp,avg(tb.de2a) as de2a,avg(tb.bm2bp) as bm2bp,avg(tb.bp2a) as bp2a,avg(tb.bm2a) as bm2a
        from(select sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a
          from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.agent_id) tb";
        $sql .= " ";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取意向转化率导出数据列表
     * @author     ryf
     */
    public function exportConversionRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.agent_id,acr.agent_no,max(acr.agent_name) as agent_name,max(acr.channel_user_name) as channel_user_name,max(acr.channel_uid) as channel_uid,
        sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a,
        sum(acr.a2bp) as a2bp,sum(acr.a2bm) as a2bm,sum(acr.a2de) as a2de,sum(acr.bp2bm) as bp2bm,sum(acr.bp2de) as bp2de,sum(acr.bm2de) as bm2de
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.agent_id $strOrder";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //后台管理end
    
    //前台管理begin
    //获取网盟意向统计数据
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
	public function selectPaged4($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
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
    		$sqlCount = "SELECT  COUNT(acr.user_id) as uid_count from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
    
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.user_id,max(acr.user_name) as user_name,
         sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,
         sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7,sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,
         sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.user_id $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}

    //获取网盟意向总计数据
    public function getIntentionFroTotalNum($strWhere)
    {
        
        $sql = "select 
         sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,
         sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7,sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,
         sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
               
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取网盟意向等级统计导出数据列表
     * @author     ryf
     */
    public function exportIntentionFroRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.user_id,max(acr.user_name) as user_name,
         sum(acr.rating_1) as rating_1,sum(acr.rating_2) as rating_2,sum(acr.rating_3) as rating_3,sum(acr.rating_4) as rating_4,sum(acr.rating_5) as rating_5,
         sum(acr.rating_6) as rating_6,sum(acr.rating_7) as rating_7,sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,
         sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.user_id $strOrder";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    
    //获取预计到账统计数据   
    public function getEstimateFroData($strWhere)
    {
        
        $sql = "select acr.report_date,
            sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.report_date";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //获取预计到账总计数据
    public function getEstimateFroTotalNum($sWhere)
    {
        
        $sql = "select sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $sWhere";
        
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取预计到账导出数据列表
     * @author     ryf
     */
    public function exportEstimateFroRptData($sWhere)
    {
        
        $sql = "select acr.report_date,
            sum(acr.income_money) as income_money,sum(acr.order_count) as order_count,sum(acr.charge_money) as charge_money,sum(acr.charge_count) as charge_count
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $sWhere group by acr.report_date";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //获取转化率数据
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
	public function selectPaged5($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel = false)
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
    		$sqlCount = "SELECT  COUNT(acr.user_id) AS `recordCount` from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        $sqlData  = "select acr.user_id,max(acr.user_name) as user_name,
        sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a,
        sum(acr.a2bp) as a2bp,sum(acr.a2bm) as a2bm,sum(acr.a2de) as a2de,sum(acr.bp2bm) as bp2bm,sum(acr.bp2de) as bp2de,sum(acr.bm2de) as bm2de
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere  group by acr.user_id $strOrder LIMIT $offset,$iPageSize";
         // print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    //获取转化率总计数据
    public function getConversionFroTotalNum($strWhere)
    {
        $sql = "select 
        sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a,
        sum(acr.a2bp) as a2bp,sum(acr.a2bm) as a2bm,sum(acr.a2de) as a2de,sum(acr.bp2bm) as bp2bm,sum(acr.bp2de) as bp2de,sum(acr.bm2de) as bm2de
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere";
        
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
        
    }
    
    /**
     * @functional 获取意向转化率导出数据列表
     * @author     ryf
     */
    public function exportConversionFroRptData($strWhere,$strOrder)
    {
        if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        $sql = "select acr.user_id,max(acr.user_name) as user_name,
        sum(acr.de2bm) as de2bm,sum(acr.de2bp) as de2bp,sum(acr.de2a) as de2a,sum(acr.bm2bp) as bm2bp,sum(acr.bp2a) as bp2a,sum(acr.bm2a) as bm2a,
        sum(acr.a2bp) as a2bp,sum(acr.a2bm) as a2bm,sum(acr.a2de) as a2de,sum(acr.bp2bm) as bp2bm,sum(acr.bp2de) as bp2de,sum(acr.bm2de) as bm2de
         from rpt_agent_intention_rating acr 
         inner join sys_user on sys_user.user_id = acr.user_id where 1=1 $strWhere group by acr.user_id $strOrder";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //前台管理end
    
    
}
		 