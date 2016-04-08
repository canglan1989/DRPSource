<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_visit_appoint的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-10-12 13:53:07
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitAppointInfo.php';
require_once __DIR__.'/../Model/AgentContactInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class VisitAppointBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param VisitAppointInfo $objVisitAppointInfo  VisitAppoint实例
     * @return 
     */
	public function insert(VisitAppointInfo $objVisitAppointInfo)
	{
		$sql = "INSERT INTO `am_visit_appoint`(`euser_id`,`agent_id`,`visitor`,`tel`,`mobile`,`note`,`title`,`check_status`,`sappoint_time`,`eappoint_time`,`create_time`,`update_time`,`create_id`,`update_id`,`is_del`,`inten_level`,`product_id`,`product_name`,`ass_uid`,`is_visit`,`create_user_name`,`update_user_name`,`contact_id`,`check_remark`,`check_time`,`check_user_name`,`check_uid`,`position`,`role_name`)"
		." values(".$objVisitAppointInfo->iEuserId.",".$objVisitAppointInfo->iAgentId.",'".$objVisitAppointInfo->strVisitor."','".$objVisitAppointInfo->strTel."','".$objVisitAppointInfo->strMobile."',".$objVisitAppointInfo->iNote.",'".$objVisitAppointInfo->strTitle."',".$objVisitAppointInfo->iCheckStatus.",'".$objVisitAppointInfo->strSappointTime."','".$objVisitAppointInfo->strEappointTime."',now(),'".$objVisitAppointInfo->strUpdateTime."',".$objVisitAppointInfo->iCreateId.",".$objVisitAppointInfo->iUpdateId.",".$objVisitAppointInfo->iIsDel.",'".$objVisitAppointInfo->strIntenLevel."',".$objVisitAppointInfo->iProductId.",'".$objVisitAppointInfo->strProductName."',".$objVisitAppointInfo->iAss_uid.",{$objVisitAppointInfo->iIsVisit},'{$objVisitAppointInfo->strCreateUserName}','{$objVisitAppointInfo->strUpdateUserName}',{$objVisitAppointInfo->iContactId},'{$objVisitAppointInfo->strCheckRemark}','{$objVisitAppointInfo->strCheckTime}','{$objVisitAppointInfo->strCheckUserName}',{$objVisitAppointInfo->iCheckUid},'{$objVisitAppointInfo->strPosition}','{$objVisitAppointInfo->strRoleName}')";
       
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param VisitAppointInfo $objVisitAppointInfo  VisitAppoint实例
     * @return
     */
	public function updateByID(VisitAppointInfo $objVisitAppointInfo)
	{
		$sql = "update `am_visit_appoint` set `euser_id`=".$objVisitAppointInfo->iEuserId.",`agent_id`=".$objVisitAppointInfo->iAgentId.",`visitor`='".$objVisitAppointInfo->strVisitor."',`tel`='".$objVisitAppointInfo->strTel."',`mobile`='".$objVisitAppointInfo->strMobile."',`note`=".$objVisitAppointInfo->iNote.",`title`='".$objVisitAppointInfo->strTitle."',`check_status`=".$objVisitAppointInfo->iCheckStatus.",`sappoint_time`='".$objVisitAppointInfo->strSappointTime."',`eappoint_time`='".$objVisitAppointInfo->strEappointTime."',`update_time`=now(),`create_id`=".$objVisitAppointInfo->iCreateId.",`update_id`=".$objVisitAppointInfo->iUpdateId.",`is_del`=".$objVisitAppointInfo->iIsDel.",`inten_level`='".$objVisitAppointInfo->strIntenLevel."',`product_id`=".$objVisitAppointInfo->iProductId.",`product_name`='".$objVisitAppointInfo->strProductName."',ass_uid=".$objVisitAppointInfo->iAss_uid.",`is_visit`={$objVisitAppointInfo->iIsVisit},`create_user_name`='{$objVisitAppointInfo->strCreateUserName}',`update_user_name`='{$objVisitAppointInfo->strUpdateUserName}',`contact_id`={$objVisitAppointInfo->iContactId},`check_remark`='{$objVisitAppointInfo->strCheckRemark}',`check_time`='{$objVisitAppointInfo->strCheckTime}',`check_user_name`='{$objVisitAppointInfo->strCheckUserName}',`check_uid`={$objVisitAppointInfo->iCheckUid},`role_name`='{$objVisitAppointInfo->strRoleName}',`position`='{$objVisitAppointInfo->strPosition}'  where appoint_id=".$objVisitAppointInfo->iAppointId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
        
      public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `am_visit_appoint` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }
      
      public function setNoteAdded($iAppointId){
          return $this->UpdateData(array(
              'note'=>1
          ), "appoint_id = {$iAppointId}");
      }
        
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id appoint_id
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID,$user_name = '')
    {
		$sql = "update `am_visit_appoint` set is_del=1,update_id=".$userID.",`update_user_name`='{$user_name}',update_time=now() where is_del=0 and appoint_id=".$id;
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
			$sField = T_VisitAppoint::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by create_time desc";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_visit_appoint` ".$sWhere.$sOrder.$sGroup.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个am_visit_appoint对象
	 * @param int $id 
     * @return am_visit_appoint对象
     */
	public function getModelByID($id)
	{
		$objVisitAppointInfo = null;
		$arrayInfo = $this->select("*","appoint_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitAppointInfo = new VisitAppointInfo();
			$objVisitAppointInfo->iAppointId = $arrayInfo[0]['appoint_id'];
			$objVisitAppointInfo->iEuserId = $arrayInfo[0]['euser_id'];
			$objVisitAppointInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objVisitAppointInfo->strVisitor = $arrayInfo[0]['visitor'];
			$objVisitAppointInfo->strTel = $arrayInfo[0]['tel'];
			$objVisitAppointInfo->strMobile = $arrayInfo[0]['mobile'];
			$objVisitAppointInfo->iNote = $arrayInfo[0]['note'];
			$objVisitAppointInfo->strTitle = $arrayInfo[0]['title'];
			$objVisitAppointInfo->iCheckStatus = $arrayInfo[0]['check_status'];
			$objVisitAppointInfo->strSappointTime = $arrayInfo[0]['sappoint_time'];
			$objVisitAppointInfo->strEappointTime = $arrayInfo[0]['eappoint_time'];
			$objVisitAppointInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objVisitAppointInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objVisitAppointInfo->iCreateId = $arrayInfo[0]['create_id'];
			$objVisitAppointInfo->iUpdateId = $arrayInfo[0]['update_id'];
			$objVisitAppointInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objVisitAppointInfo->strIntenLevel = $arrayInfo[0]['inten_level'];
			$objVisitAppointInfo->iProductId = $arrayInfo[0]['product_id'];
			$objVisitAppointInfo->strProductName = $arrayInfo[0]['product_name'];
                        $objVisitAppointInfo->iIsVisit = $arrayInfo[0]['is_visit'];
                        $objVisitAppointInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
                        $objVisitAppointInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
                        $objVisitAppointInfo->iContactId = $arrayInfo[0]['contact_id'];
                        $objVisitAppointInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
                        $objVisitAppointInfo->strCheckTime = $arrayInfo[0]['check_time'];
                        $objVisitAppointInfo->strCheckUserName = $arrayInfo[0]['check_user_name'];
                        $objVisitAppointInfo->iCheckUid = $arrayInfo[0]['check_uid'];
                        $objVisitAppointInfo->strRoleName = $arrayInfo[0]['role_name'];
                        $objVisitAppointInfo->strPosition = $arrayInfo[0]['position'];
			settype($objVisitAppointInfo->iAppointId,"integer");
			settype($objVisitAppointInfo->iEuserId,"integer");
			settype($objVisitAppointInfo->iAgentId,"integer");
			settype($objVisitAppointInfo->iNote,"integer");
			settype($objVisitAppointInfo->iCheckStatus,"integer");
			settype($objVisitAppointInfo->iCreateId,"integer");
			settype($objVisitAppointInfo->iUpdateId,"integer");
			settype($objVisitAppointInfo->iIsDel,"integer");
			settype($objVisitAppointInfo->iProductId,"integer");
                        settype($objVisitAppointInfo->iIsVisit, 'integer');
                        settype($objVisitAppointInfo->iContactId, 'integer');
                         settype($objVisitAppointInfo->iCheckUid, 'integer');
		}
		return $objVisitAppointInfo;
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel=false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;
        
        if($strOrder == "")
            $strOrder = " `am_visit_appoint`.create_time desc ";
                
        if($bExportExcel == false)
        {
        $sqlCount = "SELECT  COUNT(1) AS `recordCount`  FROM
                      `am_visit_appoint`  left JOIN
                      `am_agent_source` ON `am_visit_appoint`.`agent_id` =
                      `am_agent_source`.`agent_id` left JOIN
                      `sys_user` ON `am_visit_appoint`.`euser_id` = `sys_user`.`user_id`   
                      WHERE am_visit_appoint.is_visit=0 and $strWhere
        
        ";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
    	}
		$sWhere = " ";
        if($strOrder == "")
            $strOrder = " `am_visit_appoint`.create_time desc ";
                
        $sqlData = "SELECT     
                      `am_agent_source`.`agent_name`,`sys_user`.e_name,am_agent_source.last_revisit_time,`am_visit_appoint`.*,
                      `am_visit_appoint`.title as v_title
                    FROM
                      `am_visit_appoint` inner JOIN
                      `am_agent_source` ON `am_visit_appoint`.`agent_id` =
                      `am_agent_source`.`agent_id` left JOIN
                      `sys_user` ON `am_visit_appoint`.`euser_id` = `sys_user`.`user_id`   
                      WHERE am_visit_appoint.is_visit=0 and $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize
                      ";
        //echo($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    /**
     * @functional 用户关联的代理商JSON
     * @param $id 当前用户ID; $text 文本框内容
    */
	public function AutoAgentJson($text,$id)
	{
	   $sql = "SELECT distinct
                  `am_agent_source`.`agent_name` as name,
                  `am_agent_source`.`agent_id` as id
                FROM 
                  `am_agent_source` 
                where `am_agent_source`.`channel_uid`=$id and `am_agent_source`.`is_del`=0 and `am_agent_source`.is_check=1
                and `am_agent_source`.`agent_name` like '%$text%' 
                order by `am_agent_source`.`agent_name` limit 0,15 ";
         
         $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         return json_encode(array('value'=>$arrayData));
	}
    /**
     * @functional 拜访者（代理商联系人）模糊匹配
     * @param $agentId 代理商ID; $text 文本框内容
    */
	public function VisitorInfo($text,$agentId)
	{
        $sql = "SELECT
                  `contact_name` as name, `tel`,`mobile` as id,
                  `am_agent_contact`.`agent_id` 
                FROM
                  `am_agent_contact` where `agent_id`=".$agentId." and `is_del`=0 and contact_name like '%$text%' and `event_type`=0"; 
         //print_r($sql);
         $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         return json_encode(array('value'=>$arrayData));
	}
    /**
     * @functional 拜访者（代理商联系人）固定电话  （待优化）
     * @param $contact_name 联系人名称
    */
	public function GetTel($contact_name,$agent_id)
	{
        $sql = "SELECT  `tel`
                FROM
                  `am_agent_contact` where `contact_name`='".$contact_name."' and `is_del`=0 and `agent_id`=$agent_id"; 
         return $this->objMysqlDB->executeAndReturn(false,$sql,null);
	}
    /**
     * @functional 根据代理商ID取得预约拜访的代理商的信息
     * @param  $agentid 代理商ID
    */
	public function AppointAgentData($agentid,$appoint_id)
	{
        if($appoint_id > 0)//编辑
        {
            $sqlData = "SELECT
                          `am_visit_appoint`.*, `am_agent_source`.`agent_name`,sys_user.e_name,`am_agent_source`.`is_del`,if(`am_visit_appoint`.product_name,1,0) as pact_statu
                        FROM `am_visit_appoint` 
                          left JOIN `am_agent_source` ON `am_visit_appoint`.`agent_id` = `am_agent_source`.`agent_id`
                          left join sys_user on `am_visit_appoint`.create_id = sys_user.user_id
                          where `am_visit_appoint`.appoint_id = $appoint_id and `am_visit_appoint`.is_visit = 0
                        ";
        }
        else
        {
                $sqlData = "SELECT
                              `am_agent_contact`.`leval` as levelorp,`am_agent_source`.agent_name
                            FROM
                              `am_agent_contact` left join `am_agent_source` 
                              on `am_agent_contact`.agent_id=`am_agent_source`.agent_id
                               where `am_agent_contact`.`agent_id`=$agentid and `am_agent_contact`.`is_del`=0 and `am_visit_appoint`.is_visit = 0";
         }
         
         $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
         return $arrayData;
	}
    /**
     * @functional 获取被访人是否在代理商联系人列表内
     * @param $visitor 被访人名称
     * @return 
     */
    public function VisitorCompare($visitor,$agentId)
    {
    	/*$sql = "select 1
    		from `am_visit_appoint`
    		left join `am_agent_contact` on `am_agent_contact`.agent_id=`am_visit_appoint`.agent_id
    		where `am_agent_contact`.`contact_name`='$visitor' and  `am_visit_appoint`.is_del=0";*/
        $sql = "select `aid`,`am_agent_contact`.`contact_name` from  `am_agent_contact` 
                where `am_agent_contact`.`contact_name`='$visitor' and event_type=0 and `am_agent_contact`.agent_id=$agentId ";
    	return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    
    }
    /**
     * @functional 被访人信息添加到代理商联系人
     * @param AgentContactInfo $objAgentContactInfo  AgentContact实例
     * @return 
     */
    public function insertContactName(AgentContactInfo $objAgentContactInfo)
    {
            $sql = "INSERT INTO `am_agent_contact`(`agent_id`,`event_type`,`contact_type`,`contact_name`,`mobile`,`tel`,`leval`,`contact_time`,`create_uid`,`create_time`)"
                    . " values(" 
                    . $objAgentContactInfo->iAgentId . "," 
                    . $objAgentContactInfo->iEventType . "," 
            		. $objAgentContactInfo->iContactType . ",'" 
            		. $objAgentContactInfo->strContactName . "','" 
            		. $objAgentContactInfo->strMobile . "','" 
                    . $objAgentContactInfo->strTel."','"
                    . $objAgentContactInfo->strLeval . "','" 
            		. $objAgentContactInfo->strContactTime . "'," 
            		. $objAgentContactInfo->iCreateUid . ",now())";
            return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    /**
     * @functional 意向等级
     * @param 
     * @return 
     */
    public function GetLevel($agent_id)
    {
            $sql = "select leval from am_agent_contact where agent_id = $agent_id and is_del = 0 order by create_time desc limit 0,1;";
            return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
   
    /**
     * @functional 根据上级user_id找出下级user_id（不包括自己的user_id）
     * @param 
     * @return 
     */
    public function GetLowPositionUser($uid)
    {
        //AB岗未考虑
        
        $sql = "SELECT
                  `hr_level`.`m_value`,`hr_department`.`dept_id`,
                  `hr_department`.`dept_name`,
                  `hr_employee`.`e_id`, `hr_position`.`post_id`,
                  `hr_department`.`dept_fullname`, `hr_department`.`is_del`,`hr_department`.`dept_no`,
                  `hr_employee`.`e_status`, `hr_employee`.`e_name`, `sys_user`.`user_id`
                FROM
                  `hr_employee` 
                  left JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` = `hr_dept_position`.`dept_position_id` 
                  left JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` = `hr_department`.`dept_id`
                  left JOIN `hr_position` ON `hr_position`.`post_id` = `hr_dept_position`.`post_id`
                  left JOIN `hr_level` ON `hr_position`.`level_id` = `hr_level`.`level_id` 
                  inner JOIN `sys_user` ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
                where `sys_user`.`user_id`=".$uid;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $dept_id = $arrayData[0]["dept_id"];
        $dept_no = $arrayData[0]["dept_no"];
        $m_value = $arrayData[0]["m_value"];
        $m_value = substr($m_value,1);
        $sqlLow = "SELECT  group_concat(`sys_user`.`user_id`)
                FROM
                  `hr_employee` 
                   JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` = `hr_dept_position`.`dept_position_id` 
                   JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` = `hr_department`.`dept_id`
                   JOIN `hr_position` ON `hr_position`.`post_id` = `hr_dept_position`.`post_id`
                   JOIN `hr_level` ON `hr_position`.`level_id` = `hr_level`.`level_id` 
                   JOIN `sys_user` ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
                  where sys_user.is_del=0 and `hr_department`.`is_del`=0 and `hr_employee`.`e_status`>=0  and `sys_user`.`user_id`<>".$uid."
                  and `hr_department`.`dept_no` like '".$dept_no."%' and substring(`hr_level`.`m_value`,2)<".$m_value;
         return $this->objMysqlDB->executeAndReturn(false,$sqlLow,null);
        
    }


    /** 
     * @function 根据代理商ID取得渠道经理的ID
     * @param 代理商ID
     */
    public function GetChannelIdByAid($agengtId)
    {
        $sql = "SELECT `am_agent_source`.`channel_uid`
            FROM `am_agent_source` where `am_agent_source`.`agent_id`=$agengtId and `am_agent_source`.`is_del`=0 ";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
    /**
     * @functional 拜访那天是否已经添加过拜访小记或者陪访小记
     * @param  
    */
    public function IsExistAccompanyVisit($uid,$agentId,$time,$appoint_id)
    {
        $sWhere = "";       
        //if($appoint_id > 0)
        $sWhere = " and  appoint_id <>".$appoint_id;
        $sql = " select if(count(*)>0,1,(select count(*) from am_visit_appoint where create_id =$uid $sWhere and agent_id=$agentId and left(sappoint_time,10)='$time')  ) counts
                from  am_visit_accompany   
                where create_id = $uid and agent_id=$agentId and left(s_time,10)='$time'";
        
        $sql2 = " SELECT am_visit_accompany.id from am_visit_accompany where agent_id= $agentId and create_id =$uid and 
                left(am_visit_accompany.s_time,10)='$time'
                union all 
                select 
                am_visit_appoint.appoint_id
                from am_visit_appoint where agent_id =$agentId  and create_id=$uid $sWhere and left(am_visit_appoint.sappoint_time,10)='$time' and is_del=0";
        //exit($sql);
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);        
    }
    
    /**
     * 获取excel信息
     * @param type $strWhere
     * @return type 
     */
    public function getExcelNoteInfo($strWhere){
        if(!empty ($strWhere)){
            $strWhere = " where {$strWhere} ";
        }
        $sql = "select n.visitnoteid,euser.e_name,s.agent_name,a.inten_level,a.product_id,n.afterlevel,n.after_productid,n.visitor,n.tel,n.mobile,a.sappoint_time,a.eappoint_time,a.title,
                n.visit_timestart,n.visit_timeend,n.result,n.create_time,n.support,n.check_status,n.check_time,n.check_remark,checkr.e_name,t.content,t.return_time,returnr.e_name 
                from am_visit_note n 
                join am_agent_source s on s.agent_id = n.agent_id and n.agent_id>0
                left join am_visit_appoint a on a.appoint_id = n.visitnoteid and am_visit_appoint.is_visit=0
                left join sys_user euser on euser.user_id = a.euser_id
                left join sys_user checkr on checkr.user_id = n.check_uid
                left join (select MAX(id) as id,visitNoteID,content,return_time,add_user_id from am_visit_return GROUP BY visitNoteID) t on t.visitNoteID = n.visitnoteid 
                left join sys_user returnr on returnr.user_id = t.add_user_id {$strWhere}";
         return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    public function getTelTaskManageList($strWhere,$strOrder){
        $strWhere = " where am_visit_appoint.is_del = 0  {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY am_visit_appoint.create_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }

        $sql = "select am_visit_appoint.appoint_id,am_agent_source.agent_name,am_visit_appoint.agent_id,am_visit_appoint.visitor,am_visit_appoint.mobile,am_visit_appoint.tel,
                am_visit_appoint.sappoint_time,am_visit_appoint.title,am_visit_appoint.create_id,am_visit_appoint.create_time,am_visit_appoint.create_user_name,
                am_visit_appoint.check_status,am_visit_appoint.note
                from am_visit_appoint
                INNER join am_agent_source on am_agent_source.agent_id = am_visit_appoint.agent_id and am_agent_source.is_del = 0
                INNER join sys_user on sys_user.user_id = am_visit_appoint.create_id and sys_user.is_del = 0
                left join v_hr_employee on v_hr_employee.e_id = sys_user.e_uid
                {$strWhere} {$strOrder}";
       $arrData = $this->getPageData($sql);
       for($i = 0;$i<count($arrData['list']);$i++){
           $arrData['list'][$i]['check_status_cn'] = AgentCheckStatus::GetText($arrData['list'][$i]['check_status']);
       }
       return $arrData;
    }
    
    public function getVisitTaskManageList($strWhere,$strOrder,$iIsDownload = false){
        $strWhere = " where am_visit_appoint.is_del = 0 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY am_visit_appoint.create_time desc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
                
        $sql = "select am_visit_appoint.appoint_id,am_agent_source.agent_name,am_visit_appoint.agent_id, am_visit_appoint.sappoint_time,am_visit_appoint.title,
                am_visit_appoint.create_id,am_visit_appoint.create_time,am_visit_appoint.create_user_name, am_visit_appoint.check_status,am_visit_appoint.note, 
                am_expect_charge.inten_level,am_visit_appoint.product_name,am_visit_appoint.product_id, am_agent_source.agent_no,am_visit_appoint.visitor,
                am_visit_appoint.mobile,am_visit_appoint.tel,am_visit_appoint.position,am_visit_appoint.role_name as role 
                from am_visit_appoint 
                INNER join am_agent_source on am_agent_source.agent_id = am_visit_appoint.agent_id and am_agent_source.is_del = 0 
                INNER join sys_user on sys_user.user_id = am_visit_appoint.create_id and sys_user.is_del = 0 
                left join v_hr_employee on v_hr_employee.e_id = sys_user.e_uid 
                left join am_expect_charge on am_expect_charge.agent_id = am_visit_appoint.agent_id 
                {$strWhere} {$strOrder}";
                //print_r($sql);
       $arrData = $this->getPageData($sql,$iIsDownload);
       
       foreach($arrData['list'] as $key=>$item){
           $arrData['list'][$key]['check_status_cn'] = AgentCheckStatus::GetText($item['check_status']);
           $arrData['list'][$key]['sappoint_time_cn'] = date('Y-m-d',  strtotime($item['sappoint_time']));
           if($item['agent_no'] == $item['agent_id']){
               //潜在
               $arrData['list'][$key]['intertion_product'] = $item['inten_level'];
           }else{
               //签约
               $arrData['list'][$key]['intertion_product'] = $item['product_name'];
           }
       }
       return $arrData;
    }
    
    
    public function getAppointListByAgentId($iAgentId){
        return $this->select("appoint_id,visitor,contact_id,sappoint_time", "agent_id = {$iAgentId} and check_status =".AgentCheckStatus::CheckSuccess." and is_visit =1 and note = 0");
    }
}
?>
