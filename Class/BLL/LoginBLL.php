<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表log_login的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-4 15:37:16
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/LoginInfo.php';

class LoginBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param LoginInfo $objLoginInfo  Login实例
     * @return 
     */
	public function insert(LoginInfo $objLoginInfo)
	{
		$sql = "INSERT INTO `log_login`(`user_name`,`login_ip`,`login_time`,`login_page`,`is_success`,`err_msg`)"
		." values('".$objLoginInfo->strUserName."','".$objLoginInfo->strLoginIp."','".$objLoginInfo->strLoginTime."','".$objLoginInfo->strLoginPage."',".$objLoginInfo->iIsSuccess.",'".$objLoginInfo->strErrMsg."')";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param LoginInfo $objLoginInfo  Login实例
     * @return
     */
	public function updateByID(LoginInfo $objLoginInfo)
	{
		$sql = "update `log_login` set `user_name`='".$objLoginInfo->strUserName."',`login_ip`='".$objLoginInfo->strLoginIp."',`login_time`='".$objLoginInfo->strLoginTime."',`login_page`='".$objLoginInfo->strLoginPage."',`is_success`=".$objLoginInfo->iIsSuccess.",`err_msg`='".$objLoginInfo->strErrMsg."' where login_id=".$objLoginInfo->iLoginId;
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
			$sField = T_Login::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `log_login` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个log_login对象
	 * @param int $id 
     * @return log_login对象
     */
	public function getModelByID($id)
	{
		$objLoginInfo = null;
		$arrayInfo = $this->select("*","login_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objLoginInfo = new LoginInfo();
			$objLoginInfo->iLoginId = $arrayInfo[0]['login_id'];
			$objLoginInfo->strUserName = $arrayInfo[0]['user_name'];
			$objLoginInfo->strLoginIp = $arrayInfo[0]['login_ip'];
			$objLoginInfo->strLoginTime = $arrayInfo[0]['login_time'];
			$objLoginInfo->strLoginPage = $arrayInfo[0]['login_page'];
			$objLoginInfo->iIsSuccess = $arrayInfo[0]['is_success'];
			$objLoginInfo->strErrMsg = $arrayInfo[0]['err_msg'];
		
			settype($objLoginInfo->iLoginId,"integer");
			
			
			
			
			settype($objLoginInfo->iIsSuccess,"integer");
			
		}
		
		return $objLoginInfo;
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `log_login` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `log_login` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>