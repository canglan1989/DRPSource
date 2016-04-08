<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 cm_ag_contact_recode 的类业务逻辑层
 * 表描述：代理商联系/拜访小记 
 * 创建人：温智星
 * 添加时间：2012-10-24 15:03:30
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgContactRecodeInfo.php';
require_once "AgentIntentionRatingBLL.php";
require_once "AgentContactRecordBLL.php";

class AgContactRecodeBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objAgContactRecodeInfo  AgContactRecodeInfo 实例
     * @return 
     */
	public function insert(AgContactRecodeInfo $objAgContactRecodeInfo)
	{
		$sql = "INSERT INTO `cm_ag_contact_recode`(`source_id`,`is_visit`,`agent_id`,`agent_no`,`agent_name`,`customer_id`,`customer_name`,`visit_theme`,`invite_contact_name`,`invite_contact_tel`,`invite_contact_mobile`,`invite_status`,`invite_time`,`invite_e_time`,`invite_create_uid`,`invite_create_user_name`,`invite_create_time`,`invite_update_uid`,`invite_update_user_name`,`invite_update_time`,`invite_drop_time`,`contact_name`,`contact_tel`,`contact_mobile`,`contact_time`,`contact_e_time`,`contact_recode`,`not_valid_contact_id`,`not_valid_contact_name`,`is_alliance`,`intention_rating`,`intention_rating_name`,`income_date`,`income_money`,`is_to_sea`,`shield_day`,`is_del_customer`,`del_customer_reson`,`next_time`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`revisit_content`,`revisit_uid`,`revisit_user_name`,`revisit_time`,`is_intention_recode`,`is_last_intention`,`is_del`,`finance_uid`,`finance_no`) 
        values(".$objAgContactRecodeInfo->iSourceId.",".$objAgContactRecodeInfo->iIsVisit.",".$objAgContactRecodeInfo->iAgentId.",'".$objAgContactRecodeInfo->strAgentNo."','".$objAgContactRecodeInfo->strAgentName."',".$objAgContactRecodeInfo->iCustomerId.",'".$objAgContactRecodeInfo->strCustomerName."','".$objAgContactRecodeInfo->strVisitTheme."','".$objAgContactRecodeInfo->strInviteContactName."','".$objAgContactRecodeInfo->strInviteContactTel."','".$objAgContactRecodeInfo->strInviteContactMobile."',".$objAgContactRecodeInfo->iInviteStatus.",'".$objAgContactRecodeInfo->strInviteTime."','".$objAgContactRecodeInfo->strInviteETime."',".$objAgContactRecodeInfo->iInviteCreateUid.",'".$objAgContactRecodeInfo->strInviteCreateUserName."','".$objAgContactRecodeInfo->strInviteCreateTime."',".$objAgContactRecodeInfo->iInviteUpdateUid.",'".$objAgContactRecodeInfo->strInviteUpdateUserName."','".$objAgContactRecodeInfo->strInviteUpdateTime."','".$objAgContactRecodeInfo->strInviteDropTime."','".$objAgContactRecodeInfo->strContactName."','".$objAgContactRecodeInfo->strContactTel."','".$objAgContactRecodeInfo->strContactMobile."','".$objAgContactRecodeInfo->strContactTime."','".$objAgContactRecodeInfo->strContactETime."','".$objAgContactRecodeInfo->strContactRecode."',".$objAgContactRecodeInfo->iNotValidContactId.",'".$objAgContactRecodeInfo->strNotValidContactName."',".$objAgContactRecodeInfo->iIsAlliance.",".$objAgContactRecodeInfo->iIntentionRating.",'".$objAgContactRecodeInfo->strIntentionRatingName."','".$objAgContactRecodeInfo->strIncomeDate."',".$objAgContactRecodeInfo->iIncomeMoney.",".$objAgContactRecodeInfo->iIsToSea.",'".$objAgContactRecodeInfo->strShieldDay."',".$objAgContactRecodeInfo->iIsDelCustomer.",'".$objAgContactRecodeInfo->strDelCustomerReson."','".$objAgContactRecodeInfo->strNextTime."',".$objAgContactRecodeInfo->iCreateUid.",'".$objAgContactRecodeInfo->strCreateUserName."',now(),".$objAgContactRecodeInfo->iUpdateUid.",'".$objAgContactRecodeInfo->strUpdateUserName."',now(),'".$objAgContactRecodeInfo->strRevisitContent."',".$objAgContactRecodeInfo->iRevisitUid.",'".$objAgContactRecodeInfo->strRevisitUserName."','".$objAgContactRecodeInfo->strRevisitTime."',".$objAgContactRecodeInfo->iIsIntentionRecode.",".$objAgContactRecodeInfo->iIsLastIntention.",".$objAgContactRecodeInfo->iIsDel.",".$objAgContactRecodeInfo->iFinanceUid.",'".$objAgContactRecodeInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            $newID = $this->objMysqlDB->lastInsertId();
            if($objAgContactRecodeInfo->iIsVisit == 0 && $objAgContactRecodeInfo->iCreateUid > 0)
                $this->UpdateCustomerEx($objAgContactRecodeInfo->iCustomerId,$objAgContactRecodeInfo->iAgentId);//最后一次联系信息
                
            $objAgContactRecodeInfo->iRecodeId = $newID;
            $this->UpdateIntentionRating($objAgContactRecodeInfo);//网盟意向
            
            if($objAgContactRecodeInfo->iCreateUid > 0)
            {
                $this->UpdateIncomeReport($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$objAgContactRecodeInfo->strIncomeDate);
        
                //代理商客服联系量统计
                $reportDate = Utility::getShortDate($objAgContactRecodeInfo->strContactTime);
                $this->updateContactRecord($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$reportDate);
            }
                                
            return $newID;
        }            
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgContactRecodeInfo  AgContactRecodeInfo 实例
     * @return
     */
	public function updateByID(AgContactRecodeInfo $objAgContactRecodeInfo,$bIsUpdateRevisit=false)
	{
        $oldIncomeDate = "";        
        if($bIsUpdateRevisit == false)//不是回访信息更新
        {
            $arrayData = $this->select("income_date","create_uid > 0 and recode_id=".$objAgContactRecodeInfo->iRecodeId);
            if(isset($arrayData)&&count($arrayData)>0)
            {
                $oldIncomeDate = $arrayData[0]["income_date"];
            }
            
            $objAgContactRecodeInfo->strCreateTime = Utility::Now();
        }
       
	    $sql = "update `cm_ag_contact_recode` set `source_id`=".$objAgContactRecodeInfo->iSourceId.",`is_visit`=".$objAgContactRecodeInfo->iIsVisit.",`agent_id`=".$objAgContactRecodeInfo->iAgentId.",`agent_no`='".$objAgContactRecodeInfo->strAgentNo."',`agent_name`='".$objAgContactRecodeInfo->strAgentName."',`visit_theme`='".$objAgContactRecodeInfo->strVisitTheme."',`customer_id`=".$objAgContactRecodeInfo->iCustomerId.",`customer_name`='".$objAgContactRecodeInfo->strCustomerName."',`invite_contact_name`='".$objAgContactRecodeInfo->strInviteContactName."',`invite_contact_tel`='".$objAgContactRecodeInfo->strInviteContactTel."',`invite_contact_mobile`='".$objAgContactRecodeInfo->strInviteContactMobile."',`contact_tel`='".$objAgContactRecodeInfo->strContactTel."',`contact_mobile`='".$objAgContactRecodeInfo->strContactMobile."',`not_valid_contact_id`=".$objAgContactRecodeInfo->iNotValidContactId.",`not_valid_contact_name`='".$objAgContactRecodeInfo->strNotValidContactName."',`invite_status`=".$objAgContactRecodeInfo->iInviteStatus.",`invite_time`='".$objAgContactRecodeInfo->strInviteTime."',`invite_e_time`='".$objAgContactRecodeInfo->strInviteETime."',`invite_create_uid`=".$objAgContactRecodeInfo->iInviteCreateUid.",`invite_create_user_name`='".$objAgContactRecodeInfo->strInviteCreateUserName."',`invite_create_time`='".$objAgContactRecodeInfo->strInviteCreateTime."',`invite_update_uid`=".$objAgContactRecodeInfo->iInviteUpdateUid.",`invite_update_user_name`='".$objAgContactRecodeInfo->strInviteUpdateUserName."',`invite_update_time`='".$objAgContactRecodeInfo->strInviteUpdateTime."',`invite_drop_time`='".$objAgContactRecodeInfo->strInviteDropTime."',`contact_name`='".$objAgContactRecodeInfo->strContactName."',`contact_time`='".$objAgContactRecodeInfo->strContactTime."',`contact_e_time`='".$objAgContactRecodeInfo->strContactETime."',`contact_recode`='".$objAgContactRecodeInfo->strContactRecode."',`is_alliance`=".$objAgContactRecodeInfo->iIsAlliance.",`intention_rating`=".$objAgContactRecodeInfo->iIntentionRating.",`intention_rating_name`='".$objAgContactRecodeInfo->strIntentionRatingName."',`income_date`='".$objAgContactRecodeInfo->strIncomeDate."',`income_money`=".$objAgContactRecodeInfo->iIncomeMoney.",`is_to_sea`=".$objAgContactRecodeInfo->iIsToSea.",`shield_day`='".$objAgContactRecodeInfo->strShieldDay."',`is_del_customer`=".$objAgContactRecodeInfo->iIsDelCustomer.",`del_customer_reson`='".$objAgContactRecodeInfo->strDelCustomerReson."',`next_time`='".$objAgContactRecodeInfo->strNextTime
            ."',`create_uid`=".$objAgContactRecodeInfo->iCreateUid.",`create_user_name`='".$objAgContactRecodeInfo->strCreateUserName."',`create_time`='".$objAgContactRecodeInfo->strCreateTime."',`update_uid`=".$objAgContactRecodeInfo->iUpdateUid.",`update_user_name`='".$objAgContactRecodeInfo->strUpdateUserName."',`update_time`= now(),`revisit_content`='".$objAgContactRecodeInfo->strRevisitContent."',`revisit_uid`=".$objAgContactRecodeInfo->iRevisitUid.",`revisit_user_name`='".$objAgContactRecodeInfo->strRevisitUserName."',`revisit_time`='".$objAgContactRecodeInfo->strRevisitTime."',`is_intention_recode`=".$objAgContactRecodeInfo->iIsIntentionRecode.",`is_last_intention`=".$objAgContactRecodeInfo->iIsLastIntention.",`is_del`=".$objAgContactRecodeInfo->iIsDel.",`finance_uid`=".$objAgContactRecodeInfo->iFinanceUid.",`finance_no`='".$objAgContactRecodeInfo->strFinanceNo."' where recode_id=".$objAgContactRecodeInfo->iRecodeId;      
    
        $updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        if($bIsUpdateRevisit == false)
        {
            if($objAgContactRecodeInfo->iIsVisit == 0 && $objAgContactRecodeInfo->iCreateUid > 0 && $objAgContactRecodeInfo->iRevisitUid<=0)
                $this->UpdateCustomerEx($objAgContactRecodeInfo->iCustomerId,$objAgContactRecodeInfo->iAgentId);//最后一次联系信息
            
            $this->UpdateIntentionRating($objAgContactRecodeInfo);//网盟意向
                
            if($objAgContactRecodeInfo->iCreateUid > 0)
            {
                if($oldIncomeDate != "" && $oldIncomeDate != $objAgContactRecodeInfo->strIncomeDate)//预计到账时间有变化
                {
                    $this->UpdateIncomeReport($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$oldIncomeDate);
                }
               //$this->IntentionRatingReport($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$oldIncomeDate);
                
                $this->UpdateIncomeReport($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$objAgContactRecodeInfo->strIncomeDate);
        
                //代理商客服联系量统计    
                $reportDate = Utility::getShortDate($objAgContactRecodeInfo->strContactTime);
                $this->updateContactRecord($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$reportDate);
            }
        }
                
        return $updateCount;                
	}
    
    public function UpdateData($arrUpdateData,$strWhere){
            $arrSetField = array();
            foreach ($arrUpdateData as $key=>$value){
                $arrSetField[] = " `{$key}`='{$value}'";
            }
            $strSetField = implode(',', $arrSetField);
            $sql = "update `cm_ag_contact_recode` set {$strSetField} where {$strWhere}";
            return $this->objMysqlDB->executeNonQuery(false,$sql,null);
      }
    
    /**
     * @functional 联系小记的一些信息更新客户信息。
     * @param 客户ID
    */
    protected function UpdateCustomerEx($customerID,$agentID)
    {                   
        $sql = "SELECT contact_recode,is_alliance,intention_rating,intention_rating_name,contact_time,not_valid_contact_id,
            is_to_sea,`shield_day`,is_del_customer,create_uid  
            FROM cm_ag_contact_recode where customer_id=$customerID and agent_id =$agentID and 
            is_visit= 0 and invite_status >-1 and create_uid>0 and is_del=0 ORDER BY contact_time desc limit 0,1";//最近一条联系小记
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData)&&count($arrayData)>0)
        {
            //最近联系时间：最近的添加联系小记的“联系时间”字段输出的值，精确到秒    
            $sql = "update cm_customer_ex set record_count=record_count+1,last_record_time='".$arrayData[0]["contact_time"]."' where customer_id=$customerID and agent_id =$agentID;";
            if($arrayData[0]["not_valid_contact_id"] <= 0)//有效的联系
            {
                //最近联系内容：即最近联系小记的有效联系的联系内容或者无效联系的相应选项
                $sql .= "update cm_customer_ex set last_record_content='".$arrayData[0]["contact_recode"]."' where customer_id=$customerID and agent_id =$agentID;";
                                
                //网盟意向等级：由网盟意向等级选项操作的值决定（添加联系小记-选择网盟推广选项所选择的意向等级相应的值） 
                if($arrayData[0]["is_alliance"] == 1 && $arrayData[0]["intention_rating"] > 0)
                    $sql .= "update cm_customer_ex set intention_rating=".$arrayData[0]["intention_rating"].",intention_rating_name='".$arrayData[0]["intention_rating_name"]."' where customer_id=$customerID and agent_id =$agentID;";
            }
            $this->objMysqlDB->executeNonQuery(false,$sql,null);   
            
            if($arrayData[0]["is_to_sea"] == 1)//踢入公海
            {
                
                $sql = "update cm_customer_ex set last_to_sea_time=now(),to_sea_time=now(),shield_uid=0,shield_time=now() where customer_id=$customerID and agent_id =$agentID;";
                if($arrayData[0]["shield_day"] == "")
                    $arrayData[0]["shield_day"] = 0;
                    
                settype($arrayData[0]["shield_day"],"integer");
                if($arrayData[0]["shield_day"] > 0)//屏蔽天数
                {
                    $shield_day = Utility::addDay(Utility::Now(),$arrayData[0]["shield_day"],false);
                    $sql .= "update cm_customer_ex set shield_uid=".$arrayData[0]["create_uid"].",shield_time='{$shield_day}' where customer_id=$customerID and agent_id =$agentID;";
                }
                
                $this->objMysqlDB->executeNonQuery(false,$sql,null);  
            }  else {
                $strExSql = "select defend_state,record_count from cm_customer_ex where customer_id={$customerID} and agent_id={$agentID} limit 1";
                $arrExDate = $this->objMysqlDB->fetchAllAssoc(false, $strExSql, null);
                include_once 'DataConfigBLL.php';
                $objDataConfigBLL = new DataConfigBLL();
                switch ($arrExDate[0]['defend_state']) {
                    case CustomerDefendState::DefendCustomer: {
                            if ($arrExDate[0]['record_count'] > 1) {
                                $iDefendTime = $objDataConfigBLL->GetProtectTime_Protect_Record($agentID);
                            } else {
                                $iDefendTime = $objDataConfigBLL->GetProtectTime_Protect_No_Record($agentID);
                            }
                        }break;
                    case CustomerDefendState::AddMyselfCustomer: {
                            if ($arrExDate[0]['record_count'] > 1) {
                                $iDefendTime = $objDataConfigBLL->GetProtectTime_Self_Record($agentID);
                            } else {
                                $iDefendTime = $objDataConfigBLL->GetProtectTime_Self_No_Record($agentID);
                            }
                        }break;
                    case CustomerDefendState::HasOrderCustomer: {
                            $iDefendTime = $objDataConfigBLL->GetProtectTime_Formal($agentID);
                        }break;
                    default :$iDefendTime = $objDataConfigBLL->GetProtectTime_Tel($agentID);
                        break;
                }
                $strUpdateSql = "update cm_customer_ex set to_sea_time = '".Utility::addDay(Utility::Now(), $iDefendTime, false)."' where customer_id={$customerID} and agent_id={$agentID} ";
                $this->objMysqlDB->executeNonQuery(false,$strUpdateSql,null); 
            }
        }
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID) {
        $sql = "update `cm_ag_contact_recode` set is_del=1,update_uid=" . $userID . ",update_time=now() where recode_id=" . $id;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "") {
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
			$sField = T_AgContactRecode::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `cm_ag_contact_recode` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgContactRecodeInfo 对象
	 * @param int $id 
     * @return AgContactRecodeInfo 对象
     */
	public function getModelByID($id,$agentID = 0)
	{
		$objAgContactRecodeInfo = null;
        $sWhere = "recode_id=".$id;
        if($agentID > 0)
            $sWhere .= " and agent_id=".$agentID;
            
		$arrayInfo = $this->select("*",$sWhere,"");		
		return $this->f_arrayDataToInfo($arrayInfo);
       
	}
    
    protected function f_arrayDataToInfo($arrayInfo)
    {        
		$objAgContactRecodeInfo = null;
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgContactRecodeInfo = new AgContactRecodeInfo();
            		        
            $objAgContactRecodeInfo->iRecodeId = $arrayInfo[0]['recode_id'];
            $objAgContactRecodeInfo->iSourceId = $arrayInfo[0]['source_id'];
            $objAgContactRecodeInfo->iIsVisit = $arrayInfo[0]['is_visit'];
            $objAgContactRecodeInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgContactRecodeInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objAgContactRecodeInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objAgContactRecodeInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objAgContactRecodeInfo->strCustomerName = $arrayInfo[0]['customer_name'];
            $objAgContactRecodeInfo->strVisitTheme = $arrayInfo[0]['visit_theme'];
            $objAgContactRecodeInfo->strInviteContactName = $arrayInfo[0]['invite_contact_name'];
            $objAgContactRecodeInfo->strInviteContactTel = $arrayInfo[0]['invite_contact_tel'];
            $objAgContactRecodeInfo->strInviteContactMobile = $arrayInfo[0]['invite_contact_mobile'];
            $objAgContactRecodeInfo->iInviteStatus = $arrayInfo[0]['invite_status'];
            $objAgContactRecodeInfo->strInviteTime = $arrayInfo[0]['invite_time'];
            $objAgContactRecodeInfo->strInviteETime = $arrayInfo[0]['invite_e_time'];
            $objAgContactRecodeInfo->iInviteCreateUid = $arrayInfo[0]['invite_create_uid'];
            $objAgContactRecodeInfo->strInviteCreateUserName = $arrayInfo[0]['invite_create_user_name'];
            $objAgContactRecodeInfo->strInviteCreateTime = $arrayInfo[0]['invite_create_time'];
            $objAgContactRecodeInfo->iInviteUpdateUid = $arrayInfo[0]['invite_update_uid'];
            $objAgContactRecodeInfo->strInviteUpdateUserName = $arrayInfo[0]['invite_update_user_name'];
            $objAgContactRecodeInfo->strInviteUpdateTime = $arrayInfo[0]['invite_update_time'];
            $objAgContactRecodeInfo->strInviteDropTime = $arrayInfo[0]['invite_drop_time'];
            $objAgContactRecodeInfo->strContactName = $arrayInfo[0]['contact_name'];
            $objAgContactRecodeInfo->strContactTel = $arrayInfo[0]['contact_tel'];
            $objAgContactRecodeInfo->strContactMobile = $arrayInfo[0]['contact_mobile'];
            $objAgContactRecodeInfo->strContactTime = $arrayInfo[0]['contact_time'];
            $objAgContactRecodeInfo->strContactETime = $arrayInfo[0]['contact_e_time'];
            $objAgContactRecodeInfo->strContactRecode = $arrayInfo[0]['contact_recode'];
            $objAgContactRecodeInfo->iNotValidContactId = $arrayInfo[0]['not_valid_contact_id'];
            $objAgContactRecodeInfo->strNotValidContactName = $arrayInfo[0]['not_valid_contact_name'];
            $objAgContactRecodeInfo->iIsAlliance = $arrayInfo[0]['is_alliance'];
            $objAgContactRecodeInfo->iIntentionRating = $arrayInfo[0]['intention_rating'];
            $objAgContactRecodeInfo->strIntentionRatingName = $arrayInfo[0]['intention_rating_name'];
            $objAgContactRecodeInfo->strIncomeDate = $arrayInfo[0]['income_date'];
            $objAgContactRecodeInfo->iIncomeMoney = $arrayInfo[0]['income_money'];
            $objAgContactRecodeInfo->iIsToSea = $arrayInfo[0]['is_to_sea'];
            $objAgContactRecodeInfo->strShieldDay = $arrayInfo[0]['shield_day'];
            $objAgContactRecodeInfo->iIsDelCustomer = $arrayInfo[0]['is_del_customer'];
            $objAgContactRecodeInfo->strDelCustomerReson = $arrayInfo[0]['del_customer_reson'];
            $objAgContactRecodeInfo->strNextTime = $arrayInfo[0]['next_time'];
            $objAgContactRecodeInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgContactRecodeInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objAgContactRecodeInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgContactRecodeInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgContactRecodeInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objAgContactRecodeInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgContactRecodeInfo->strRevisitContent = $arrayInfo[0]['revisit_content'];
            $objAgContactRecodeInfo->iRevisitUid = $arrayInfo[0]['revisit_uid'];
            $objAgContactRecodeInfo->strRevisitUserName = $arrayInfo[0]['revisit_user_name'];
            $objAgContactRecodeInfo->strRevisitTime = $arrayInfo[0]['revisit_time'];
            $objAgContactRecodeInfo->iIsIntentionRecode = $arrayInfo[0]['is_intention_recode'];
            $objAgContactRecodeInfo->iIsLastIntention = $arrayInfo[0]['is_last_intention'];
            $objAgContactRecodeInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objAgContactRecodeInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objAgContactRecodeInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objAgContactRecodeInfo->iRecodeId,"integer");
            settype($objAgContactRecodeInfo->iSourceId,"integer");
            settype($objAgContactRecodeInfo->iIsVisit,"integer");
            settype($objAgContactRecodeInfo->iAgentId,"integer");
            settype($objAgContactRecodeInfo->iCustomerId,"integer");
            settype($objAgContactRecodeInfo->iInviteStatus,"integer");
            settype($objAgContactRecodeInfo->iInviteCreateUid,"integer");
            settype($objAgContactRecodeInfo->iInviteUpdateUid,"integer");
            settype($objAgContactRecodeInfo->iNotValidContactId,"integer");
            settype($objAgContactRecodeInfo->iIsAlliance,"integer");
            settype($objAgContactRecodeInfo->iIntentionRating,"integer");
            settype($objAgContactRecodeInfo->iIncomeMoney,"float");
            settype($objAgContactRecodeInfo->iIsToSea,"integer");
            settype($objAgContactRecodeInfo->iIsDelCustomer,"integer");
            settype($objAgContactRecodeInfo->iCreateUid,"integer");
            settype($objAgContactRecodeInfo->iUpdateUid,"integer");
            settype($objAgContactRecodeInfo->iRevisitUid,"integer");
            settype($objAgContactRecodeInfo->iIsIntentionRecode,"integer");
            settype($objAgContactRecodeInfo->iIsLastIntention,"integer");
            settype($objAgContactRecodeInfo->iIsDel,"integer");
            settype($objAgContactRecodeInfo->iFinanceUid,"integer");
            
        }
		return $objAgContactRecodeInfo;
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
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount,$bExportExcel = false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex - 1) * $iPageSize;
        
        $sWhere = " cm_ag_contact_recode.is_del=0";
        if($strWhere != "")
            $sWhere .= $strWhere;
            
        if($strOrder == "")
            $strOrder = " if(cm_ag_contact_recode.invite_status = -1,3,cm_ag_contact_recode.invite_status) asc,cm_ag_contact_recode.invite_time asc";
        
		$sqlCount = "SELECT COUNT(1) as count FROM `cm_ag_contact_recode` 
            left join sys_user on sys_user.user_id = cm_ag_contact_recode.create_uid where ".$sWhere;

        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sqlData  = "SELECT ".T_AgContactRecode::AllFields." FROM `cm_ag_contact_recode` 
            left join sys_user on sys_user.user_id = cm_ag_contact_recode.create_uid WHERE $sWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";

        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * 预约删除
    */
    public function InviteDel($iIsVisit,$ids,$agentId,$delUid,$delUserName)
    {
        $sql = "update cm_ag_contact_recode set invite_update_uid={$delUid},invite_update_user_name='{$delUserName}',
        invite_update_time=now(), is_del =1 where agent_id=$agentId and create_uid<=0 and is_visit= $iIsVisit and is_del=0 
        and recode_id in($ids)";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    /**
     * 预约作废
    */
    public function InviteDrop($iIsVisit,$ids,$agentId,$dropUid,$dropUserName)
    {
        $sql = "update cm_ag_contact_recode set invite_update_uid={$dropUid},invite_update_user_name='{$dropUserName}',
        invite_update_time=now(),invite_drop_time=now(), invite_status =-1 where agent_id=$agentId and create_uid<=0 and is_visit= $iIsVisit and is_del=0 
        and recode_id in($ids)";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    
    /**
     * @function 最近的一次预计到帐
     * @return PredictIncomeInfo 对象
    */
    public function GetPredictIncome($customerID,$agentID)
    {
        $sWhere = "customer_id=$customerID and agent_id=$agentID and is_intention_recode = 1 and is_del=0 and income_date>=DATE_FORMAT(now(),'%Y-%m-%d')";
		$arrayInfo = $this->selectTop("*",$sWhere,"income_date","",1); 
		return $this->f_arrayDataToInfo($arrayInfo);        
    }
    
    
    /**
     * 更新意向
    */
    public function UpdateIntentionRating(AgContactRecodeInfo $objAgContactRecodeInfo)
    {
        if($objAgContactRecodeInfo->iRecodeId<=0 || $objAgContactRecodeInfo->iCreateUid <= 0)//不是记录
            return ;
            
        if($objAgContactRecodeInfo->iIsAlliance != 1 || $objAgContactRecodeInfo->iNotValidContactId > 0)//不是有效的网盟联系
            return ;
                          
        $bUpdateIntention = false;
        //前一条记录的意向
        $sql = "SELECT intention_rating,contact_time,income_date,income_money FROM 
            cm_ag_contact_recode where is_intention_recode = 1 and agent_id = ".$objAgContactRecodeInfo->iAgentId." and customer_id = ".$objAgContactRecodeInfo->iCustomerId." and 
            is_alliance = 1 AND not_valid_contact_id<=0 and create_time < '".$objAgContactRecodeInfo->strCreateTime."' and create_uid>0 and is_del=0 order by create_time desc,recode_id desc limit 0,1";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            if($arrayData[0]["intention_rating"] != $objAgContactRecodeInfo->iIntentionRating)
                $bUpdateIntention = true;
        }
        else
        {
            $bUpdateIntention = true;
        }
       
//        if($bUpdateIntention == false)
//        {
//            //后一条记录的意向
//            $sql = "SELECT intention_rating,contact_time,income_date,income_money FROM 
//                cm_ag_contact_recode where agent_id = ".$objAgContactRecodeInfo->iAgentId." and customer_id = ".$objAgContactRecodeInfo->iCustomerId." and 
//                is_alliance = 1 AND not_valid_contact_id<=0 and create_time > '".$objAgContactRecodeInfo->strCreateTime."' and create_uid>0 and is_del=0 order by create_time,recode_id limit 0,1";
//            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
//            if(isset($arrayData) && count($arrayData) > 0)
//            {
//                if($arrayData[0]["intention_rating"] != $objAgContactRecodeInfo->iIntentionRating)
//                    $bUpdateIntention = true;
//            }
//        }
        
        if($bUpdateIntention == true)
        {
            //打上新的意向标记
            $sql = "update cm_ag_contact_recode set is_intention_recode = 0 where agent_id = ".$objAgContactRecodeInfo->iAgentId." and customer_id = ".$objAgContactRecodeInfo->iCustomerId." and 
                is_alliance = 1 and is_intention_recode = 1 AND not_valid_contact_id<=0 and date(create_time) =date( '".$objAgContactRecodeInfo->strCreateTime
                    ."');update cm_ag_contact_recode set is_intention_recode = 1 where recode_id=".$objAgContactRecodeInfo->iRecodeId;
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
            $recode_id = 0;
            //更新最近一次的意向
            $sql = "SELECT recode_id FROM 
                cm_ag_contact_recode where agent_id = ".$objAgContactRecodeInfo->iAgentId." and customer_id = ".$objAgContactRecodeInfo->iCustomerId." and 
                is_alliance = 1 and is_intention_recode = 1 AND not_valid_contact_id<=0 and create_uid>0 and is_del=0 order by create_time desc,recode_id desc limit 0,1";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if(isset($arrayData) && count($arrayData) > 0)
            {
                $recode_id = $arrayData[0]["recode_id"];
            }
            
            $sql = "update cm_ag_contact_recode set is_last_intention = 0 where agent_id = ".$objAgContactRecodeInfo->iAgentId." and customer_id = ".$objAgContactRecodeInfo->iCustomerId." and 
                is_alliance = 1 AND not_valid_contact_id<=0 and create_uid>0 and is_del=0 and is_intention_recode = 1;update cm_ag_contact_recode set is_last_intention = 1 where recode_id=".$recode_id;
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            $reportDate = Utility::getShortDate($objAgContactRecodeInfo->strCreateTime);
            $this->IntentionRatingReport($objAgContactRecodeInfo->iAgentId,$objAgContactRecodeInfo->iCreateUid,$reportDate);
        }
    }
    
    
    /**
     * 预计到帐更新
    */
    public function UpdateIncomeReport($agentId,$userId,$reportDate)
    {   
        if(Utility::compareSEDate($reportDate,"2011-01-01") > 0)
            return ;
            
        $record_count = 0;
        $income_money = 0;
        //预计到账单量 预计到账金额                
        $sql = "SELECT count(recode_id) as recode_id,ifnull(sum(income_money),0) as income_money FROM cm_ag_contact_recode 
            where is_intention_recode =1 and create_uid = $userId and agent_id = $agentId and income_money>0 and income_date = '$reportDate' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData)&& count($arrayData) > 0)
        {               
            $record_count = $arrayData[0]["recode_id"];
            if($record_count > 0)
                $income_money = $arrayData[0]["income_money"];
        } 
                       
        $objAgentIntentionRatingBLL = new AgentIntentionRatingBLL();
        $objAgentIntentionRatingBLL->insertData($agentId,$userId,$reportDate);   
        $sql = "update rpt_agent_intention_rating set order_count=$record_count,income_money=$income_money where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);  
    }
    
    
    /**
     * 意向报表数据更新
    */
    public function IntentionRatingReport($agentId,$userId,$reportDate)
    {
        
        if(Utility::compareSEDate($reportDate,"2011-01-01") > 0)
            return ;
            
        $objAgentIntentionRatingBLL = new AgentIntentionRatingBLL();
        $objAgentIntentionRatingBLL->insertData($agentId,$userId,$reportDate);
        //转款量 转款金额 这个做到转款里
                        
        //当日 类增减
        $arrayCount = array("de2a"=>0,"bm2a"=>0,"de2bp"=>0,"bm2bp"=>0,"bm2de"=>0,"de2bm"=>0,"bp2bm"=>0,"bp2a"=>0,"bp2de"=>0,"a2bp"=>0,"a2bm"=>0,"a2de"=>0,
        "rating_1"=>0,"rating_2"=>0,"rating_3"=>0,"rating_4"=>0,"rating_5"=>0,"rating_6"=>0,"rating_7"=>0);
        
        $sql = "SELECT recode_id,customer_id,intention_rating,create_time FROM cm_ag_contact_recode 
            where is_intention_recode =1 and create_uid = $userId and agent_id = $agentId and date(create_time) = date('$reportDate') ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
 
        foreach($arrayData as $key => $value)
        {
            $arrayCount["rating_".$value["intention_rating"]]++;
            if ($value["intention_rating"] != 5) {
                //这条记录前一次的记录前一条记录的意向
                $sql = "SELECT intention_rating FROM cm_ag_contact_recode where is_intention_recode = 1 and agent_id = $agentId and customer_id = " . $value["customer_id"] . " and 
                is_alliance = 1 AND not_valid_contact_id<=0 and create_time < '" . $value["create_time"] . "' and create_uid>0 and is_del=0 order by create_time desc,recode_id desc limit 0,1";
                $arrayIntention = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
                if (isset($arrayIntention) && count($arrayIntention) > 0) {                    
                    if ($arrayIntention[0]["intention_rating"] != 5 && $this->f_intention_rating($arrayIntention[0]["intention_rating"]) != $this->f_intention_rating($value["intention_rating"])) {
                        $arrayCount[$this->f_intention_rating($arrayIntention[0]["intention_rating"]) . "2" . $this->f_intention_rating($value["intention_rating"])]++;
                    }
                } else {
                    if ($this->f_intention_rating($value["intention_rating"]) != "de")
                        $arrayCount["de2" . $this->f_intention_rating($value["intention_rating"])]++;
                }
            }
        }
        $sql = "update rpt_agent_intention_rating set report_date ='$reportDate'";
        foreach($arrayCount as $key => $value)
        {
            $sql .= ",$key=".$value;
        }        
        $sql .=" where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'";
        
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    private function f_intention_rating($v)
    {
        switch($v)
        {
            case 1:               
            case 2:
                return "a";
            break;
            case 3:
                return "bp";
            break;
            case 4:
                return "bm";
            break;
            case 5:
                return "c";
            break;
            case 6:
            case 7:
                return "de";
            break;
        }
        
        return "de";
    }
    
    /**
     * 代理商客服联系量统计
    */
    protected function updateContactRecord($agentId,$userId,$reportDate)
    {
        $objAgentContactRecordBLL = new AgentContactRecordBLL();
        $objAgentContactRecordBLL->insertData($agentId,$userId,$reportDate);  
        $sql ="SELECT ifnull(sum(is_visit),0) as visit_count,count(recode_id) as record_count,ifnull(SUM(if(is_visit = 0 and not_valid_contact_id<=0,1,0)),0) as valid_contact_count 
                FROM cm_ag_contact_recode where agent_id = $agentId and create_uid = $userId and DATE_FORMAT(contact_time,'%Y-%m-%d') ='$reportDate' and is_del=0";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $record_count = $arrayData[0]["record_count"]-$arrayData[0]["visit_count"];
            
            $sql = "update rpt_agent_contact_record set `record_count`=".$record_count.",`valid_count`=".
            $arrayData[0]["valid_contact_count"].",`valid_rate`=".($record_count > 0 ? ($arrayData[0]["valid_contact_count"]/$record_count) : 0)
            .",`visit_count`=".$arrayData[0]["visit_count"];
            
            $sql .=" where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'";        
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
    }
    
    public function getAdHaiIntentionRatingRecordList($strWhere,$strOrder){
        $strWhere = " where cm_ag_contact_recode.create_uid > 0 and cm_ag_contact_recode.is_intention_recode = 1 {$strWhere} and cm_ag_contact_recode.is_del = 0 ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_ag_contact_recode.create_time desc "; 
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select cm_ag_contact_recode.customer_id,cm_ag_contact_recode.customer_name,cm_ag_contact_recode.is_visit,cm_ag_contact_recode.intention_rating,cm_ag_contact_recode.intention_rating_name,
                cm_ag_contact_recode.income_date,cm_ag_contact_recode.income_money,cm_ag_contact_recode.create_user_name,cm_ag_contact_recode.create_uid,cm_ag_contact_recode.create_time 
                from cm_ag_contact_recode 
                left join sys_user on cm_ag_contact_recode.create_uid = sys_user.user_id
                {$strWhere} {$strOrder}";
        $arrData = $this->getPageData($sql);
        return $arrData;
    }
    
    
    public function getAgentContactRecordList($strWhere,$strOrder){
        $strWhere = " where cm_ag_contact_recode.is_del = 0 {$strWhere} and cm_ag_contact_recode.create_uid > 0 and am_agent_source.is_del = 0 and sys_user.is_del = 0 ";
        if(empty ($strOrder)){
            $strOrder = " order by cm_ag_contact_recode.agent_id desc,cm_ag_contact_recode.create_time desc,cm_ag_contact_recode.revisit_uid asc ";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select cm_ag_contact_recode.customer_id,cm_ag_contact_recode.customer_name,cm_ag_contact_recode.is_visit,cm_ag_contact_recode.intention_rating_name,
                cm_ag_contact_recode.intention_rating,cm_ag_contact_recode.contact_name,cm_ag_contact_recode.contact_tel,cm_ag_contact_recode.contact_mobile,
                cm_ag_contact_recode.contact_time,cm_ag_contact_recode.create_uid,cm_ag_contact_recode.create_user_name,cm_ag_contact_recode.not_valid_contact_id,
                cm_ag_contact_recode.contact_recode,cm_ag_contact_recode.revisit_uid,cm_ag_contact_recode.revisit_user_name,cm_ag_contact_recode.revisit_time,
                sys_user.user_name,sys_user.e_name,am_agent_source.agent_name,cm_ag_contact_recode.agent_id,cm_ag_contact_recode.recode_id,cm_ag_contact_recode.contact_e_time,
                am_agent_source.channel_uid,cm_ag_contact_recode.income_money,cm_ag_contact_recode.income_date,cm_ag_contact_recode.create_time
                from cm_ag_contact_recode 
                left join am_agent_source on am_agent_source.agent_id = cm_ag_contact_recode.agent_id
                left join sys_user on sys_user.user_id = am_agent_source.channel_uid
                {$strWhere} {$strOrder} ";
        $arrData = $this->getPageData($sql);
        return $arrData;
    } 
}
		 