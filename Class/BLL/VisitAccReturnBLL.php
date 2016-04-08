<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_acc_return 的类业务逻辑层
 * 表描述：
 * 创建人：许丹丹
 * 添加时间：2012-04-24 15:33:08
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitAccReturnInfo.php';

class VisitAccReturnBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objVisitAccReturnInfo  VisitAccReturnInfo 实例
     * @return 
     */
	public function insert(VisitAccReturnInfo $objVisitAccReturnInfo)
	{
		$sql = "INSERT INTO `am_visit_acc_return`(`accoID`,`content`,`return_time`,`add_time`,`add_user_id`) 
        values(".$objVisitAccReturnInfo->iAccoid.",'".$objVisitAccReturnInfo->strContent."','".$objVisitAccReturnInfo->strReturnTime."',now(),".$objVisitAccReturnInfo->iAddUserId.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objVisitAccReturnInfo  VisitAccReturnInfo 实例
     * @return
     */
	public function updateByID(VisitAccReturnInfo $objVisitAccReturnInfo)
	{
	   $sql = "update `am_visit_acc_return` set `accoID`=".$objVisitAccReturnInfo->iAccoid.",`content`='".$objVisitAccReturnInfo->strContent."',`return_time`='".$objVisitAccReturnInfo->strReturnTime."',`add_time`='".$objVisitAccReturnInfo->strAddTime."',`add_user_id`=".$objVisitAccReturnInfo->iAddUserId." where id=".$objVisitAccReturnInfo->iId;      
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
			$sField = T_VisitAccReturn::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_visit_acc_return` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 VisitAccReturnInfo 对象
	 * @param int $id 
     * @return VisitAccReturnInfo 对象
     */
	public function getModelByID($id)
	{
		$objVisitAccReturnInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitAccReturnInfo = new VisitAccReturnInfo();
            		
        
            $objVisitAccReturnInfo->iId = $arrayInfo[0]['id'];
            $objVisitAccReturnInfo->iAccoid = $arrayInfo[0]['accoID'];
            $objVisitAccReturnInfo->strContent = $arrayInfo[0]['content'];
            $objVisitAccReturnInfo->strReturnTime = $arrayInfo[0]['return_time'];
            $objVisitAccReturnInfo->strAddTime = $arrayInfo[0]['add_time'];
            $objVisitAccReturnInfo->iAddUserId = $arrayInfo[0]['add_user_id'];
            settype($objVisitAccReturnInfo->iId,"integer");
            settype($objVisitAccReturnInfo->iAccoid,"integer");
            settype($objVisitAccReturnInfo->iAddUserId,"integer");
            
        }
		return $objVisitAccReturnInfo;
       
	}
}
		 