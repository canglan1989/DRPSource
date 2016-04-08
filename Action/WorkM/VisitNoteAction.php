<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：代理商管理-工作管理-拜访小记
 * 创建人：xdd
 * 添加时间：2011-10-13 
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitAppointBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitVertifyBLL.php';
require_once __DIR__ . '/../../Class/Model/VisitNoteInfo.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/VisitReturnBLL.php';
require_once __DIR__ . '/../../Class/Model/VisitReturnInfo.php';

require_once __DIR__ . '/../Common/PHPExcel.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel2007.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel5.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeHistoryBLL.php';
require_once __DIR__ . '/NoteBase.php';
require_once __DIR__ . '/../Common/ExportExcel.php';
class VisitNoteAction extends NoteBase
{

    public function __construct()
    {
        
    }

    public function Index()
    {
        $this->NoteList();
    }

//    /**
//     * @functional 拜访小记列表
//     */
//    public function NoteList()
//    {
//        $this->PageRightValidate("VisitNote", RightValue::view);
//        $agent_id = Utility::GetFormInt('agent_id', $_GET);
//        $id = $this->getUserId();
//
//        $this->smarty->assign('agent_id', $agent_id);
//        $this->smarty->assign('id', $id);
//        $this->smarty->assign('NoteListBody', "/?d=WorkM&c=VisitNote&a=NoteListBody&agent_id=" . $agent_id);
//        $this->displayPage('Agent/WorkManagement/NoteList.tpl');
//    }
    /**
     * @functional 拜访小记列表
     */
    public function NoteList()
    {
        if(!$this->HaveRight("VisitNote", RightValue::viewCompany,true)){
            $this->PageRightValidate("VisitNote", RightValue::view);
        }
        $agent_id = Utility::GetFormInt('agent_id', $_GET);
        $id = $this->getUserId();

        $this->smarty->assign('agent_id', $agent_id);
        $this->smarty->assign('id', $id);
        $this->smarty->assign('NoteListBody', "/?d=WorkM&c=VisitNote&a=NoteListBody&agent_id=" . $agent_id);
        $this->displayPage('Agent/WorkManagement/VisitNoteList.tpl');
    }
    
