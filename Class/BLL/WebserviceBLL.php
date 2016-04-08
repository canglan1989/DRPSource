<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 log_webservice 的类业务逻辑层
 * 表描述：
 * 创建人：温智星
 * 添加时间：2012-03-26 10:45:21
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/WebserviceInfo.php';

class WebserviceBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objWebserviceInfo  WebserviceInfo 实例
     * @return 
     */
	public function insert(WebserviceInfo $objWebserviceInfo)
	{
		$sql = "INSERT INTO `log_webservice`(class_name,function_name,params,log_ip,create_uid,create_time) 
        values('".$objWebserviceInfo->strClassName."','".$objWebserviceInfo->strFunctionName."','".$objWebserviceInfo->strParams."','".$objWebserviceInfo->strLogIp."',".$objWebserviceInfo->iCreateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objWebserviceInfo  WebserviceInfo 实例
     * @return
     */
	public function updateReturnDataByID($id,$strReturnData)
	{
	   $sql = "update `log_webservice` set `return_data`='".$strReturnData."',update_time=now() where log_webservice_id=".$id;      
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
			$sField = T_Webservice::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `log_webservice` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 WebserviceInfo 对象
	 * @param int $id 
     * @return WebserviceInfo 对象
     */
	public function getModelByID($id)
	{
		$objWebserviceInfo = null;
		$arrayInfo = $this->select("*","log_webservice_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objWebserviceInfo = new WebserviceInfo();
            		
        
            $objWebserviceInfo->iLogWebserviceId = $arrayInfo[0]['log_webservice_id'];
            $objWebserviceInfo->strClassName = $arrayInfo[0]['class_name'];
            $objWebserviceInfo->strFunctionName = $arrayInfo[0]['function_name'];
            $objWebserviceInfo->strParams = $arrayInfo[0]['params'];
            $objWebserviceInfo->strLogIp = $arrayInfo[0]['log_ip'];
            $objWebserviceInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objWebserviceInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objWebserviceInfo->iLogWebserviceId,"integer");
            settype($objWebserviceInfo->iCreateUid,"integer");
            
        }
		return $objWebserviceInfo;
       
	}
}
		 