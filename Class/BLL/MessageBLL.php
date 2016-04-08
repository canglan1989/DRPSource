<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_message 的类业务逻辑层
 * 表描述：
 * 创建人：温智星
 * 添加时间：2011-11-15 16:06:57
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/MessageInfo.php';

class MessageBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objMessageInfo  MessageInfo 实例
     * @return 
     */
	public function insert(MessageInfo $objMessageInfo)
	{
		$sql = "INSERT INTO `sys_message`(msg_type,msg_status,msg_title,msg_content,msg_url,from_uid,from_time,to_uid,look_time,look_uid,create_uid,create_time) 
        values(".$objMessageInfo->iMsgType.",".$objMessageInfo->iMsgStatus.",'".$objMessageInfo->strMsgTitle."','".$objMessageInfo->strMsgContent."','".$objMessageInfo->strMsgUrl."',".$objMessageInfo->iFromUid.",'".$objMessageInfo->strFromTime."',".$objMessageInfo->iToUid.",'".$objMessageInfo->strLookTime."',".$objMessageInfo->iLookUid.",".$objMessageInfo->iCreateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objMessageInfo  MessageInfo 实例
     * @return
     */
	public function updateByID(MessageInfo $objMessageInfo)
	{
	   $sql = "update `sys_message` set `msg_type`=".$objMessageInfo->iMsgType.",`msg_status`=".$objMessageInfo->iMsgStatus.",`msg_title`='".$objMessageInfo->strMsgTitle."',`msg_content`='".$objMessageInfo->strMsgContent."',`msg_url`='".$objMessageInfo->strMsgUrl."',`from_uid`=".$objMessageInfo->iFromUid.",`from_time`='".$objMessageInfo->strFromTime."',`to_uid`=".$objMessageInfo->iToUid.",`look_time`='".$objMessageInfo->strLookTime."',`look_uid`=".$objMessageInfo->iLookUid." where msg_id=".$objMessageInfo->iMsgId;      
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
			$sField = T_Message::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_message` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 MessageInfo 对象
	 * @param int $id 
     * @return MessageInfo 对象
     */
	public function getModelByID($id)
	{
		$objMessageInfo = null;
		$arrayInfo = $this->select("*","msg_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objMessageInfo = new MessageInfo();
            		
        
            $objMessageInfo->iMsgId = $arrayInfo[0]['msg_id'];
            $objMessageInfo->iMsgType = $arrayInfo[0]['msg_type'];
            $objMessageInfo->iMsgStatus = $arrayInfo[0]['msg_status'];
            $objMessageInfo->strMsgTitle = $arrayInfo[0]['msg_title'];
            $objMessageInfo->strMsgContent = $arrayInfo[0]['msg_content'];
            $objMessageInfo->strMsgUrl = $arrayInfo[0]['msg_url'];
            $objMessageInfo->iFromUid = $arrayInfo[0]['from_uid'];
            $objMessageInfo->strFromTime = $arrayInfo[0]['from_time'];
            $objMessageInfo->iToUid = $arrayInfo[0]['to_uid'];
            $objMessageInfo->strLookTime = $arrayInfo[0]['look_time'];
            $objMessageInfo->iLookUid = $arrayInfo[0]['look_uid'];
            $objMessageInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objMessageInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objMessageInfo->iMsgId,"integer");
            settype($objMessageInfo->iMsgType,"integer");
            settype($objMessageInfo->iMsgStatus,"integer");
            settype($objMessageInfo->iFromUid,"integer");
            settype($objMessageInfo->iToUid,"integer");
            settype($objMessageInfo->iLookUid,"integer");
            settype($objMessageInfo->iCreateUid,"integer");
            
        }
		return $objMessageInfo;
       
	}
    
    public function AddOrderPostMsg($orderID,$uid)
    {
        
    }
    
    public function AddOrderAuditMsg($orderID,$uid)
    {
        
    }
    
    
    public function ReadMsg($msgID,$uid)
    {
        $sql = "update sys_message set look_time= now(),look_uid=$uid where `msg_id`=$msgID";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    
    public function DeleteMsgs($msgIDs,$uid)
    {
        $aMsg = explode(",",$msgIDs);
        $sql = "";
        foreach($aMsg as $key => $value)
        {
            $sql .= "delete from sys_message where `msg_id`=$msgID;";
        }
        
        if(count($aMsg) > 0)
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return 0;
    }
    
    
}
		 