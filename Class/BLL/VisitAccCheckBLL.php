<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_acc_check 的类业务逻辑层
 * 表描述：
 * 创建人：许丹丹
 * 添加时间：2012-04-24 16:27:18
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitAccCheckInfo.php';

class VisitAccCheckBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objVisitAccCheckInfo  VisitAccCheckInfo 实例
     * @return 
     */
	public function insert(VisitAccCheckInfo $objVisitAccCheckInfo)
	{
		$sql = "INSERT INTO `am_visit_acc_check`(`accoID`,`detial`,`check_time`,`check_statu`,`check_uid`) 
        values(".$objVisitAccCheckInfo->iAccoid.",'".$objVisitAccCheckInfo->strDetial."','".$objVisitAccCheckInfo->strCheckTime."',".$objVisitAccCheckInfo->iCheckStatu.",".$objVisitAccCheckInfo->iCheckUid.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objVisitAccCheckInfo  VisitAccCheckInfo 实例
     * @return
     */
	public function updateByID(VisitAccCheckInfo $objVisitAccCheckInfo)
	{
	   $sql = "update `am_visit_acc_check` set `accoID`=".$objVisitAccCheckInfo->iAccoid.",`detial`='".$objVisitAccCheckInfo->strDetial."',`check_time`='".$objVisitAccCheckInfo->strCheckTime."',`check_statu`=".$objVisitAccCheckInfo->iCheckStatu.",`check_uid`=".$objVisitAccCheckInfo->iCheckUid." where id=".$objVisitAccCheckInfo->iId;      
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
			$sField = T_VisitAccCheck::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_visit_acc_check` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 VisitAccCheckInfo 对象
	 * @param int $id 
     * @return VisitAccCheckInfo 对象
     */
	public function getModelByID($id)
	{
		$objVisitAccCheckInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitAccCheckInfo = new VisitAccCheckInfo();
            		
        
            $objVisitAccCheckInfo->iId = $arrayInfo[0]['id'];
            $objVisitAccCheckInfo->iAccoid = $arrayInfo[0]['accoID'];
            $objVisitAccCheckInfo->strDetial = $arrayInfo[0]['detial'];
            $objVisitAccCheckInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objVisitAccCheckInfo->iCheckStatu = $arrayInfo[0]['check_statu'];
            $objVisitAccCheckInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            settype($objVisitAccCheckInfo->iId,"integer");
            settype($objVisitAccCheckInfo->iAccoid,"integer");
            settype($objVisitAccCheckInfo->iCheckStatu,"integer");
            settype($objVisitAccCheckInfo->iCheckUid,"integer");
            
        }
		return $objVisitAccCheckInfo;
       
	}
}
		 