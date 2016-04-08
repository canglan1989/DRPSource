<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表cm_customer_move的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerMoveInfo.php';

class CustomerMoveBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objCustomerMoveInfo  CustomerMove实例
     * @return 
     */
	public function insert(CustomerMoveInfo $objCustomerMoveInfo)
	{
		$sql = "INSERT INTO `cm_customer_move`(`customer_id`,`from_anget_id`,`to_anget_id`,`create_uid`,`create_time`,`product_name`)"
		." values(".$objCustomerMoveInfo->iCustomerId.",".$objCustomerMoveInfo->iFromAngetId.",".$objCustomerMoveInfo->iToAngetId.",".$objCustomerMoveInfo->iCreateUid.",'".$objCustomerMoveInfo->iCreateTime."','{$objCustomerMoveInfo->strProductName}')";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objCustomerMoveInfo  CustomerMove实例
     * @return
     */
	public function updateByID(CustomerMoveInfo $objCustomerMoveInfo)
	{
		$sql = "update `cm_customer_move` set `cm_customer_move.customer_id`=".$objCustomerMoveInfo->iCustomerId.",`cm_customer_move.from_anget_id`=".$objCustomerMoveInfo->iFromAngetId.",`cm_customer_move.to_anget_id`=".$objCustomerMoveInfo->iToAngetId.",`cm_customer_move.create_uid`=".$objCustomerMoveInfo->iCreateUid.",`cm_customer_move.create_time`=".$objCustomerMoveInfo->iCreateTime.",`product_name`='{$objCustomerMoveInfo->strProductName}' where customer_move_id=".$objCustomerMoveInfo->iCustomerMoveId;
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
		$sql = "update `cm_customer_move` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where customer_move_id=".$id;
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
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
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
    public function selectTop($sField, $sWhere, $sOrder,$sGroup,$iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_CustomerMove::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `cm_customer_move` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个cm_customer_move对象
	 * @param mixed $id 
     * @return cm_customer_move对象
     */
	public function getModelByID($id)
	{
		$objCustomerMoveInfo = null;
		$arryInfo = $this->select("*","customer_move_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objCustomerMoveInfo = new CustomerMoveInfo();
			$objCustomerMoveInfo->iCustomerMoveId = $arryInfo[0]['customer_move_id'];
			$objCustomerMoveInfo->iCustomerId = $arryInfo[0]['customer_id'];
			$objCustomerMoveInfo->iFromAngetId = $arryInfo[0]['from_anget_id'];
			$objCustomerMoveInfo->iToAngetId = $arryInfo[0]['to_anget_id'];
			$objCustomerMoveInfo->iCreateUid = $arryInfo[0]['create_uid'];
			$objCustomerMoveInfo->iCreateTime = $arryInfo[0]['create_time'];
                        $objCustomerMoveInfo->strProductName = $arryInfo[0]['product_name'];
                        settype($objCustomerMoveInfo->iCustomerMoveId, 'integer');
                        settype($objCustomerMoveInfo->iCustomerId, 'integer');
                        settype($objCustomerMoveInfo->iFromAngetId, 'integer');
                        settype($objCustomerMoveInfo->iToAngetId, 'integer');
                        settype($objCustomerMoveInfo->iCreateUid, 'integer');
		}
		
		return $objCustomerMoveInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
	{
		return $this->objMysqlDB->selectPage("`cm_customer_move`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount);
	}
        
        public function getIntention($iCustomerId){
            $sql ="select GROUP_CONCAT(intention_name) as intention_name from cm_intention where customer_id = {$iCustomerId} GROUP BY customer_id";
            $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if($arrData){
                return $arrData[0]['intention_name'];
            }
            return false;
        }
}
?>