<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_log_customer的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/LogCustomerInfo.php';

class LogCustomerBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objLogCustomerInfo  LogCustomer实例
     * @return 
     */
	public function insert(LogCustomerInfo $objLogCustomerInfo)
	{
		$sql = "INSERT INTO `cm_log_customer`(`cm_log_customer.customer_id`,`cm_log_customer.change_values`,`cm_log_customer.create_time`,`cm_log_customer.create_uid`)"
		." values(".$objLogCustomerInfo->iCustomerId.",'".$objLogCustomerInfo->strChangeValues."',".$objLogCustomerInfo->iCreateTime.",".$objLogCustomerInfo->iCreateUid.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objLogCustomerInfo  LogCustomer实例
     * @return
     */
	public function updateByID(LogCustomerInfo $objLogCustomerInfo)
	{
		$sql = "update `cm_log_customer` set `cm_log_customer.customer_id`=".$objLogCustomerInfo->iCustomerId.",`cm_log_customer.change_values`='".$objLogCustomerInfo->strChangeValues."',`cm_log_customer.create_time`=".$objLogCustomerInfo->iCreateTime.",`cm_log_customer.create_uid`=".$objLogCustomerInfo->iCreateUid." where log_customer_id=".$objLogCustomerInfo->iLogCustomerId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
	 * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `cm_log_customer` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where log_customer_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
			
	/**
     * 返回数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
				
	/**
     * 返回TOP数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
	 * @param mixed $sGroup group  by 关键字的分组
	 * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_LogCustomer::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
			
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_log_customer` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个cm_log_customer对象
	 * @param mixed $id 
     * @return cm_log_customer对象
     */
	public function getModelByID($id)
	{
		$objLogCustomerInfo = null;
		$arryInfo = Select("*","log_customer_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objLogCustomerInfo = new LogCustomerInfo();
			$objLogCustomerInfo->iLogCustomerId = settype($arryInfo['log_customer_id'],"integer");
			$objLogCustomerInfo->iCustomerId = settype($arryInfo['customer_id'],"integer");
			$objLogCustomerInfo->strChangeValues = $arryInfo['change_values'];
			$objLogCustomerInfo->iCreateTime = settype($arryInfo['create_time'],"integer");
			$objLogCustomerInfo->iCreateUid = settype($arryInfo['create_uid'],"integer");
		}
		
		return $objLogCustomerInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`cm_log_customer`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
}
?>