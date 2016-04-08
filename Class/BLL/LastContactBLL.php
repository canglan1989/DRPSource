<?php
/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_last_contact 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2013-01-23 16:17:29
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/LastContactInfo.php';

class LastContactBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objLastContactInfo  LastContactInfo 实例
     * @return 
     */
	public function insert(LastContactInfo $objLastContactInfo)
	{
		$sql = "INSERT INTO `am_last_contact`(`agent_id`,`last_time`,`last_type`,`last_content`,`train_number`,`communicate_number`,`note_id`) 
        values(".$objLastContactInfo->iAgentId.",'".$objLastContactInfo->strLastTime."',".$objLastContactInfo->iLastType.",'".$objLastContactInfo->strLastContent."',".$objLastContactInfo->iTrainNumber.",".$objLastContactInfo->iCommunicateNumber.",{$objLastContactInfo->iNoteId})";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objLastContactInfo  LastContactInfo 实例
     * @return
     */
	public function updateByID(LastContactInfo $objLastContactInfo)
	{
	   $sql = "update `am_last_contact` set `agent_id`=".$objLastContactInfo->iAgentId.",`last_time`='".$objLastContactInfo->strLastTime."',`last_type`=".$objLastContactInfo->iLastType.",`last_content`='".$objLastContactInfo->strLastContent."',`train_number`=".$objLastContactInfo->iTrainNumber.",`communicate_number`=".$objLastContactInfo->iCommunicateNumber.",`note_id`={$objLastContactInfo->iNoteId} where id=".$objLastContactInfo->iId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
        public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `am_last_contact` set {$strSetField} where {$strWhere}";
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
			$sField = T_LastContact::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_last_contact` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 LastContactInfo 对象
	 * @param int $id 
     * @return LastContactInfo 对象
     */
	public function getModelByID($id)
	{
		$objLastContactInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objLastContactInfo = new LastContactInfo();
            		
        
            $objLastContactInfo->iId = $arrayInfo[0]['id'];
            $objLastContactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objLastContactInfo->strLastTime = $arrayInfo[0]['last_time'];
            $objLastContactInfo->iLastType = $arrayInfo[0]['last_type'];
            $objLastContactInfo->strLastContent = $arrayInfo[0]['last_content'];
            $objLastContactInfo->iTrainNumber = $arrayInfo[0]['train_number'];
            $objLastContactInfo->iCommunicateNumber = $arrayInfo[0]['communicate_number'];
            $objLastContactInfo->iNoteId = $arrayInfo[0]['note_id'];
            settype($objLastContactInfo->iId,"integer");
            settype($objLastContactInfo->iAgentId,"integer");
            settype($objLastContactInfo->iLastType,"integer");
            settype($objLastContactInfo->iTrainNumber,"integer");
            settype($objLastContactInfo->iCommunicateNumber,"integer");
            settype($objLastContactInfo->iNoteId,"integer");
        }
		return $objLastContactInfo;
       
	}
        
        public function getModelByAgentId($iAgentId)
	{
		$objLastContactInfo = null;
		$arrayInfo = $this->select("*","agent_id=".$iAgentId,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objLastContactInfo = new LastContactInfo();
            		
        
            $objLastContactInfo->iId = $arrayInfo[0]['id'];
            $objLastContactInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objLastContactInfo->strLastTime = $arrayInfo[0]['last_time'];
            $objLastContactInfo->iLastType = $arrayInfo[0]['last_type'];
            $objLastContactInfo->strLastContent = $arrayInfo[0]['last_content'];
            $objLastContactInfo->iTrainNumber = $arrayInfo[0]['train_number'];
            $objLastContactInfo->iCommunicateNumber = $arrayInfo[0]['communicate_number'];
            $objLastContactInfo->iNoteId = $arrayInfo[0]['note_id'];
            settype($objLastContactInfo->iId,"integer");
            settype($objLastContactInfo->iAgentId,"integer");
            settype($objLastContactInfo->iLastType,"integer");
            settype($objLastContactInfo->iTrainNumber,"integer");
            settype($objLastContactInfo->iCommunicateNumber,"integer");
            settype($objLastContactInfo->iNoteId,"integer");
        }
		return $objLastContactInfo;
       
	}
}
		 