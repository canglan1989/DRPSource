<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_send_mail 的类业务逻辑层
 * 表描述： 邮件发送
 * 创建人：温智星
 * 添加时间：2012-11-11 09:12:14
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/SendMailInfo.php';
require_once __DIR__.'/../../WebService/UnitMarketQuestion_Service.php';

class SendMailBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objSendMailInfo  SendMailInfo 实例
     * @return 
     */
	public function insert(SendMailInfo $objSendMailInfo)
	{
		$sql = "INSERT INTO `sys_send_mail`(`data_type`,`object_id`,`object_name`,`mail_from`,`mail_to`,`mail_cc`,`mail_theme`,`annex_path`,`send_time`,`send_result`,`mail_content`,`create_uid`,`create_user_name`,`create_time`,`is_del`) 
        values('".$objSendMailInfo->strDataType."',".$objSendMailInfo->iObjectId.",'".$objSendMailInfo->strObjectName."','".$objSendMailInfo->strMailFrom."','".$objSendMailInfo->strMailTo."','".$objSendMailInfo->strMailCc."','".$objSendMailInfo->strMailTheme."','".$objSendMailInfo->strAnnexPath."','".$objSendMailInfo->strSendTime."','".$objSendMailInfo->strSendResult."','".$objSendMailInfo->strMailContent."',".$objSendMailInfo->iCreateUid.",'".$objSendMailInfo->strCreateUserName."',now(),".$objSendMailInfo->iIsDel.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objSendMailInfo  SendMailInfo 实例
     * @return
     */
	public function updateByID(SendMailInfo $objSendMailInfo)
	{
	   $sql = "update `sys_send_mail` set `data_type`='".$objSendMailInfo->strDataType."',`object_id`=".$objSendMailInfo->iObjectId.",`object_name`='".$objSendMailInfo->strObjectName."',`mail_from`='".$objSendMailInfo->strMailFrom."',`mail_to`='".$objSendMailInfo->strMailTo."',`mail_cc`='".$objSendMailInfo->strMailCc."',`mail_theme`='".$objSendMailInfo->strMailTheme."',`annex_path`='".$objSendMailInfo->strAnnexPath."',`send_time`='".$objSendMailInfo->strSendTime."',`send_result`='".$objSendMailInfo->strSendResult."',`mail_content`='".$objSendMailInfo->strMailContent."',`create_user_name`='".$objSendMailInfo->strCreateUserName."',`is_del`=".$objSendMailInfo->iIsDel." where mail_id=".$objSendMailInfo->iMailId;      
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
		$sql = "update `sys_send_mail` set is_del=1,update_uid=".$userID.",update_time=now() where mail_id=".$id;
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
			$sField = T_SendMail::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `sys_send_mail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 SendMailInfo 对象
	 * @param int $id 
     * @return SendMailInfo 对象
     */
	public function getModelByID($id)
	{
		$objSendMailInfo = null;
		$arrayInfo = $this->select("*","mail_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objSendMailInfo = new SendMailInfo();
            		        
            $objSendMailInfo->iMailId = $arrayInfo[0]['mail_id'];
            $objSendMailInfo->strDataType = $arrayInfo[0]['data_type'];
            $objSendMailInfo->iObjectId = $arrayInfo[0]['object_id'];
            $objSendMailInfo->strObjectName = $arrayInfo[0]['object_name'];
            $objSendMailInfo->strMailFrom = $arrayInfo[0]['mail_from'];
            $objSendMailInfo->strMailTo = $arrayInfo[0]['mail_to'];
            $objSendMailInfo->strMailCc = $arrayInfo[0]['mail_cc'];
            $objSendMailInfo->strMailTheme = $arrayInfo[0]['mail_theme'];
            $objSendMailInfo->strAnnexPath = $arrayInfo[0]['annex_path'];
            $objSendMailInfo->strSendTime = $arrayInfo[0]['send_time'];
            $objSendMailInfo->strSendResult = $arrayInfo[0]['send_result'];
            $objSendMailInfo->strMailContent = $arrayInfo[0]['mail_content'];
            $objSendMailInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objSendMailInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objSendMailInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objSendMailInfo->iIsDel = $arrayInfo[0]['is_del'];
            settype($objSendMailInfo->iMailId,"integer");
            settype($objSendMailInfo->iObjectId,"integer");
            settype($objSendMailInfo->iCreateUid,"integer");
            settype($objSendMailInfo->iIsDel,"integer");
            
        }
		return $objSendMailInfo;
       
	}
    
    /**
     * 参数加密
     * http://127.0.0.1:9092/question/show/?qid=1&cid=1&m=yuanyun@adpanshi.com&cn=%E5%AE%A2%E6%88%B7&md=f5f7968dc6875c44
     */
    public function p_md5($parameter)
    {
        $str = '';
        if (is_array($parameter))
        {
            foreach ($parameter as $key => $value)
            {
                $str .= ($key . '-' . $value);
            }
        } else
            $str = $parameter;
        $str .= 'www.adyun.com';
        return substr(md5($str), 5, 16);
    }
    
    /**
     * 取代理商联系人邮箱
    */
    public function GetAgentContactMail($agentIDs)
    {
        $sql = "SELECT distinct am_agent_source.agent_id,am_agent_source.agent_name,
        ifnull((select am_agent_contact.email from am_agent_contact where am_agent_source.agent_id = am_agent_contact.agent_id and am_agent_contact.event_type = 0 
         and am_agent_contact.is_del=0 ORDER BY isCharge,aid LIMIT 0,1),'') as contact_email 
        FROM am_agent_source where am_agent_source.agent_id in({$agentIDs}) and am_agent_source.is_del=0";
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * 网盟市场调查问卷类型
    */
    public function GetUnitMarketQuestionType()
    {
        $objUnitMarketQuestion_Service = new UnitMarketQuestion_Service();
        return $objUnitMarketQuestion_Service->getQuestionList();
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
        $offset   = ($iPageIndex-1)*$iPageSize;
        $sWhere = " is_del=0";
        if($strWhere != "")
            $sWhere .= $strWhere;
        if($strOrder == "")
            $strOrder = " mail_id";
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_send_mail` where ".$sWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sqlData  = "SELECT ".T_SendMail::AllFields." FROM `sys_send_mail` WHERE $sWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
}
		 