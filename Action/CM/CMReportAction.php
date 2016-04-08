<?php

/* * http://localhost/?c=cm&d=cm&a=index
* @functional 
*/
require_once __DIR__ . '/../Common/Alert.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/CommonAction.php';
require_once __DIR__ . '/../../Class/BLL/AgentContactRecordBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentIntentionRatingBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class CMReportAction extends ActionBase
{
    private $strTitle = ''; //设置网页标题
    private $strMsg = ''; //设置网页消息
    private $strWhere = '';
    private $ContactRecordBLL = '';
    private $IntentionRatingBLL='';
    public function __construct()
    {
        $this->ContactRecordBLL = new AgentContactRecordBLL();
        $this->IntentionRatingBLL = new AgentIntentionRatingBLL();
    }

    public function Index()
    {
    }
    //后台管理begin

    //展现联系量统计列表[主页面]
    public function showContactRecordRpt()
    {
        if(!$this->HaveRight("ContactRecordRpt", RightValue::v64,true))//V64查看所有
            $this->PageRightValidate("ContactRecordRpt", RightValue::view);
            
        $rep_datee = date("Y-m-d",time());
        $rep_dateb = substr($rep_datee,0,8);
        if($rep_dateb != "")
            $rep_dateb .= "01";
        $this->smarty->assign('rep_datee',$rep_datee);
        $this->smarty->assign('rep_dateb',$rep_dateb);
        $this->smarty->assign('strTitle', '联系量统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showContactRecordRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/ContactRecordRpt.tpl");
    }
    //展现联系量统计列表主体
    public function showContactRecordRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("ContactRecordRpt", RightValue::v64))//V64查看所有
        {
            if($this->HaveRight("ContactRecordRpt", RightValue::view))//查看
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit("您没有此访问权限");
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
                
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date_begin != "" && Utility::isShortTime($rep_date_begin)) {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "" && Utility::isShortTime($rep_date_end)) {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        $objContactRecordBLL = new AgentContactRecordBLL();
        $arrayData = $this->getPageList($objContactRecordBLL,"*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));
        if($iExportExcel == 0)
        {
            self::showPageSmarty($arrayData, 'CM/ContactRecordRptBody.tpl');
        }else{
            $arrayRpt=$arrayData["list"];
            $arrayLength = count($arrayRpt);
            for ($i = 0; $i < $arrayLength; $i++)
            {
                $arrayRpt[$i]["valid_rate"] = (number_format($arrayRpt[$i]["valid_rate"],4)*100)."%";
                
            }
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商ID", "agent_no",
                            ExcelDataTypes::String, 25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",
                            ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("所属战区经理", "channel_user_name",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效联系量", "valid_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("无效联系量", "invalid_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("总联系量", "record_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("平均有效联系占比", "valid_rate"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访量", "visit_count"));
            $objDataToExcel->Init("联系量统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
            
        }
    }
    //获取总计信息
    public function getTotalNum()
    {
        $valid_num=0;
        $invalid_num=0;
        $total_num=0;
        $avg_rate=0;
        $visit_num=0;
        
        $sWhere = "";
        if(!$this->HaveRight("ContactRecordRpt", RightValue::v64))//V64查看所有
        {
            if($this->HaveRight("ContactRecordRpt", RightValue::view))//查看
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit($valid_num."|".$invalid_num."|".$total_num."|".$avg_rate."|".$visit_num);
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
        
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        
        $arrList = $this->ContactRecordBLL->getTotalNum($sWhere);
        $valid_num=$arrList["valid_count"];
        $invalid_num = $arrList["invalid_count"];
        $total_num = $arrList["record_count"];
        $avg_rate = (number_format($arrList["valid_rate"],4)*100)."%";
        $visit_num = $arrList["visit_count"];
        exit($valid_num."|".$invalid_num."|".$total_num."|".$avg_rate."|".$visit_num);
        
    }
        
    
    //展现网盟意向等级统计列表[主页面]
    public function showIntentionRpt()
    {
        if(!$this->HaveRight("IntentionRpt", RightValue::v64,true))  
            $this->PageRightValidate("IntentionRpt", RightValue::view);
            
        $rep_date = date("Y-m-d",time());
        $this->smarty->assign('rep_date',$rep_date);
        $this->smarty->assign('strTitle', '网盟意向等级统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showIntentionRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/IntentionRpt.tpl");
    }
    //展现网盟意向等级统计列表主体
    public function showIntentionRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("IntentionRpt", RightValue::v64))
        {
            if($this->HaveRight("IntentionRpt", RightValue::view))
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit("您没有此访问权限");
        }
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
                
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` = '{$rep_date}'";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);    
        $objIntentionRatingBLL = new AgentIntentionRatingBLL();
        $arrayData = $this->getPageList($objIntentionRatingBLL,"*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));

        if($iExportExcel == 0)
        {
            self::showPageSmarty($arrayData, 'CM/IntentionRptBody.tpl');
        }else{
            $arrayRpt=$arrayData["list"];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商ID", "agent_no",
                            ExcelDataTypes::String, 25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",
                            ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("所属战区经理", "channel_user_name",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A+", "rating_1",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A-", "rating_2",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+", "rating_3",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-", "rating_4",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("C", "rating_5",
                            ExcelDataTypes::String, 15)); 
            $objExcelBottomColumns->Add(new ExcelBottomColumn("D", "rating_6",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("E", "rating_7",
                            ExcelDataTypes::String, 15));                                                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账金额", "income_money",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账单量", "order_count",
                            ExcelDataTypes::String, 15));                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款金额", "charge_money"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款次数", "charge_count"));
            $objDataToExcel->Init("网盟意向等级统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    //获取网盟意向统计总计信息
    public function getIntentionTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        $rpt_item5=0;
        $rpt_item6=0;
        $rpt_item7=0;
        
            $sWhere = "";
        if(!$this->HaveRight("IntentionRpt", RightValue::v64))
        {
            if($this->HaveRight("IntentionRpt", RightValue::view))
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6."|".$rpt_item7);
        }
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
        
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` = '{$rep_date}'";
        }
        
        
        $arrList = $this->IntentionRatingBLL->getIntentionTotalNum($sWhere);
        $rpt_item1=$arrList["rating_1"];
        $rpt_item2=$arrList["rating_2"];
        $rpt_item3=$arrList["rating_3"];
        $rpt_item4=$arrList["rating_4"];
        $rpt_item5=$arrList["rating_5"];
        $rpt_item6=$arrList["rating_6"];
        $rpt_item7=$arrList["rating_7"];
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6."|".$rpt_item7);
        
    }
   
    
    
    //展现预计到账统计列表[主页面]
    public function showEstimateRpt()
    {
        if(!$this->HaveRight("EstimateRpt", RightValue::v64,true))
            $this->PageRightValidate("EstimateRpt", RightValue::view);
                
        $this->smarty->assign('strTitle', '网盟预计到账统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showEstimateRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/EstimateRpt.tpl");
    }
    //展现预计到账统计列表主体
    public function showEstimateRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("EstimateRpt", RightValue::v64))
        {
            if($this->HaveRight("EstimateRpt", RightValue::view))
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit("您没有此访问权限");
        }
            
        $rep_date = Utility::GetForm("rep_date", $_GET);
        
        $tmp_year=date("Y");     
        $tmp_mon =date("m");   
        $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
        $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
        if($rep_date==2){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+2,1,$tmp_year)); 
        }elseif($rep_date==3){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+3,1,$tmp_year)); 
        }
        
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
        
        
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}' and acr.`report_date` < '{$rep_date_end}'";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);        
        $objIntentionRatingBLL = new AgentIntentionRatingBLL();
        $arrayData = $this->getPageList2($objIntentionRatingBLL,"selectPaged2","*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));
        
        if($iExportExcel == 0)
        {
            $this->smarty->assign('arrayData',$arrayData['list']);
            $this->smarty->display('CM/EstimateRptBody.tpl');
            echo("<script>pageList.totalPage=".$arrayData['totalPage'].";pageList.recordCount=".$arrayData['recordCount'].";</script>"); 
            //$arrPageList = $this->IntentionRatingBLL->getEstimateData($sWhere);
            //self::showPageSmarty($arrPageList, 'CM/EstimateRptBody.tpl');
        }else{
            $arrayRpt=$arrayData['list'];
            $arrayLength = count($arrayRpt);
            for ($i = 0; $i < $arrayLength; $i++)
            {
                $arrayRpt[$i]["income_money"] = Utility::FormatMoney($arrayRpt[$i]["income_money"]);
                $arrayRpt[$i]["charge_money"] = Utility::FormatMoney($arrayRpt[$i]["charge_money"]);
            }
            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商ID", "agent_no",
                            ExcelDataTypes::String, 25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",
                            ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("所属战区经理", "channel_user_name",
                            ExcelDataTypes::String, 15));                                                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账总额", "income_money",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账总量", "order_count",
                            ExcelDataTypes::String, 15));                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("实际转款总额", "charge_money"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("实际转款次数", "charge_count"));
            $objDataToExcel->Init("网盟预计到账统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    //获取预计到账统计总计信息
    public function getEstimateTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        
        $sWhere = "";
        if(!$this->HaveRight("EstimateRpt", RightValue::v64))
        {
            if($this->HaveRight("EstimateRpt", RightValue::view))
                $sWhere = " and acr.channel_uid = ".$this->getUserId();
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4);
        }
            
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $tmp_year=date("Y");     
        $tmp_mon =date("m");   
        $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
        $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
        if($rep_date==2){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+2,1,$tmp_year)); 
        }elseif($rep_date==3){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+3,1,$tmp_year)); 
        }
        
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
        
            
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}' and acr.`report_date` < '{$rep_date_end}'";
        }
        
        
        $arrList = $this->IntentionRatingBLL->getEstimateTotalNum($sWhere);
        $rpt_item1=Utility::FormatMoney($arrList["income_money"]);
        $rpt_item2=$arrList["order_count"];
        $rpt_item3=Utility::FormatMoney($arrList["charge_money"]);
        $rpt_item4=$arrList["charge_count"];
        
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4);
        
    }
    
    
    
    //展现转化率统计列表[主页面]
    public function showConversionRpt()
    {
        if(!$this->HaveRight("ConversionRpt", RightValue::v64,true))
            $this->PageRightValidate("ConversionRpt", RightValue::view);
            
        $rep_datee = date("Y-m-d",time());
        $rep_dateb = substr($rep_datee,0,8);
        if($rep_dateb != "")
            $rep_dateb .= "01";
        $this->smarty->assign('rep_datee',$rep_datee);
        $this->smarty->assign('rep_dateb',$rep_dateb);
        $this->smarty->assign('strTitle', '意向转化率统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showConversionRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/ConversionRpt.tpl");
    }
    //展现意向转化率统计列表主体
    public function showConversionRptBody()
    {
        $sWhere = "";
                
        if(!$this->HaveRight("ConversionRpt", RightValue::v64))
        {
            if($this->HaveRight("ConversionRpt", RightValue::view))
                $sWhere = " and acr.channel_uid = ".$this->getUserId();    
            else
                exit("您没有此访问权限");
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
        
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);    
        $objIntentionRatingBLL = new AgentIntentionRatingBLL();
        $arrayData = $this->getPageList2($objIntentionRatingBLL,"selectPaged3","*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));
        
        if($iExportExcel == 0)
        {
            //$arrPageList = $this->IntentionRatingBLL->getConversionData();
            self::showPageSmarty($arrayData, 'CM/ConversionRptBody.tpl');
        }else{
            $arrayRpt=$arrayData['list'];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商ID", "agent_no",
                            ExcelDataTypes::String, 25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",
                            ExcelDataTypes::String, 35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("所属战区经理", "channel_user_name",
                            ExcelDataTypes::String, 15));                                                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转B-", "de2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转B+", "de2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转A", "de2a",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转B+", "bm2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转A", "bp2a",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转A", "bm2a",
                            ExcelDataTypes::String, 15));   
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转B+", "a2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转B-", "a2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转DE", "a2de",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转B-", "bp2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转DE", "bp2de",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转DE", "bm2de",
                            ExcelDataTypes::String, 15));                                 
            $objDataToExcel->Init("意向转化率统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    //获取预计到账统计总计信息
    public function getConversionTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        $rpt_item5=0;
        $rpt_item6=0;
        
        $sWhere = "";
        if(!$this->HaveRight("ConversionRpt", RightValue::v64))
        {
            if($this->HaveRight("ConversionRpt", RightValue::view))
                $sWhere .= " and acr.channel_uid = ".$this->getUserId(); 
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6);
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $agent_name = Utility::GetForm("agent_name", $_GET);
        $channel_user_name = Utility::GetForm("channel_user_name", $_GET);
                
        
        if ($agent_name != "") {
            $sWhere .= " and (acr.agent_name like '%{$agent_name}%' or acr.agent_no like '%{$agent_name}%')";
        }
        if ($channel_user_name != "") {
            $sWhere .= " and (acr.channel_user_name like '%{$channel_user_name}%' or acr.channel_uid like '%{$channel_user_name}%')";
        }
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        
        $arrList = $this->IntentionRatingBLL->getConversionTotalNum($sWhere);
        $rpt_item1=number_format($arrList["de2bm"], 2, '.', '');
        $rpt_item2=number_format($arrList["de2bp"], 2, '.', '');
        $rpt_item3=number_format($arrList["de2a"], 2, '.', '');
        $rpt_item4=number_format($arrList["bm2bp"], 2, '.', '');
        $rpt_item5=number_format($arrList["bp2a"], 2, '.', '');
        $rpt_item6=number_format($arrList["bm2a"], 2, '.', '');
        
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6);
        
    }
    
    //后台管理end
    
    //前台管理begin
    //展现联系量统计列表[主页面]
    public function showContactRecordFroRpt()
    {
        if(!$this->HaveRight("ContactRecordFroRpt", RightValue::v64,true) && !$this->HaveRight("ContactRecordFroRpt",RightValue::view,true) 
            && !$this->HaveRight("ContactRecordRpt",RightValue::view,true))
        {
            $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        
        $rep_datee = date("Y-m-d",time());
        $rep_dateb = substr($rep_datee,0,8);
        if($rep_dateb != "")
            $rep_dateb .= "01";
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        if($bdate != "")
            $rep_dateb = $bdate;
        if($edate != "")
            $rep_datee = $edate;
        
        $this->smarty->assign('agent_id',$agent_id);
        $this->smarty->assign('rep_datee',$rep_datee);
        $this->smarty->assign('rep_dateb',$rep_dateb);
        $this->smarty->assign('strTitle', '联系量统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showContactRecordFroRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/ContactRecordFroRpt.tpl");
    }
    //展现联系量统计列表主体
    public function showContactRecordFroRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("ContactRecordFroRpt", RightValue::v64) && !$this->HaveRight("ContactRecordRpt", RightValue::view))
        {
            if($this->HaveRight("ContactRecordFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit("您没有此访问权限");
        }
                
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
                        
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%'";
        }
      
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        $objContactRecordBLL = new AgentContactRecordBLL();
        $arrayData = $this->getPageList2($objContactRecordBLL,"selectPaged2","*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));
        if($iExportExcel == 0)
        {
            if ($this->HaveRight("ContactRecordRpt", RightValue::view)) {
                $IsBack = 1;
            } else {
                $IsBack = 0;
            }
            
            $this->smarty->assign('IsBack', $IsBack);
            self::showPageSmarty($arrayData, 'CM/ContactRecordFroRptBody.tpl');
        }else{
            $arrayRpt=$arrayData['list'];
            $arrayLength = count($arrayRpt);
            for ($i = 0; $i < $arrayLength; $i++)
            {
                $arrayRpt[$i]["valid_rate"] = (number_format($arrayRpt[$i]["valid_rate"],4)*100)."%";
                
            }
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("客户经理", "user_name",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("有效联系量", "valid_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("无效联系量", "invalid_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("总联系量", "record_count",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("平均有效联系占比", "valid_rate"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访量", "visit_count"));
            $objDataToExcel->Init("联系量统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        
        
    }
    //获取总计信息
    public function getFroTotalNum()
    {
        $valid_num=0;
        $invalid_num=0;
        $total_num=0;
        $avg_rate=0;
        $visit_num=0;
        
        $sWhere = "";
        if(!$this->HaveRight("ContactRecordFroRpt", RightValue::v64) && !$this->HaveRight("ContactRecordRpt", RightValue::view))
        {
            if($this->HaveRight("ContactRecordFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit($valid_num."|".$invalid_num."|".$total_num."|".$avg_rate."|".$visit_num);
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        
        
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%'";
        }
      
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        $arrList = $this->ContactRecordBLL->getFroTotalNum($sWhere);
        $valid_num=$arrList["valid_count"];
        $invalid_num = $arrList["invalid_count"];
        $total_num = $arrList["record_count"];
        $avg_rate = (number_format($arrList["valid_rate"],4)*100)."%";
        $visit_num = $arrList["visit_count"];
        exit($valid_num."|".$invalid_num."|".$total_num."|".$avg_rate."|".$visit_num);
        
    }
            
    
    //展现网盟意向等级统计列表[主页面]
    public function showIntentionFroRpt()
    {        
        if(!$this->HaveRight("IntentionFroRpt", RightValue::v64,true) && !$this->HaveRight("IntentionFroRpt",RightValue::view,true) 
            && !$this->HaveRight("IntentionRpt",RightValue::view,true))
        {
            $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        
        $rep_date = date("Y-m-d",time());
        $bdate = Utility::GetForm("bdate", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        if($bdate != "")
            $rep_date = $bdate;
        $this->smarty->assign('agent_id',$agent_id);
        
        $this->smarty->assign('rep_date',$rep_date);
        $this->smarty->assign('strTitle', '网盟意向等级统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showIntentionFroRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/IntentionFroRpt.tpl");
    }
    //展现网盟意向等级统计列表主体
    public function showIntentionFroRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("IntentionFroRpt", RightValue::v64) && !$this->HaveRight("IntentionRpt", RightValue::view))
        {
            if($this->HaveRight("IntentionFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit("您没有此访问权限");
        }
                
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%' ";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` = '{$rep_date}'";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);   
        $objIntentionRatingBLL = new AgentIntentionRatingBLL();
        $arrayData = $this->getPageList2($objIntentionRatingBLL,"selectPaged4","*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));

        if($iExportExcel == 0)
        {
            if($this->HaveRight("IntentionRpt", RightValue::view)){
                $IsBack = 1;
            }else{
                $IsBack = 0;
            }
            $this->smarty->assign("IsBack",$IsBack);
            self::showPageSmarty($arrayData, 'CM/IntentionFroRptBody.tpl');
        }else{
            $arrayRpt=$arrayData['list'];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("客户经理", "user_name",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A+", "rating_1",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A-", "rating_2",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+", "rating_3",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-", "rating_4",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("C", "rating_5",
                            ExcelDataTypes::String, 15)); 
            $objExcelBottomColumns->Add(new ExcelBottomColumn("D", "rating_6",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("E", "rating_7",
                            ExcelDataTypes::String, 15));                                                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账金额", "income_money",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账单量", "order_count",
                            ExcelDataTypes::String, 15));                
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款金额", "charge_money"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款次数", "charge_count"));
            $objDataToExcel->Init("网盟意向等级统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        
    }
    
    //获取网盟意向统计总计信息
    public function getIntentionFroTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        $rpt_item5=0;
        $rpt_item6=0;
        $rpt_item7=0;
        
        $sWhere = "";
        if(!$this->HaveRight("IntentionFroRpt", RightValue::v64) && !$this->HaveRight("IntentionRpt", RightValue::view))
        {
            if($this->HaveRight("IntentionFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6."|".$rpt_item7);
        }
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        
        
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%' ";
        }
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` = '{$rep_date}'";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        $arrList = $this->IntentionRatingBLL->getIntentionFroTotalNum($sWhere);
        $rpt_item1=$arrList["rating_1"];
        $rpt_item2=$arrList["rating_2"];
        $rpt_item3=$arrList["rating_3"];
        $rpt_item4=$arrList["rating_4"];
        $rpt_item5=$arrList["rating_5"];
        $rpt_item6=$arrList["rating_6"];
        $rpt_item7=$arrList["rating_7"];
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6."|".$rpt_item7);
        
    }
   
    //展现预计到账统计列表[主页面]
    public function showEstimateFroRpt()
    {
        if(!$this->HaveRight("EstimateFroRpt", RightValue::v64,true) && !$this->HaveRight("EstimateFroRpt",RightValue::view,true) 
        && !$this->HaveRight("EstimateRpt",RightValue::view,true))
        {
            $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        
        $bdate = Utility::GetForm("bdate", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        $this->smarty->assign("bDate",$bdate);   
        $this->smarty->assign('agent_id',$agent_id);
        $this->smarty->assign('strTitle', '网盟预计到账统计');
        
        $this->smarty->display("CM/EstimateFroRpt.tpl");
    }
    //展现预计到账统计列表主体
    public function showEstimateFroRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("EstimateFroRpt", RightValue::v64) && !$this->HaveRight("EstimateRpt", RightValue::view))
        {
            if($this->HaveRight("EstimateFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit("您没有此访问权限");
        }
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
         
        $tmp_year=date("Y");     
        $tmp_mon =date("m");   
        $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
        $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year));
        if($rep_date==2){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+2,1,$tmp_year)); 
        }elseif($rep_date==3){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+3,1,$tmp_year)); 
        } 
                
        
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}' and acr.`report_date` < '{$rep_date_end}'";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        
        $arrPageList = $this->IntentionRatingBLL->getEstimateFroData($sWhere);
        
        if($this->HaveRight("EstimateRpt", RightValue::view)){
            $IsBack = 1;
        }else{
            $IsBack = 0;
        }
        $this->smarty->assign("IsBack",$IsBack);
        $this->smarty->assign('arrayData',$arrPageList);
        $this->smarty->display('CM/EstimateFroRptBody.tpl'); 
    }
    
    //获取预计到账统计总计信息
    public function getEstimateFroTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        
        $sWhere = "";
        if(!$this->HaveRight("EstimateFroRpt", RightValue::v64) && !$this->HaveRight("EstimateRpt", RightValue::view))
        {
            if($this->HaveRight("EstimateFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4);
        }
       
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
         
        $tmp_year=date("Y");     
        $tmp_mon =date("m");   
        $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
        $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year));
        if($rep_date==2){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+2,1,$tmp_year)); 
        }elseif($rep_date==3){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+3,1,$tmp_year)); 
        } 
        
        
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}' and acr.`report_date` < '{$rep_date_end}'";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        $arrList = $this->IntentionRatingBLL->getEstimateFroTotalNum($sWhere);
        $rpt_item1=Utility::FormatMoney($arrList["income_money"]);
        $rpt_item2=$arrList["order_count"];
        $rpt_item3=Utility::FormatMoney($arrList["charge_money"]);
        $rpt_item4=$arrList["charge_count"];
        
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4);
        
    }
    //导出预计到账统计数据
    public function excelExportEstimateFroRpt()
    {
        $sWhere = "";
        if(!$this->HaveRight("EstimateFroRpt", RightValue::v64) && !$this->HaveRight("EstimateRpt", RightValue::view))
        {
            if($this->HaveRight("EstimateFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit("您没有此访问权限");
        }
        
        $rep_date = Utility::GetForm("rep_date", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
         
        $tmp_year=date("Y");     
        $tmp_mon =date("m");   
        $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
        $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year));
        if($rep_date==2){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon+1,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+2,1,$tmp_year)); 
        }elseif($rep_date==3){
            $rep_date_begin = date('Y-m-d',mktime(0,0,0,$tmp_mon,1,$tmp_year)); 
            $rep_date_end = date('Y-m-d',mktime(0,0,0,$tmp_mon+3,1,$tmp_year)); 
        } 
        
        if ($rep_date != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}' and acr.`report_date` < '{$rep_date_end}'";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        $arrayData = $this->IntentionRatingBLL->exportEstimateFroRptData($sWhere);
        $arrayLength = count($arrayData);
        for ($i = 0; $i < $arrayLength; $i++)
        {
            $arrayData[$i]["income_money"] = Utility::FormatMoney($arrayData[$i]["income_money"]);
            $arrayData[$i]["charge_money"] = Utility::FormatMoney($arrayData[$i]["charge_money"]);
        }
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("日期", "report_date",
                        ExcelDataTypes::String, 25));
                        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账总额", "income_money",
                        ExcelDataTypes::String, 15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预计到账总量", "order_count",
                        ExcelDataTypes::String, 15));                
        $objExcelBottomColumns->Add(new ExcelBottomColumn("实际转款总额", "charge_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("实际转款次数", "charge_count"));
        $objDataToExcel->Init("网盟预计到账统计", $arrayData, null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    //展现转化率统计列表[主页面]
    public function showConversionFroRpt()
    {
        if(!$this->HaveRight("ConversionFroRpt", RightValue::v64,true) && 
            !$this->HaveRight("ConversionFroRpt",RightValue::view) && !$this->HaveRight("ConversionRpt",RightValue::view))
        {
            $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        $rep_datee = date("Y-m-d",time());
        $rep_dateb = substr($rep_datee,0,8);
        if($rep_dateb != "")
            $rep_dateb .= "01";
            
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        if($bdate != "")
            $rep_dateb = $bdate;
        if($edate != "")
            $rep_datee = $edate;
        
        $this->smarty->assign('agent_id',$agent_id);    
            
        $this->smarty->assign('rep_datee',$rep_datee);
        $this->smarty->assign('rep_dateb',$rep_dateb);
        $this->smarty->assign('strTitle', '意向转化率统计');
        $strUrl = $this->getActionUrl('CM', 'CMReport', 'showConversionFroRptBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/ConversionFroRpt.tpl");
    }
    //展现意向转化率统计列表主体
    public function showConversionFroRptBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("ConversionFroRpt", RightValue::v64) && !$this->HaveRight("ConversionRpt", RightValue::view))
        {
            if($this->HaveRight("ConversionFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit("您没有此访问权限");
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        
        
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%'";
        }
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);    
        $objIntentionRatingBLL = new AgentIntentionRatingBLL();
        $arrayData = $this->getPageList2($objIntentionRatingBLL,"selectPaged5","*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));

        if($iExportExcel == 0)
        {
            self::showPageSmarty($arrayData, 'CM/ConversionFroRptBody.tpl');
        }else{
            $arrayRpt=$arrayData['list'];
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("客户经理", "user_name",
                            ExcelDataTypes::String, 15));
                                  
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转B-", "de2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转B+", "de2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("DE转A", "de2a",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转B+", "bm2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转A", "bp2a",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转A", "bm2a",
                            ExcelDataTypes::String, 15));   
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转B+", "a2bp",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转B-", "a2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("A转DE", "a2de",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转B-", "bp2bm",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B+转DE", "bp2de",
                            ExcelDataTypes::String, 15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("B-转DE", "bm2de",
                            ExcelDataTypes::String, 15));                                 
            $objDataToExcel->Init("意向转化率统计", $arrayRpt, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    //获取预计到账统计总计信息
    public function getConversionFroTotalNum()
    {
        $rpt_item1=0;
        $rpt_item2=0;
        $rpt_item3=0;
        $rpt_item4=0;
        $rpt_item5=0;
        $rpt_item6=0;
        
        $sWhere = "";
        if(!$this->HaveRight("ConversionFroRpt", RightValue::v64) && !$this->HaveRight("ConversionRpt", RightValue::view))
        {
            if($this->HaveRight("ConversionFroRpt", RightValue::view))
                $sWhere = " and EXISTS(select  '1' from sys_user t1 where t1.user_no like CONCAT('".$this->getUserNo()."','%') and t1.user_id=acr.user_id )  ";
            else
                exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6);
        }
        
        $rep_date_begin = Utility::GetForm("rep_date_begin", $_GET);
        $rep_date_end = Utility::GetForm("rep_date_end", $_GET);
        $user_name = Utility::GetForm("user_name", $_GET);
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
                
        if ($user_name != "") {
            $sWhere .= " and acr.user_name like '%{$user_name}%'";
        }
        if ($rep_date_begin != "") {
            $sWhere .= " and acr.`report_date` >= '{$rep_date_begin}'";
        }
        if ($rep_date_end != "") {
            $sWhere .= " and acr.`report_date` < date_add('{$rep_date_end}',interval 1 day)";
        }
        if ($agent_id > 0 && !$this->isAgentUser()) {
            $sWhere .= " and acr.agent_id = {$agent_id} ";
        }else{
            $sWhere .= " and acr.agent_id=".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        }
        
        $arrList = $this->IntentionRatingBLL->getConversionFroTotalNum($sWhere);
        $rpt_item1=$arrList["de2bm"];
        $rpt_item2=$arrList["de2bp"];
        $rpt_item3=$arrList["de2a"];
        $rpt_item4=$arrList["bm2bp"];
        $rpt_item5=$arrList["bp2a"];
        $rpt_item6=$arrList["bm2a"];
        
        exit($rpt_item1."|".$rpt_item2."|".$rpt_item3."|".$rpt_item4."|".$rpt_item5."|".$rpt_item6);
        
    }
        
}