    /**
     * @functional 拜访小计列表Body
     */
    public function NoteListBody()
    {
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();
        $strWhere = "";
        if(!$this->HaveRight("VisitNote", RightValue::viewCompany)){
            $this->ExitWhenNoRight("VisitNote", RightValue::view);
        }
            
        //------------------------------搜索-b--------------------------------//            
        $is_sign =Utility::GetFormInt('is_sign', $_GET);//是否签约代理商
        
        $icre_people = Utility::GetFormInt('cre_people', $_GET);//操作人
        if ($icre_people == 0)
            $strWhere = " and A.create_uid= $uid ";
        else
        {
            $strUid = $objVisitAppointBLL->GetLowPositionUser($uid); //下级的id
            if ($icre_people == -100)//权限范围内的全部
            {
                if(!$this->HaveRight("VisitNote", RightValue::viewCompany))
                {
                    if ($strUid != "")
                        $strWhere = " and A.create_uid in (" . $strUid . ",$uid)";
                    else
                        $strWhere = " and A.create_uid= $uid ";
                }                
            }
            else if ($icre_people == 1)//下属
            {
                if ($strUid != "")
                    $strWhere = " and A.create_uid in (" . $strUid . ")";
                else
                    $strWhere = " and A.create_uid=-1";
            }
        }
        $agent_id = Utility::GetFormInt('agent_id', $_GET);
        $qcheck_state = Utility::GetFormInt('qcheck_state', $_GET);//质检状态

        $agent_name = Utility::GetForm('agent_name', $_GET);
        $readState = Utility::GetForm('readState', $_GET);//批示状态
    
        $user_name = Utility::GetForm('user_name', $_GET);
        $agentLevel=Utility::GetForm('agentLevel', $_GET);//意向评级
        
        if (isset($agent_id) && $agent_id > 0)
            $strWhere .= " and A.`agent_id` =" . $agent_id;
        if ($user_name != ""&&$icre_people!=0)
            $strWhere .= " and (A.create_user_name like '%$user_name%') ";
       
        if ($agent_name != "")
            $strWhere .= " and B.`agent_name` like '%$agent_name%'";
        //$agentLevel = isset($_GET['agentLevel']) ? trim($_GET['agentLevel']) : '';
        if($is_sign!=0)
        {
            $strWhere .=" and B.agent_id != B.agent_no";
        }
        $agentLevel = isset($_GET['agentLevel'])? rawurldecode($_REQUEST['agentLevel']):'';
        
        if ($agentLevel != ''&&$is_sign!=1)
        {
            $con = '';
            if (strpos($agentLevel, ','))
            {
                $arrLeval = explode(',', $agentLevel);
                foreach ($arrLeval as $val)
                {
                    $con .= "(A.afterlevel = '" . $val . "') OR ";
                }
                $con = substr($con, 0, -4);
            }
            else
            {
                $con = "A.afterlevel = '" . $agentLevel . "'";
            }
            $strWhere .= " AND (" . $con . ") AND B.agent_id = B.agent_no";
        }
        
        $create_timeb = Utility::GetForm('create_timeb', $_GET);
        $create_timee = Utility::GetForm('create_timee', $_GET);
        
        if ($create_timeb != "" && Utility::isShortTime($create_timeb))
            $strWhere .= " and A.visit_timestart >= '$create_timeb' ";
        if ($create_timee != "" && Utility::isShortTime($create_timee))
            $strWhere .= " and A.visit_timestart < ".Utility::SQLEndDate($create_timee);
            
        if($qcheck_state != -100){
            switch ($qcheck_state) {
                case 0: {
                        $strWhere .= " and A.is_vertifyed = 0 ";
                    }break;
                case 1: {
                        $strWhere .= " and A.is_vertifyed > 0 and F.verfity_status =1 ";
                    }break;
                case 2 : {
                        $strWhere .= " and A.is_vertifyed > 0 and F.verfity_status =0 ";
                    }break;
                case 3 : {
                        $strWhere .= " and A.is_vertifyed = 2 ";
                    }break;
            }
        }
        if($readState !=-100)
        {
            switch ($readState) {
                case 0: {
                        $strWhere .= " and A.is_vertifyed <3 ";
                    }break;
                case 1: {
                        $strWhere .= " and A.is_vertifyed =3   ";
                    }break;
                case 2 : {
                        $strWhere .= " and A.is_vertifyed =4 ";
                    }break;
            }
        }
        //------------------------------搜索-e--------------------------------//
        $strOrder = Utility::GetForm("sortField", $_GET);
        $this->smarty->assign('uid', $uid);
        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if ($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
        $arrPageList =$objVisitNoteBLL->getVisitRecord($strWhere, $strOrder,$iExportExcel);
        //var_dump($iExportExcel);
        if ($iExportExcel == true) {
            
            $arrayData = &$arrPageList["list"];

            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("编号", "id", ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商编号", "agent_no", ExcelDataTypes::String));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("意向评级", "afterlevel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("签约产品", "product_name", ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访类型", "visit_type"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访人", "visitor"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系电话", "mobile"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("联系手机", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访时间", "visit_timestart", ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人", "create_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作时间", "create_time", ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访计划", "visit_content", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访结果", "result"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("下次拜访时间", "follow_up_time",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("下次拜访计划", "follow_up_content", ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("批示内容", "instruction",ExcelDataTypes::String, 100));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检结果", "verfity_status"));
            $objDataToExcel->Init("拜访小记", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            exit("");
        } else {
            $this->showPageSmarty($arrPageList, "Agent/WorkManagement/VisitNoteListBody.tpl");
        }
        
        
             
    }
    /**
     * @functional 添加编辑拜访小记
     */
    public function ModifyNote()//visitnoteid
    {
        $this->PageRightValidate("VisitNote", RightValue::add);
        $uid = $this->getUserId();
        $id = Utility::GetFormInt('id', $_GET); //拜访小记ID
        $appoint_id = Utility::GetFormInt('appoint_id', $_GET);
        $agentId = Utility::GetFormInt('agentId', $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        if ($id > 0)
        {
            $arrayData = $objVisitNoteBLL->GetNoteInfo($appoint_id);
        }
        else
            $arrayData = $objVisitNoteBLL->GetAppointData($appoint_id);
        //print_r($arrayData);
        $objExpectChargeBLL= new ExpectChargeBLL();
        $arrExpect =$objExpectChargeBLL->getInfoByAgentId($agentId);
        //var_dump($arrExpect);
        if(count($arrExpect)>0)
        {
            $this->smarty->assign('arrExpect',$arrExpect);
        }
        $this->smarty->assign('arrayData', $arrayData);
        $this->smarty->assign('id', $uid);
        $this->smarty->assign('appoint_id', $appoint_id);
        $this->smarty->assign('agentId', $agentId);
        $this->smarty->display('Agent/WorkManagement/ModifyNote.tpl');
    }

    /**
     * @functional 拜访人
     */
    public function CompleteVisiterJson()
    {
        $text = Utility::GetForm('q', $_GET);
        $appoint_id = Utility::GetForm('appoint_id', $_GET);
        $id = $this->getUserId();
        if ($id <= 0)
            exit("");
        $objVisitNoteBLL = new VisitNoteBLL();

        $strJson = $objVisitNoteBLL->AutoVisitorJson($text, $appoint_id);
        exit($strJson);
    }

    /**
     * @functional 拜访小记数据提交
     */
    public function NoteModifySubmit()
    {
        $this->PageRightValidate("VisitNote", RightValue::add);
        $id = Utility::GetFormInt("id", $_POST); //拜访小记id
        $appoint_id = Utility::GetFormInt("appoint_id", $_POST);
        $agentId = Utility::GetFormInt("agentId", $_POST);
        $mobile = Utility::GetForm("mobile", $_POST);
        $tel = Utility::GetForm("tel", $_POST);
        $visitor = Utility::GetForm("visitor", $_POST);
        $note_timeb = Utility::GetForm("note_timeb", $_POST);
        $note_timee = Utility::GetForm("note_timee", $_POST);
        $inten_level = Utility::GetForm("inten_level", $_POST);
        $result = Utility::GetForm("result", $_POST);
        $support = Utility::GetForm("support", $_POST);
        $product_name = Utility::GetForm("product_name", $_POST);

        $visitor    = urldecode($visitor);
        $note_timeb = urldecode($note_timeb);
        $note_timee = urldecode($note_timee);
        $inten_level = urldecode($inten_level);
        $result     = urldecode($result);
        $support    = urldecode($support);
        $product_name = urldecode($product_name);

        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = new VisitNoteInfo();

        $uid = $this->getUserId();
        $objVisitNoteInfo->iAgentId = $agentId;
        $objVisitNoteInfo->iVisitnoteid = $appoint_id;
        $objVisitNoteInfo->strMobile = $mobile;
        $objVisitNoteInfo->strTel = $tel;
        $objVisitNoteInfo->strVisitor = $visitor;
        $objVisitNoteInfo->strAfterlevel = $inten_level;
        $objVisitNoteInfo->strProductName = $product_name;
        $objVisitNoteInfo->strResult = $result;
        $objVisitNoteInfo->strSupport = $support;
        
        if(Utility::is_time($note_timeb) == 0 || Utility::is_time($note_timee) == 0)
            exit("请输入小记拜访时间段");
        else if(substr($note_timeb,0,10) != substr($note_timee,0,10))
            exit("拜访时间必须在同一天"); 
        
        $expect_money=Utility::GetFormDouble('expectMoney', $_POST);
        $expect_time=Utility::isNullOrEmpty('expectTime', $_POST);
        $percentage=Utility::GetFormInt('expectPercent', $_POST);
        $type=Utility::GetFormInt('type', $_POST);
        //如果意向等级选择为A或者B+ ，则判断预计到账金额和时间是否输入
        if($inten_level=="A"||$inten_level=="B+")
        {
            
            if($expect_money==0)
            {
                exit("请输入预计到账金额");
            }
            
            if(!$expect_time)
            {
                exit("请输入预计到账时间");
            }
            
        }    
        $objVisitNoteInfo->strVisitTimestart = $note_timeb;
        $objVisitNoteInfo->strVisitTimeend = $note_timee;
        $time = substr($note_timeb,0,10);
        $objVisitAppointBLL = new VisitAppointBLL();
        if($objVisitAppointBLL->IsExistAccompanyVisit($uid,$agentId,$time,$appoint_id)>0)
            exit("您已经添加了一条该代理商 $time 日的拜访小记或陪访小记");
        
        if ($id <= 0)//添加
        {
            $objVisitNoteInfo->iCreateUid = $uid;
            if ($iNoteRtn = $objVisitNoteBLL->insert($objVisitNoteInfo) > 0)
            {
                $objVisitNoteBLL->updateNoteState($appoint_id);
                if($expect_money!="")
                {
                    $this->addExpectInfo($agentId, $expect_time, $expect_money, $percentage, $type,$inten_level,$iNoteRtn);
                }                
                exit("0");
            }
            else
                exit("添加出错！");
        }
        else
        {
            $objVisitNoteInfo->iId = $id;
            $objVisitNoteInfo->iUpdateId = $this->getUserId();

            if ($objVisitNoteBLL->updateByID($objVisitNoteInfo))
            {
                if($expect_money!="")
                {
                    $this->addExpectInfo($agentId, $expect_time, $expect_money, $percentage, $type,$inten_level,$id);
                }   
                 exit("0");
            }              
            else
            {
                exit("修改出错！");
            }              
        }
    }
   
    /**
     * @functional 审核页面
     */
    public function CheckPage()
    {
        $this->PageRightValidate("VisitManagementCheck", RightValue::check);

        $visitnoteid = Utility::GetFormInt("visitnoteid", $_GET);
        $check = Utility::GetFormInt("check", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();

        $uid = $this->getUserId();
        $is_check = 1;

        $strTitle = "拜访预约审核";
        $this->smarty->assign('strTitle', $strTitle);
        $arrayData = $objVisitNoteBLL->GetNoteInfo($visitnoteid);
        $this->smarty->assign('check', $check);
        $this->smarty->assign('arrayData', $arrayData);
        $this->smarty->assign('is_check', $is_check);
        $this->smarty->display('Agent/WorkManagement/CheckPage.tpl');
    }

    /**
     * @functional 审核提交
     */
    public function checksubmit()
    {
        $this->PageRightValidate("VisitManagementCheck", RightValue::check);
        $visitnoteid = Utility::GetFormInt("visitnoteid", $_POST);
        $state = Utility::GetForm("auditState", $_POST);
        $check_remark = Utility::GetForm("check_remark", $_POST);

        $objVisitNoteBLL = new VisitNoteBLL();

        $uid = $this->getUserId();
        $icount = $objVisitNoteBLL->updateCheckState($visitnoteid, $state, $uid, $check_remark);
        if ($icount > 0)
            exit("1");
        if ($icount <= 0)
            exit("2");
        else
            exit("3");
    }

    /**
     * @functional 拜访小记详细信息
     */
    public function NoteDetial()
    {
        $this->PageRightValidate("VisitNote", RightValue::view);
        $visitnoteid = Utility::GetFormInt("appoint_id", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $uid = $this->getUserId();
        $strTitle = "拜访小记信息";
        $this->smarty->assign('strTitle', $strTitle);
        $arrayData = $objVisitNoteBLL->GetNoteInfo($visitnoteid);
        $this->smarty->assign('arrayData', $arrayData);

        $this->smarty->display('Agent/WorkManagement/NoteDetial.tpl');
    }

    /**
     * @functional 拜访小记列表EXCEL导出
     */
    public function ExcelExportVisitNoteList()
    {
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitAppointBLL = new VisitAppointBLL();
        $uid = $this->getUserId();
        $strWhere = $this->StrExcelWhere();
        $arrayData = $objVisitNoteBLL->getExcelData($strWhere);
        $iRecordCount = count($arrayData);

        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);

        $objExcel = new PHPExcel();

        $outputFileName = "拜访小记列表";
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
        $objActSheet->getColumnDimension('L')->setWidth(20);
        $objActSheet->getColumnDimension('M')->setWidth(20);
        $objActSheet->getColumnDimension('N')->setWidth(20);
        $objActSheet->getColumnDimension('O')->setWidth(20);
        $objActSheet->getColumnDimension('P')->setWidth(20);
        $objActSheet->getColumnDimension('Q')->setWidth(20);



        $objActSheet->setCellValue('A1', '编号');
        $objActSheet->setCellValue('B1', "制定人");
        $objActSheet->setCellValue('C1', "代理商名称");
        $objActSheet->setCellValue('D1', '预约时的意向评级/签约产品');
        $objActSheet->setCellValue('E1', '拜访后的意向评级/签约产品');
        $objActSheet->setCellValue('F1', '被访人');
        $objActSheet->setCellValue('G1', '联系电话');
        $objActSheet->setCellValue('H1', '预约拜访时间');
        $objActSheet->setCellValue('I1', '拜访主题');
        $objActSheet->setCellValue('J1', '实际拜访时间');
        $objActSheet->setCellValue('K1', '拜访结果');
        $objActSheet->setCellValue('L1', '拜访小记添加时间');
        $objActSheet->setCellValue('M1', '需求支持');
        $objActSheet->setCellValue('N1', '审查结果');
        $objActSheet->setCellValue('O1', '审查人');
        $objActSheet->setCellValue('P1', '审查时间');
        $objActSheet->setCellValue('Q1', '审查备注');
        $objActSheet->setCellValue('R1', '回访内容');
        $objActSheet->setCellValue('S1', '回访时间');
        $objActSheet->setCellValue('T1', '回访人');
        //设置填充颜色  
        $objStyle = $objActSheet->getStyle('A1:P1')->getFill();
        $objStyle->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objStyle->getStartColor()->setARGB('FF999999');

        //设置对齐方式
        $objStyle = $objActSheet->getStyle('C1:C' . ($iRecordCount + 2))->getAlignment();
        $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objStyle = $objActSheet->getStyle('D1:D' . ($iRecordCount + 2))->getAlignment();
        $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        for ($i = 0; $i < $iRecordCount; $i++)
        {
            $rowIndex = $i + 2;
            $objActSheet->setCellValue("A" . $rowIndex, $arrayData[$i]["visitnoteid"]);
            $objActSheet->setCellValue("B" . $rowIndex, $arrayData[$i]["euser_name"]);
            $objActSheet->setCellValue("C" . $rowIndex, $arrayData[$i]["agent_name"]);
            $objActSheet->setCellValue("D" . $rowIndex, (empty ($arrayData[$i]["product_name"]) ? $arrayData[$i]["inten_level"] : $arrayData[$i]["product_name"]));
            $objActSheet->setCellValue("E" . $rowIndex, (empty ($arrayData[$i]["after_productname"]) ? $arrayData[$i]["afterlevel"] : $arrayData[$i]["after_productname"]));
            $objActSheet->setCellValue("F" . $rowIndex, $arrayData[$i]["visitor"]);
            $objActSheet->setCellValue("G" . $rowIndex, $arrayData[$i]["mobile"] . "/" . $arrayData[$i]["tel"]);
            $objActSheet->setCellValue("H" . $rowIndex, $arrayData[$i]["sappoint_time"] . "/" . $arrayData[$i]["eappoint_time"]);
            $objActSheet->setCellValue("I" . $rowIndex, $arrayData[$i]["title"]);
            $objActSheet->setCellValue("J" . $rowIndex, $arrayData[$i]["visit_timestart"] . "/" . $arrayData[$i]["visit_timeend"]);
            $objActSheet->setCellValue("K" . $rowIndex, $arrayData[$i]["result"]);
            $objActSheet->setCellValue("L" . $rowIndex, $arrayData[$i]["create_time"]);
            $objActSheet->setCellValue("M" . $rowIndex, $arrayData[$i]["support"]);
            $objActSheet->setCellValue("N" . $rowIndex, (array_search($arrayData[$i]['check_status'], VisitNoteBLL::$_arrCheckState)));
            $objActSheet->setCellValue("O" . $rowIndex, $arrayData[$i]["checkr_name"]);
            $objActSheet->setCellValue("P" . $rowIndex, $arrayData[$i]["check_time"]);
            $objActSheet->setCellValue("Q" . $rowIndex, $arrayData[$i]["check_remark"]);
            $objActSheet->setCellValue("R" . $rowIndex, $arrayData[$i]["content"]);
            $objActSheet->setCellValue("S" . $rowIndex, $arrayData[$i]["return_time"]);
            $objActSheet->setCellValue("T" . $rowIndex, $arrayData[$i]["returnr_name"]);
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
     * @functional 显示审查信息
     */
    public function showCheckInfo()
    {
        //$this->PageRightValidate("VisitNote",RightValue::view);
        $visitnoteid = Utility::GetFormInt("id", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $uid = $this->getUserId();
        $arrayData = $objVisitNoteBLL->GetNoteInfo($visitnoteid);
        $this->smarty->assign('arrayData', $arrayData);

        $this->smarty->display('Agent/WorkManagement/showCheckInfo.tpl');
    }

    /**
     * @functional 拜访小记审查列表
     */
    public function CheckList()
    {
        $this->PageRightValidate("VisitManagementCheck", RightValue::check);
        $id = $this->getUserId();
        $countname = Utility::GetForm('countname', $_GET);
        $counttimeb = Utility::GetForm('counttimeb', $_GET);
        $counttimee = Utility::GetForm('counttimee', $_GET);
        if ($countname != "")
        {
            $this->smarty->assign('countname', $countname);
            $this->smarty->assign('counttimeb', $counttimeb);
            $this->smarty->assign('counttimee', $counttimee);
        }
        $this->smarty->assign('id', $id);
        $this->smarty->assign('strTitle', '拜访陪访小记审查列表');
        $this->smarty->assign('CheckListBody', "/?d=WorkM&c=VisitNote&a=CheckListBody");
        $this->displayPage('Agent/WorkManagement/CheckList.tpl');
    }

    /**
     * @functional 拜访小记审查列表Body
     */
    public function CheckListBody()
    {
        $this->PageRightValidate("VisitManagementCheck", RightValue::check);
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitAppointBLL = new VisitAppointBLL();
        //$uid = $this->getUserId();
        //------------------------------搜索-b--------------------------------//
        $strWhere = $this->StrWhere();
        
        //------------------------------搜索-e--------------------------------//
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $arrPageList = $this->getPageList($objVisitNoteBLL, "", $strWhere, "", $iPageSize);

        $this->smarty->assign('uid', $this->getUserId());
        $this->smarty->assign('arrayNote', $arrPageList['list']);
        $this->displayPage('Agent/WorkManagement/CheckListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    //展现回访记录添加页面
    public function ShowAddReturnVisit()
    {
        $visitNoteID = Utility::GetForm("id", $_GET);
        $strAct = Utility::GetForm("act", $_GET);
        if($strAct == "edit"){
            $objVisitReturnBLL = new VisitReturnBLL();
            $arrReturnInfo = $objVisitReturnBLL->getLastReturn($visitNoteID);
        }else{
            $arrReturnInfo = array();
            $arrReturnInfo["return_time"] = Utility::Now();
        }
        $this->smarty->assign('id', $visitNoteID);
        $this->smarty->assign("ReturnInfo",$arrReturnInfo);
        $this->displayPage('Agent/WorkManagement/ShowAddReturnVisit.tpl');
    }

    //保存回访记录
    public function AddReturnVisit()
    {
        $returnVisitTime = urldecode(Utility::GetForm("visitTime", $_POST));
        $returnVisitContent = urldecode(Utility::GetForm("visitContent", $_POST));
        $visitNoteID = Utility::GetFormInt("id", $_POST);
        $objVisitReturnInfo = new VisitReturnInfo();
        $objVisitReturnInfo->iVisitnoteid = $visitNoteID;
        $objVisitReturnInfo->strReturnTime = $returnVisitTime;
        $objVisitReturnInfo->strContent = $returnVisitContent;
        $objVisitReturnInfo->strAddTime = "now()";
        $objVisitReturnInfo->iAddUserId = $this->getUserId();

        $objVisitReturnBLL = new VisitReturnBLL();
        $rst = $objVisitReturnBLL->insert($objVisitReturnInfo);
        if ($rst > 0)
        {
            $objVisitNoteBLL = new VisitNoteBLL();       
            $arrayAgent = $objVisitNoteBLL->select("agent_id","visitnoteid=".$visitNoteID);
            if(isset($arrayAgent) && count($arrayAgent) > 0)
            {     
                $objAgentSourceBLL = new AgentSourceBLL();
                $objAgentSourceBLL->UpdateLastRevisitTime($arrayAgent[0]["agent_id"],$returnVisitTime);
            }
            
            $objVisitNoteBLL = new VisitNoteBLL();
            $iRn = $objVisitNoteBLL->setReturnFalg($visitNoteID);
            echo json_encode(array("success" => true, 'msg' => '添加成功'));
        }
        else
        {
            echo json_encode(array("success" => false, 'msg' => '添加出错'));
        }
    }
    
    public function NoReturnVisit()
    {
        $visitNoteID = Utility::GetFormInt("id", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $iRn = $objVisitNoteBLL->setReturnFalg($visitNoteID,2);
        exit("0");
    }

    public function ReturnVisitList()
    {
        $visitnoteid = Utility::GetForm("visitnoteid", $_GET);

        $this->smarty->assign('visitnoteid', $visitnoteid);
        $this->smarty->assign('strUrl', "/?d=WorkM&c=VisitNote&a=ReturnVisitListBody");
        $this->displayPage('Agent/WorkManagement/ReturnVisitList.tpl');
    }

    public function ReturnVisitListBody()
    {
        $visitnoteid = Utility::GetForm("id", $_REQUEST);

        $objVisitReturnBLL = new VisitReturnBLL();
        $strWhere = " and am_visit_return.visitnoteid=$visitnoteid";
        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $arrPageList = $this->getPageList($objVisitReturnBLL, "", $strWhere, "", $iPageSize);
        
        $this->smarty->assign('arrPageList', $arrPageList['list']);
        $this->displayPage('Agent/WorkManagement/ReturnVisitListBody.tpl');
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }
    
    public function StrExcelWhere(){
        $strCreateName = Utility::GetForm("create_name", $_GET);
        $strBeginCreateTime = Utility::GetForm("create_timeb", $_GET);
        $strEndCreateTime = Utility::GetForm("create_timee", $_GET);
        $iReturnState = Utility::GetFormInt("returnstate", $_GET);
        $iHasAcc = isset ($_GET['haveAccVisit'])?1:0;
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        $iAuditState = Utility::GetFormInt("auditState", $_GET);
        $iVisitNoteID = Utility::GetFormInt("visitnoteid", $_GET);
        $strVisitor = Utility::GetForm("contact_name", $_GET);
        
        $strWhere = '';
        if(!empty ($strCreateName)){
            $strWhere .= " and euser.e_name like '%{$strCreateName}%' ";
        }
        if(!empty ($strBeginCreateTime)&& Utility::is_time($strBeginCreateTime)){
            $strWhere .= " and a.create_time >= '{$strBeginCreateTime}' ";
        }
        if(!empty ($strEndCreateTime)&& Utility::is_time($strEndCreateTime)){
            $strWhere .= " and a.create_time <= '{$strEndCreateTime}' ";
        }
        if($iReturnState>=0){
            $strWhere .= " and n.has_return = {$iReturnState} ";
        }
        if(!empty ($strAgentName)){
            $strWhere .= " and s.agent_name like '%{$strAgentName}%' ";
        }
        if($iAuditState>=0){
            $strWhere .= " and n.check_status = {$iAuditState} ";
        }
        if(!empty ($iVisitNoteID)){
            $strWhere .= " and n.visitnoteid = {$iVisitNoteID} ";
        }
        if(!empty ($strVisitor)){
            $strWhere .= " and n.visitor like '%{$strVisitor}%' ";
        }
        
        $tbxSVistDate = Utility::GetForm('tbxSVistDate', $_GET);
        $tbxEVistDate = Utility::GetForm('tbxEVistDate', $_GET);
        if ($tbxSVistDate != "" && Utility::isShortTime($tbxSVistDate))
            $strWhere .= " and n.`visit_timestart` >= '{$tbxSVistDate}' ";
        if ($tbxEVistDate != "" && Utility::isShortTime($tbxEVistDate))
            $strWhere .= " and n.`visit_timestart` < ".Utility::SQLEndDate($tbxEVistDate);


        if($iHasAcc){
            $strWhere .= " and EXISTS (select id from am_visit_accompany ac 
                            where ac.agent_id=`n`.agent_id 
		                      and ac.invaited_name=`n`.`create_uid` and left(ac.s_time,10)=left(`n`.visit_timestart,10) LIMIT 0,1 )";
        }
        return $strWhere;
    }
    
    /**
     * @functional where条件
    */
    public function StrWhere()
    {
        $countname = Utility::GetForm('countname', $_GET);
        
        $counttimeb = Utility::GetForm('counttimeb', $_GET);
        $counttimee = Utility::GetForm('counttimee', $_GET);
        $visitnoteid = Utility::GetFormInt('visitnoteid', $_GET);
        $create_name = Utility::GetForm('create_name', $_GET); //制定人
        //$icre_people = Utility::GetForm('cre_people',$_GET);
        $agent_name = Utility::GetForm('agent_name', $_GET);
        $auditState = Utility::GetForm('auditState', $_GET);

        $create_timeb = Utility::GetForm('create_timeb', $_GET);
        $create_timee = Utility::GetForm('create_timee', $_GET);
        $contact_name = Utility::GetForm('contact_name', $_GET);
        $user_name    = Utility::GetForm('user_name', $_GET);
        $haveAccVisit = Utility::GetForm('haveAccVisit', $_GET);
        $iReturnState = Utility::GetFormInt("returnstate", $_GET);
        
        if ($countname != "")
        {
            $strWhere = " and `sys_user`.`e_name` like '%$countname%' and `am_visit_note`.check_status=1 ";
            if ($counttimeb == "" && $counttimee == "")
                $strWhere .= " and DATE_FORMAT(`am_visit_note`.`create_time`,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ";
            else
            {
                if ($create_timeb == "" || $create_timee == "")
                {
                    if ($counttimeb != "" && Utility::is_time($counttimeb))
                        $strWhere .= " and `am_visit_note`.`create_time` >= '" . $counttimeb . "'";
                    if ($counttimee != "" && Utility::is_time($counttimee))
                        $strWhere .= " and `am_visit_note`.`create_time` <= '" . $counttimee . "'";
                }
            }
        }
        else
            $strWhere = " and am_visit_note.agent_id>0 ";
        if ($user_name != "")
            $strWhere .= " and `sys_user`.`e_name` like '%$user_name%'";
        if ($visitnoteid > 0)
            $strWhere .= " and am_visit_note.visitnoteid = $visitnoteid ";
        if ($auditState === "0")
            $strWhere .= " and `am_visit_note`.check_status=0 ";
        else if ($auditState == "1")
            $strWhere .= " and `am_visit_note`.check_status=1 ";
        else if ($auditState == "2")
            $strWhere .= " and am_visit_note.check_status=2 ";
    
        if ($agent_name != "")
            $strWhere .= " and `am_agent_source`.`agent_name` like '%$agent_name%'";
        
        if ($create_timeb != "" && Utility::is_time($create_timeb))
            $strWhere .= " and `am_visit_note`.`create_time` >= '$create_timeb' ";
        if ($create_timee != "" && Utility::is_time($create_timee))
            $strWhere .= " and `am_visit_note`.`create_time` <= '$create_timee' ";
    
        $tbxSVistDate = Utility::GetForm('tbxSVistDate', $_GET);
        $tbxEVistDate = Utility::GetForm('tbxEVistDate', $_GET);
        if ($tbxSVistDate != "" && Utility::isShortTime($tbxSVistDate))
            $strWhere .= " and `am_visit_note`.`visit_timestart` >= '{$tbxSVistDate}' ";
        if ($tbxEVistDate != "" && Utility::isShortTime($tbxEVistDate))
            $strWhere .= " and `am_visit_note`.`visit_timestart` < ".Utility::SQLEndDate($tbxEVistDate);
            
        if ($contact_name != "")
            $strWhere .= " and `am_visit_appoint`.`visitor` like '%$contact_name%' ";

        if ($create_name != "")
            $strWhere .= " and `sys_user`.`e_name` like '%$create_name%'";
        if($haveAccVisit == 'on')
            $strWhere .= " and EXISTS (select id from am_visit_accompany ac 
                            where ac.agent_id=`am_visit_note`.agent_id 
		                      and ac.invaited_name=`am_visit_note`.`create_uid` and left(ac.s_time,10)=left(`am_visit_note`.visit_timestart,10) LIMIT 0,1 )";
//        if($haveReturnVisit == 'on')
//            $strWhere .= " and v_return.r_id > 0 ";
        
        if($iReturnState >= 0){
            $strWhere .= " and am_visit_note.has_return = {$iReturnState} ";
        }
        
        return $strWhere;
    }
    public function showInstructionInfo()
    {
        $noteId = Utility::GetFormInt('noteId', $_GET);
        
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrInfo = $objVisitVertifyBLL->getVertifyByNoteID($noteId);
        
        $this->displayPage('Agent/WorkManagement/ShowInstructionInfo.tpl', $arrInfo);
    }
    public function showVerifyInfo()
    {
        $noteId = Utility::GetFormInt('noteId', $_GET);
        $type =  Utility::GetFormInt('type', $_GET);
        $objVisitVertifyBLL = new VisitVertifyBLL();
        $arrInfo = $objVisitVertifyBLL->getVertifyByNoteID($noteId);        
        if($type==1)
        {            
            $this->smarty->assign('content','录音编号');
        }
        else{          
            $this->smarty->assign('content','质检地址');
        }
        $this->displayPage('Agent/WorkManagement/ShowVerifyInfo.tpl', $arrInfo);
    }
}