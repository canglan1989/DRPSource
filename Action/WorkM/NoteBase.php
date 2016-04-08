<?php

/**
 * 拜访、联系小记基类
 *
 * @author xxf
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeHistoryBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__ . '/../../Class/BLL/UploadDocBLL.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';
require_once __DIR__ . '/../../Class/BLL/AgentPermitBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';


class NoteBase extends ActionBase {

    /**
     * 添加预计到账相关信息
     */
    public function addExpectInfo($agentId, $expect_time, $expect_money, $percentage, $type, $level, $iProductId, $iNoteId = 0, $iIsNew = 1) {
        $objExpectChargeBLL = new ExpectChargeBLL();
        $arrExpect = $objExpectChargeBLL->getInfoByAgentId($agentId);
        $objExpectChargeInfo = new ExpectChargeInfo();
        $objExpectChargeInfo->iAgentId = $agentId;
        $objExpectChargeInfo->strIntenLevel = ($iIsNew || !$arrExpect) ? $level : $arrExpect[0]['inten_level'];
        $objExpectChargeInfo->iProductId = $iProductId;
        if ($arrExpect) {
            if ($iIsNew && $level <= 'B+') {
                $objExpectChargeInfo->strExpectTime = $expect_time;
                $objExpectChargeInfo->iExpectMoney = $expect_money;
                $objExpectChargeInfo->iChargePercentage = $percentage;
                $objExpectChargeInfo->iExpectType = $type;
            } else {
                $objExpectChargeInfo->strExpectTime = $arrExpect[0]['expect_time'];
                $objExpectChargeInfo->iExpectMoney = $arrExpect[0]['expect_money'];
                $objExpectChargeInfo->iChargePercentage = $arrExpect[0]['charge_percentage'];
                $objExpectChargeInfo->iExpectType = $arrExpect[0]['expect_type'];
            }
        } else {
            $objExpectChargeInfo->strExpectTime = $expect_time;
            $objExpectChargeInfo->iExpectMoney = $expect_money;
            $objExpectChargeInfo->iChargePercentage = $percentage;
            $objExpectChargeInfo->iExpectType = $type;
        }
        $objExpectChargeInfo->iCreateUid = $this->getUserId();

        if (!empty($iNoteId)) {
            $objVisitNoteBLL = new VisitNoteBLL();
            $iNoteRtn = $objVisitNoteBLL->setExpectInfo($iNoteId, $objExpectChargeInfo->strExpectTime, $objExpectChargeInfo->iExpectMoney, $objExpectChargeInfo->iChargePercentage, $objExpectChargeInfo->iExpectType);
        }

        //判断该代理商是否有预计到账记录，没有->添加，有-覆盖，并添加历史记录
        if (count($arrExpect) == 0) {
            $objExpectChargeBLL->insert($objExpectChargeInfo);
        } else {
            if ($iIsNew && ($arrExpect[0]["inten_level"] != $level || $arrExpect[0]["expect_time"] != $expect_time || $arrExpect[0]["expect_money"] != $expect_money || $arrExpect[0]["charge_percentage"] != $percentage || $arrExpect[0]["expect_type"] != $type || $arrExpect[0]['product_id'] != $iProductId)) {
                $objExpectChargeHistoryBLL = new ExpectChargeHistoryBLL();
                $objExpectChargeHistoryInfo = new ExpectChargeHistoryInfo();
                $objExpectChargeHistoryInfo->iProductId = $arrExpect[0]["product_id"];
                $objExpectChargeHistoryInfo->iAgentId = $arrExpect[0]["agent_id"];
                $objExpectChargeHistoryInfo->strIntenLevel = $arrExpect[0]["inten_level"];
                $objExpectChargeHistoryInfo->strExpectTime = $arrExpect[0]["expect_time"];
                $objExpectChargeHistoryInfo->iExpectMoney = $arrExpect[0]["expect_money"];
                $objExpectChargeHistoryInfo->iChargePercentage = $arrExpect[0]["charge_percentage"];
                $objExpectChargeHistoryInfo->iExpectType = $arrExpect[0]["expect_type"];
                $objExpectChargeHistoryInfo->iCreateUid = $arrExpect[0]["create_uid"];
                $objExpectChargeHistoryInfo->strCreateTime = $arrExpect[0]["create_time"];
                $objExpectChargeHistoryInfo->iOperateUid = $this->getUserId();
                //将覆盖掉的记录转移到历史记录表
                $objExpectChargeHistoryBLL->insert($objExpectChargeHistoryInfo);

                $objExpectChargeInfo->iId = $arrExpect[0]["id"];
                $objExpectChargeBLL->updateByID($objExpectChargeInfo);
            }
        }
    }

    public function AddFileUpdate() {
        $this->ExitWhenNoRight("AgentDocList", RightValue::add);
        $agentID = Utility::GetFormInt("tbxAgentID", $_POST); 
        $agentName = Utility::GetForm("tbxAgent", $_POST); 
        if($agentID <= 0 || $agentName == "")
            exit("请选择代理商");
        
        $strAuthor = urldecode(Utility::GetForm("tbxAuthor", $_POST));
        $iFileType = Utility::GetFormInt("cbDocType", $_POST);
        if($iFileType <= 0)
            exit("请选择文件类型");
            
        $cbPermitType = 0;
        if($iFileType == AgentDocType::Qualification)
        {
            $cbPermitType = Utility::GetFormInt('cbPermitType',$_POST);
            if($cbPermitType <= 0)
                exit("请选择资质类型！");
        }
        
        $strFileName = Utility::GetForm("tbxUploadFilePath", $_POST);
        $strFilePath = "$agentID/".$strFileName;
        if($strFileName == "")
            exit("请上传文件");
            
        $strFileName = Utility::GetForm("filename", $_POST);
        if($strFileName == "")
            exit("上传文件名为空");   
        
        $objAgentBLL = new AgentBLL();
        $agentInfo = $objAgentBLL->getModelByID($agentID);
        if($agentInfo == null)
            exit("代理商不存在！");
            
        if($cbPermitType <= 0)
        {
            //删除同名文件
            $objUploadDocBLL = new UploadDocBLL();
            $objUploadDocInfo = null;
            $docID = $objUploadDocBLL->ExistFile(UploadDocObjctType::Agent,$iFileType,$agentID,$strFileName);
            if($docID > 0)
            {
                $objUploadDocInfo = $objUploadDocBLL->getModelByID($docID);
                //wzx 暂时不做删除文件的操作
                //$objFileOperate = new FileOperate();
                //$strUploadPath = "FrontFile/upload/AgentFile/".$objUploadDocInfo->strFilePath;
                //$objFileOperate->delFile(__DIR__ . '/../../'.$strUploadPath);
            }
            
            if($objUploadDocInfo == null)
                $objUploadDocInfo = new UploadDocInfo();
            
            $objUploadDocInfo->iObjectType = UploadDocObjctType::Agent;
            $objUploadDocInfo->iObjectId = $agentInfo->iAgentId;
            $objUploadDocInfo->strObjectNo = $agentInfo->strAgentNo;
            $objUploadDocInfo->strObjectName = $agentInfo->strAgentName;
            $objUploadDocInfo->strFileName = $strFileName;
            
            $objUploadDocInfo->strFilePath = $strFilePath;
            $objUploadDocInfo->strAuthor = $strAuthor;
            $objUploadDocInfo->iFileType = $iFileType;
            
            $objUploadDocInfo->iIsDel = 0;
            if($objUploadDocInfo->iDocId > 0)
            {
                $objUploadDocInfo->iUpdateUid =  $this->getUserId();
                $objUploadDocInfo->strUpdateUserName = $this->getUserName()." ". $this->getUserCNName();
                $c = $objUploadDocBLL->updateByID($objUploadDocInfo);
                if($objUploadDocBLL->updateByID($objUploadDocInfo) <= 0)
                    return 0;
            }
            else
            {      
                $objUploadDocInfo->iCreateUid = $this->getUserId();
                $objUploadDocInfo->strCreateUserName = $this->getUserName()." ". $this->getUserCNName();
                $docID = $objUploadDocBLL->insert($objUploadDocInfo);
                if($docID <= 0)
                    return 0;
            }            
        }
        else //资质上传
        {
            $arrayFile = explode(".",$strFilePath);
            $objAgentPermitBLL = new AgentPermitBLL();
            $objAgentPermitInfo =null;
            $docID = $objAgentPermitBLL->selectExistsPermit($agentID,$cbPermitType);
            if($docID > 0)
            {
                $objAgentPermitInfo = $objAgentPermitBLL->getModelByID($docID);
                //wzx 暂时不做删除文件的操作
            }
            
            if($objAgentPermitInfo == null)
                $objAgentPermitInfo = new AgentPermitInfo();
                
    	    $objAgentPermitInfo->strFilePath = "FrontFile/upload/".$arrayFile[0];
    	    $objAgentPermitInfo->strFileExt = $arrayFile[1];
            if($objAgentPermitInfo->iAid <= 0)
            {
                $arrayPermit = $objAgentPermitBLL->GetPermits();
        	    $objAgentPermitInfo->strPermitName = $arrayPermit[$cbPermitType];
        	    $objAgentPermitInfo->iPermitType = $cbPermitType;
                $objAgentPermitInfo->iAgentId = $agentID;
        	    $objAgentPermitInfo->iCreateUid = $this->getUserId();
                $docID = $objAgentPermitBLL->insert($objAgentPermitInfo);
                if($docID <= 0)
                   return 0;
            }
    	    else
            {
        	    $objAgentPermitInfo->iUpdateUid = $this->getUserId();
                if($objAgentPermitBLL->update($objAgentPermitInfo) <= 0)
                    return 0;
            }                
        }
        
        return 1;
    }

    public function getUpdateInfoByContact($arrPostInfo) {
        $arrChangeInfo = array();
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($arrPostInfo['strVisitor'], $arrPostInfo['iAgentID']);
        if ($arrContactInfo) {
            if($arrPostInfo['iIsCharge'] == 1 && $arrContactInfo['isCharge'] == 0){
                Utility::Msg("不允许由负责人直接修改为非负责人");
            }
            $arrChangeInfo['aid'] = $arrContactInfo['aid'];
            $this->IsInfoChange($arrPostInfo['strVisitor'], $arrContactInfo, 'contact_name', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['iIsCharge'], $arrContactInfo, 'isCharge', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strMobile'], $arrContactInfo, 'mobile', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strTel'], $arrContactInfo, 'tel', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strPosition'], $arrContactInfo, 'position', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strFax'], $arrContactInfo, 'fax', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strEmail'], $arrContactInfo, 'email', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['iQq'], $arrContactInfo, 'qq', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strMsn'], $arrContactInfo, 'msn', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strWeiBo'], $arrContactInfo, 'twitter', $arrChangeInfo);
            $this->IsInfoChange($arrPostInfo['strRemark'], $arrContactInfo, 'agent_remark', $arrChangeInfo);
        } else {
            $arrChangeInfo = new AgentContactInfo();
            $arrChangeInfo->strContactName = $arrPostInfo['strVisitor'];
            $arrChangeInfo->iIscharge = $arrPostInfo['iIsCharge'];
            $arrChangeInfo->strMobile = $arrPostInfo['strMobile'];
            $arrChangeInfo->strTel = $arrPostInfo['strTel'];
            $arrChangeInfo->strPosition = $arrPostInfo['strPosition'];
            $arrChangeInfo->strFax = $arrPostInfo['strFax'];
            $arrChangeInfo->strEmail = $arrPostInfo['strEmail'];
            $arrChangeInfo->iQq = $arrPostInfo['iQq'];
            $arrChangeInfo->strMsn = $arrPostInfo['strMsn'];
            $arrChangeInfo->strTwitter = $arrPostInfo['strWeiBo'];
            $arrChangeInfo->strAgentRemark = $arrPostInfo['strRemark'];
            $arrChangeInfo->strUpdateTime = Utility::Now();
            $arrChangeInfo->strCreateTime = Utility::Now();
            $arrChangeInfo->iUpdateUid = $this->getUserId();
            $arrChangeInfo->iCreateUid = $this->getUserId();
            $arrChangeInfo->iNumberOfContacts = 0;
            $arrChangeInfo->iAgentId = $arrPostInfo['iAgentID'];
        }
        return $arrChangeInfo;
    }

    protected function IsInfoChange($NewValue, $arrContactInfo, $strKey, &$arrChangeInfo) {
        if ($arrContactInfo[$strKey] != $NewValue) {
            $arrChangeInfo[$strKey] = $NewValue;
            return true;
        }
        return false;
    }

    protected function UpdateContactInfo($arrChangeInfo) {
        $objAgentContactBLL = new AgentContactBLL();
        if (gettype($arrChangeInfo) == "object") {
            $iRtn = $objAgentContactBLL->insert($arrChangeInfo);
        } else {
            $iContactID = $arrChangeInfo['aid'];
            unset($arrChangeInfo['aid']);
            $iRtn = $objAgentContactBLL->UpdateData($arrChangeInfo, "aid={$iContactID}");
        }
        return $iRtn;
    }

}

?>
