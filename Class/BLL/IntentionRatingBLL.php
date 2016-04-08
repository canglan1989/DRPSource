<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_intention_rating 的类业务逻辑层
 * 表描述：网盟意向评级 
 * 创建人：温智星
 * 添加时间：2012-10-22 15:40:38
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/IntentionRatingInfo.php';


class IntentionRatingBLL extends BLLBase
{
    
   public static $_arrAgentIntentionRating = array(
       'A'=>'A',
       'B+'=>'B+',
       'B-'=>'B-',
       'C'=>'C',
       'D'=>'D',
       'E'=>'E',
   );
    
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objIntentionRatingInfo  IntentionRatingInfo 实例
     * @return 
     */
	public function insert(IntentionRatingInfo $objIntentionRatingInfo)
	{
		$sql = "INSERT INTO `sys_intention_rating`(`rating_name`,`sort_index`,`remark`,`is_money_time`,`is_report`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`) 
        values('".$objIntentionRatingInfo->strRatingName."',".$objIntentionRatingInfo->iSortIndex.",'".$objIntentionRatingInfo->strRemark."',".$objIntentionRatingInfo->iIsMoneyTime.",".$objIntentionRatingInfo->iIsReport.",".$objIntentionRatingInfo->iIsDel.",".$objIntentionRatingInfo->iCreateUid.",now(),".$objIntentionRatingInfo->iUpdateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objIntentionRatingInfo  IntentionRatingInfo 实例
     * @return
     */
	public function updateByID(IntentionRatingInfo $objIntentionRatingInfo)
	{
	   $sql = "update `sys_intention_rating` set `rating_name`='".$objIntentionRatingInfo->strRatingName."',`sort_index`=".$objIntentionRatingInfo->iSortIndex.",`remark`='".$objIntentionRatingInfo->strRemark."',`is_money_time`=".$objIntentionRatingInfo->iIsMoneyTime.",`is_report`=".$objIntentionRatingInfo->iIsReport.",`is_del`=".$objIntentionRatingInfo->iIsDel.",`update_uid`=".$objIntentionRatingInfo->iUpdateUid.",`update_time`= now() where rating_id=".$objIntentionRatingInfo->iRatingId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_intention_rating` set is_del=1,update_uid=".$userID.",update_time=now() where rating_id=".$id;
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
			$sField = T_IntentionRating::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `sys_intention_rating` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 IntentionRatingInfo 对象
	 * @param int $id 
     * @return IntentionRatingInfo 对象
     */
	public function getModelByID($id)
	{
		$objIntentionRatingInfo = null;
		$arrayInfo = $this->select("*","rating_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objIntentionRatingInfo = new IntentionRatingInfo();
            		
        
            $objIntentionRatingInfo->iRatingId = $arrayInfo[0]['rating_id'];
            $objIntentionRatingInfo->strRatingName = $arrayInfo[0]['rating_name'];
            $objIntentionRatingInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objIntentionRatingInfo->strRemark = $arrayInfo[0]['remark'];
            $objIntentionRatingInfo->iIsMoneyTime = $arrayInfo[0]['is_money_time'];
            $objIntentionRatingInfo->iIsReport = $arrayInfo[0]['is_report'];
            $objIntentionRatingInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objIntentionRatingInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objIntentionRatingInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objIntentionRatingInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objIntentionRatingInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objIntentionRatingInfo->iRatingId,"integer");
            settype($objIntentionRatingInfo->iSortIndex,"integer");
            settype($objIntentionRatingInfo->iIsMoneyTime,"integer");
            settype($objIntentionRatingInfo->iIsReport,"integer");
            settype($objIntentionRatingInfo->iIsDel,"integer");
            settype($objIntentionRatingInfo->iCreateUid,"integer");
            settype($objIntentionRatingInfo->iUpdateUid,"integer");
            
        }
		return $objIntentionRatingInfo;
       
	}
    
    public function SelectList($bFullName=true)
    {
        $strFields = "rating_id,is_money_time";
        if($bFullName == true)
            $strFields .= ",concat(rating_name,' ',remark) as rating_name";
        else
            $strFields .= ",rating_name";
            
        return $this->select($strFields,"","sort_index");
    }
    
    public function JsonForMultiSelect($bFullName=true)
    {
        $arrayInvite = $this->SelectList($bFullName);  
        $strIntentionRatingJson = "[";
        if(isset($arrayInvite) && count($arrayInvite) > 0)
        {
            foreach($arrayInvite as $key => $value)
            {
                $strIntentionRatingJson .= "{'value':'".$value["rating_name"]."','key':'".$value["rating_id"]."'},";
            }
                                    
            $strIntentionRatingJson = substr($strIntentionRatingJson, 0, strlen($strIntentionRatingJson) - 1);
        }                
        $strIntentionRatingJson .= "]";
        
        return $strIntentionRatingJson;
    }
    
    public function getIntentionRating(){
        return $this->select("*", "", "sort_index");
    }
    
    public function GetNameByID($id)
    {
        $arrayData = $this->select("rating_name","rating_id={$id}","");
        if(isset($arrayData) && count($arrayData) > 0)
        {
            return $arrayData[0]["rating_name"];
        }
        
        return  "";
    }
    
    public function IsIntentionRatngExist($iSortIndex,$strRatingName){
        $sql = "select 1 as is_exit from sys_intention_rating where rating_name = '{$strRatingName}' and is_del = 0 limit 1;
                select 1 as is_exit from sys_intention_rating where sort_index = {$iSortIndex} and is_del = 0 limit 1;";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if($arrData){
            return $arrData;
        }
        return FALSE;
    }
    
    public function getIntentionRatingByIds($strRatingIds){
        if(!$strRatingIds){
            return false;
        }
        $sql = "select rating_name from sys_intention_rating where rating_id in ({$strRatingIds}) and is_del = 0";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if($arrData){
            $arrInfo = array();
            foreach($arrData as $item){
                $arrInfo[] = "'{$item['rating_name']}'";
            }
            return implode(',', $arrInfo);
        }
        return false;
    }
    
    public function getJsonStyle($arrayInvite){
        $strIntentionRatingJson = "[";
        if(isset($arrayInvite) && count($arrayInvite) > 0)
        {
            foreach($arrayInvite as $key => $value)
            {
                $strIntentionRatingJson .= "{'value':'".$value."','key':'".$key."'},";
            }
                                    
            $strIntentionRatingJson = substr($strIntentionRatingJson, 0, strlen($strIntentionRatingJson) - 1);
        }                
        $strIntentionRatingJson .= "]";
        
        return $strIntentionRatingJson;
    }
        
    public function getArrAgentIntentionRatingByTiem($arrKey){
        if(!empty ($arrKey)){
            $arrAgentIntentionRating = array();
            foreach($arrKey as $item){
                if(isset (self::$_arrAgentIntentionRating[$item])){
                    $arrAgentIntentionRating[$item] = self::$_arrAgentIntentionRating[$item];
                }
            }
            return $arrAgentIntentionRating;
        }
        return array();
    }
}
		 