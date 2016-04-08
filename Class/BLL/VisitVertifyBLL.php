<?php
/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_vertify 的类业务逻辑层
 * 表描述：小记质检表 
 * 创建人：邱玉虹
 * 添加时间：2013-01-10 14:41:55
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitVertifyInfo.php';

class VisitVertifyBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objVisitVertifyInfo  VisitVertifyInfo 实例
     * @return 
     */
	public function insert(VisitVertifyInfo $objVisitVertifyInfo)
	{
		$sql = "INSERT INTO `am_visit_vertify`(`item_list`,`record_no`,`verfity_status`,`vertify_remark`,`note_id`,`is_visit`,`create_time`,`create_uid`,`create_user_name`,`is_del`,`agent_id`,`new_item_name`,`instruction`,`update_uid`,`update_user_name`,`update_time`) 
        values('".$objVisitVertifyInfo->strItemList."','".$objVisitVertifyInfo->strRecordNo."',".$objVisitVertifyInfo->iVerfityStatus.",'".$objVisitVertifyInfo->strVertifyRemark."',".$objVisitVertifyInfo->iNoteId.",".$objVisitVertifyInfo->iIsVisit.",now(),".$objVisitVertifyInfo->iCreateUid.",'".$objVisitVertifyInfo->strCreateUserName."',".$objVisitVertifyInfo->iIsDel.",{$objVisitVertifyInfo->iAgentId},'{$objVisitVertifyInfo->strNewItemName}','{$objVisitVertifyInfo->strInstruction}',{$objVisitVertifyInfo->iUpdateUid},'{$objVisitVertifyInfo->strUpdateUserName}','{$objVisitVertifyInfo->strUpdateTime}')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objVisitVertifyInfo  VisitVertifyInfo 实例
     * @return
     */
	public function updateByID(VisitVertifyInfo $objVisitVertifyInfo)
	{
	   $sql = "update `am_visit_vertify` set `item_list`='".$objVisitVertifyInfo->strItemList."',`record_no`='".$objVisitVertifyInfo->strRecordNo."',`verfity_status`=".$objVisitVertifyInfo->iVerfityStatus.",`vertify_remark`='".$objVisitVertifyInfo->strVertifyRemark."',`note_id`=".$objVisitVertifyInfo->iNoteId.",`is_visit`=".$objVisitVertifyInfo->iIsVisit.",`create_user_name`='".$objVisitVertifyInfo->strCreateUserName."',`is_del`=".$objVisitVertifyInfo->iIsDel.",`agent_id`={$objVisitVertifyInfo->iAgentId},`new_item_name`='{$objVisitVertifyInfo->strNewItemName}',`instruction`='{$objVisitVertifyInfo->strInstruction}',`update_uid`={$objVisitVertifyInfo->iUpdateUid},`update_user_name`='{$objVisitVertifyInfo->strUpdateUserName}',`update_time`='{$objVisitVertifyInfo->strUpdateTime}' where vertify_id=".$objVisitVertifyInfo->iVertifyId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
     public function UpdateData($arrUpdateData, $strWhere) {
        $arrSetField = array();
        foreach ($arrUpdateData as $key => $value) {
            $arrSetField[] = " `{$key}`='{$value}'";
        }
        $strSetField = implode(',', $arrSetField);
        $sql = "update `am_visit_vertify` set {$strSetField} where {$strWhere}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `am_visit_vertify` set is_del=1,update_uid=".$userID.",update_time=now() where vertify_id=".$id;
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
			$sField = T_VisitVertify::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `am_visit_vertify` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 VisitVertifyInfo 对象
	 * @param int $id 
     * @return VisitVertifyInfo 对象
     */
	public function getModelByID($id)
	{
		$objVisitVertifyInfo = null;
		$arrayInfo = $this->select("*","vertify_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitVertifyInfo = new VisitVertifyInfo();            		
        
            $objVisitVertifyInfo->iVertifyId = $arrayInfo[0]['vertify_id'];
            $objVisitVertifyInfo->strItemList = $arrayInfo[0]['item_list'];
            $objVisitVertifyInfo->strRecordNo = $arrayInfo[0]['record_no'];
            $objVisitVertifyInfo->iVerfityStatus = $arrayInfo[0]['verfity_status'];
            $objVisitVertifyInfo->strVertifyRemark = $arrayInfo[0]['vertify_remark'];
            $objVisitVertifyInfo->iNoteId = $arrayInfo[0]['note_id'];
            $objVisitVertifyInfo->iIsVisit = $arrayInfo[0]['is_visit'];
            $objVisitVertifyInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objVisitVertifyInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objVisitVertifyInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objVisitVertifyInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objVisitVertifyInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objVisitVertifyInfo->strNewItemName = $arrayInfo[0]['new_item_name'];
            $objVisitVertifyInfo->strInstruction = $arrayInfo[0]['instruction'];
            $objVisitVertifyInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objVisitVertifyInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objVisitVertifyInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objVisitVertifyInfo->iVertifyId,"integer");
            settype($objVisitVertifyInfo->iVerfityStatus,"integer");
            settype($objVisitVertifyInfo->iNoteId,"integer");
            settype($objVisitVertifyInfo->iIsVisit,"integer");
            settype($objVisitVertifyInfo->iCreateUid,"integer");
            settype($objVisitVertifyInfo->iIsDel,"integer");
            settype($objVisitVertifyInfo->iAgentId,"integer");
            settype($objVisitVertifyInfo->iUpdateUid,"integer");
        }
		return $objVisitVertifyInfo;
       
	}
        
        public function getVertifyLogByAgentId($iAgentId,$iIsVisit = 0){
            $sql = "SELECT
                    am_visit_vertify.vertify_id,
                    am_visit_note.id as note_id,
                    am_visit_vertify.record_no,
                    am_visit_vertify.new_item_name,
                    am_visit_vertify.verfity_status,
                    am_visit_note.is_vertifyed,
                    am_visit_vertify.vertify_remark,
                    am_visit_vertify.create_user_name,
                    am_visit_vertify.create_time,
                    am_visit_vertify.create_uid,
                    am_visit_vertify.item_list
                    from am_visit_vertify
                    left join am_visit_note on am_visit_note.id = am_visit_vertify.note_id
                    where am_visit_vertify.agent_id = {$iAgentId}  and am_visit_vertify.is_del = 0  and am_visit_vertify.is_visit = {$iIsVisit}
                    ORDER BY am_visit_vertify.create_time desc";
            return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        }
        
        public function getLastVertifyLogByAgentId($iAgentId,$iVertifyId = 0){
            $strWhere = '';
            if(!empty ($iVertifyId)){
                $strWhere = " and vertify_id < {$iVertifyId} ";
            }
            return $this->selectTop("*", "agent_id = {$iAgentId} and is_del = 0 {$strWhere} ", "create_time desc", "", 1);
        }
        
        public function setInstruction($iVertifyId,$strInstruction){
            return $this->UpdateData(array(
                'instruction'=>$strInstruction
            ), "vertify_id = {$iVertifyId}");
        }
        
        public function getVertifyByNoteID($iNoteId){
            $arrData = $this->selectTop("*", "note_id = {$iNoteId} and is_del = 0", "", "", 1);
            if($arrData){
                return $arrData[0];
            }
            return array();
        }
     
}
		 