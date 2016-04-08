<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表om_audit_allolt的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-22 20:50:39
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AuditAlloltInfo.php';

class AuditAlloltBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AuditAlloltInfo $objAuditAlloltInfo  AuditAllolt实例
     * @return 
     */
	public function insert(AuditAlloltInfo $objAuditAlloltInfo)
	{
		$sql = "INSERT INTO `om_audit_allolt`(`order_id`,`audit_uid`,`allolt_remark`,`create_uid`,`create_time`,`is_del`)"
		." values(".$objAuditAlloltInfo->iOrderId.",".$objAuditAlloltInfo->iAuditUid.",'".$objAuditAlloltInfo->strAlloltRemark."',".$objAuditAlloltInfo->iCreateUid.",now(),".$objAuditAlloltInfo->iIsDel.")";

        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}
	
	/**
     * @functional 新增记录
     * @param 
     * @return 插入记录数
     */
    public function AddAuditer($iAlloltUid,$iAuditUid,$strReamrk,$strOrderIDs)
    {
        if($strOrderIDs == "" || $strOrderIDs == "0")
            return 0;
            
        $insertCount = 0;
        $arrayOrderID = explode(",",$strOrderIDs);
        $arrayLength = count($arrayOrderID);
        $objAuditAlloltInfo = new AuditAlloltInfo();
        $objAuditAlloltInfo->iAuditUid = $iAuditUid;
        $objAuditAlloltInfo->iCreateUid = $iAlloltUid;
        $objAuditAlloltInfo->strAlloltRemark = $strReamrk;
        
        for($i = 0;$i < $arrayLength; $i++)
        { 
            settype($arrayOrderID[$i],"integer");
            if($arrayOrderID[$i] > 0)
            {
                $this->deleteByID($arrayOrderID[$i]);
                $objAuditAlloltInfo->iOrderId = $arrayOrderID[$i];
                $insertCount += $this->insert($objAuditAlloltInfo);
            }                
        }
        
        return $insertCount;
    }
    
	/**
     * @functional 根据ID更新一条记录
     * @param AuditAlloltInfo $objAuditAlloltInfo  AuditAllolt实例
     * @return
     */
	public function updateByID(AuditAlloltInfo $objAuditAlloltInfo)
	{
		$sql = "update `om_audit_allolt` set `order_id`=".$objAuditAlloltInfo->iOrderId.",`audit_uid`=".$objAuditAlloltInfo->iAuditUid.",`allolt_remark`='".$objAuditAlloltInfo->strAlloltRemark."',`is_del`=".$objAuditAlloltInfo->iIsDel." where audit_allolt_id=".$objAuditAlloltInfo->iAuditAlloltId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $iOrderId 
     * @return 
     */
    public function deleteByID($iOrderId)
    {
		$sql = "update `om_audit_allolt` set is_del=1 where order_id=".$iOrderId;
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
			$sField = T_AuditAllolt::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `om_audit_allolt` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个om_audit_allolt对象
	 * @param int $id 
     * @return om_audit_allolt对象
     */
	public function getModelByID($id)
	{
		$objAuditAlloltInfo = null;
		$arrayInfo = $this->select("*","audit_allolt_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAuditAlloltInfo = new AuditAlloltInfo();
			$objAuditAlloltInfo->iAuditAlloltId = $arrayInfo[0]['audit_allolt_id'];
			$objAuditAlloltInfo->iOrderId = $arrayInfo[0]['order_id'];
			$objAuditAlloltInfo->iAuditUid = $arrayInfo[0]['audit_uid'];
			$objAuditAlloltInfo->strAlloltRemark = $arrayInfo[0]['allolt_remark'];
			$objAuditAlloltInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAuditAlloltInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objAuditAlloltInfo->iIsDel = $arrayInfo[0]['is_del'];
		
			settype($objAuditAlloltInfo->iAuditAlloltId,"integer");
			settype($objAuditAlloltInfo->iOrderId,"integer");
			settype($objAuditAlloltInfo->iAuditUid,"integer");
			
			settype($objAuditAlloltInfo->iCreateUid,"integer");
			
			settype($objAuditAlloltInfo->iIsDel,"integer");
		}
		
		return $objAuditAlloltInfo;
	}
	
}
?>
