<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：陪访小记
 * 创建人：xdd
 * 添加时间：2011-10-12 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/VisitAccompanyBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitAppointBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitAccReturnBLL.php';
require_once __DIR__ . '/../../Class/BLL/VisitAccCheckBLL.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';
require_once __DIR__ . '/../Common/PHPExcel.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel2007.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel5.php';
require_once __DIR__ . '/../Common/ExportExcel.php';


class AccompanyVisitAction extends ActionBase
{
    
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->AccompanyVisitList();
    }
    /**
     * @functional 陪访小记列表
    */
    public function AccompanyVisitList()
    {
        $listName = "AccompanyVisitList";
        if(!$this->HaveRight("{$listName}",RightValue::v64,true))
        {
            if(!$this->HaveRight("{$listName}",RightValue::v16,true))
            {
                $this->PageRightValidate("{$listName}",RightValue::view);
            }
        }
        
        $arrayCheck = AccompanyVisitCheckStatus::Data();
        $this->smarty->assign('arrayCheck',$arrayCheck);
        $this->smarty->assign("{$listName}Body","/?d=WorkM&c=AccompanyVisit&a={$listName}Body");
        $this->displayPage("Agent/WorkManagement/{$listName}.tpl");
    }
    
    /**
     * @functional 陪访小记列表Body
    */
    public function AccompanyVisitListBody()
    {
        $listName = "AccompanyVisitList";
        if(!$this->HaveRight("{$listName}",RightValue::v64))
        {
            if(!$this->HaveRight("{$listName}",RightValue::v16))
            {
                $this->ExitWhenNoRight("{$listName}",RightValue::view);
            }
        }
        
        $this->f_AccompanyVisitListQuery("{$listName}");
    }
    
    /**
     * @functional 陪访小记列表
    */
    public function AccompanyVisitVerifyList()
    {
        $listName = "AccompanyVisitVerifyList";
        $this->PageRightValidate("{$listName}",RightValue::view);
        
        $this->smarty->assign("{$listName}Body","/?d=WorkM&c=AccompanyVisit&a={$listName}Body");
        $this->displayPage("Agent/WorkManagement/{$listName}.tpl");
    }
    
    
    /**
     * @functional 陪访小记质检列表Body
    */
    public function AccompanyVisitVerifyListBody()
    {
        $listName = "AccompanyVisitVerifyList";
        $this->ExitWhenNoRight("{$listName}",RightValue::view);
           
        $this->f_AccompanyVisitListQuery("{$listName}");
    }
    
    /**
     * @functional 陪访小记记录列表
    */
    public function AccompanyVisitVerifyRecordList()
    {
        $listName = "AccompanyVisitVerifyRecordList";
        $this->PageRightValidate("{$listName}",RightValue::view);
        
        $this->smarty->assign("{$listName}Body","/?d=WorkM&c=AccompanyVisit&a={$listName}Body");
        $this->displayPage("Agent/WorkManagement/{$listName}.tpl");
    }
    
    
    /**
     * @functional 陪访小记质检记录列表Body
    */
    public function AccompanyVisitVerifyRecordListBody()
    {
        $listName = "AccompanyVisitVerifyRecordList";
        $this->ExitWhenNoRight("{$listName}",RightValue::view);
           
        $this->f_AccompanyVisitListQuery("{$listName}");
    }
    
    protected function f_AccompanyVisitListQuery($dataType = "")
    {
        $strWhere = "";
        $bHaveUidIn = false;
        if("AccompanyVisitVerifyList" == $dataType)
        {
            $strWhere .= " and am_visit_accompany.check_statu = ".AccompanyVisitCheckStatus::auditting;
        }
        else if("AccompanyVisitVerifyRecordList" == $dataType)
        {
            $strWhere .= " and am_visit_accompany.check_statu <> ".AccompanyVisitCheckStatus::auditting ;
        }
        else if("AccompanyVisitList" == $dataType)
        {
            if(!$this->HaveRight($dataType,RightValue::v64))
            {
                if(!$this->HaveRight($dataType,RightValue::v16))
                {
                    $strWhere .= " and am_visit_accompany.create_uid = ".$this->getUserId();
                }
                else
                {
                    $objVisitAppointBLL = new VisitAppointBLL();
                    $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                    if($strUid != "")
                    {
                        $strUid .= ",".$this->getUserId();                        
                        $strWhere .= " and am_visit_accompany.create_uid in({$strUid}) ";
                    }
                    else
                        $strWhere .= " and am_visit_accompany.create_uid = ".$this->getUserId();
                        
                    $bHaveUidIn = true;                
                }
            }
        }
        
        $cbAuditState = Utility::GetFormInt("cbAuditState",$_GET,-100);
        if($cbAuditState != -100)
        {
            $strWhere .= " and am_visit_accompany.check_statu = ".$cbAuditState;
        }
        
        $cbCreateUserType = Utility::GetFormInt("cbCreateUserType",$_GET);  
        $tbxCreateName = Utility::GetForm("tbxCreateName",$_GET);
        if($cbCreateUserType > 0)
        {
            if($cbCreateUserType == 1)//自己
            {
                $strWhere .= " and am_visit_accompany.create_uid = ".$this->getUserId();
            }
            else //下级
            {   
                if($bHaveUidIn == false)
                {
                    $objVisitAppointBLL = new VisitAppointBLL();
                    $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                    if($strUid != "")
                        $strWhere .= " and am_visit_accompany.create_uid in({$strUid}) ";
                }
                else
                {
                    $strWhere .= " and am_visit_accompany.create_uid <> ".$this->getUserId();
                }
                
                if($tbxCreateName != "")
                    $strWhere .= " and am_visit_accompany.create_user_name like '%{$tbxCreateName}%' ";
            }
        }
        else
        {
            if($tbxCreateName != "")
                $strWhere .= " and am_visit_accompany.create_user_name like '%{$tbxCreateName}%' ";
        }
        
        $tbxVisitTimeS = Utility::GetForm("tbxVisitTimeS",$_GET);
        if($tbxVisitTimeS != "" && Utility::isShortTime($tbxVisitTimeS))
            $strWhere .= " and am_visit_accompany.s_time >= '{$tbxVisitTimeS}' ";
                
        $tbxVisitTimeE = Utility::GetForm("tbxVisitTimeE",$_GET);
        if($tbxVisitTimeE != "" && Utility::isShortTime($tbxVisitTimeE))
            $strWhere .= " and am_visit_accompany.s_time <".Utility::SQLEndDate($tbxVisitTimeE);
        
        $tbxCreateTimeS = Utility::GetForm("tbxCreateTimeS",$_GET);
        if($tbxCreateTimeS != "" && Utility::isShortTime($tbxCreateTimeS))
            $strWhere .= " and am_visit_accompany.create_time >= '{$tbxCreateTimeS}' ";
            
        $tbxCreateTimeE = Utility::GetForm("tbxCreateTimeE",$_GET);
        if($tbxCreateTimeE != "" && Utility::isShortTime($tbxCreateTimeE))
            $strWhere .= " and am_visit_accompany.create_time <".Utility::SQLEndDate($tbxCreateTimeE);
                       
        $tbxCheckTimeS = Utility::GetForm("tbxCheckTimeS",$_GET);
        if($tbxCheckTimeS != "" && Utility::isShortTime($tbxCheckTimeS))
            $strWhere .= " and am_visit_accompany.check_time >= '{$tbxCheckTimeS}' ";
            
        $tbxCheckTimeE = Utility::GetForm("tbxCheckTimeE",$_GET);
        if($tbxCheckTimeE != "" && Utility::isShortTime($tbxCheckTimeE))
            $strWhere .= " and am_visit_accompany.check_time <".Utility::SQLEndDate($tbxCheckTimeE);
                
        $tbxAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($tbxAgentName != "")
            $strWhere .= " and (am_visit_accompany.agent_no like '%{$tbxAgentName}%' or am_visit_accompany.agent_name like '%{$tbxAgentName}%')";
            
        $tbxInviter = Utility::GetForm("tbxInviter",$_GET);
        if($tbxInviter != "")
            $strWhere .= " and am_visit_accompany.invaited_user_name like '%{$tbxInviter}%' ";
            
        $tbxVisitor = Utility::GetForm("tbxVisitor",$_GET);
        if($tbxVisitor != "")
            $strWhere .= " and am_visit_accompany.visitor like '%{$tbxVisitor}%' ";

        $bExportExcel = Utility::GetFormInt('iExportExcel',$_GET)==1?true:false;
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $arrPageList = $this->getPageList($objVisitAccompanyBLL,"*",$strWhere,"",$iPageSize,$bExportExcel);
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayAccompanyVisit',$arrPageList['list']);
            $this->displayPage("Agent/WorkManagement/{$dataType}Body.tpl");
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
        else
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("编号", "id",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("制定人", "create_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("制定时间", "create_time"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("邀请人", "invaited_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("陪访开始时间", "s_time"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("陪访结束时间", "e_time"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商编号", "agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被访人", "visitor"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("被访人电话", "tel"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("陪访内容", "content"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("质检状态", "check_statu_text"));
            
            $fileName = "陪访小记";
            if("AccompanyVisitList" == $dataType || "AccompanyVisitVerifyRecordList" == $dataType)
            {
                $objExcelBottomColumns->Add(new ExcelBottomColumn("质检位置", "check_address"));
                $objExcelBottomColumns->Add(new ExcelBottomColumn("质检情况", "check_detial"));
                $objExcelBottomColumns->Add(new ExcelBottomColumn("质检人", "check_user_name"));
                $objExcelBottomColumns->Add(new ExcelBottomColumn("质检时间", "check_time"));   
                if("AccompanyVisitVerifyRecordList" == $dataType)
                    $fileName .= "质检记录";             
            }
            else
            {
                $fileName .= "质检";
            }
            
            $objDataToExcel->Init($fileName, $arrPageList["list"], null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        } 
    }
    
    /**
     * @functional 显示添加陪访小记添加第一步：关联代理商
    */
    public function AddAccompanyVisitStep1()
    {
        $this->PageRightValidate("AccompanyVisitList",RightValue::add);
        $this->smarty->display('Agent/WorkManagement/AddAccompanyVisitStep1.tpl'); 
    }
    
    /**
     * @functional 代理商是否存在
    */
    public function IsExistAgent()
    {
        $tbxAgentName = Utility::GetForm('tbxAgentName',$_GET);
        $tbxAgentName = urldecode($tbxAgentName);
        
        if($tbxAgentName == "")
            exit("1");
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $arrayData = $objVisitAccompanyBLL->AgentArray($tbxAgentName);
        if(count($arrayData) <= 0)
            exit("2");
        else
            exit("0");
    }
    
    /**
     * @functional 代理商
    */
    public function CompleteAgentJson()
    {
        $text = Utility::GetForm('q',$_GET);
        $id = $this->getUserId();
        if($id <= 0)
            exit("");
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        
        $arrayData = $objVisitAccompanyBLL->AutoAgentArray($text);
        $strJson = json_encode(array('value'=>$arrayData));
        exit($strJson);
    }
    
    /**
     * @functional 显示添加陪访小记添加第二步
    */
    public function AddAccompanyVisitStep2()
    {
        $this->PageRightValidate("AccompanyVisitList",RightValue::add);
        $id  = Utility::GetFormInt('id',$_GET);
        $agentId = Utility::GetFormInt('agentId',$_GET);
        if($agentId <= 0)
        {
            exit("参数有误！");
        }
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = null;
        if($id > 0)
        {
            $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($id);
            if($objVisitAccompanyInfo == null)
                exit("未找到对应陪访记录");                
        }
        else
        {
            $objVisitAccompanyInfo = new VisitAccompanyInfo();
            $objAgentSourceBLL = new AgentSourceBLL();
            $objAgentInfo = $objAgentSourceBLL->getModelByID($agentId);
            if($objAgentInfo == null)
                exit("未找到该代理商！");
            
            $objVisitAccompanyInfo->strSTime = '';
            $objVisitAccompanyInfo->strETime = '';
            $objVisitAccompanyInfo->iAgentId = $objAgentInfo->iAgentId;
            $objVisitAccompanyInfo->strAgentNo = $objAgentInfo->strAgentNo;
            $objVisitAccompanyInfo->strAgentName = $objAgentInfo->strAgentName;
            $objVisitAccompanyInfo->iInvaitedUid = $objAgentInfo->iChannelUid;
            $objVisitAccompanyInfo->strInvaitedUserName = $objAgentInfo->strAgentChannelUserName;
        }
                                
        $this->smarty->assign('objVisitAccompanyInfo',$objVisitAccompanyInfo);
        $this->smarty->display('Agent/WorkManagement/AddAccompanyVisitStep2.tpl'); 
    }
    
    public function AccompanyVisitVerifyModify()
    {
        $this->PageRightValidate("AccompanyVisitList",RightValue::check);
        $id  = Utility::GetFormInt('id',$_GET);
        if($id <= 0)
        {
            exit("参数有误！");
        }
        
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($id);
        if($objVisitAccompanyInfo == null)
            exit("未找到对应陪访记录");
            
        $strTitle = "陪访小记质检";
        $this->smarty->assign('strTitle',$strTitle);
        $this->smarty->assign('objVisitAccompanyInfo',$objVisitAccompanyInfo);
        $this->smarty->display('Agent/WorkManagement/AccompanyVisitVerifyModify.tpl');  
    }
    
    public function AccompanyVisitVerifyModifySubmit()
    {        
        $this->ExitWhenNoRight("AccompanyVisitList",RightValue::check);
        $id  = Utility::GetFormInt('tbxID',$_POST);
        if($id <= 0)
        {
            exit("参数有误！");
        }
        
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($id);
        if($objVisitAccompanyInfo == null)
            exit("未找到对应陪访记录");
                
        $cbVertifyStatus = Utility::GetFormInt("cbVertifyStatus",$_POST);
        if($cbVertifyStatus != AccompanyVisitCheckStatus::isPass && $cbVertifyStatus != AccompanyVisitCheckStatus::notPass)
            exit("请选择质检结果");
        
        $objVisitAccompanyInfo->iCheckStatu = $cbVertifyStatus;
        $objVisitAccompanyInfo->strCheckAddress = Utility::GetForm("tbxAddress",$_POST);
        $objVisitAccompanyInfo->strCheckDetial = Utility::GetRemarkForm("tbxCheckDetail",$_POST);
        $objVisitAccompanyInfo->iCheckUid = $this->getUserId(); 
        $objVisitAccompanyInfo->strCheckUserName = $this->getUserName()." ".$this->getUserCNName();
        $objVisitAccompanyInfo->strCheckTime = Utility::Now();
        $objVisitAccompanyBLL->updateByID($objVisitAccompanyInfo);
        exit("0");
    }
    
    /**
     * @functional 匹配邀请人
    */
    public function CompleteInviter()
    {
        $text = Utility::GetForm('q',$_GET);
        $objUserBLL = new UserBLL();
        $strJson = $objUserBLL->AutoUserJson($text,$this->getUserId());
        exit($strJson);
    }
    
    /**
     * @functional 陪访小记数据提交
    */
    public function AccompanyVisitSubmit()
    {
        $agentId = Utility::GetFormInt("tbxAgentID",$_POST);
        if($agentId <= 0)
            exit("参数有误！");
            
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentInfo = $objAgentSourceBLL->getModelByID($agentId);
        if($objAgentInfo == null)
            exit("未找到该代理商！");
       
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = null;
        $id = Utility::GetFormInt("tbxID",$_POST);
        if($id > 0)
        {
            $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($id);
            if($objVisitAccompanyInfo == null)
                exit("未找到陪访记录");
        }
        else
        {
            $objVisitAccompanyInfo = new VisitAccompanyInfo();            
        }
        
        $objVisitAccompanyInfo->iAgentId = $objAgentInfo->iAgentId;
        $objVisitAccompanyInfo->strAgentNo = $objAgentInfo->strAgentNo;
        $objVisitAccompanyInfo->strAgentName = $objAgentInfo->strAgentName;
        
        $objVisitAccompanyInfo->iInvaitedUid = Utility::GetFormInt("tbxInvaitedUserID",$_POST);
        if($objVisitAccompanyInfo->iInvaitedUid <= 0)
            exit("请输入邀请人");
        
        $objUserBLL = new UserBLL();
        $objVisitAccompanyInfo->strInvaitedUserName = $objUserBLL->getUserNameAndENameById($objVisitAccompanyInfo->iInvaitedUid);
        if($objVisitAccompanyInfo->strInvaitedUserName == "")
            exit("请输入有效邀请人");
            
        $objVisitAccompanyInfo->strVisitor = Utility::GetForm("tbxVisitor",$_POST);
        if($objVisitAccompanyInfo->strVisitor == "")
            exit("请输入被访人");
            
        $objVisitAccompanyInfo->strTel = Utility::GetForm("tbxTel",$_POST);
        if($objVisitAccompanyInfo->strTel == "")
            exit("请输入被访人联系电话");
        
        $tbxSTime = Utility::GetForm("tbxSTime",$_POST);
        if($tbxSTime == "")
            exit("请输入陪访开始时间");
        
        $tbxSTime .= ":00";
        if(!Utility::is_time($tbxSTime)) 
            exit("陪访开始时间格式不正确");
                    
        $tbxETime = Utility::GetForm('tbxETime',$_POST);
        if($tbxETime == "")
            exit("请输入陪访结束时间");
            
        $tbxETime .= ":00";
        if(!Utility::isTime($tbxETime)) 
            exit("陪访结束时间格式不正确");
        
        $arrTemp = explode(' ', $tbxSTime);
        if($arrTemp[1]> $tbxETime){
            exit("陪访开始时间必须小于结束时间");
        }
        
        $objVisitAccompanyInfo->strSTime = $tbxSTime;
        $objVisitAccompanyInfo->strETime = $arrTemp[0] ." ".$tbxETime;
        $objVisitAccompanyInfo->strContent = Utility::GetRemarkForm('tbxContent',$_POST);
        if($objVisitAccompanyInfo->strContent == "")
            exit("请输入陪访内容");            
        
        $time = substr($tbxSTime,0,10);
        $count = $objVisitAccompanyBLL->IsExistAccompanyVisit($this->getUserId(),$agentId,$time,$id);
        if($count > 0)
            exit("您已经添加了一条该代理商 $time 的拜访小记或陪访小记");
        
        if($id > 0)
        {            
            $objVisitAccompanyInfo->iUpdateUid = $this->getUserId(); 
            $objVisitAccompanyInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName();
            $updateCount = $objVisitAccompanyBLL->updateByID($objVisitAccompanyInfo);
            if($updateCount <= 0)
                exit("编辑失败！");
        }
        else
        {            
            $objVisitAccompanyInfo->iCreateUid = $this->getUserId();
            $objVisitAccompanyInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
            if($objVisitAccompanyBLL->insert($objVisitAccompanyInfo) <= 0)
                exit("添加失败！");            
        }
       
        exit("0");
    }
    /**
     * @functional 与拜访小记关联的陪访小记
    */
    public function RelateAccompany()
    {
        $visitnoteid = Utility::GetFormInt("visitnoteid",$_GET);
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $this->smarty->assign('strTitle','陪访小记列表');
        $arrayRelateAccompanyList = $objVisitAccompanyBLL->GetRelateAccompanyList($visitnoteid);
        $this->smarty->assign('arrayRelateAccompanyList',$arrayRelateAccompanyList);
        
        $this->smarty->assign('visitnoteid',$visitnoteid);
        $this->smarty->assign('uid',$this->getUserId());
        $this->smarty->display('Agent/WorkManagement/RelateAccompanyList.tpl'); 
        
    }
    
    /**
     * @functional 审核陪访小记
    */
    public function CheckAccompanyVisit()
    {
        $this->ExitWhenNoRight("AccompanyVisitList", 32);
        
        $this->smarty->display('Agent/WorkManagement/CheckAccompanyVisit.tpl'); 
    }
    /**
     * @functional 审核陪访小记提交
    */
    public function CheckAccompanyVisitSubmit()
    {
        $ac_id = Utility::GetFormInt("id",$_GET);
        
        $auditState   = Utility::GetFormInt("auditState",$_POST);
        $check_remark = Utility::GetForm("check_remark",$_POST);
        //echo 
        $objVisitAccCheckBLL   = new VisitAccCheckBLL();
        $objVisitAccCheckInfo  = new VisitAccCheckInfo();
        $objVisitAccCheckInfo->iAccoid = $ac_id;
       
        $objVisitAccCheckInfo->iCheckStatu = $auditState;
        $objVisitAccCheckInfo->strDetial   = $check_remark;
        $objVisitAccCheckInfo->iCheckUid   = $this->getUserId();
        $objVisitAccCheckInfo->strCheckTime = date('Y-m-d H:i:s',time()) ;
        
        $result = $objVisitAccCheckBLL->insert($objVisitAccCheckInfo);
        
        
        if($result > 0)
        {
            //同时修改陪访表的审核状态，便于审查人员审核修改后再次提交的陪访小记
            $objVisitAccompanyBLL  = new VisitAccompanyBLL();
            $objVisitAccompanyInfo = new VisitAccompanyInfo();
            $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($ac_id);
            $objVisitAccompanyInfo->iCheckStatu = $auditState;
            $objVisitAccompanyBLL->updateByID($objVisitAccompanyInfo);
            exit("{success:true,'msg':'审核成功！'}");
        }
            
        else
            exit("{success:false,'msg':'审核失败！'}");
    }
    
    /**
     * @functional 陪访小记质检信息
    */
    public function CheckDetial()
    {
        $this->ExitWhenNoRight("AccompanyVisitList",RightValue::view);
        $id  = Utility::GetFormInt('id',$_GET);
        if($id <= 0)
        {
            exit("参数有误！");
        }
        
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($id);
        if($objVisitAccompanyInfo == null)
            exit("未找到对应陪访记录"); 
            
        $strCheckStatu = AccompanyVisitCheckStatus::GetText($objVisitAccompanyInfo->iCheckStatu);
        $this->smarty->assign('strCheckStatu',$strCheckStatu);
        $this->smarty->assign('objVisitAccompanyInfo',$objVisitAccompanyInfo);
        $this->smarty->display('Agent/WorkManagement/AccompanyVisitVerifyDetial.tpl');  
    }
    
    /**
     * @functional 编辑陪访小记
    */
    public function ModifyAccompanyVisit()
    {
        $id = Utility::GetFormInt('id',$_GET);
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = new VisitAccompanyInfo();
        if($id > 0)
        {
            $arrayData = $objVisitAccompanyBLL->AccompanyVisitInfo($id);
            $this->smarty->assign('arrayData',$arrayData);
        }
        $this->smarty->display('Agent/WorkManagement/ModifyAccompanyVisit.tpl'); 
    }
    /**
     * @functional 显示添加回访
    */
    public function ShowAddReturnVisit()
    {
        $id = Utility::GetForm("id", $_GET);
        $this->smarty->assign('id', $id);
        $this->displayPage('Agent/WorkManagement/ShowAddReturnVisit.tpl');
    }
    /**
     * @functional 陪访的回访提交
    */
    public function ReturnVisitSubmit()
    {
        $returnVisitTime = urldecode(Utility::GetForm("visitTime", $_POST));
        $returnVisitContent = urldecode(Utility::GetForm("visitContent", $_POST));
        $id = Utility::GetForm("id", $_POST);
        $objVisitAccReturnInfo = new VisitAccReturnInfo();
        $objVisitAccReturnInfo->iAccoid = $id;
        $objVisitAccReturnInfo->strReturnTime = $returnVisitTime;
        $objVisitAccReturnInfo->strContent = $returnVisitContent;
        $objVisitAccReturnInfo->strAddTime = "now()";
        $objVisitAccReturnInfo->iAddUserId = $this->getUserId();

        $objVisitAccReturnBLL = new VisitAccReturnBLL();
        $rst = $objVisitAccReturnBLL->insert($objVisitAccReturnInfo);
        if (!$rst)
        {
            echo json_encode(array("success" => false, 'msg' => '添加出错'));
        }
        else
        {
            echo json_encode(array("success" => true, 'msg' => '添加成功'));
        }
    }
    
    public function UnNeedCheck(){
        if(!$this->HaveRight("AccompanyVisitVerifyList", RightValue::v8)){
            Utility::Msg("对不起，您没有权限");
        }
        $iId = Utility::GetFormInt("id", $_GET);
        $objVisitAccompanyBLL = new VisitAccompanyBLL();
        $objVisitAccompanyInfo = $objVisitAccompanyBLL->getModelByID($iId);
        if(!$objVisitAccompanyInfo){
            Utility::Msg("获取参数出错");
        }
        $objVisitAccompanyInfo->iCheckStatu = AccompanyVisitCheckStatus::unNeedCheck;
        $objVisitAccompanyInfo->iCheckUid = $this->getUserId();
        $objVisitAccompanyInfo->strCheckTime = Utility::Now();
        $objVisitAccompanyInfo->strCheckUserName = "{$this->getUserId()} {$this->getUserCNName()}";
        $iRtn = $objVisitAccompanyBLL->updateByID($objVisitAccompanyInfo);
        if($iRtn === false){
            Utility::Msg("表示不质检失败");
        }
        
        Utility::Msg("标记不质检成功",true);
    }
    
}
 
 
 ?>