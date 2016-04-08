<?php

/**
 * 质检操作类
 *
 * @author xxf
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitVertifyBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitVertifyItemBLL.php';
require_once __DIR__ . '/../../Class/BLL/IntentionRatingBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentContactBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class VisitVerifyAction extends ActionBase {

    //put your code here
    public function __construct() {
        
    }

    /**
     * 电话小记质检列表
     */
    public function showTelVerifyList() {
        $this->PageRightValidate("TelVerify", RightValue::view);

        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->getJsonStyle($objIntentionRatingBLL->getArrAgentIntentionRatingByTiem(array(
                    'A', 'B+'
                )));

        $this->smarty->assign('strIntentionRatingJson', $strIntentionRatingJson);
        $this->smarty->assign("BodyUrl", $this->getActionUrl("WorkM", "VisitVerify", "showTelVerifyBody"));
        $this->displayPage('Agent/WorkManagement/TelVerifyList.tpl');
    }

    public function showTelVerifyBody() {
        $this->ExitWhenNoRight("TelVerify", RightValue::view);
        $strWhere = $this->showTelVerifyWhere();
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();

        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if ($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;

        $arrPageInfo = $objVisitNoteBLL->getTelVerifyList($strWhere, $strOrder, $iExportExcel);
        if ($iExportExcel == true) {
            $arrayData = &$arrPageInfo["list"];


            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();

            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向等级", "afterlevel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被联系人", "visitor"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系时间", "visit_timestart", ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人工号", "user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人姓名", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间", "create_time", ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系小记", "result", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("行业动态", "dynamics", ExcelDataTypes::String, 100));

            $objDataToExcel->Init("电话小记质检", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        } else {
            $this->showPageSmarty($arrPageInfo, "Agent/WorkManagement/TelVerifyBody.tpl");
        }
    }

    public function showTelVerifyWhere() {
        $strWhere = " am_visit_note.afterlevel <= 'B+' and am_visit_note.afterlevel > '' and am_visit_note.contact_type = 0 and am_visit_note.is_visit = 1 and am_visit_note.is_vertifyed = 0 ";
        $strAgentName = urldecode(Utility::GetForm("agent_name", $_GET));
        if (!empty($strAgentName)) {
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%' ";
        }

        $strIntentionRating = Utility::GetForm("IntentionRating", $_GET);
        if (!empty($strIntentionRating)) {
            $arrTemp = explode(',', $strIntentionRating);
            foreach ($arrTemp as $key => $item) {
                $arrTemp[$key] = "'{$item}'";
            }
            $strIntentionRating = implode(',', $arrTemp);
            $strWhere .= " and afterlevel in ({$strIntentionRating}) ";
        }

        $strCreateUser = urldecode(Utility::GetForm("create_user", $_GET));
        if (!empty($strCreateUser)) {
            $strWhere .= " and (sys_user.user_name like '%{$strCreateUser}%' or sys_user.e_name like '%{$strCreateUser}%' ) ";
        }

        $strCreateTimeStart = Utility::GetForm("create_time_start", $_GET);
        if (!empty($strCreateTimeStart)) {
            $strWhere .= " and am_visit_note.create_time >= '{$strCreateTimeStart}' ";
        }

        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if (!empty($strCreateTimeEnd)) {
            $strWhere .= " and am_visit_note.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 DAY) ";
        }

        //联系时间
        $strVisitTimeBegin = Utility::GetForm("visit_time_start", $_GET);
        if (!empty($strVisitTimeBegin)) {
            $strWhere .=" and am_visit_note.visit_timestart >= '{$strVisitTimeBegin}' ";
        }
        $strVisitTimeEnd = Utility::GetForm("visit_time_end", $_GET);
        if (!empty($strVisitTimeEnd)) {
            $strWhere .= " and am_visit_note.visit_timestart < DATE_ADD('{$strVisitTimeEnd}',INTERVAL 1 DAY) ";
        }

        return $strWhere;
    }

    public function showAddTelVerfity() {
        $this->PageRightValidate("TelVerify", RightValue::add);
        $iNoteId = Utility::GetFormInt("noteid", $_GET);
        //获取联系小记信息
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        if ($objVisitNoteInfo) {
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);

        //获取质检操作记录
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrVertifyList = $objVisitVertifyBLL->getVertifyLogByAgentId($objAgentSourceInfo->iAgentId, 1);
        if ($arrVertifyList && $arrVertifyList[0]['item_list']) {
            $arrItemChecked = explode(',', $arrVertifyList[0]['item_list']);
        }

        //获取选项
        $objVisitVertifyItemBLL = new VisitVertifyItemBLL();
        $arrVertifyItemList = $objVisitVertifyItemBLL->getItemList();
        if ($arrVertifyItemList) {
            $bFlag = true;
            $arrVertifyItemListLeft = array();
            $arrVertifyItemListRight = array();
            foreach ($arrVertifyItemList as $item) {
                $item['checked'] = (isset($arrItemChecked) && in_array($item['item_id'], $arrItemChecked)) ? 1 : 0;
                if ($bFlag) {
                    $arrVertifyItemListLeft[] = $item;
                    $bFlag = false;
                } else {
                    $arrVertifyItemListRight[] = $item;
                    $bFlag = true;
                }
            }
        }

        $this->smarty->assign("VertifyList", $arrVertifyList);
        $this->smarty->assign("NoteInfo", $objVisitNoteInfo);
        $this->smarty->assign("AgentInfo", $objAgentSourceInfo);
        $this->smarty->assign("VertifyListItemLeft", $arrVertifyItemListLeft);
        $this->smarty->assign("VertifyListItemRight", $arrVertifyItemListRight);
        $this->displayPage("Agent/WorkManagement/AddTelVerfity.tpl");
    }

    public function AddTelVerfity() {
        $this->ExitWhenNoRight("TelVerify", RightValue::add);
        $iAgentId = Utility::GetFormInt("agentId", $_POST);
        if (empty($iAgentId)) {
            Utility::Msg("获取代理商数据失败");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_POST);
        if (empty($iNoteId)) {
            Utility::Msg("获取电话小记信息失败");
        }
        $iVertifyStatus = Utility::GetFormInt("vertify_status", $_POST);
        $strVertifyRemark = urldecode(Utility::GetForm("vertify_remark", $_POST));
        $strRecordNo = urldecode(Utility::GetForm("record_no", $_POST));

        $objVisitVertifyBLL = new VisitVertifyBLL();
        $objVisitVertifyInfo = new VisitVertifyInfo();
        $objVisitVertifyInfo->iAgentId = $iAgentId;
        $objVisitVertifyInfo->iNoteId = $iNoteId;
        $objVisitVertifyInfo->iVerfityStatus = $iVertifyStatus;
        $objVisitVertifyInfo->strVertifyRemark = $strVertifyRemark;
        $objVisitVertifyInfo->iIsVisit = 1;
        $objVisitVertifyInfo->strRecordNo = $strRecordNo;
        list($objVisitVertifyInfo->strItemList, $objVisitVertifyInfo->strNewItemName) = $this->getItemInfo($_POST['item'], $iAgentId);
        $objVisitVertifyInfo->iCreateUid = $this->getUserId();
        $objVisitVertifyInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitVertifyInfo->strCreateTime = Utility::Now();
        $iRtn = $objVisitVertifyBLL->insert($objVisitVertifyInfo);
        if ($iRtn === false) {
            Utility::Msg("质检失败");
        }

        $objVisitNoteBLL = new VisitNoteBLL();
        $iUpdateRtn = $objVisitNoteBLL->setVertifyed($iNoteId);
        if ($iUpdateRtn === false) {
            Utility::Msg("更新电话小记信息失败");
        }

        Utility::Msg("质检成功,结果可在电话质检记录中查看", true);
    }

    public function getItemInfo($arrItem, $iAgentId) {
        $arrNewItem = array_keys($arrItem);
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrVertifyInfo = $objVisitVertifyBLL->getLastVertifyLogByAgentId($iAgentId);
        if ($arrVertifyInfo && $arrVertifyInfo[0]['item_list']) {
            $arrOldItem = explode(",", $arrVertifyInfo[0]['item_list']);
            $arrDiffItem = array_diff($arrNewItem, $arrOldItem);
            foreach ($arrDiffItem as $item) {
                $arrDiffItemCN[$item] = isset($arrItem[$item]) ? $arrItem[$item] : '';
            }
        } else {
            $arrDiffItemCN = $arrItem;
        }
        return array(implode(',', $arrNewItem), isset($arrDiffItemCN) ? implode(',', $arrDiffItemCN) : '');
    }

    public function UnNeedVertify() {
        if (!$this->HaveRight("TelVerify", RightValue::del)) {
            Utility::Msg("对不起，您没有权限");
        }
        $this->UnNeedVertifyCommon();
    }

    public function UnNeedVertifyVisit() {
        if (!$this->HaveRight("VisitManagementCheck", RightValue::v16)) {
            Utility::Msg("对不起，您没有权限");
        }
        $this->UnNeedVertifyCommon();
    }

    protected function UnNeedVertifyCommon() {
        $iNoteId = Utility::GetFormInt("id", $_GET);
        if (empty($iNoteId)) {
            Utility::Msg("获取数据失败");
        }
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);

        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrLastVertify = $objVisitVertifyBLL->getLastVertifyLogByAgentId($objVisitNoteInfo->iAgentId);
        
        $objVisitVertifyInfo = new VisitVertifyInfo();
        $objVisitVertifyInfo->iAgentId = $objVisitNoteInfo->iAgentId;
        $objVisitVertifyInfo->iNoteId = $iNoteId;
        $objVisitVertifyInfo->strItemList = empty ($arrLastVertify)?'':$arrLastVertify[0]['item_list'];
        $objVisitVertifyInfo->strCreateTime = Utility::Now();
        $objVisitVertifyInfo->iCreateUid = $this->getUserId();
        $objVisitVertifyInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitVertifyInfo->iIsVisit = $objVisitNoteInfo->iIsVisit;
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $iInsertRtn = $objVisitVertifyBLL->insert($objVisitVertifyInfo);
        if ($iInsertRtn === false) {
            Utility::Msg("生成质检记录失败");
        }

        $iRtn = $objVisitNoteBLL->setVertifyed($iNoteId, 2);
        if ($iRtn === false) {
            Utility::Msg("标记失败");
        }
        Utility::Msg("标记成功", true);
    }

    /**
     * 拜访小记质检列表
     */
    public function showVistVerifyList() {
        $this->PageRightValidate("VisitManagementCheck", RightValue::view);

        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->getJsonStyle(IntentionRatingBLL::$_arrAgentIntentionRating);

        $this->smarty->assign('strIntentionRatingJson', $strIntentionRatingJson);
        $this->smarty->assign("BodyUrl", $this->getActionUrl("WorkM", "VisitVerify", "showVisitVerifyBody"));
        $this->displayPage('Agent/WorkManagement/VisitVerifyList.tpl');
    }

    public function showVisitVerifyBody() {
        $this->ExitWhenNoRight("VisitManagementCheck", RightValue::view);
        $strWhere = $this->showVisitVerifyWhere();
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();

        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if ($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;

        $arrPageInfo = $objVisitNoteBLL->getVisitVerifyList($strWhere, $strOrder, $iExportExcel);
        if ($iExportExcel == true) {
            $arrayData = &$arrPageInfo["list"];

            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();

            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向等级或签约产品", "intertion_product"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访类型", "visit_type"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访人", "visitor"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访开始时间", "visit_timestart", ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访结束时间", "visit_timeend", ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("小记添加人工号", "user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("小记添加人姓名", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("小记添加时间", "create_time", ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访计划", "visit_content", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访结果", "result", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检状态", "is_vertifyed"));
            $objDataToExcel->Init("拜访小记质检", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        } else {
            $this->showPageSmarty($arrPageInfo, "Agent/WorkManagement/VisitVerifyBody.tpl");
        }
    }

    public function showVisitVerifyWhere() {
        $strWhere = " am_visit_note.is_visit = 0 and am_visit_note.is_vertifyed < 2 ";
        $strAgentName = urldecode(Utility::GetForm("agent_name", $_GET));
        if (!empty($strAgentName)) {
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%' ";
        }

        $iVertifyStatus = Utility::GetFormInt("vertify_status", $_GET);
        switch ($iVertifyStatus) {
            case 1: {
                    $strWhere .=" and am_visit_note.is_vertifyed = 0";
                }break;
            case 2: {
                    $strWhere .= " and am_visit_vertify.verfity_status =1 ";
                }break;
            case 3: {
                    $strWhere .= " and am_visit_vertify.verfity_status =0 ";
                }break;
            default :break;
        }

        $iHasPect = Utility::GetFormInt("hasPect", $_GET);
        if ($iHasPect) {
            if ($iHasPect == 1) {
                //已签约
                $strWhere .= " and am_visit_note.contact_type = 1 ";
            } else {//潜在
                $strWhere .= " and am_visit_note.contact_type = 0 ";
                $strIntentionRating = Utility::GetForm("IntentionRating", $_GET);
                if (!empty($strIntentionRating)) {
                    $arrTemp = explode(',', $strIntentionRating);
                    foreach ($arrTemp as $key => $item) {
                        $arrTemp[$key] = "'{$item}'";
                    }
                    $strIntentionRating = implode(',', $arrTemp);
                    $strWhere .= " and afterlevel in ({$strIntentionRating}) ";
                }
            }
        }

        if (!$iHasPect) {
            
        }

        $strCreateUser = urldecode(Utility::GetForm("create_user", $_GET));
        if (!empty($strCreateUser)) {
            $strWhere .= " and (sys_user.user_name like '%{$strCreateUser}%' or sys_user.e_name like '%{$strCreateUser}%' ) ";
        }

        $strCreateTimeStart = Utility::GetForm("create_time_start", $_GET);
        if (!empty($strCreateTimeStart)) {
            $strWhere .= " and am_visit_note.create_time >= '{$strCreateTimeStart}' ";
        }

        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if (!empty($strCreateTimeEnd)) {
            $strWhere .= " and am_visit_note.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 DAY) ";
        }

        //拜访时间
        $strVisitTimeBegin = Utility::GetForm("visit_time_start", $_GET);
        if (!empty($strVisitTimeBegin)) {
            $strWhere .=" and am_visit_note.visit_timestart >= '{$strVisitTimeBegin}' ";
        }
        $strVisitTimeEnd = Utility::GetForm("visit_time_end", $_GET);
        if (!empty($strVisitTimeEnd)) {
            $strWhere .= " and am_visit_note.visit_timestart < DATE_ADD('{$strVisitTimeEnd}',INTERVAL 1 DAY) ";
        }

        return $strWhere;
    }

    public function showAddVisitVerfity() {
        $this->PageRightValidate("VisitManagementCheck", RightValue::add);
        $iNoteId = Utility::GetFormInt("noteid", $_GET);
        //获取联系小记信息
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        if ($objVisitNoteInfo) {
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);
        //获取联系人信息
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($objVisitNoteInfo->strVisitor, $objVisitNoteInfo->iAgentId);

        $this->smarty->assign("ContactInfo", $arrContactInfo);
        $this->smarty->assign("NoteInfo", $objVisitNoteInfo);
        $this->smarty->assign("AgentInfo", $objAgentSourceInfo);
        $this->displayPage("Agent/WorkManagement/AddVisitVerfity.tpl");
    }

    public function AddVisitVerfity() {
        $this->ExitWhenNoRight("VisitManagementCheck", RightValue::add);
        $iAgentId = Utility::GetFormInt("agentId", $_POST);
        if (empty($iAgentId)) {
            Utility::Msg("获取代理商数据失败");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_POST);
        if (empty($iNoteId)) {
            Utility::Msg("获取拜访小记信息失败");
        }
        $iVertifyStatus = Utility::GetFormInt("vertify_status", $_POST);
        $strVertifyRemark = urldecode(Utility::GetForm("vertify_remark", $_POST));
        $strRecordNo = urldecode(Utility::GetForm("record_no", $_POST));

        $objVisitVertifyBLL = new VisitVertifyBLL();
        $objVisitVertifyInfo = new VisitVertifyInfo();
        $objVisitVertifyInfo->iAgentId = $iAgentId;
        $objVisitVertifyInfo->iNoteId = $iNoteId;
        $objVisitVertifyInfo->iVerfityStatus = $iVertifyStatus;
        $objVisitVertifyInfo->strVertifyRemark = $strVertifyRemark;
        $objVisitVertifyInfo->iIsVisit = 0;
        $objVisitVertifyInfo->strRecordNo = $strRecordNo;
        $objVisitVertifyInfo->iCreateUid = $this->getUserId();
        $objVisitVertifyInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitVertifyInfo->strCreateTime = Utility::Now();
        $iRtn = $objVisitVertifyBLL->insert($objVisitVertifyInfo);
        if ($iRtn === false) {
            Utility::Msg("质检失败");
        }

        $objVisitNoteBLL = new VisitNoteBLL();
        $iUpdateRtn = $objVisitNoteBLL->setVertifyed($iNoteId);
        if ($iUpdateRtn === false) {
            Utility::Msg("更新拜访小记信息失败");
        }

        Utility::Msg("质检成功", true);
    }

    public function showAddVisitInstruction() {
        $this->PageRightValidate("VisitManagementCheck", RightValue::v8);
        $iNoteId = Utility::GetFormInt("noteid", $_GET);
        //获取联系小记信息
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        if ($objVisitNoteInfo) {
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);

        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrVertifyInfo = $objVisitVertifyBLL->getVertifyByNoteID($iNoteId);

        //获取联系小记提交人信息
        $objUserBLL = new UserBLL();
        $strUserName = $objUserBLL->getUserNameAndENameById($objVisitNoteInfo->iCreateUid);
        $this->smarty->assign("UserName", $strUserName);
        $this->smarty->assign("NoteInfo", $objVisitNoteInfo);
        $this->smarty->assign("AgentInfo", $objAgentSourceInfo);
        $this->smarty->assign("VertifyInfo", $arrVertifyInfo);
        $this->displayPage("Agent/WorkManagement/AddVisitInstruction.tpl");
    }

    public function AddVisitInstruction() {
        $this->ExitWhenNoRight("VisitManagementCheck", RightValue::v8);
        $iVertifyId = Utility::GetFormInt("vertifyid", $_POST);
        if (empty($iVertifyId)) {
            Utility::Msg("获取质检数据失败");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_POST);
        if (empty($iNoteId)) {
            Utility::Msg("获取拜访小记信息失败");
        }
        $strInstruction = urldecode(Utility::GetForm("vertify_instruction", $_POST));
        if (empty($strInstruction)) {
            Utility::Msg("批示不得为空");
        }

        $objVisitVertifyBLL = new VisitVertifyBLL();
        $iRtn = $objVisitVertifyBLL->setInstruction($iVertifyId, $strInstruction);
        if ($iRtn === false) {
            Utility::Msg("批示失败");
        }

        $objVisitNoteBLL = new VisitNoteBLL();
        $iUpdateRtn = $objVisitNoteBLL->setVertifyed($iNoteId, 3);
        if ($iUpdateRtn === false) {
            Utility::Msg("更新拜访小记信息失败");
        }

        Utility::Msg("批示成功,结果可在拜访质检记录中查看", true);
    }

    public function VertifyReview() {
        if (!$this->HaveRight("VisitManagementCheck", RightValue::v32)) {
            Utility::Msg("对不起，您没有权限");
        }
        $iNoteId = Utility::GetFormInt("id", $_GET);
        if (empty($iNoteId)) {
            Utility::Msg("获取数据失败");
        }
        $objVisitNoteBLL = new VisitNoteBLL();
        $iRtn = $objVisitNoteBLL->setVertifyed($iNoteId, 4);
        if ($iRtn === false) {
            Utility::Msg("审阅失败");
        }
        Utility::Msg("审阅成功", true);
    }

    /**
     * 电话小记质检记录
     */
    public function telVerifyRecordList() {
        $this->PageRightValidate("TelVerifyRecord", RightValue::view);

        $objVisitVertifyItemBLL = new VisitVertifyItemBLL();
        $arrVertifyItem = $objVisitVertifyItemBLL->getItemList();
        $json = "";
        foreach ($arrVertifyItem as $k => $v) {
            $json .=",{'value':'" . $v["item_name"] . "','key':'" . $v["item_id"] . "'}";
        }
        $json = "[" . substr($json, 1) . "]";

        $this->smarty->assign("vertifyJson", $json);
        $this->smarty->assign("BodyUrl", $this->getActionUrl("WorkM", "VisitVerify", "telVerifyRecordListBody"));
        $this->displayPage("Agent/WorkManagement/TelVerifyRecordList.tpl");
    }

    public function telVerifyRecordListBody() {
        $this->ExitWhenNoRight("TelVerifyRecord", RightValue::view);
        $strWhere = "";
        $recordNo = Utility::GetFormInt("record_no", $_GET);
        if ($recordNo != 0) {
            $strWhere .= " and am_visit_vertify.note_id =$recordNo ";
        }
        $qCheck = Utility::GetFormInt("qcheck_state", $_GET);
        if ($qCheck != -100) {
            if($qCheck != -9){
                $strWhere .= " and am_visit_note.is_vertifyed = 1 and am_visit_vertify.verfity_status =$qCheck ";
            }else{
                $strWhere .= " and am_visit_note.is_vertifyed = 2 ";
            }
            
        }

        $cbVertifyTtem = Utility::GetForm("cbVertifyTtem", $_GET);
        if ($cbVertifyTtem != "") {
            $arrayVertifyTtem = explode(",", $cbVertifyTtem);
            $arrayCount = count($arrayVertifyTtem);
            for ($i = 0; $i < $arrayCount; $i++) {
                if ($i == 0)
                    $strWhere .= " AND (am_visit_vertify.new_item_name like '%$arrayVertifyTtem[$i]%'";
                else
                    $strWhere .= " OR am_visit_vertify.new_item_name like '%$arrayVertifyTtem[$i]%'";
            }
            $strWhere .=")";
        }

        $agentName = Utility::GetForm("agent_name", $_GET);
        if (!empty($agentName)) {
            $strWhere .= " and am_agent_source.agent_name like '%{$agentName}%' ";
        }
        $strCreateUser = Utility::GetForm("create_user", $_GET);
        if (!empty($strCreateUser)) {
            $strWhere .= " and am_visit_note.create_user_name like '%{$strCreateUser}%' ";
        }
        $strCreateTimeBegin = Utility::GetForm("create_time_start", $_GET);
        if (!empty($strCreateTimeBegin)) {
            $strWhere .=" and am_visit_note.create_time >= '{$strCreateTimeBegin}' ";
        }
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if (!empty($strCreateTimeEnd)) {
            $strWhere .= " and am_visit_note.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 DAY) ";
        }
        $contactTimeBegin = Utility::GetForm("contact_time_start", $_GET);
        if (!empty($contactTimeBegin)) {
            $strWhere .=" and am_visit_note.visit_timestart >= '{$contactTimeBegin}' ";
        }
        $contactTimeEnd = Utility::GetForm("contact_time_end", $_GET);
        if (!empty($contactTimeEnd)) {
            $strWhere .= " and am_visit_note.visit_timestart < DATE_ADD('{$contactTimeEnd}',INTERVAL 1 DAY) ";
        }
        $strOrder = Utility::GetForm("sortField", $_GET);

        $bExportExcel = false;
        if (Utility::GetFormInt('iExportExcel', $_GET) == 1)
            $bExportExcel = true;

        $objVisitNoteBLL = new VisitNoteBLL();
        $arrPageInfo = $objVisitNoteBLL->selectTelVerifyRecordPage($strWhere, $strOrder, $bExportExcel);
        if ($bExportExcel == false) {
            $this->showPageSmarty($arrPageInfo, "Agent/WorkManagement/TelVerifyRecordListBody.tpl");
        } else {
            $arrPageInfo = $arrPageInfo["list"];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();

            $objVisitVertifyItemBLL = new VisitVertifyItemBLL();
            $arrVertifyItem = $objVisitVertifyItemBLL->getItemList();
            $arrayName = array();

            foreach ($arrPageInfo as $key => $value) {
                if ($value["visit_timestart"] != "")
                    $arrPageInfo[$key]["visit_timestart"] = date("Y-m-d H:i", strtotime($value["visit_timestart"]));

                foreach ($arrVertifyItem as $k => $v) {
                    $arrPageInfo[$key]["vertify_item_" . $v["item_id"]] = "0";
                    if (strpos("," . $value["new_item_name"], $v["item_name"]) > 0)
                        $arrPageInfo[$key]["vertify_item_" . $v["item_id"]] = "1";
                }

                $arrPageInfo[$key]["note_user_name"] = "";
                $arrPageInfo[$key]["note_user_e_name"] = "";
                $arrayName = explode(" ", $value["note_create_user"]);
                if (count($arrayName) > 1) {
                    $arrPageInfo[$key]["note_user_name"] = $arrayName[0];
                    $arrPageInfo[$key]["note_user_e_name"] = $arrayName[1];
                }

                $arrPageInfo[$key]["create_u_name"] = "";
                $arrPageInfo[$key]["create_user_e_name"] = "";
                $arrayName = explode(" ", $value["create_user_name"]);
                if (count($arrayName) > 1) {
                    $arrPageInfo[$key]["create_u_name"] = $arrayName[0];
                    $arrPageInfo[$key]["create_user_e_name"] = $arrayName[1];
                }
            }


            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检编号", "vertify_id", ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系小记编号", "note_id", ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系时间", "visit_timestart"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("录音编号", "record_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人工号", "note_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人姓名", "note_user_e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间", "note_create_time"));
            $objExcelTopColumns = new ExcelTopColumns();
            $objExcelTopColumns->Add(new ExcelTopColumn("本次质检操作通过的项", 8, count($arrVertifyItem)));

            foreach ($arrVertifyItem as $k => $v) {
                $objExcelBottomColumns->Add(new ExcelBottomColumn($v["item_name"], "vertify_item_" . $v["item_id"], ExcelDataTypes::Int));
            }

            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检结果", "verfity_status_cn"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检评语", "vertify_remark"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检人工号", "create_u_name", ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检人姓名", "create_user_e_name", ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检操作时间", "create_time"));

            $objDataToExcel->Init("电话小记质检记录", $arrPageInfo, $objExcelTopColumns, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }

    /**
     * 拜访小记质检记录
     */
    public function visitVerifyRecordList() {
        $this->PageRightValidate("VisitVerifyRecord", RightValue::view);
        $this->smarty->assign("BodyUrl", $this->getActionUrl("WorkM", "VisitVerify", "visitVerifyRecordListBody"));
        $this->displayPage("Agent/WorkManagement/VisitVerifyRecordList.tpl");
    }

    public function visitVerifyRecordListBody() {
        $this->ExitWhenNoRight("VisitVerifyRecord", RightValue::view);
        $strWhere = "";
        $agentName = urldecode(Utility::GetForm("agent_name", $_GET));
        if (!empty($agentName)) {
            $strWhere .= " and am_agent_source.agent_name like '%{$agentName}%' ";
        }
        $recordNo = Utility::GetFormInt("record_no", $_GET);
        if ($recordNo != 0) {
            $strWhere .= " and am_visit_vertify.note_id =$recordNo ";
        }
        $qCheck = Utility::GetFormInt("qcheck_state", $_GET);
        if ($qCheck != -100) {
            $strWhere .= " and am_visit_vertify.verfity_status =$qCheck ";
        }
        $strCreateUser = urldecode(Utility::GetForm("create_user", $_GET));
        if (!empty($strCreateUser)) {
            $strWhere .= " and am_visit_note.create_user_name like '%{$strCreateUser}%' ";
        }
        //提交时间
        $strCreateTimeBegin = Utility::GetForm("create_time_start", $_GET);
        if (!empty($strCreateTimeBegin)) {
            $strWhere .=" and am_visit_note.create_time >= '{$strCreateTimeBegin}' ";
        }
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if (!empty($strCreateTimeEnd)) {
            $strWhere .= " and am_visit_note.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 DAY) ";
        }
        //拜访时间
        $strVisitTimeBegin = Utility::GetForm("visit_time_start", $_GET);
        if (!empty($strVisitTimeBegin)) {
            $strWhere .=" and am_visit_note.visit_timestart >= '{$strVisitTimeBegin}' ";
        }
        $strVisitTimeEnd = Utility::GetForm("visit_time_end", $_GET);
        if (!empty($strVisitTimeEnd)) {
            $strWhere .= " and am_visit_note.visit_timestart < DATE_ADD('{$strVisitTimeEnd}',INTERVAL 1 DAY) ";
        }
        //质检时间
        $strVertifyTimeBegin = Utility::GetForm("vertify_time_start", $_GET);
        if (!empty($strVertifyTimeBegin)) {
            $strWhere .=" and am_visit_vertify.create_time >= '{$strVertifyTimeBegin}' ";
        }
        $strVertifyTimeEnd = Utility::GetForm("vertify_time_end", $_GET);
        if (!empty($strVertifyTimeEnd)) {
            $strWhere .= " and am_visit_vertify.create_time < DATE_ADD('{$strVertifyTimeEnd}',INTERVAL 1 DAY) ";
        }
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();

        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if ($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;

        $arrPageInfo = $objVisitNoteBLL->selectVisitVerifyRecordPage($strWhere, $strOrder, $iExportExcel);
        if ($iExportExcel == true) {
            $arrayData = &$arrPageInfo["list"];


            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("编号", "vertify_id", ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访小记编号", "note_id", ExcelDataTypes::String, 35));

            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访人工号", "user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访人姓名", "e_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访开始时间", "visit_timestart", ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访结束时间", "visit_timeend", ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检位置", "record_no", ExcelDataTypes::String, 50));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检结果", "verfity_status_cn", ExcelDataTypes::String, 10));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检情况", "vertify_remark", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检人工号", "vuser_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检人姓名", "ve_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检操作时间", "create_time", ExcelDataTypes::Date));
            $objDataToExcel->Init("拜访小记质检记录", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        } else {
            $this->showPageSmarty($arrPageInfo, "Agent/WorkManagement/VisitVerifyRecordListBody.tpl");
        }
    }

    public function showEditTelVertifyRecord() {
        $this->PageRightValidate("TelVerifyRecord", RightValue::add);
        $iVertifyId = Utility::GetFormInt("id", $_GET);
        //获取质检信息
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $objVertifyInfo = $objVisitVertifyBLL->getModelByID($iVertifyId);
        if (!$objVertifyInfo) {
            exit("获取质检信息失败");
        }
        if ($objVertifyInfo->strItemList) {
            $arrItemChecked = explode(',', $objVertifyInfo->strItemList);
        }

        //获取联系小记信息
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($objVertifyInfo->iNoteId);
        if ($objVisitNoteInfo) {
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);

        //获取质检操作记录
        $arrVertifyList = $objVisitVertifyBLL->getVertifyLogByAgentId($objAgentSourceInfo->iAgentId, 1);
        if ($arrVertifyList) {
            foreach ($arrVertifyList as $key => $item) {
                if ($item['vertify_id'] == $iVertifyId) {
                    if (isset($arrVertifyList[$key + 1])) {
                        $arrItemCheckedOld = explode(',', $arrVertifyList[$key + 1]['item_list']);
                    }
                    $item['current'] = 1;
                    break;
                }
            }
        }

        //获取选项
        $objVisitVertifyItemBLL = new VisitVertifyItemBLL();
        $arrVertifyItemList = $objVisitVertifyItemBLL->getItemList();
        if ($arrVertifyItemList) {
            $bFlag = true;
            $arrVertifyItemListLeft = array();
            $arrVertifyItemListRight = array();
            foreach ($arrVertifyItemList as $item) {
                if (isset($arrItemChecked) && in_array($item['item_id'], $arrItemChecked)) {
                    if (isset($arrItemCheckedOld) && in_array($item['item_id'], $arrItemCheckedOld)) {
                        $item['checked'] = 2;
                    } else {
                        $item['checked'] = 1;
                    }
                } else {
                    $item['checked'] = 0;
                }

                if ($bFlag) {
                    $arrVertifyItemListLeft[] = $item;
                    $bFlag = false;
                } else {
                    $arrVertifyItemListRight[] = $item;
                    $bFlag = true;
                }
            }
        }

        $this->smarty->assign("VertifyInfo", $objVertifyInfo);
        $this->smarty->assign("VertifyList", $arrVertifyList);
        $this->smarty->assign("NoteInfo", $objVisitNoteInfo);
        $this->smarty->assign("AgentInfo", $objAgentSourceInfo);
        $this->smarty->assign("VertifyListItemLeft", $arrVertifyItemListLeft);
        $this->smarty->assign("VertifyListItemRight", $arrVertifyItemListRight);
        $this->displayPage("Agent/WorkManagement/EditVisitVerfity.tpl");
    }

    public function EditVertify() {
        if (!$this->HaveRight("TelVerifyRecord", RightValue::add)) {
            Utility::Msg("对不起，您没有权限");
        }
        $iVertifyId = Utility::GetFormInt("id", $_POST);
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $objVertifyInfo = $objVisitVertifyBLL->getModelByID($iVertifyId);
        if (!$objVertifyInfo) {
            Utility::Msg("获取质检信息失败");
        }

        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($objVertifyInfo->iNoteId);

        $iVertiftStatus = Utility::GetFormInt("vertify_status", $_POST); //判断是否不质检，不质检的话，修改note表的is_vertifyed字段.TM需求改的跟玩似的，楼下手贱点错还要我们提供纸给他们擦屁股,真想问一句，屁股擦得可爽？
        if ($iVertiftStatus == -9) {
            if ($objVisitNoteInfo->iIsVertifyed != 2) {
                $objVisitNoteBLL->setVertifyed($objVertifyInfo->iNoteId, 2);
            }
            $arrLastVertify = $objVisitVertifyBLL->getLastVertifyLogByAgentId($objVertifyInfo->iAgentId, $iVertifyId);
            if ($arrLastVertify) {
                $strNewItem = $arrLastVertify[0]['item_list'];
                $arrNewItem = explode(',', $arrLastVertify[0]['item_list']);
                $arrNewItem = array_flip($arrNewItem);
            } else {
                $strNewItem = '';
                $arrNewItem = array();
            }
        } else {
            if ($objVisitNoteInfo->iIsVertifyed == 2) {
                $objVisitNoteBLL->setVertifyed($objVertifyInfo->iNoteId, 1);
            }
            $arrNewItem = isset($_POST) ? $_POST['item'] : array();
            $strNewItem = implode(',', array_keys($arrNewItem));
        }
        $arrOldItem = explode(',', $objVertifyInfo->strItemList);
        //获取新增和丢失的选项
        $arrLost = array();
        foreach ($arrOldItem as $key => $item) {
            if (!isset($arrNewItem[$item])) {
                $arrLost[] = $item;
            } else {
                unset($arrNewItem[$item]);
            }
        }
        $arrAdd = array_keys($arrNewItem);
        $objVisitVertifyItemBLL = new VisitVertifyItemBLL();
        if(!empty ($arrAdd)){
            $arrVertifyList = $objVisitVertifyBLL->select("*", "is_del = 0 and is_visit = 1 and vertify_id > {$iVertifyId} and agent_id=".$objVertifyInfo->iAgentId,'create_time desc');
            if(isset ($arrVertifyList[0]) && $arrVertifyList[0]['item_list']){

                $strTemp = ",{$arrVertifyList[0]['item_list']},";
                $arrExitItem = array();
                foreach ($arrAdd as $iAddId) {
                    $result = strpos($strTemp, ",{$iAddId},");
                    if ($result !== false) {
                        $arrExitItem[] = $_POST['item'][$iAddId];
                    }
                }
                if (!empty($arrExitItem)) {
                    $arrExitItem = implode(',', $arrExitItem);
                    Utility::Msg("以后的质检记录中已存在:{$arrExitItem}");
                }
            }
        }

        $strRecordNo = urldecode(Utility::GetForm("record_no", $_POST));
        $strRemark = urldecode(Utility::GetForm("vertify_remark", $_POST));

        $arrLostName = $objVisitVertifyItemBLL->getItemNameById(implode(',', $arrLost)); //丢失的中文选项
        $arrAddName = $objVisitVertifyItemBLL->getItemNameById(implode(',', $arrAdd)); //新增的中文选项
        $strNewItemName = $this->getUpdatedItem(!empty($arrLostName) ? explode(',', $arrLostName) : array(), !empty($arrAddName) ? explode(',', $arrAddName) : array(), $objVertifyInfo->strNewItemName);
        $objVertifyInfo->strRecordNo = $strRecordNo;
        $objVertifyInfo->strVertifyRemark = $strRemark;
        $objVertifyInfo->iVerfityStatus = $iVertiftStatus;
        $objVertifyInfo->strItemList = $strNewItem;
        $objVertifyInfo->strNewItemName = $strNewItemName;
        $objVertifyInfo->strUpdateTime = Utility::Now();
        $objVertifyInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVertifyInfo->iUpdateUid = $this->getUserId();
        $iVertifyRtn = $objVisitVertifyBLL->updateByID($objVertifyInfo);
        if ($iVertifyRtn === false) {
            Utility::Msg("修改质检记录失败");
        }

        if (!empty($arrLost) || !empty($arrAdd)) {
            if(!isset ($arrVertifyList)){
                $arrVertifyList = $objVisitVertifyBLL->select("*", "is_del = 0 and is_visit = 1 and vertify_id > {$iVertifyId} and agent_id=".$objVertifyInfo->iAgentId,'create_time desc');
            }
            if ($arrVertifyList) {
                foreach ($arrVertifyList as $key => $item) {
                    $strNewItem = $this->getUpdatedItem($arrLost, $arrAdd, $item['item_list']);
                    $iUpdateRtn = $objVisitVertifyBLL->UpdateData(array(
                        'item_list' => $strNewItem
                            ), "vertify_id = {$item['vertify_id']}");
                }
            }
        }
        Utility::Msg("修改质检记录成功", true);
    }

    private function getUpdatedItem($arrLost, $arrAdd, $strItem) {
        $arrNew = empty($strItem) ? array() : explode(',', $strItem);
        if (!empty($arrLost)) {
            $arrNew = array_diff($arrNew, $arrLost);
        }
        if (!empty($arrAdd)) {
            $arrNew = array_merge($arrNew, $arrAdd);
        }
        return implode(',', $arrNew);
    }

}

?>
