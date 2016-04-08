<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_accompany 的类业务逻辑层
 * 表描述：
 * 创建人：许丹丹
 * 添加时间：2012-04-17 14:25:03
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/VisitAccompanyInfo.php';

class VisitAccompanyBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objVisitAccompanyInfo  VisitAccompanyInfo 实例
     * @return 
     */
	public function insert(VisitAccompanyInfo $objVisitAccompanyInfo)
	{
		$sql = "INSERT INTO `am_visit_accompany`(`invaited_uid`,`agent_id`,`visitor`,`tel`,`mobile`,`content`,`s_time`,`e_time`,`check_uid`,`check_detial`,`check_time`,`check_statu`,`create_uid`,`create_time`,`update_uid`,`update_time`,`note_id`,`agent_no`,`agent_name`,`create_user_name`,`update_user_name`,`check_user_name`,`invaited_user_name`,`check_address`,`remark_statu`,`remark_uid`,`remark_user_name`,`remark_time`,`remark_detail`) 
        values(".$objVisitAccompanyInfo->iInvaitedUid.",".$objVisitAccompanyInfo->iAgentId.",'".$objVisitAccompanyInfo->strVisitor."','".$objVisitAccompanyInfo->strTel."','".$objVisitAccompanyInfo->strMobile."','".$objVisitAccompanyInfo->strContent."','".$objVisitAccompanyInfo->strSTime."','".$objVisitAccompanyInfo->strETime."',".$objVisitAccompanyInfo->iCheckUid.",'".$objVisitAccompanyInfo->strCheckDetial."','".$objVisitAccompanyInfo->strCheckTime."',".$objVisitAccompanyInfo->iCheckStatu.",".$objVisitAccompanyInfo->iCreateUid.",now(),".$objVisitAccompanyInfo->iUpdateUid.",now(),".$objVisitAccompanyInfo->iNoteId.",'".$objVisitAccompanyInfo->strAgentNo."','".$objVisitAccompanyInfo->strAgentName."','".$objVisitAccompanyInfo->strCreateUserName."','".$objVisitAccompanyInfo->strUpdateUserName."','".$objVisitAccompanyInfo->strCheckUserName."','".$objVisitAccompanyInfo->strInvaitedUserName."','".$objVisitAccompanyInfo->strCheckAddress."',".$objVisitAccompanyInfo->iRemarkStatu.",".$objVisitAccompanyInfo->iRemarkUid.",'".$objVisitAccompanyInfo->strRemarkUserName."','".$objVisitAccompanyInfo->strRemarkTime."','".$objVisitAccompanyInfo->strRemarkDetail."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            $id = $this->objMysqlDB->lastInsertId();
            $this->UpdateNoteID($objVisitAccompanyInfo->strSTime,$objVisitAccompanyInfo->iAgentId,$objVisitAccompanyInfo->iInvaitedUid,$id);
            return $id;
        }
        
        return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objVisitAccompanyInfo  VisitAccompanyInfo 实例
     * @return
     */
	public function updateByID(VisitAccompanyInfo $objVisitAccompanyInfo)
	{
	   $sql = "update `am_visit_accompany` set `invaited_uid`=".$objVisitAccompanyInfo->iInvaitedUid.",`agent_id`=".$objVisitAccompanyInfo->iAgentId.",`visitor`='".$objVisitAccompanyInfo->strVisitor."',`tel`='".$objVisitAccompanyInfo->strTel."',`mobile`='".$objVisitAccompanyInfo->strMobile."',`content`='".$objVisitAccompanyInfo->strContent."',`s_time`='".$objVisitAccompanyInfo->strSTime."',`e_time`='".$objVisitAccompanyInfo->strETime."',`check_uid`=".$objVisitAccompanyInfo->iCheckUid.",`check_detial`='".$objVisitAccompanyInfo->strCheckDetial."',`check_time`='".$objVisitAccompanyInfo->strCheckTime."',`check_statu`=".$objVisitAccompanyInfo->iCheckStatu.",`update_uid`=".$objVisitAccompanyInfo->iUpdateUid.",`update_time`= now(),`note_id`=".$objVisitAccompanyInfo->iNoteId.",`agent_no`='".$objVisitAccompanyInfo->strAgentNo."',`agent_name`='".$objVisitAccompanyInfo->strAgentName."',`create_user_name`='".$objVisitAccompanyInfo->strCreateUserName."',`update_user_name`='".$objVisitAccompanyInfo->strUpdateUserName."',`check_user_name`='".$objVisitAccompanyInfo->strCheckUserName."',`invaited_user_name`='".$objVisitAccompanyInfo->strInvaitedUserName."',`check_address`='".$objVisitAccompanyInfo->strCheckAddress."',`remark_statu`=".$objVisitAccompanyInfo->iRemarkStatu.",`remark_uid`=".$objVisitAccompanyInfo->iRemarkUid.",`remark_user_name`='".$objVisitAccompanyInfo->strRemarkUserName."',`remark_time`='".$objVisitAccompanyInfo->strRemarkTime."',`remark_detail`='".$objVisitAccompanyInfo->strRemarkDetail."' where id=".$objVisitAccompanyInfo->iId;
        $updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        if($updateCount > 0)
            $this->UpdateNoteID($objVisitAccompanyInfo->strSTime,$objVisitAccompanyInfo->iAgentId,$objVisitAccompanyInfo->iInvaitedUid,$objVisitAccompanyInfo->iId);
        return $updateCount;
	}
    
	/**
     * @functional 预约对应小记
     */
    public function UpdateNoteID($actDate,$agentID,$iInvaitedUid,$accompanyID=0,$noteID = 0)
    {
        if($accompanyID == 0)
        {
            $sql = "SELECT id FROM am_visit_accompany where agent_id=$agentID and date(s_time)=date('$actDate') ";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (isset($arrayData)&& count($arrayData)>0)
                $accompanyID = $arrayData[0]["id"];
        }
        
        if($accompanyID == 0)
            return ;
            
        if($noteID == 0)
        {
            $sql = "SELECT id FROM am_visit_note where agent_id=$agentID and create_uid=$iInvaitedUid and date(visit_timestart) =date('$actDate') ";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if (isset($arrayData)&& count($arrayData)>0)
                $noteID = $arrayData[0]["id"];
        }
                
        $sql = "update am_visit_accompany set note_id = $noteID where id = $accompanyID";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
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
			$sField = T_VisitAccompany::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_visit_accompany` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 VisitAccompanyInfo 对象
	 * @param int $id 
     * @return VisitAccompanyInfo 对象
     */
	public function getModelByID($id)
	{
		$objVisitAccompanyInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objVisitAccompanyInfo = new VisitAccompanyInfo();
            		        
            $objVisitAccompanyInfo->iId = $arrayInfo[0]['id'];
            $objVisitAccompanyInfo->iInvaitedUid = $arrayInfo[0]['invaited_uid'];
            $objVisitAccompanyInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objVisitAccompanyInfo->strVisitor = $arrayInfo[0]['visitor'];
            $objVisitAccompanyInfo->strTel = $arrayInfo[0]['tel'];
            $objVisitAccompanyInfo->strMobile = $arrayInfo[0]['mobile'];
            $objVisitAccompanyInfo->strContent = $arrayInfo[0]['content'];
            $objVisitAccompanyInfo->strSTime = $arrayInfo[0]['s_time'];
            $objVisitAccompanyInfo->strETime = $arrayInfo[0]['e_time'];
            $objVisitAccompanyInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objVisitAccompanyInfo->strCheckDetial = $arrayInfo[0]['check_detial'];
            $objVisitAccompanyInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objVisitAccompanyInfo->iCheckStatu = $arrayInfo[0]['check_statu'];
            $objVisitAccompanyInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objVisitAccompanyInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objVisitAccompanyInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objVisitAccompanyInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objVisitAccompanyInfo->iNoteId = $arrayInfo[0]['note_id'];
            $objVisitAccompanyInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objVisitAccompanyInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objVisitAccompanyInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objVisitAccompanyInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objVisitAccompanyInfo->strCheckUserName = $arrayInfo[0]['check_user_name'];
            $objVisitAccompanyInfo->strInvaitedUserName = $arrayInfo[0]['invaited_user_name'];
            $objVisitAccompanyInfo->strCheckAddress = $arrayInfo[0]['check_address'];
            $objVisitAccompanyInfo->iRemarkStatu = $arrayInfo[0]['remark_statu'];
            $objVisitAccompanyInfo->iRemarkUid = $arrayInfo[0]['remark_uid'];
            $objVisitAccompanyInfo->strRemarkUserName = $arrayInfo[0]['remark_user_name'];
            $objVisitAccompanyInfo->strRemarkTime = $arrayInfo[0]['remark_time'];
            $objVisitAccompanyInfo->strRemarkDetail = $arrayInfo[0]['remark_detail'];
            settype($objVisitAccompanyInfo->iId,"integer");
            settype($objVisitAccompanyInfo->iInvaitedUid,"integer");
            settype($objVisitAccompanyInfo->iAgentId,"integer");
            settype($objVisitAccompanyInfo->iCheckUid,"integer");
            settype($objVisitAccompanyInfo->iCheckStatu,"integer");
            settype($objVisitAccompanyInfo->iCreateUid,"integer");
            settype($objVisitAccompanyInfo->iUpdateUid,"integer");
            settype($objVisitAccompanyInfo->iNoteId,"integer");
            settype($objVisitAccompanyInfo->iRemarkStatu,"integer");
            settype($objVisitAccompanyInfo->iRemarkUid,"integer");
            
        }
		return $objVisitAccompanyInfo;
       
	}
    /**
     * @functional 代理商
     * @param  $text 文本框内容
    */
	public function AutoAgentArray($text)
	{
	   $sql = "SELECT `am_agent_source`.`agent_name` as name,`am_agent_source`.`agent_id` as id
                FROM `am_agent_source` where  `am_agent_source`.`is_del`=0 and 
                `am_agent_source`.`agent_name` like '%$text%' and `am_agent_source`.is_check=1 order by `am_agent_source`.`agent_name` limit 0,15";
         return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         //$arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         //return json_encode(array('value'=>$arrayData));
	}
    /**
     * @functional 代理商
     * @param  $text 文本框内容
    */
	public function AgentArray($agent_name)
	{
	   $sql = "SELECT 
                  `am_agent_source`.`agent_name` as name,
                  `am_agent_source`.`agent_id` as id
                FROM
                  `am_agent_source` 
                where  `am_agent_source`.`is_del`=0 and 
                `am_agent_source`.`agent_name` ='$agent_name' and `am_agent_source`.is_check=1
                  ";
         return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         //$arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
         //return json_encode(array('value'=>$arrayData));
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
        $offset = ($iPageIndex - 1) * $iPageSize;
        
        $strWhere = " where 1=1 ".$strWhere;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;
        else
            $strOrder = " ORDER BY `am_visit_accompany`.id desc";
            
        if($bExportExcel == false)
        {
            $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM am_visit_accompany $strWhere ";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
                
        $sqlData = "SELECT ".T_VisitAccompany::AllFields." FROM am_visit_accompany $strWhere $strOrder LIMIT $offset,$iPageSize";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        AccompanyVisitCheckStatus::ReplaceArrayText($arrayData,"check_statu","check_statu_text");
        
        return $arrayData;
	}
    /**
     * @functional 取得拜访小记相关的陪访小记
     * @param  $visitnoteid 拜访小记ID
    */
    public function GetRelateAccompanyList($visitnoteid)
    {
        $sql = "SELECT sys_user.e_name,sys_user.user_id,ac.id,ac.create_time,ac.s_time,ac.e_time,ac.visitor,ac.tel,ac.check_statu,
        ac.content as ac_content,
        
         (select user.e_name as rname  from am_visit_acc_return rt left join sys_user user on user.user_id=rt.add_user_id where rt.accoID=ac.id order by rt.add_time desc limit 1) rname        
        from  am_visit_accompany  ac 
        left join am_visit_note on ac.agent_id=am_visit_note.agent_id
        left join sys_user on ac.create_uid=sys_user.user_id   
        
        where ac.invaited_name =  am_visit_note.create_uid and left(am_visit_note.visit_timestart,10)=left(ac.s_time,10) and am_visit_note.visitnoteid =$visitnoteid
        order by ac.create_time desc
                        ";//ac.check_statu,
                        //left join am_visit_acc_check acheck  on ac.id=acheck.accoID
                        //acheck.check_statu,acheck.detial,
                        //(select check_statu from  am_visit_acc_check where accoID=ac.id order by check_time desc limit 1) check_statu,
        return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	               
    }
    /**
     * @functional 根据ID取得陪访信息
     * @param  $id 陪访ID
    */
    public function AccompanyVisitInfo($id)
    {
        $sql = "SELECT     
                      su.`e_name` as inviter_name,su2.`e_name` as check_name,`am_agent_source`.`agent_name`,`sys_user`.`user_id`,`sys_user`.e_name,am.*
                    FROM
                      `am_visit_accompany` am  left JOIN
                      `am_agent_source` ON am.`agent_id` =
                      `am_agent_source`.`agent_id` left JOIN
                      `sys_user` ON am.`create_uid` = `sys_user`.`user_id`   
                      left join `sys_user` su on am.invaited_name = su.`user_id`
                      left join `sys_user` su2 on am.check_id = su2.`user_id`
                      where am.`id`=$id";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
    }
    /**
     * @functional 拜访那天是否已经添加过拜访预约或者陪访小记
     * @param  $uid用户ID,$agentId代理商ID,$time拜访时间,$id陪访小记ID（添加为0和编辑大于0）
     * 
    */
    public function IsExistAccompanyVisit($uid,$agentId,$time,$id)
    {
        if($id > 0)
            $strWhere = " and id <> $id ";
        else
            $strWhere = "";
        $sql = " select if(count(*)>0,1,(select count(*) from am_visit_note where create_uid =$uid and agent_id=$agentId and left(visit_timestart,10)='$time')) counts
                from  am_visit_accompany   
                where create_uid = $uid and agent_id=$agentId and left(s_time,10)='$time' $strWhere";
        
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);        
    }
    /**
     * @functional 陪访小记审核历史
     * @param  
     * 
    */
    public function CheckList($id)
    {
        $sql = " select acheck.*,sys_user.e_name from am_visit_acc_check acheck left join sys_user on acheck.check_uid = sys_user.user_id where acheck.accoID = ".$id." order by acheck.check_time desc";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
    }
    
}
		 