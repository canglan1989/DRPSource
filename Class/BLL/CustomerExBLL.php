<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 cm_customer_ex 的类业务逻辑层
 * 表描述：客户信息拓展表 
 * 创建人：温智星
 * 添加时间：2012-10-22 15:40:10
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/CustomerExInfo.php';

class CustomerExBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objCustomerExInfo  CustomerExInfo 实例
     * @return 
     */
	public function insert(CustomerExInfo $objCustomerExInfo)
	{
		$sql = "INSERT INTO `cm_customer_ex`(`customer_id`,`agent_id`,`record_count`,`last_record_time`,`last_record_content`,`intention_rating`,`intention_rating_name`,`last_to_sea_time`,`buy_product_ids`,`buy_product_name`,`to_sea_time`,`shield_uid`,`shield_time`,`defend_state`) 
        values(".$objCustomerExInfo->iCustomerId.",".$objCustomerExInfo->iAgentId.",".$objCustomerExInfo->iRecordCount.",'".$objCustomerExInfo->strLastRecordTime."','".$objCustomerExInfo->strLastRecordContent."',".$objCustomerExInfo->iIntentionRating.",'".$objCustomerExInfo->strIntentionRatingName."','".$objCustomerExInfo->strLastToSeaTime."','".$objCustomerExInfo->strBuyProductIds."','".$objCustomerExInfo->strBuyProductName."','".$objCustomerExInfo->strToSeaTime."',".$objCustomerExInfo->iShieldUid.",'".$objCustomerExInfo->strShieldTime."',".$objCustomerExInfo->iDefendState.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objCustomerExInfo  CustomerExInfo 实例
     * @return
     */
	public function updateByID(CustomerExInfo $objCustomerExInfo)
	{
	   $sql = "update `cm_customer_ex` set `agent_id`=".$objCustomerExInfo->iAgentId.",`record_count`=".$objCustomerExInfo->iRecordCount.",`last_record_time`='".$objCustomerExInfo->strLastRecordTime."',`last_record_content`='".$objCustomerExInfo->strLastRecordContent."',`intention_rating`=".$objCustomerExInfo->iIntentionRating.",`intention_rating_name`='".$objCustomerExInfo->strIntentionRatingName."',`last_to_sea_time`='".$objCustomerExInfo->strLastToSeaTime."',`buy_product_ids`='".$objCustomerExInfo->strBuyProductIds."',`buy_product_name`='".$objCustomerExInfo->strBuyProductName."',`to_sea_time`='".$objCustomerExInfo->strToSeaTime."',`shield_uid`=".$objCustomerExInfo->iShieldUid.",`shield_time`='".$objCustomerExInfo->strShieldTime."',`defend_state`=".$objCustomerExInfo->iDefendState." where customer_id=".$objCustomerExInfo->iCustomerId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
        public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `cm_customer_ex` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        public function UpdateToSeaTime($iAgentID,$strTime,$strCusomerIDs,$iDefendState = 0){
            if(empty ($strCusomerIDs)){
                $strCusomerIDs = 'null';
            }
            $arrUpdateFields = array('to_sea_time'=>$strTime);
            if(!empty ($iDefendState)){
                $arrUpdateFields['defend_state'] = $iDefendState;
            }
            return $this->UpdateData($arrUpdateFields, " customer_id in ({$strCusomerIDs}) and agent_id={$iAgentID}");
        }
        
        /**
         * 踢入公海操作
         * @param type $strToSeaTime
         * @param type $strShieldTime
         * @param type $strCustomerIDs
         * @return type 
         */
        public function setToSeaOpr($strToSeaTime,$strShieldTime,$strCusomerIDs,$strShieldUid){
            if(empty ($strCusomerIDs)){
                $strCusomerIDs = 'null';
            }
            return $this->UpdateData(array(
                'last_to_sea_time'=>$strToSeaTime,
                'to_sea_time'=>$strToSeaTime,
                'shield_time'=>$strShieldTime,
                'shield_uid'=>$strShieldUid
            ), " customer_id in ({$strCusomerIDs})");
        }
        
        public function setShieldTime($strCusomerIDs,$strShieldTime,$strShieldUid){
            if(empty ($strCusomerIDs)){
                $strCusomerIDs = 'null';
            }
            return $this->UpdateData(array(
                'shield_time'=>$strShieldTime,
                'shield_uid'=>$strShieldUid
            ), " customer_id in ({$strCusomerIDs})");
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
			$sField = T_CustomerEx::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `cm_customer_ex` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 CustomerExInfo 对象
	 * @param int $id 
     * @return CustomerExInfo 对象
     */
	public function getModelByID($id,$iAgentID)
	{
		$objCustomerExInfo = null;
		$arrayInfo = $this->select("*","customer_id=".$id." and agent_id={$iAgentID}","");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objCustomerExInfo = new CustomerExInfo();
            		
        
            $objCustomerExInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objCustomerExInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objCustomerExInfo->iRecordCount = $arrayInfo[0]['record_count'];
            $objCustomerExInfo->strLastRecordTime = $arrayInfo[0]['last_record_time'];
            $objCustomerExInfo->strLastRecordContent = $arrayInfo[0]['last_record_content'];
            $objCustomerExInfo->iIntentionRating = $arrayInfo[0]['intention_rating'];
            $objCustomerExInfo->strIntentionRatingName = $arrayInfo[0]['intention_rating_name'];
            $objCustomerExInfo->strLastToSeaTime = $arrayInfo[0]['last_to_sea_time'];
            $objCustomerExInfo->strBuyProductIds = $arrayInfo[0]['buy_product_ids'];
            $objCustomerExInfo->strBuyProductName = $arrayInfo[0]['buy_product_name'];
            $objCustomerExInfo->strToSeaTime = $arrayInfo[0]['to_sea_time'];
            $objCustomerExInfo->iShieldUid = $arrayInfo[0]['shield_uid'];
            $objCustomerExInfo->strShieldTime = $arrayInfo[0]['shield_time'];
            $objCustomerExInfo->iDefendState = $arrayInfo[0]['defend_state'];
            settype($objCustomerExInfo->iCustomerId,"integer");
            settype($objCustomerExInfo->iAgentId,"integer");
            settype($objCustomerExInfo->iRecordCount,"integer");
            settype($objCustomerExInfo->iIntentionRating,"integer");
            settype($objCustomerExInfo->iShieldUid,"integer");
            settype($objCustomerExInfo->iDefendState,"integer");
            
        }
		return $objCustomerExInfo;
       
	}
        
        
      public function getCustomerExListByCustomerID($strCustomerIDs,$iAgentID){
          if(empty ($strCustomerIDs)){
              $strCustomerIDs = "null";
          }
          $sql = "select to_sea_time,customer_id,defend_state,record_count from cm_customer_ex where agent_id = {$iAgentID} and customer_id in ({$strCustomerIDs})";
          return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
      }
      
      public function getCustomerCountByID($iUserID,$iAgentID,$iDefendState){
          $sql = "select count(1) as num from cm_customer_ex 
                inner join cm_customer_agent on cm_customer_agent.customer_id = cm_customer_ex.customer_id and cm_customer_agent.agent_id = {$iAgentID} and cm_customer_agent.is_del = 0
                inner join cm_customer on cm_customer_ex.customer_id = cm_customer.customer_id and cm_customer.is_del = 0
                where cm_customer_ex.agent_id = {$iAgentID} and cm_customer_ex.to_sea_time > now() and cm_customer_agent.user_id = {$iUserID} and cm_customer_ex.defend_state = {$iDefendState}";
          return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
      }
       
}
		 