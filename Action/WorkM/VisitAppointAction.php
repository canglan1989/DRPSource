<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：拜访预约
 * 创建人：xdd
 * 添加时间：2011-10-12 
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/VisitAppointBLL.php';
require_once __DIR__ . '/../../Class/Model/VisitAppointInfo.php';
require_once __DIR__ . '/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__ . '/../../Class/Model/VisitNoteInfo.php';

require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/Model/AgentContactInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentContactBLL.php';
require_once __DIR__ . '/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__ . '/../../Class/BLL/IntentionRatingBLL.php';

require_once __DIR__ . '/NoteBase.php';
require_once __DIR__ . '/../Common/PHPExcel.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel2007.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel5.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class VisitAppointAction extends NoteBase {

    public function __construct() {
        
    }

    public function Index() {
        $this->AppointList();
    }

    /**
     * @functional 拜访预约列表
     */
    public function AppointList() {
        $this->PageRightValidate("VisitAppoint", RightValue::view);
        $id = $this->getUserId();
        $this->smarty->assign('id', $id);
        $this->smarty->assign('strTitle', '拜访预约管理');
        $this->smarty->assign('AppointListBody', "/?d=WorkM&c=VisitAppoint&a=AppointListBody");
        $this->displayPage('Agent/WorkManagement/AppointList.tpl');
    }

    /**
     * @functional 拜访预约列表Body
     */
    public function AppointListBody() {
        $this->PageRightValidate("VisitAppoint", RightValue::view);
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();

        //===============================搜索b====================================//


        $strUid = $objVisitAppointBLL->GetLowPositionUser($uid);
        $strWhere = $this->StrWhere(0, $strUid);

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $arrPageList = $this->getPageList($objVisitAppointBLL, "", $strWhere, "", $iPageSize);

        $this->smarty->assign('uid', $uid);
        $this->smarty->assign('arrayAppoint', $arrPageList['list']);
        $this->displayPage('Agent/WorkManagement/AppointListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    /**
     * @functional 显示拜访预约添加/编辑第一步：关联代理商
     */
    public function AppointModifyStep1() {
        $this->PageRightValidate("VisitAppoint", RightValue::add);
        $id = $this->getUserId();
        $this->smarty->assign('id', $id);
        $this->smarty->display('Agent/WorkManagement/AppointModifyStep1.tpl');
    }

    /**
     * @functional 判断代理商
     */
    public function CheckAgent() {
        //$agentId = Utility::GetFormInt('agentId',$_GET);
        $tbxAgentName = Utility::GetForm('tbxAgentName', $_GET);
        $tbxAgentName = urldecode($tbxAgentName);
        if ($tbxAgentName == "")
            echo("1");
        else {
            $objAgentSourceBLL = new AgentSourceBLL();
            $agent_Id = $objAgentSourceBLL->GetAgentIDByName($tbxAgentName);
            if ($agent_Id == 0)
                echo("2");
            else
                echo("0");
        }
    }

    /**
     * @functional 显示拜访预约添加/编辑第二步
     */
    public function AppointModifyStep2() {
        $this->PageRightValidate("VisitAppoint", RightValue::add);
        $id = $this->getUserId();
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        $objProductTypeBLL = new ProductTypeBLL();
        if (isset($_GET['tbxAgentName'])) {
            $tbxAgentName = Utility::GetForm('tbxAgentName', $_GET);
            $tbxAgentName = urldecode($tbxAgentName);
            $objAgentSourceBLL = new AgentSourceBLL();
            $agent_Id = $objAgentSourceBLL->GetAgentIDByName($tbxAgentName);
        }
        else
            $tbxAgentName = '';
        $appoint_id = Utility::GetFormInt('appoint_id', $_GET);




        //$ContactType = $objVisitAppointBLL->GetContactProduct($agentId);

        $ContactType = $objProductTypeBLL->GetAgentSignedProductTypeName($agentId, true);
        if ($ContactType == "")//未签约
            $ContactType = $objVisitAppointBLL->GetLevel($agentId);

        $arrayData = $objVisitAppointBLL->AppointAgentData($agentId, $appoint_id);
        if (isset($arrayData) && count($arrayData) > 0)
            $this->smarty->assign('arrayData', $arrayData);
        $this->smarty->assign('id', $id);
        $this->smarty->assign('ContactType', $ContactType);
        $this->smarty->assign('appoint_id', $appoint_id);
        $this->smarty->assign('agentId', $agentId);
        $this->smarty->display('Agent/WorkManagement/AppointModifyStep2.tpl');
    }

    /**
     * @functional 用户关联的代理商
     */
    public function CompleteAgentJson() {
        $text = Utility::GetForm('q', $_GET);
        $id = $this->getUserId();
        if ($id <= 0)
            exit("");
        $objVisitAppointBLL = new VisitAppointBLL();

        $strJson = $objVisitAppointBLL->AutoAgentJson($text, $id);
        exit($strJson);
    }

    /**
     * @functional 拜访者名称JSON
     */
    public function CompleteVisitorInfo() {
        $text = Utility::GetForm('q', $_GET);
        $agentId = Utility::GetForm('agentId', $_GET);
        $id = $this->getUserId();
        if ($agentId <= 0)
            exit("");
        $objVisitAppointBLL = new VisitAppointBLL();
        $strJson = $objVisitAppointBLL->VisitorInfo($text, $agentId);
        exit($strJson);
    }

    /**
     * @functional 拜访者TEL
     */
    public function GetTel() {
        $contact_name = Utility::GetForm('contact_name', $_POST);
        $agent_id = Utility::GetForm('agent_id', $_POST);
        $objVisitAppointBLL = new VisitAppointBLL();
        $tel = $objVisitAppointBLL->GetTel($contact_name, $agent_id);
        exit($tel);
    }

    /**
     * @functional 拜访预约数据提交
     */
    public function AppointModifySubmit() {
        $agentId = Utility::GetFormInt("agent_id", $_POST);
        $appoint_id = Utility::GetFormInt("appoint_id", $_POST);
        $objVisitAppointBLL = new VisitAppointBLL();
        $objProductTypeBLL = new ProductTypeBLL();
        $objVisitAppointInfo = new VisitAppointInfo();
        $objAgentContactInfo = new AgentContactInfo();


        $uid = $this->getUserId();
        $title = Utility::GetForm("title", $_POST);
        $mobile = Utility::GetForm("mobile", $_POST);
        $tel = Utility::GetForm("tel", $_POST);
        $visitor = Utility::GetForm("visitor", $_POST);
        $app_timeb = Utility::GetForm("app_timeb", $_POST);
        $app_timee = Utility::GetForm("app_timee", $_POST);
        $create_id = Utility::GetFormInt("create_id", $_POST); //编辑的时候传入的制定人的ID

        $visitor = urldecode($visitor);
        $title = urldecode($title);
        $app_timeb = urldecode($app_timeb);
        $app_timee = urldecode($app_timee);

        if ($visitor == "")
            exit("{success:false,'msg':'请输入拜访人名称'}");
        if ($title == "")
            exit("{success:false,'msg':'请输入拜访主题'}");
        if (Utility::is_time($app_timeb) == 0 || Utility::is_time($app_timee) == 0)
            exit("{success:false,'msg':'请输入预约时间段'}");
        else if (substr($app_timeb, 0, 10) != substr($app_timee, 0, 10))
            exit("{success:false,'msg':'请填写合理时间'}");
        else {
            $visit_time = substr($app_timeb, 0, 10);
            $count = $objVisitAppointBLL->IsExistAccompanyVisit($uid, $agentId, $visit_time, $appoint_id);
            if ($count > 0)
                exit("{success:false,'msg':'您已经添加了一条该代理商 $visit_time 日的拜访小记或陪访小记'}");
        }
        $channel_uid = $objVisitAppointBLL->GetChannelIdByAid($agentId);
        $ContactType = $objProductTypeBLL->GetAgentSignedProductTypeName($agentId, true);
        $level = $objVisitAppointBLL->GetLevel($agentId);
        if ($ContactType == "") {//未签约
            $objAgentContactInfo->iContactType = 0;
            $objVisitAppointInfo->strIntenLevel = $level;
        }
        else
            $objAgentContactInfo->iContactType = 1;
        //------------------------------------------判断联系人是否在代理商联系人列表中，若不在，并且填写了联系方式，添加到代理商联系人表中B--------------//
        $Viscpare = $objVisitAppointBLL->VisitorCompare($visitor, $agentId);
        if ($Viscpare <= 0) {
            if ($tel == "" && $mobile == "")
                exit("{success:false,'msg':'该联系人不在代理商联系人列表中，请输入联系方式'}");
            else {
                $objAgentContactInfo->iAgentId = $agentId;
                $objAgentContactInfo->iCreateUid = $uid;
                $objAgentContactInfo->iEventType = 0;
                $objAgentContactInfo->strContactName = $visitor;
                $objAgentContactInfo->strLeval = $level;
                $objAgentContactInfo->strMobile = $mobile;
                $objAgentContactInfo->strTel = $tel;
                $objVisitAppointBLL->insertContactName($objAgentContactInfo);
            }
        }

        //---------------------------------------------------------------------------------------------------------------e------------------------------------//
        $iAss_uid = 0;
        if ($uid != $channel_uid)
            $iAss_uid = $uid;
        //exit($iAss_uid."=".$uid."=".$channel_uid);
        $objVisitAppointInfo->iAss_uid = $iAss_uid;
        $objVisitAppointInfo->iAgentId = $agentId;
        $objVisitAppointInfo->iEuserId = $channel_uid;
        $objVisitAppointInfo->strTitle = $title;
        $objVisitAppointInfo->strTel = $tel;
        $objVisitAppointInfo->strMobile = $mobile;
        $objVisitAppointInfo->strVisitor = $visitor;
        $objVisitAppointInfo->strSappointTime = $app_timeb;
        $objVisitAppointInfo->strEappointTime = $app_timee;
        $objVisitAppointInfo->strProductName = $ContactType;

        if ($appoint_id > 0) {//编辑
            $objVisitAppointInfo->iCreateId = $create_id;
            $objVisitAppointInfo->iUpdateId = $uid;
            $objVisitAppointInfo->iAppointId = $appoint_id;
            if ($objVisitAppointBLL->updateByID($objVisitAppointInfo))
                exit("{success:true,'msg':'修改成功！'}");
            else
                exit("{'success':false,'msg':'修改出错！'}");
        }
        else {
            $objVisitAppointInfo->iCreateId = $channel_uid;
            if ($objVisitAppointBLL->insert($objVisitAppointInfo) > 0)
                exit("{success:true,'msg':'添加成功！'}");
            else
                exit("{'success':false,'msg':'添加出错！'}");
        }
    }

    /**
     * @functional 信息删除
     */
    public function DelAppoint() {
        $appoint_id = Utility::GetFormInt("appoint_id", $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();
        if ($objVisitAppointBLL->deleteByID($appoint_id, $uid) > 0)
            exit("{success:true,'msg':'删除成功！'}");
        else
            exit("{success:true,'msg':'删除失败！'}");
    }

    /**
     * @functional 预约信息卡片
     */
    public function AppointDetial() {
        $appoint_id = Utility::GetFormInt("appoint_id", $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();
        $arrayData = $objVisitAppointBLL->AppointAgentData(0, $appoint_id);

        $this->smarty->assign('arrayData', $arrayData);

        $this->smarty->display('Agent/WorkManagement/AppointDetial.tpl');
    }

    /**
     * @functional 拜访预约列表EXCEL导出
     */
    public function ExcelExportVisitAppointList() {
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();
        //===============================搜索b====================================//
        $is_all = Utility::GetFormInt('is_all', $_GET);
        $strUid = $objVisitAppointBLL->GetLowPositionUser($uid);
        $strWhere = $this->StrWhere($is_all, $strUid);


        //===============================搜索e====================================//
        $arrPageList = $this->getPageList($objVisitAppointBLL, "*", $strWhere, "", 10000);
        $arrayData = $arrPageList['list'];
        $iRecordCount = count($arrayData);

        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);

        $objExcel = new PHPExcel();

        $outputFileName = "拜访预约列表";
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->setTitle($outputFileName);
        $objActSheet->getColumnDimension('A')->setWidth(10);
        $objActSheet->getColumnDimension('B')->setWidth(20);
        $objActSheet->getColumnDimension('C')->setWidth(20);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $objActSheet->getColumnDimension('E')->setWidth(20);
        $objActSheet->getColumnDimension('F')->setWidth(20);
        $objActSheet->getColumnDimension('G')->setWidth(20);
        $objActSheet->getColumnDimension('H')->setWidth(20);
        $objActSheet->getColumnDimension('I')->setWidth(20);
        $objActSheet->getColumnDimension('G')->setWidth(20);
        $objActSheet->getColumnDimension('K')->setWidth(20);

        $objActSheet->setCellValue('A1', '编号');
        $objActSheet->setCellValue('B1', "制定人");
        $objActSheet->setCellValue('C1', '制定时间');
        $objActSheet->setCellValue('D1', '代理商名称');
        $objActSheet->setCellValue('E1', '拜访主题');
        $objActSheet->setCellValue('F1', '意向评级/签约产品');
        $objActSheet->setCellValue('G1', '被访人');
        $objActSheet->setCellValue('H1', '联系电话');
        $objActSheet->setCellValue('I1', '预约时间');
        $objActSheet->setCellValue('J1', '是否生成小记');
        $objActSheet->setCellValue('K1', '审查状态');

        //设置填充颜色  
        $objStyle = $objActSheet->getStyle('A1:K1')->getFill();
        $objStyle->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objStyle->getStartColor()->setARGB('FF999999');

        //设置对齐方式
        $objStyle = $objActSheet->getStyle('C1:C' . ($iRecordCount + 2))->getAlignment();
        $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objStyle = $objActSheet->getStyle('D1:D' . ($iRecordCount + 2))->getAlignment();
        $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        for ($i = 0; $i < $iRecordCount; $i++) {
            $rowIndex = $i + 2;
            $objActSheet->setCellValue("A" . $rowIndex, $arrayData[$i]["appoint_id"]);
            $objActSheet->setCellValue("B" . $rowIndex, $arrayData[$i]["e_name"]);
            $objActSheet->setCellValue("C" . $rowIndex, $arrayData[$i]["create_time"]);
            $objActSheet->setCellValue("D" . $rowIndex, $arrayData[$i]["agent_name"]);
            $objActSheet->setCellValue("E" . $rowIndex, $arrayData[$i]["title"]);
            $objActSheet->setCellValue("F" . $rowIndex, ($arrayData[$i]["product_name"] == "" ? $arrayData[$i]["inten_level"] : $arrayData[$i]["product_name"])); //inten_level
            $objActSheet->setCellValue("G" . $rowIndex, $arrayData[$i]["visitor"]);
            $objActSheet->setCellValue("H" . $rowIndex, ($arrayData[$i]["mobile"] . "/" . $arrayData[$i]["tel"])); //TEL
            $objActSheet->setCellValue("I" . $rowIndex, $arrayData[$i]["sappoint_time"] . "/" . $arrayData[$i]["eappoint_time"]); //
            $objActSheet->setCellValue("J" . $rowIndex, ($arrayData[$i]["note"] == 1) ? "是" : "否");
            $objActSheet->setCellValue("K" . $rowIndex, ($arrayData[$i]["check_status"] == 0) ? "未审查" : (($arrayData[$i]["check_status"] == 1) ? "通过" : "未通过"));
        }

        header("Content-type: text/html;charset=utf-8");
        header("Content-type: text/csv");
        header('Content-Disposition: attachment;filename="' . iconv("utf-8", "gb2312//IGNORE", $outputFileName) . '.xls"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     * @functional 拜访预约列表与导出列表公共的搜索条件
     */
    public function StrWhere($is_all, $strUid) {

        $appoint_id = Utility::GetFormInt('appoint_id', $_GET);
        $icre_people = Utility::GetFormInt('cre_people', $_GET);
        $agent_name = Utility::GetForm('agent_name', $_GET);
        $auditState = Utility::GetForm('auditState', $_GET);

        $create_timeb = Utility::GetForm('create_timeb', $_GET);
        $create_timee = Utility::GetForm('create_timee', $_GET);
        $contact_name = Utility::GetForm('contact_name', $_GET);
        $haveNote = Utility::GetForm('haveNote', $_GET);
        $user_name = Utility::GetForm('user_name', $_GET);

        $uid = $this->getUserId();
        if ($is_all == 1)//拜访预约审核列表中导出全部数据
            $strWhere = " `am_visit_appoint`.is_del = 0  ";
        else {
            if ($icre_people == -100) {//权限范围内的全部
                if ($strUid != "")
                    $strWhere = " `am_visit_appoint`.create_id in(" . $strUid . ",$uid) and `am_visit_appoint`.is_del = 0 ";
                else
                    $strWhere = " `am_visit_appoint`.create_id =$uid and `am_visit_appoint`.is_del = 0 ";
            }
            if ($icre_people == 0)//自己
                $strWhere = " (`am_visit_appoint`.create_id= $uid or (`am_visit_appoint`.ass_uid = $uid)) and `am_visit_appoint`.is_del = 0 ";
            if ($icre_people == 1) {//下属
                if ($strUid != "")
                    $strWhere = " `am_visit_appoint`.create_id in($strUid) and `am_visit_appoint`.is_del = 0 ";
                else
                    $strWhere = " `am_visit_appoint`.create_id in(0) and `am_visit_appoint`.is_del = 0 ";
            }
        }
        if ($icre_people == 2)//自己的助理
            $strWhere = " ((`am_visit_appoint`.ass_uid > 0 and `am_visit_appoint`.create_id=$uid) or (`am_visit_appoint`.ass_uid = $uid)) and `am_visit_appoint`.is_del = 0";

        if ($user_name != "")
            $strWhere .= " and `sys_user`.e_name like '%$user_name%'";
        if ($haveNote === "0")
            $strWhere .= " and `am_visit_appoint`.note=0 ";
        if ($haveNote === "1")
            $strWhere .= " and `am_visit_appoint`.note=1 ";
        if ($appoint_id > 0)
            $strWhere .= " and `am_visit_appoint`.appoint_id=$appoint_id ";
        if ($agent_name != "")
            $strWhere .= " and `am_agent_source`.`agent_name` like '%$agent_name%'";
        if ($auditState === "0")
            $strWhere .= " and `am_visit_appoint`.check_status=0 ";
        if ($auditState == "1")
            $strWhere .= " and `am_visit_appoint`.check_status=1 ";
        if ($auditState == "2")
            $strWhere .= " and `am_visit_appoint`.check_status=2 ";
        if ($create_timeb != "" && $create_timee != "") {
            $strWhere .= " and `am_visit_appoint`.create_time > '$create_timeb' and `am_visit_appoint`.create_time < '$create_timee' ";
        } else {
            if ($create_timeb != "")
                $strWhere .= " and `am_visit_appoint`.create_time > '$create_timeb' ";
            if ($create_timee != "")
                $strWhere .= " and `am_visit_appoint`.create_time < '$create_timee' ";
        }
        if ($contact_name != "")
            $strWhere .= " and `am_visit_appoint`.`visitor` like '%$contact_name%' ";
        return $strWhere;
    }

    /**
     * @functional 拜访预约审查列表
     */
    public function AppCheckList() {
        $this->PageRightValidate("AppCheckList", RightValue::check);

        $countname = Utility::GetForm('countname', $_GET);
        $counttimeb = Utility::GetForm('counttimeb', $_GET);
        $counttimee = Utility::GetForm('counttimee', $_GET);
        if ($countname != "") {
            $this->smarty->assign('countname', $countname);
            $this->smarty->assign('counttimeb', $counttimeb);
            $this->smarty->assign('counttimee', $counttimee);
        }

        $objVisitAppointBLL = new VisitAppointBLL();
        $objProductTypeBLL = new ProductTypeBLL();
        $id = $this->getUserId();
        $this->smarty->assign('id', $id);
        $this->smarty->assign('strTitle', '拜访预约审查列表');
        $this->smarty->assign('AppCheckListBody', "/?d=WorkM&c=VisitAppoint&a=AppCheckListBody");
        $this->displayPage('Agent/WorkManagement/AppCheckList.tpl');
    }

    /**
     * @functional 拜访预约审查列表Body
     */
    public function AppCheckListBody() {
        $this->PageRightValidate("AppCheckList", RightValue::check);
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();

        //===============================搜索b====================================//
        $countname = Utility::GetForm('countname', $_GET);
        $counttimeb = Utility::GetForm('counttimeb', $_GET);
        $counttimee = Utility::GetForm('counttimee', $_GET);
        $create_name = Utility::GetForm('create_name', $_GET);
        $appoint_id = Utility::GetFormInt('appoint_id', $_GET);
        $agent_name = Utility::GetForm('agent_name', $_GET);
        $auditState = Utility::GetForm('auditState', $_GET);

        $create_timeb = Utility::GetForm('create_timeb', $_GET);
        $create_timee = Utility::GetForm('create_timee', $_GET);
        $contact_name = Utility::GetForm('contact_name', $_GET);
        $haveNote = Utility::GetForm('haveNote', $_GET);
        $user_name = Utility::GetForm('user_name', $_GET);
        $strWhere = " `am_visit_appoint`.is_del = 0 ";
        if ($countname != "") {
            $strWhere .= " and `sys_user`.e_name like '%$countname%' and `am_visit_appoint`.note=1";
            if ($counttimeb != "")
                $strWhere .= " and DATE_FORMAT(`am_visit_appoint`.create_time,'%Y-%m-%d') >= '$counttimeb' ";
            if ($counttimee != "")
                $strWhere .= " and DATE_FORMAT(`am_visit_appoint`.create_time,'%Y-%m-%d') <= '$counttimee' ";
        }
        else {
            if ($create_timeb != "" && $create_timee != "") {
                $strWhere .= " and `am_visit_appoint`.create_time >= '$create_timeb' and `am_visit_appoint`.create_time <= '$create_timee' ";
            } else {
                if ($create_timeb != "")
                    $strWhere .= " and `am_visit_appoint`.create_time >= '$create_timeb' ";
                if ($create_timee != "")
                    $strWhere .= " and `am_visit_appoint`.create_time <= '$create_timee' ";
            }
        }

        if ($user_name != "")
            $strWhere .= " and `sys_user`.e_name like '%$user_name%'";
        if ($haveNote === "0")
            $strWhere .= " and `am_visit_appoint`.note=0 ";
        if ($haveNote === "1")
            $strWhere .= " and `am_visit_appoint`.note=1 ";
        if ($appoint_id > 0)
            $strWhere .= " and `am_visit_appoint`.appoint_id=$appoint_id ";
        if ($agent_name != "")
            $strWhere .= " and `am_agent_source`.`agent_name` like '%$agent_name%'";
        if ($auditState === "0")
            $strWhere .= " and `am_visit_appoint`.check_status=0 ";
        if ($auditState == "1")
            $strWhere .= " and `am_visit_appoint`.check_status=1 ";
        if ($auditState == "2")
            $strWhere .= " and `am_visit_appoint`.check_status=2 ";

        if ($contact_name != "")
            $strWhere .= " and `am_visit_appoint`.`visitor` like '%$contact_name%' ";
        if ($create_name != "")
            $strWhere .= " and `sys_user`.e_name like '%$create_name%'";


        //===============================搜索e====================================//
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $arrPageList = $this->getPageList($objVisitAppointBLL, "", $strWhere, "", $iPageSize);

        $this->smarty->assign('uid', $uid);
        $this->smarty->assign('arrayAppoint', $arrPageList['list']);
        $this->displayPage('Agent/WorkManagement/AppCheckListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    public function showAddVisitInvite() {
        $this->PageRightValidate("VisitAppoint", RightValue::add);
        $iAppointId = Utility::GetFormInt("appointid", $_GET);
        //获取代理商ID
        $objVisitAppointBLL = new VisitAppointBLL();
        if (empty($iAppointId)) {
            $iAgentId = Utility::GetFormInt("agentid", $_GET);
            $iOldNoteId = Utility::GetFormInt("oldNoteId", $_GET);
            $this->smarty->assign("oldNoteId", $iOldNoteId);
        } else {
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            if ($objVisitAppointInfo) {
                $iAgentId = $objVisitAppointInfo->iAgentId;
            } else {
                $iAgentId = 0;
            }
        }



        //获取代理商名称
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($iAgentId);
        if ($objAgentSourceInfo) {
            $strAgentName = $objAgentSourceInfo->strAgentName;
        }
        //获取网盟意向
        $iHasPect = $objAgentSourceInfo->iAgentId == $objAgentSourceInfo->strAgentNo ? 0 : 1;
        if ($iHasPect) {
            $objProductTypeBLL = new ProductTypeBLL();
            $arrProductType = $objProductTypeBLL->GetAgentProductType($iAgentId);
            if ($arrProductType) {
                foreach ($arrProductType as $item) {
                    $arrTemp[] = $item['product_type_name'];
                }
                $strIntertionRating = implode(',', $arrTemp);
            } else {
                $strIntertionRating = "无签约产品";
            }
        } else {
            $objExpectChargeBLL = new ExpectChargeBLL();
            $arrExpectInfo = $objExpectChargeBLL->getInfoByAgentId($iAgentId);
            if ($arrExpectInfo) {
                $strIntertionRating = $arrExpectInfo[0]['inten_level'];
            }
        }

        $objAgentContactBLL = new AgentContactBLL();
        if (empty($iAppointId)) {//添加，则获取最近一条电话任务所使用的联系人
            $objVisitNoteBLL = new VisitNoteBLL();
            $arrLastAppoint = $objVisitNoteBLL->getLastNote($iAgentId, 0);
            if ($arrLastAppoint) {
                $arrContactInfo = $objAgentContactBLL->getContactInfo($arrLastAppoint[0]['visitor'], $iAgentId);
            }
        } else {
            $arrContactInfo = $objAgentContactBLL->getContactInfoById($objVisitAppointInfo->iContactId);
        }
        if (isset($arrContactInfo) && $arrContactInfo) {
            $strVisitor = $arrContactInfo['contact_name'];
            $strTel = $arrContactInfo['tel'];
            $strMobile = $arrContactInfo['mobile'];
            $iIsCharge = $arrContactInfo['isCharge'];
            $iContactId = $arrContactInfo['aid'];
        }

        
        $this->smarty->assign("HasPect", $iHasPect);
        $this->smarty->assign('AppointId', $iAppointId);
        $this->smarty->assign("AgentID", $iAgentId);
        $this->smarty->assign("AgentName", isset($strAgentName) ? $strAgentName : '');
        $this->smarty->assign("Visitor", isset($strVisitor) ? $strVisitor : '');
        $this->smarty->assign("Tel", isset($strTel) ? $strTel : '');
        $this->smarty->assign("Mobile", isset($strMobile) ? $strMobile : '');
        $this->smarty->assign("IntentionRating", isset($strIntertionRating) ? $strIntertionRating : '');
        $this->smarty->assign("ContactId", isset($iContactId) ? $iContactId : 0);
        $this->smarty->assign("IsCharge", isset($iIsCharge) ? $iIsCharge : 1);
        $this->smarty->assign("appointtime", isset($objVisitAppointInfo) ? $objVisitAppointInfo->strSappointTime : Utility::addDay(Utility::Now(), 1, false));
        $this->smarty->assign("title", isset($objVisitAppointInfo) ? $objVisitAppointInfo->strTitle : '');
        $this->displayPage('Agent/WorkManagement/AddVisitInvite.tpl');
    }

    public function AddVisitInvite() {

        if (!$this->HaveRight("VisitAppoint", RightValue::add)) {
            Utility::Msg("对不起，您没有权限");
        }
        $iAgentID = Utility::GetFormInt("agentid", $_POST);
        if (empty($iAgentID))
            Utility::Msg("获取代理商信息失败");
        $strAppointTime = Utility::GetForm("appointtime", $_POST);
        if (empty($strAppointTime))
            Utility::Msg("请设置预约日期");
        $strAppointTimeEnd = Utility::GetForm("appointtime_end", $_POST);
        if (empty($strAppointTimeEnd))
            Utility::Msg("请设置预约日期");
        $strAppointTimeEnd = substr($strAppointTime, 0, 10) . " {$strAppointTimeEnd}";
        $strVisitor = Utility::GetForm("visitor", $_POST);
        if (empty($strVisitor))
            Utility::Msg("请填写被访人姓名");
        $strTel = Utility::GetForm("telphone", $_POST);
        $strMobile = Utility::GetForm("mobile", $_POST);
        if (empty($strTel) && empty($strMobile))
            Utility::Msg("固话和手机必须填写一项");
        $strTitle = urldecode(Utility::GetForm("title", $_POST));
        $strIntenLevel = Utility::GetForm("intenlevel", $_POST);
        $iAppointId = Utility::GetFormInt("appointid", $_POST);
        $iHasPect = Utility::GetFormInt("hasPect", $_POST);

        $iContactId = 0;
        //检查联系人信息，有出入则更新联系人表
        $iIsCharge = isset($_POST['ischarge']) ? 0 : 1;
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($strVisitor, $iAgentID); //若没有ID，则查看该代理商是否存在同名的联系人
        if ($arrContactInfo) {
            $iContactId = $arrContactInfo['aid'];
        }

        if (empty($iContactId)) {
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId = $iAgentID;
            $objAgentContactInfo->iEventType = 0;
            $objAgentContactInfo->iContactType = 0;
            $objAgentContactInfo->strContactName = $strVisitor;
            $objAgentContactInfo->strMobile = $strMobile;
            $objAgentContactInfo->iIscharge = $iIsCharge;
            $objAgentContactInfo->strTel = $strTel;
            $objAgentContactInfo->strCreateTime = Utility::Now();
            $objAgentContactInfo->iCreateUid = $this->getUserId();
            $objAgentContactInfo->iUpdateUid = $this->getUserId();
            $objAgentContactInfo->strUpdateTime = Utility::Now();
            $iContactRtn = $objAgentContactBLL->insert($objAgentContactInfo);
            if ($iContactRtn !== false) {
                $iContactId = $iContactRtn;
            }
        } else {
            if (!isset($arrContactInfo)) {//若联系人信息未获取，则获取信息
                $arrContactInfo = $objAgentContactBLL->getContactInfoById($iContactId);
            }
            
            if($arrContactInfo['isCharge'] == 0 && $iIsCharge == 1){
                Utility::Msg("不允许由负责人直接修改为非负责人");
            }

            $arrEdit = array();
            if ($iIsCharge != $arrContactInfo['isCharge'])
                $arrEdit['isCharge'] = $iIsCharge;
            if ($strTel != $arrContactInfo['tel'])
                $arrEdit['tel'] = $strTel;
            if ($strMobile != $arrContactInfo['mobile'])
                $arrEdit['mobile'] = $strMobile;
            if (count($arrEdit) > 0) {
                $iContactRtn = $objAgentContactBLL->UpdateData($arrEdit, "aid={$iContactId}");
            }
        }
        $objVisitAppointBLL = new VisitAppointBLL();
        if (empty($iAppointId)) {
            $objVisitAppointInfo = new VisitAppointInfo();
            $objVisitAppointInfo->iIsVisit = 0;
            $objVisitAppointInfo->iEuserId = $this->getUserId();
            $objVisitAppointInfo->iAgentId = $iAgentID;
            $objVisitAppointInfo->strRoleName = isset ($arrContactInfo['role'])?$arrContactInfo['role']:'';
            $objVisitAppointInfo->strPosition = isset ($arrContactInfo['position'])?$arrContactInfo['position']:'';
            $objVisitAppointInfo->iCreateId = $this->getUserId();
            $objVisitAppointInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
            $objVisitAppointInfo->strCreateTime = Utility::Now();
        } else {
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            $objVisitAppointInfo->iCheckStatus = AgentCheckStatus::UnCheck;
        }
        $objVisitAppointInfo->strVisitor = $strVisitor;
        $objVisitAppointInfo->strTel = $strTel;
        $objVisitAppointInfo->strMobile = $strMobile;
        $objVisitAppointInfo->strTitle = $strTitle;
        if ($iHasPect == 1) {
            $objVisitAppointInfo->strProductName = $strIntenLevel;
        } else {
            $objVisitAppointInfo->strIntenLevel = $strIntenLevel;
        }
        $objVisitAppointInfo->strSappointTime = $strAppointTime;
        $objVisitAppointInfo->strEappointTime = $strAppointTimeEnd;
        $objVisitAppointInfo->iUpdateId = $this->getUserId();
        $objVisitAppointInfo->iContactId = $iContactId;
        $objVisitAppointInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitAppointInfo->strUpdateTime = Utility::Now();
        if (empty($iAppointId)) {
            $iRtn = $objVisitAppointBLL->insert($objVisitAppointInfo);
        } else {
            $iRtn = $objVisitAppointBLL->updateByID($objVisitAppointInfo);
        }
        if ($iRtn === false) {
            Utility::Msg("设置拜访预约失败");
        }

        $iOldNoteId = Utility::GetFormInt("oldNoteId", $_POST);
        if (!empty($iOldNoteId)) {
            $objVisitNoteBLL = new VisitNoteBLL();
            $iNoteRtn = $objVisitNoteBLL->UpdateData(array(
                'follow_up_content' => $strTitle,
                'follow_up_time' => $strAppointTime,
                'follow_up_time_end' => $strAppointTimeEnd
                    ), "id = {$iOldNoteId}");
        }

        Utility::Msg("设置拜访预约成功", true);
    }

    public function showVisitTaskManageList() {
        if ($this->HaveRight("VisitAppoint", RightValue::v64)) {
            $this->PageRightValidate("VisitAppoint", RightValue::v64);
            $iViewType = 1; //自己
        } else if ($this->HaveRight("VisitAppoint", RightValue::v128)) {
            $this->PageRightValidate("VisitAppoint", RightValue::v128);
            $iViewType = 2; //自己
        } else {
            $this->PageRightValidate("VisitAppoint", RightValue::view);
            $iViewType = 3; //自己
        }
        $this->smarty->assign("BodyUrl", $this->getActionUrl("WorkM", "VisitAppoint", "showVisitTaskManageBody"));
        $this->displayPage('Agent/WorkManagement/VisitTaskManageList.tpl');
    }

    public function showVisitTaskManageBody() {
        if ($this->HaveRight("TelTaskManage", RightValue::v64)) {
            $this->ExitWhenNoRight("TelTaskManage", RightValue::v64);
            $iViewType = 1; //全部
        } else if ($this->HaveRight("TelTaskManage", RightValue::v128)) {
            $this->ExitWhenNoRight("TelTaskManage", RightValue::v128);
            $iViewType = 2; //自己以及下属
        } else {
            $this->ExitWhenNoRight("TelTaskManage", RightValue::view);
            $iViewType = 3; //自己
        }
        $strWhere = $this->getVisitTaskManageWhere($iViewType);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();

        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if ($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;

        $arrTelTaskManageList = $objVisitAppointBLL->getVisitTaskManageList($strWhere, $strOrder, $iExportExcel);
        if ($iExportExcel == true) {
            $arrayData = &$arrTelTaskManageList["list"];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();

            $objExcelBottomColumns->Add(new ExcelBottomColumn("任务编号", "appoint_id",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向评级或签约产品", "intertion_product",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被访人", "visitor",  ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("职位", "position",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("角色", "role",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系人手机", "mobile",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系人固话", "tel",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("计划联系日期", "sappoint_time_cn",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访计划", "title", ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访任务制定人", "create_user_name",ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访任务制定时间", "create_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("审核状态", "check_status_cn", ExcelDataTypes::String));
            $objDataToExcel->Init("拜访预约", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        } else {
            $this->smarty->assign("UserID", $this->getUserId());
            $this->showPageSmarty($arrTelTaskManageList, 'Agent/WorkManagement/VisitTaskManageBody.tpl');
        }
    }

    public function getVisitTaskManageWhere($iViewType) {
        switch ($iViewType) {
            case 1: $strWhere = "";
                break;
            case 2: {
                    $objVisitAppointBLL = new VisitAppointBLL();
                    $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                    if($strUid != "")
                        $strWhere .= " and (am_visit_appoint.create_id = {$this->getUserId()} or am_visit_appoint.create_id in({$strUid})) ";
                        /*
                    $DeptNo = $this->getDeptNoBack();
                    $strWhere = " and ( (v_hr_employee.dept_no like '{$DeptNo}%' and v_hr_employee.dept_no <> '{$DeptNo}') or am_visit_appoint.create_id = {$this->getUserId()}) ";*/
                }break;
            default :$strWhere = " and am_visit_appoint.create_id = {$this->getUserId()} ";
                break;
        }

        $strWhere .=" and am_visit_appoint.is_visit = 0 ";

        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if (!empty($strAgentName)) {
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%'  ";
        }
        $iCheckStatus = Utility::GetFormInt("checkstatus", $_GET);
        if ($iCheckStatus > -9) {
            $strWhere .= " and am_visit_appoint.check_status  = {$iCheckStatus} ";
        }
        $strAppointTime = Utility::GetForm("appointtime", $_GET);
        if (!empty($strAppointTime)) {
            $strWhere .= " and am_visit_appoint.sappoint_time >= '{$strAppointTime}' ";
        }
        
        $strAppointTimeEnd = Utility::GetForm("appointtime_end", $_GET);
        if(!empty ($strAppointTimeEnd)){
            $strWhere .= " and am_visit_appoint.sappoint_time < DATE_ADD('{$strAppointTimeEnd}',INTERVAL 1 DAY) ";
        }

        $iViewTypeFront = Utility::GetFormInt("view_type", $_GET);
        if (!empty($iViewTypeFront) && $iViewType != 3) {
            if ($iViewTypeFront == 1) {//下属
                $objVisitAppointBLL = new VisitAppointBLL();
                $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                if($strUid != "")
                    $strWhere .= " and am_visit_appoint.create_id in({$strUid}) ";
            /*
                if (!isset($DeptNo)) {
                    $DeptNo = $this->getDeptNoBack();
                }
                $strWhere .= " and v_hr_employee.dept_no like '{$DeptNo}%' and v_hr_employee.dept_no <> '{$DeptNo}' ";*/
            } else {//自己
                $strWhere .= " and am_visit_appoint.create_id = {$this->getUserId()} ";
            }
        }
        
       if($iViewTypeFront < 2){
            $strCreateUserName = Utility::GetForm("create_user", $_GET);
            if(!empty ($strCreateUserName)){
                $strWhere .= " and am_visit_appoint.create_user_name like '%{$strCreateUserName}%' ";
            }
        }
        
        $iNoteState = Utility::GetFormInt("note_state", $_GET);
        if($iNoteState >= 0){
            $strWhere .= " and am_visit_appoint.note = {$iNoteState} ";
        }
        return $strWhere;
    }

    public function showAddVisitNote() {
        $this->PageRightValidate("VisitAppoint", RightValue::v32);
        $iAppointId = Utility::GetFormInt('appid', $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        //是否已指定预约

        $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
        $this->smarty->assign("AppointInfo", $objVisitAppointInfo);
        
        $iAgentId = Utility::GetFormInt("agentid", $_GET);
        if(empty ($iAgentId)){
            $iAgentId = $objVisitAppointInfo->iAgentId;
        }

        //获取拜访人信息
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($objVisitAppointInfo->strVisitor, $iAgentId);
        if(!$arrContactInfo){
            $objVisitNoteBLL = new VisitNoteBLL();
            $arrLastAppoint = $objVisitNoteBLL->getLastNote($iAgentId, 0);
            if ($arrLastAppoint) {
                $arrContactInfo = $objAgentContactBLL->getContactInfo($arrLastAppoint[0]['visitor'], $iAgentId);
            }
        }
        
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($iAgentId);

        //获取联系内容
        $objConstDataBLL = new ConstDataBLL();
        $arrayAgentContactContent = $objConstDataBLL->select("*", "data_type='" . AgentCommSet::Agent_Contact_Content . "'", "");
        //判断是否签约代理商
        $iIsPact = ($objAgentSourceInfo->strAgentNo == $objAgentSourceInfo->iAgentId) ? 0 : 1;
        $objProductTypeBLL = new ProductTypeBLL();
        if ($iIsPact) {
            $arrProductType = $objProductTypeBLL->GetAgentProductType($iAgentId);
        } else {
            $arrProductType = $objProductTypeBLL->GetProductType();
        }
        //获取网盟意向
        $objExpectChargeBLL = new ExpectChargeBLL();
        $arrExpectInfo = $objExpectChargeBLL->getInfoByAgentId($iAgentId);
        if(isset($arrExpectInfo[0])){
            $arrExpectInfo = $arrExpectInfo[0];
        }else{
            $objProductTypeBLL = new ProductTypeBLL();
            $iAdhaiProductId = $objProductTypeBLL->GetUnitProductTypeID();
            $arrExpectInfo = array('inten_level' => 'E', 'product_id' => $iAdhaiProductId);
        }
                
        $this->smarty->assign('arrayAgentDocType',AgentDocType::GetData()); 
        $this->smarty->assign("ExpectInfo", $arrExpectInfo);
        $this->smarty->assign("ContactContent", $arrayAgentContactContent);
        $this->smarty->assign("IsPact", $iIsPact);
        $this->smarty->assign("ProductType", $arrProductType);
        $this->smarty->assign("AgentInfo", $objAgentSourceInfo);
        $this->smarty->assign("ContactInfo", isset($arrContactInfo) ? $arrContactInfo : array());
        $this->displayPage('Agent/WorkManagement/AddVisitNote.tpl');
    }

    public function AddVisitNote() {
        if (!$this->HaveRight("TelTaskManage", RightValue::v32)) {
            Utility::Msg("对不起,您没有权限");
        }

        $objAgentSourceInfo = null;
        $arrPostInfo = $this->getPostInfo($objAgentSourceInfo);

//        //查看联系人是否改变，若改变则更新联系人信息
        $arrChangeInfo = $this->getUpdateInfoByContact($arrPostInfo);
        if ($arrChangeInfo) {
            $iUpdateRtn = $this->UpdateContactInfo($arrChangeInfo);
            if ($iUpdateRtn === false) {
                Utility::Msg("更新联系人信息失败");
            }
        }

        //添加联系小记
        $objVisitNoteInfo = new VisitNoteInfo();
        $objVisitNoteInfo->iVisitnoteid = $arrPostInfo['iAppointId'];
        $objVisitNoteInfo->iAgentId = $arrPostInfo['iAgentID'];
        $objVisitNoteInfo->iIsVisit = 0;
        $objVisitNoteInfo->iVisitType = $arrPostInfo['iContactType'] ? $arrPostInfo['iVisitType'] : 0;
        $objVisitNoteInfo->strAfterlevel = $arrPostInfo['iContactType'] ? 'A+' : $arrPostInfo['iIntentionRating'];
        $objVisitNoteInfo->iAfterProductid = $arrPostInfo['iProductTypeId'];
        $objVisitNoteInfo->strProductName = $arrPostInfo['strProductType'];
        $objVisitNoteInfo->strVisitor = $arrPostInfo['strVisitor'];
        $objVisitNoteInfo->strMobile = $arrPostInfo['strMobile'];
        $objVisitNoteInfo->strTel = $arrPostInfo['strTel'];
        $objVisitNoteInfo->strVisitTimestart = $arrPostInfo['strVisitTime'];
        $objVisitNoteInfo->strVisitTimeend = $arrPostInfo['strVisitTimeEnd'];
        $objVisitNoteInfo->iContactContentId = $arrPostInfo['iContactContentId'];
        $objVisitNoteInfo->strResult = $arrPostInfo['strContactContent'];
        $objVisitNoteInfo->strVisitContent = $arrPostInfo['strVisitPlan'];
        $objVisitNoteInfo->strCreateTime = Utility::Now();
        $objVisitNoteInfo->iCreateUid = $this->getUserId();
        $objVisitNoteInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitNoteInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitNoteInfo->strUpdateTime = Utility::Now();
        $objVisitNoteInfo->iUpdateUid = $this->getUserId();
        $objVisitNoteInfo->iContactType = $arrPostInfo['iContactType'];
        $objVisitNoteBll = new VisitNoteBLL();
        $iNoteRtn = $objVisitNoteBll->insert($objVisitNoteInfo);
        if ($iNoteRtn === false) {
            Utility::Msg("添加拜访小记失败");
        }

        if ($arrPostInfo['iContactType'] && $arrPostInfo['iVisitType'] == 2 && !empty($arrPostInfo['strUploadFilePath'])) {
            $arrPostInfo['strUploadFilePath'] = "{$arrPostInfo['iAgentID']}/{$arrPostInfo['strUploadFilePath']}";
            $_POST['tbxAgentID'] = $objAgentSourceInfo->iAgentId;
            $_POST['tbxAgent'] = $objAgentSourceInfo->strAgentName;
            $this->AddFileUpdate();
        }

        //更新代理商意向
        $this->addExpectInfo(
                $arrPostInfo['iAgentID'], isset($arrPostInfo['strIncomeTime']) ? $arrPostInfo['strIncomeTime'] : '', isset($arrPostInfo['dIncomeMoney']) ? $arrPostInfo['dIncomeMoney'] : 0, isset($arrPostInfo['dIncomeRate']) ? $arrPostInfo['dIncomeRate'] : 0, isset($arrPostInfo['iIncomeType']) ? $arrPostInfo['iIncomeType'] : 0, isset($arrPostInfo['iIntentionRating']) ? $arrPostInfo['iIntentionRating'] : 'A', $arrPostInfo['iProductTypeId'], $iNoteRtn, $arrPostInfo['iHasIncome']);

        //判断是否关联电话任务，若关联，则更新电话任务为已添加联系小记
        $objVisitAppointBLL = new VisitAppointBLL();
        if (!empty($arrPostInfo['iAppointId'])) {
            $iAppointFlagRtn = $objVisitAppointBLL->setNoteAdded($arrPostInfo['iAppointId']);
        }

        if ($arrPostInfo['iGoNext']) {
            Utility::Msg("添加拜访小记成功", true, $this->getActionUrl("WorkM", "VisitAppoint", "showAddVisitInvite", "agentid={$arrPostInfo['iAgentID']}&oldNoteId={$iNoteRtn}"));
        }

//        if (!empty($arrPostInfo['strNextVisitTime'])) {//是否设定下次联系时间，设定的话添加一条电话任务
//            $objVisitAppointInfo = new VisitAppointInfo();
//            $objVisitAppointInfo->iIsVisit = 0;
//            $objVisitAppointInfo->iEuserId = $this->getUserId();
//            $objVisitAppointInfo->iAgentId = $arrPostInfo['iAgentID'];
//            $objVisitAppointInfo->iCreateId = $this->getUserId();
//            $objVisitAppointInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
//            $objVisitAppointInfo->strCreateTime = Utility::Now();
//            $objVisitAppointInfo->strVisitor = $arrPostInfo['strVisitor'];
//            $objVisitAppointInfo->strTel = $arrPostInfo['strTel'];
//            $objVisitAppointInfo->strMobile = $arrPostInfo['strMobile'];
//            $objVisitAppointInfo->strTitle = $arrPostInfo['strContactContent'];
//            $objVisitAppointInfo->strIntenLevel = $arrPostInfo['iIntentionRating'];
//            $objVisitAppointInfo->strSappointTime = "{$arrPostInfo['strNextVisitTime']} 00:00:00";
//            $objVisitAppointInfo->strEappointTime = "{$arrPostInfo['strNextVisitTime']} 23:59:59";
//            $objVisitAppointInfo->iUpdateId = $this->getUserId();
//            $objVisitAppointInfo->iContactId = $arrPostInfo['iContactId'];
//            $objVisitAppointInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
//            $objVisitAppointInfo->strUpdateTime = Utility::Now();
//            $iAppointRtn = $objVisitAppointBLL->insert($objVisitAppointInfo);
//        }

        Utility::Msg("添加拜访小记成功", true);
    }

    private function getPostInfo(&$objAgentSourceInfo) {
        $arrPostInfo = array();
        //获取ID信息
        $arrPostInfo['iAppointId'] = Utility::GetFormInt("appointid", $_POST);
        $arrPostInfo['iAgentID'] = Utility::GetFormInt("agentId", $_POST);
        if (empty($arrPostInfo['iAgentID']))
            Utility::Msg("获取代理商信息失败");
        $arrPostInfo['strProductType'] = urldecode(Utility::GetForm("productType", $_POST));
        if ($arrPostInfo['strProductType'] == '-100')
            Utility::Msg("请选择意向产品");
        list($arrPostInfo['iProductTypeId'], $arrPostInfo['strProductType']) = explode('|', $arrPostInfo['strProductType']);

        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($arrPostInfo['iAgentID']);
        $arrPostInfo['iContactType'] = $objAgentSourceInfo->iAgentId == $objAgentSourceInfo->strAgentNo ? 0 : 1;
        if ($arrPostInfo['iContactType']) {
            //已经签约
            $arrPostInfo['iIntentionRating'] = 'A';
            $arrPostInfo['iVisitType'] = Utility::GetFormInt("visit_type", $_POST);
            $arrPostInfo['iHasIncome'] = isset($_POST['hasIncome']) ? 1 : 0;
            if ($arrPostInfo['iVisitType'] == 1) {//沟通
                if ($arrPostInfo['iHasIncome']) {
                    $arrPostInfo['strIncomeTime'] = Utility::GetForm("incomeDate", $_POST);
                    if (empty($arrPostInfo['strIncomeTime']))
                        Utility::Msg("请确认预计到账时间");
                    $arrPostInfo['dIncomeMoney'] = Utility::GetFormDouble("incomeMoney", $_POST);
                    if (empty($arrPostInfo['dIncomeMoney']))
                        Utility::Msg("请填写预计到账金额");
                    $arrPostInfo['dIncomeRate'] = Utility::GetFormDouble("incomeRate", $_POST);
                    if (empty($arrPostInfo['dIncomeRate']))
                        Utility::Msg("请填写预计达成率");
                    $arrPostInfo['iIncomeType'] = Utility::GetFormInt("incomeType", $_POST);
                }
            }else {//培训
                $arrPostInfo['iDocType'] = Utility::GetFormInt("doc_type", $_POST);
                $arrPostInfo['strUploadFilePath'] = urldecode(Utility::GetForm("tbxUploadFilePath", $_POST));
                $arrPostInfo['strFileName'] = urldecode(Utility::GetForm("fileUpload", $_POST));
            }
        } else {
            //未签约
            $arrPostInfo['iIntentionRating'] = urldecode(Utility::GetForm("intentionRating", $_POST));
            $arrPostInfo['iHasIncome'] = $arrPostInfo['iIntentionRating'] <= 'B+' ? 1 : 0;
            if ($arrPostInfo['iHasIncome']) {//若意向等级在B+以上，则验证预计到账信息
                $arrPostInfo['strIncomeTime'] = Utility::GetForm("incomeDate", $_POST);
                if (empty($arrPostInfo['strIncomeTime']))
                    Utility::Msg("请确认预计到账时间");
                $arrPostInfo['dIncomeMoney'] = Utility::GetFormDouble("incomeMoney", $_POST);
                if (empty($arrPostInfo['dIncomeMoney']))
                    Utility::Msg("请填写预计到账金额");
                $arrPostInfo['dIncomeRate'] = Utility::GetFormDouble("incomeRate", $_POST);
                if (empty($arrPostInfo['dIncomeRate']))
                    Utility::Msg("请填写预计达成率");
                $arrPostInfo['iIncomeType'] = Utility::GetFormInt("incomeType", $_POST);
            }else {
                $arrPostInfo['strIncomeTime'] = '';
                $arrPostInfo['dIncomeMoney'] = 0;
                $arrPostInfo['dIncomeRate'] = 0;
                $arrPostInfo['iIncomeType'] = 0;
            }
        }
        //被访人信息
        $arrPostInfo['strVisitor'] = urldecode(Utility::GetForm("con_visitor", $_POST));
        if (empty($arrPostInfo['strVisitor']))
            Utility::Msg("请填写被访人");
        $arrPostInfo['iContactId'] = Utility::GetFormInt("con_id", $_POST);
        ;
        $arrPostInfo['iIsCharge'] = isset($_POST['con_isChargePerson']) ? 0 : 1;
        $arrPostInfo['strMobile'] = Utility::GetForm("con_mobile", $_POST);
        $arrPostInfo['strTel'] = Utility::GetForm("con_tel", $_POST);
        if (empty($arrPostInfo['strMobile']) && empty($arrPostInfo['strTel'])) {
            Utility::Msg("手机电话必填一项");
        }
        $arrPostInfo['strPosition'] = urldecode(Utility::GetForm("con_position", $_POST));
        $arrPostInfo['strFax'] = Utility::GetForm("con_fax", $_POST);
        $arrPostInfo['strEmail'] = urldecode(Utility::GetForm("con_email", $_POST));
        $arrPostInfo['iQq'] = Utility::GetForm("con_qq", $_POST);
        $arrPostInfo['strMsn'] = urldecode(Utility::GetForm("con_msn", $_POST));
        $arrPostInfo['strWeiBo'] = Utility::GetForm("con_weibo", $_POST);
        $arrPostInfo['strRemark'] = urldecode(Utility::GetForm("con_remark", $_POST));
        //联系人内容信息
        $arrPostInfo['strVisitTime'] = urldecode(Utility::GetForm("visit_time", $_POST));
        if (empty($arrPostInfo['strVisitTime']))
            Utility::Msg("请填写拜访时间");
        $arrPostInfo['strVisitTimeEnd'] = urldecode(Utility::GetForm("visit_time_end", $_POST));
        if (empty($arrPostInfo['strVisitTimeEnd']))
            Utility::Msg("请填写拜访时间");
        $arrPostInfo['strVisitTimeEnd'] = substr($arrPostInfo['strVisitTime'], 0, 10) . " {$arrPostInfo['strVisitTimeEnd']}";
        $arrPostInfo['iContactContentId'] = Utility::GetFormInt("visit_content", $_POST);
        $arrPostInfo['strContactContent'] = urldecode(Utility::GetForm("visit_content_new", $_POST));
        if (empty($arrPostInfo['strContactContent']))
            Utility::Msg("请填写拜访结果内容");
        $arrPostInfo['strVisitContent'] = urldecode(Utility::GetForm("visit_content", $_POST));
        $arrPostInfo['iGoNext'] = isset($_POST['goNext']) ? 1 : 0;
        $arrPostInfo['strVisitPlan'] = urldecode(Utility::GetForm("visit_plan", $_POST));
        return $arrPostInfo;
    }

    public function getVisitNoteDetail() {
        if (!$this->HaveRight("AgentList", RightValue::v8) &&
                !$this->HaveRight("VisitNote", RightValue::v2)) {
            exit("您没有此操作权限！");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        if($objVisitNoteInfo){
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($objVisitNoteInfo->strVisitor, $objVisitNoteInfo->iAgentId);
        $this->smarty->assign("ContactInfo", $arrContactInfo);
        $this->smarty->assign('NoteInfo', $objVisitNoteInfo);
        $this->smarty->assign('AgentInfo', $objAgentSourceInfo);
        echo $this->smarty->fetch('Agent/WorkManagement/VisitNoteInfoDetail.tpl');
    }
    
    public function showTransferAgent(){
        $this->displayPage('Agent/WorkManagement/transferAgent.tpl');
    }
}