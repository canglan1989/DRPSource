<?php 
/**
 * @functional 代理商档案
 * @date       2013-01-06
 * @author     wzx
 * @copyright  盘石
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/UploadFile.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/UploadDocBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentPermitBLL.php';

class AgentDocAction extends ActionBase
{
    public function __construct()
    {
    }
    
    public function Index()
    {
        
    }
    
    
    /**
     * @functional 附件信息
     * @author wzx
     */
    public function Detail()
    { 
        $this->PageRightValidate("AgentDocList", RightValue::view,false);
        $this->smarty->assign('strTitle',"附件信息"); 
        $agentID = Utility::GetFormInt('id',$_GET);
        $agentNo = "";
        $agentName = "";
        if($agentID <= 0)
            exit("参数错误！");
            
        $objAgentBLL = new AgentBLL();
        $agentInfo = $objAgentBLL->getModelByID($agentID);
        if($agentInfo == null)
            exit("代理商不存在！");
              
        $objUploadDocBLL = new UploadDocBLL();
        $sWhere = "object_type=".UploadDocObjctType::Agent." and object_id=".$agentID;
        $arrayCourseware = $objUploadDocBLL->selectTop("*",$sWhere." and file_type=".AgentDocType::Courseware,"create_time desc","",5);
       
        $sWhere = "object_type=".UploadDocObjctType::Agent." and object_id=".$agentID;
        $arrayTool = $objUploadDocBLL->selectTop("*",$sWhere." and file_type=".AgentDocType::Tool,"create_time desc","",5);
       
        $sWhere = "object_type=".UploadDocObjctType::Agent." and object_id=".$agentID;
        $arrayOther = $objUploadDocBLL->selectTop("*",$sWhere." and file_type=".AgentDocType::Other,"create_time desc","",5);
        
        $objAgentPermitBLL = new AgentPermitBLL();
        $arrayQualification = $objAgentPermitBLL->GetAgentPermit($agentID);                
        $this->smarty->assign('arrayCourseware',$arrayCourseware);
        $this->smarty->assign('arrayTool',$arrayTool);
        $this->smarty->assign('arrayOther',$arrayOther);
        $this->smarty->assign('agentInfo',$agentInfo);  
        $this->smarty->assign('arrayQualification',$arrayQualification);  
        $this->smarty->display('Agent/Doc/Detail.tpl');
    }
    
    /**
     * @functional 
     * @author wzx
     */
    public function Upload()
    {        
        $this->PageRightValidate("AgentDocList", RightValue::add,false);
        $this->smarty->assign('strTitle',"附件上传"); 
        $agentID = Utility::GetFormInt('id',$_GET);
        $agentName = "";
        if($agentID > 0)
        {
            $objAgentBLL = new AgentBLL();
            $agentName = $objAgentBLL->GetAgentNameByID($agentID);
        }
        
        $this->smarty->assign('agentID',$agentID); 
        $this->smarty->assign('agentName',$agentName); 
        $arrayAgentDocType = AgentDocType::GetData();
        
        $this->smarty->assign('arrayAgentDocType',$arrayAgentDocType); 
        $this->smarty->display('Agent/Doc/Upload.tpl');
    }
    
    public function IsExistFile()
    {
        $agentID = Utility::GetFormInt('tbxAgentID',$_POST);
        if($agentID <= 0)
            exit("请选择代理商！");
            
        $docType = Utility::GetFormInt('cbDocType',$_POST);
        if($docType <= 0)
            exit("请选择附件类型！");
        
        $cbPermitType = 0;
        if($docType == AgentDocType::Qualification)
        {
            $cbPermitType = Utility::GetFormInt('cbPermitType',$_POST);
            if($cbPermitType <= 0)
                exit("请选择资质类型！");
        }
        
        $strFileName = Utility::GetForm("filename", $_POST);
        if($strFileName == "")
            exit("请上传文件");
        
        if($cbPermitType <= 0)
        {
            $objUploadDocBLL = new UploadDocBLL();
            if($objUploadDocBLL->ExistFile(UploadDocObjctType::Agent,$docType,$agentID,$strFileName)>0)
                exit("1");
        }
        else
        {
            $objAgentPermitBLL = new AgentPermitBLL();
            if($objAgentPermitBLL->selectExistsPermit($agentID,$cbPermitType) > 0)
                exit("1");
        }
            
        exit("0");
    }    
    
    public function UploadFile()
    {
        $this->ExitWhenNoRight("AgentDocList", RightValue::add);
        
        $agentID = Utility::GetFormInt("tbxAgentID", $_GET);
        if($agentID <= 0)
            Utility::Msg("请选择代理商");
        $strInputFileID = "fileUpload";        
        $upfile = $_FILES[$strInputFileID];
        $name = $upfile['name'];
        $arrTemp = explode('.', $name);
        $strExt = array_pop($arrTemp);
        if(in_array(strtolower($strExt), array('rar','zip'))){
            die("文件格式受限制");
        }
        
        $iFileType = Utility::GetFormInt("cbDocType", $_GET);
        if($iFileType <= 0)
            exit("请选择文件类型");
            
        $cbPermitType = 0;
        if($iFileType == AgentDocType::Qualification)
        {
            $cbPermitType = Utility::GetFormInt('cbPermitType',$_GET);
            if($cbPermitType <= 0)
                exit("请选择资质类型！");
        }
        
        if($cbPermitType <= 0)
        {
            $strUploadPath = "FrontFile/upload/AgentFile/{$agentID}/";
            UploadFile::FileUpload($strInputFileID, UploadFileType::File , $strUploadPath,10);
        }
        else
        {
            $strUploadPath = "FrontFile/upload/{$agentID}/";
            UploadFile::FileUpload($strInputFileID, UploadFileType::Image , $strUploadPath,10);
        }
    }
    
    public function UploadSubmit()
    {
        $this->ExitWhenNoRight("AgentDocList", RightValue::add);
        
        $agentID = Utility::GetFormInt("tbxAgentID", $_POST); 
        $agentName = Utility::GetForm("tbxAgent", $_POST); 
        if($agentID <= 0 || $agentName == "")
            exit("请选择代理商");
        
        $strAuthor = Utility::GetForm("tbxAuthor", $_POST);
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
                if($objUploadDocBLL->updateByID($objUploadDocInfo) <= 0)
                    exit("修改失败！");
            }
            else
            {            
                $objUploadDocInfo->iCreateUid = $this->getUserId();
                $objUploadDocInfo->strCreateUserName = $this->getUserName()." ". $this->getUserCNName();
                $docID = $objUploadDocBLL->insert($objUploadDocInfo);
                if($docID <= 0)
                    exit("添加失败！");
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
                    exit("添加失败！");
            }
    	    else
            {
        	    $objAgentPermitInfo->iUpdateUid = $this->getUserId();
                if($objAgentPermitBLL->update($objAgentPermitInfo) <= 0)
                    exit("修改失败！");
            }                
        }
        
        exit("0");
    }
    
    
    public function Delete()
    {
        $this->ExitWhenNoRight("AgentDocList", RightValue::del);
        $filePath = Utility::GetForm("filePath", $_POST);
        if($filePath == "")
            exit("文件名参数错误！");
        
        $objUploadDocBLL = new UploadDocBLL();
        $sWhere = "object_type=".UploadDocObjctType::Agent." and file_path='{$filePath}'";
    
        $arrayData = $objUploadDocBLL->select("doc_id",$sWhere,"");
        if(!(isset($arrayData)&&count($arrayData) > 0))
            exit("未找到对应文件");
        
        $objUploadDocBLL->deleteByID($arrayData[0]["doc_id"],$this->getUserId(),$this->getUserName()." ".$this->getUserCNName());
        
        /*wzx 暂时不做删除文件的操作
        $objFileOperate = new FileOperate();
        $strUploadPath = "FrontFile/upload/AgentFile/".$filePath;
        $objFileOperate->delFile(__DIR__ . '/../../'.$strUploadPath,true);*/
    
        exit (json_encode(array(
            'msg'=>"删除成功",
            'success'=>true
        )));
    }
    
    public function DocList()
    {
        if(!$this->HaveRight("AgentDocList", RightValue::viewCompany,true))
            $this->PageRightValidate("AgentDocList", RightValue::view);
        
        $arrayAgentDocType = AgentDocType::GetData();        
        $this->smarty->assign('arrayAgentDocType',$arrayAgentDocType); 
        $agentNo = Utility::GetForm("agentNo", $_GET);
        $this->smarty->assign('agentNo', $agentNo);
        $this->smarty->assign('ListBody', "/?d=Agent&c=AgentDoc&a=DocListBody");
        $this->displayPage('Agent/Doc/List.tpl');
    }
    
    public function DocListBody()
    {
        $sWhere = " and object_type=" . UploadDocObjctType::Agent;         
        
        if(!$this->HaveRight("AgentDocList", RightValue::viewCompany))
        {
            $this->ExitWhenNoRight("AgentDocList", RightValue::view);
            $sWhere .= " and (am_agent_source.`channel_uid` = ".$this->getUserId()." or am_agent_share.`share_uid` = " . $this->getUserId().")";
        }
                        
        $cbFileType = Utility::GetFormInt("cbFileType", $_GET);
        if ($cbFileType > 0)
            $sWhere .= " and sys_upload_doc.file_type =" . $cbFileType;

                         
        $tbxCreateSTime = Utility::GetForm("tbxCreateSTime",$_GET);
        if($tbxCreateSTime != "" && Utility::isShortTime($tbxCreateSTime))
            $sWhere .= " and sys_upload_doc.create_time >= '".$tbxCreateSTime."'";             
            
        $tbxCreateETime = Utility::GetForm("tbxCreateETime",$_GET);
        if($tbxCreateETime != "" && Utility::isShortTime($tbxCreateETime))
            $sWhere .= " and sys_upload_doc.create_time < ". Utility::SQLEndDate($tbxCreateETime);    
                        
        $tbxAgentNo = Utility::GetForm("tbxAgentNo", $_GET);
        if ($tbxAgentNo != "")
        {            
            $chkExactMatch = Utility::GetFormInt("chkExactMatch", $_GET);
            if ($chkExactMatch > 0)
                $sWhere .= " and am_agent_source.agent_no = '" . $tbxAgentNo . "'";
            else        
                $sWhere .= " and am_agent_source.agent_no like '%" . $tbxAgentNo . "%'";
        }
        
        $strAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($strAgentName != "")
            $sWhere .= " and am_agent_source.agent_name like '%" . $strAgentName . "%'";

        $tbxFileName = Utility::GetForm("tbxFileName", $_GET);
        if ($tbxFileName != "")
            $sWhere .= " and sys_upload_doc.file_name like '%" . $tbxFileName . "%' ";

        $tbxAuthor = Utility::GetForm("tbxAuthor", $_GET);
        if ($tbxAuthor != "")
            $sWhere .= " and sys_upload_doc.`author` like '%" . $tbxAuthor . "%'";

        $tbxCreateUser = Utility::GetForm("tbxCreateUser", $_GET);
        if ($tbxCreateUser != "")
            $sWhere .= " and sys_upload_doc.`create_user_name` like '%" . $tbxCreateUser . "%'";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);        
        
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objUploadDocBLL = new UploadDocBLL();
        $arrPageList = $this->getPageList2($objUploadDocBLL,"selectAgentDocPaged", "*", $sWhere, "", $iPageSize,$iExportExcel);
        $arrayData = &$arrPageList["list"];
        AgentDocType::ReplaceArrayText($arrayData,"file_type","file_type_text");
        
        if($iExportExcel == false)
        {
            $this->smarty->assign('arrayData', $arrayData);
                    
            $this->smarty->display('Agent/Doc/ListBody.tpl');            
            echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        
        }
        else
        {            
            /*$objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商", "agent_name"));
            $objDataToExcel->Init("strExportName", $arrPageList["list"], null, $objExcelBottomColumns);
            $objDataToExcel->Export();*/
        }
    }
}
?>