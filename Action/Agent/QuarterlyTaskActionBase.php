<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述： 代理商季度任务
 * 创建人：wzx
 * 添加时间：2011-10-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AgentBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/QuarterlyTaskBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';

require_once __DIR__ . '/../Common/PHPExcel.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel2007.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel5.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class QuarterlyTaskActionBase extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        //$this->QuarterlyTaskList();
    }  
    
    /**
     * @functional 代理商季度任务管理
    */
    protected function QuarterlyTaskList()
    {
        $this->smarty->assign('strTitle','季度任务查询');
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();     
        $arrayYear = $objQuarterlyTaskBLL->GetYears();
        $this->smarty->assign('arrayYear',$arrayYear);
        
        $this->smarty->assign('qProductTypeID',$qProductTypeID);                
    }
    
    
    /**
     * @functional 代理商季度任务管理数据
    */
    protected function f_QuarterlyTaskListBody($dataDisplayPath)
    {
        $sWhere = $this->f_QuarterlyTaskListGetWhere();
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $sOrder = Utility::GetForm("sortField", $_GET);            
            
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();        
        $arrPageList = $this->getPageList($objQuarterlyTaskBLL,"*",$sWhere,$sOrder,$iPageSize);
        
        Utility::FormatArrayMoney($arrPageList['list'],"task_money,finish_money,sale_award_money,market_funds,distribution_funds,audit_status");        
       
        $this->smarty->assign('arrayQuarterlyTaskList',$arrPageList['list']);
        $this->smarty->display($dataDisplayPath);
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");
    }
    
    protected function f_QuarterlyTaskListGetWhere()
    {
        $sWhere = "";   

        $iProductType = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductType > 0)
            $sWhere .= " and `am_quarterly_task`.`product_type_id` = ".$iProductType;
            
        $iLevel = Utility::GetFormInt("cbLevel",$_GET);
        
        if($iLevel > 0)
            $sWhere .= " and `am_quarterly_task`.`agent_level` = '".$iLevel."'";
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `am_agent`.`agent_no` like '%".$strAgentNo."%'";  
                       
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `am_agent`.`agent_name` like '%".$strAgentName."%'";  
            
        $iTaskYear = Utility::GetFormInt('cbYear',$_GET);  
        if($iTaskYear > 0)
            $sWhere .= " and `am_quarterly_task`.`task_year` = ".$iTaskYear; 
            
        $iTaskQuarterly = Utility::GetFormInt('cbQuarterly',$_GET); 
        if($iTaskQuarterly > 0)
            $sWhere .= " and `am_quarterly_task`.`task_quarterly` = ".$iTaskQuarterly; 
            
        $iAwardStatus = Utility::GetFormInt('cbAwardStatus',$_GET); 
        if($iAwardStatus == 1)
            $sWhere .= " and `am_quarterly_task`.`award_money` > 0 "; 
        else if($iAwardStatus == 0)
            $sWhere .= " and `am_quarterly_task`.`award_money` = 0 "; 
            
        return $sWhere;
    }
    
    /**
     * @functional 代理商季度任务列表EXCEL导出
    */
    public function ExcelExportQuarterlyTaskList()
    {                    
        //$this->ExitWhenNoRight("QuarterlyTaskList",Rightvalue::view);
        $sWhere = $this->f_QuarterlyTaskListGetWhere();
                
        $sOrder = Utility::GetForm("sortField", $_GET);            
            
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();        
        $arrPageList = $this->getPageList($objQuarterlyTaskBLL,"*",$sWhere,$sOrder,DataToExcel::max_record_count);
        
        $arrayData = $arrPageList['list'];
        $iRecordCount = count($arrayData);
        
        PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);

        $objExcel = new PHPExcel();

        $outputFileName = "代理商季度任务列表";
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->setTitle($outputFileName); 
        $objActSheet->getColumnDimension('A')->setWidth(20);
        $objActSheet->getColumnDimension('B')->setWidth(30);
        $objActSheet->getColumnDimension('C')->setWidth(10);
        $objActSheet->getColumnDimension('D')->setWidth(20);
        $objActSheet->getColumnDimension('E')->setWidth(30);
        $objActSheet->getColumnDimension('F')->setWidth(15);
        $objActSheet->getColumnDimension('G')->setWidth(15);
        $objActSheet->getColumnDimension('H')->setWidth(15);
        $objActSheet->getColumnDimension('I')->setWidth(15);
        $objActSheet->getColumnDimension('J')->setWidth(15);
        $objActSheet->getColumnDimension('K')->setWidth(15);
        $objActSheet->getColumnDimension('L')->setWidth(15);
        
        $objActSheet->setCellValue('A1', '代理商代码');
        $objActSheet->setCellValue('B1', "代理商名称");
        $objActSheet->setCellValue('C1', '代理等级');
        $objActSheet->setCellValue('D1', '产品名称');        
        $objActSheet->setCellValue('E1', '季度时间');
        $objActSheet->setCellValue('F1', "任务额");
        $objActSheet->setCellValue('G1', '完成额');
        $objActSheet->setCellValue('H1', '销奖');
        $objActSheet->setCellValue('I1', '充值金额');
        $objActSheet->setCellValue('J1', "市场基金");
        $objActSheet->setCellValue('K1', '渠道基金');
        $objActSheet->setCellValue('L1', '添加人');
        
        //设置填充颜色  
        $objStyle = $objActSheet->getStyle('A1:l1')->getFill();
        $objStyle->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objStyle->getStartColor()->setARGB('FF999999');
        
        //设置对齐方式
        $objStyle = $objActSheet->getStyle('F1:K'.($iRecordCount+2))->getAlignment();  
        $objStyle->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                
        for ($i = 0; $i < $iRecordCount; $i++)
        {
            $rowIndex = $i + 2;
            $objActSheet->setCellValue("A" . $rowIndex, $arrayData[$i]["agent_no"]);
            $objActSheet->setCellValue("B" . $rowIndex, $arrayData[$i]["agent_name"]);
            $objActSheet->setCellValue("C" . $rowIndex, $arrayData[$i]["agent_level"]==1?"金牌":"银牌");
            $objActSheet->setCellValue("D" . $rowIndex, $arrayData[$i]["product_type_name"]);
            $objActSheet->setCellValue("E" . $rowIndex, $arrayData[$i]["task_quarterly_text"]);
            $objActSheet->setCellValue("F" . $rowIndex, $arrayData[$i]["task_money"]);
            $objActSheet->setCellValue("G" . $rowIndex, $arrayData[$i]["finish_money"]);
            $objActSheet->setCellValue("H" . $rowIndex, $arrayData[$i]["sale_award_money"]);            
            $objActSheet->setCellValue("I" . $rowIndex, $arrayData[$i]["award_money"]);            
            $objActSheet->setCellValue("J" . $rowIndex, $arrayData[$i]["market_funds"]);
            $objActSheet->setCellValue("K" . $rowIndex, $arrayData[$i]["distribution_funds"]);
            $objActSheet->setCellValue("L" . $rowIndex, $arrayData[$i]["create_user_name"]);
        }

        header("Content-type: text/html;charset=utf-8");
        header("Content-type: text/csv");
        header('Content-Disposition: attachment;filename="'.iconv("utf-8", "gb2312//IGNORE", $outputFileName).'.xls"');
        header('Cache-Control: must-revalidate, post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objWriter->save('php://output');
    }
        
      
    
    /**
     * @functional 显示季度任务添加\修改
    */
    protected function QuarterlyTaskModify()
    {        
        $thisYear = date("Y",time()); 
        $arrayYear = array($thisYear-1,$thisYear,$thisYear+1);
        
        $id = Utility::GetFormInt('id',$_GET);
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();
        $objQuarterlyTaskInfo = new QuarterlyTaskInfo();
        $strAgentName = "";
        
        if($id > 0)
        {
            $this->smarty->assign('strTitle','季度任务修改');
            $objQuarterlyTaskInfo = $objQuarterlyTaskBLL->getModelByID($id);  
            if($objQuarterlyTaskInfo == null)
                exit("未找到此季度任务！");
                
            $thisYear = $objQuarterlyTaskInfo->iTaskYear;
            $arrayYear = array($thisYear-1,$thisYear,$thisYear+1);
            $objAgentBLL = new AgentBLL();
            $arrayData = $objAgentBLL->select("agent_name","agent_id=".$objQuarterlyTaskInfo->iAgentId,"");
            if(isset($arrayData) && count($arrayData) > 0)
                $strAgentName = $arrayData[0]["agent_name"];
        }
        else
        {
            $this->smarty->assign('strTitle','季度任务添加');
            $objQuarterlyTaskInfo->iTaskYear = $thisYear;
        }
        
        $this->smarty->assign('strAgentName',$strAgentName); 
        $this->smarty->assign('objQuarterlyTaskInfo',$objQuarterlyTaskInfo);
        $this->smarty->assign('arrayYear',$arrayYear); 
        $this->smarty->display('Agent/QuarterlyTask/QuarterlyTaskModify.tpl');
    }
       
    
    /**
     * @functional 季度任务添加数据提交
    */
    protected function QuarterlyTaskModifySubmit()
    {
        $id = Utility::GetFormInt('tbxID',$_POST);
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();
        $objQuarterlyTaskInfo = new QuarterlyTaskInfo();
        $objQuarterlyTaskInfo->iQuarterlyTaskId = $id;
                
        if($id > 0)
        {
            $objQuarterlyTaskInfo = $objQuarterlyTaskBLL->getModelByID($id);
            if($objQuarterlyTaskInfo == null)
                exit("编辑失败，未找到原季度任务！");
            
            $objQuarterlyTaskInfo->iAuditStatus = CheckStatus::isPass;
    	    $objQuarterlyTaskInfo->iUpdateUid = $this->getUserId();
            $objQuarterlyTaskInfo->strUpdateUserName = $this->getUserCNName();
        }
        else
        {            
            $objQuarterlyTaskInfo->iCreateUid = $this->getUserId(); 
            $objQuarterlyTaskInfo->strCreateUserName = $this->getUserCNName();
        }
        
        $objQuarterlyTaskInfo->iProductTypeId = Utility::GetFormInt('cbProductType',$_POST);
        if($objQuarterlyTaskInfo->iProductTypeId <= 0)
            exit("请选择产品！");
                    
        $objQuarterlyTaskInfo->iAgentId = Utility::GetFormInt('tbxAgentID',$_POST);
        if($objQuarterlyTaskInfo->iAgentId <= 0)
            exit("请选择代理商！");
                    
        $objQuarterlyTaskInfo->iTaskYear = Utility::GetFormInt('cbYear',$_POST);  
        $objQuarterlyTaskInfo->iTaskQuarterly = Utility::GetFormInt('cbQuarterly',$_POST);    
        
        if($objQuarterlyTaskInfo->iTaskYear <= 0 || $objQuarterlyTaskInfo->iTaskQuarterly <= 0)
            exit("请选择季度时间！"); 
        
        $objQuarterlyTaskInfo->iTaskMoney = Utility::GetFormDouble('tbxTaskMoney',$_POST); 
        if($objQuarterlyTaskInfo->iTaskYear <= 0)
            exit("请输入任务额！"); 
                
        $objQuarterlyTaskInfo->iFinishMoney = Utility::GetFormDouble('tbxFinishMoney',$_POST); 
        if($objQuarterlyTaskInfo->iFinishMoney <= 0)
            exit("请输入完成额！"); 
     
            
        switch($objQuarterlyTaskInfo->iTaskQuarterly)    
        {
            case 1:
                $objQuarterlyTaskInfo->strTaskQuarterlyText = $objQuarterlyTaskInfo->iTaskYear."年 第一季度(1-3月)";
            break;
            case 2:
                $objQuarterlyTaskInfo->strTaskQuarterlyText = $objQuarterlyTaskInfo->iTaskYear."年 第二季度(4-6月)";
            break;
            case 3:
                $objQuarterlyTaskInfo->strTaskQuarterlyText = $objQuarterlyTaskInfo->iTaskYear."年 第三季度(7-9月)";
            break;
            case 4:
                $objQuarterlyTaskInfo->strTaskQuarterlyText = $objQuarterlyTaskInfo->iTaskYear."年 第四季度(10-12月)";
            break;
        }
               
        //记录有没有重复
        //同一代理商同一产品 同一年份同一季度
        $sWhere = " `agent_id`=". $objQuarterlyTaskInfo->iAgentId ." and `product_type_id`=".$objQuarterlyTaskInfo->iProductTypeId
        ." and `task_year`=".$objQuarterlyTaskInfo->iTaskYear." and `task_quarterly`=".$objQuarterlyTaskInfo->iTaskQuarterly
        ." and `task_quarterly`=".$objQuarterlyTaskInfo->iTaskQuarterly." and quarterly_task_id<>".$id;
        
        $arrayData = $objQuarterlyTaskBLL->select("1",$sWhere,"");
        if(isset($arrayData) && count($arrayData) > 0)
            exit($objQuarterlyTaskInfo->strTaskQuarterlyText."，当前代理商的此产品季度任务已有记录。");
            
        $objQuarterlyTaskInfo->iSaleAwardMoney = Utility::GetFormDouble('tbxSaleAwardMoney',$_POST);         
        $objQuarterlyTaskInfo->iMarketFunds = Utility::GetFormDouble('tbxMarketFunds',$_POST);         
        $objQuarterlyTaskInfo->iDistributionFunds = Utility::GetFormDouble('tbxDistributionFunds',$_POST); 
        
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,256);    
        
    	$objQuarterlyTaskInfo->strQuarterlyTaskRemark = $strRemark;
        
        $objAgentPactBLL = new AgentPactBLL();
        $arrayPact = $objAgentPactBLL->GetAgentPact($objQuarterlyTaskInfo->iAgentId,$objQuarterlyTaskInfo->iProductTypeId);
        if(isset($arrayPact) && count($arrayPact) > 0)
        {
            $objQuarterlyTaskInfo->iAgentPactId = $arrayPact[0]["agent_pact_id"];
            $objQuarterlyTaskInfo->strAgentPactNo = $arrayPact[0]["pact_number"]."".$arrayPact[0]["pact_stage"];
            $objQuarterlyTaskInfo->iAgentLevel = $arrayPact[0]["agent_level"];            
        }
        
        if($id <= 0)
        {            
            $id = $objQuarterlyTaskBLL->insert($objQuarterlyTaskInfo);
            if($id <= 0)   
                exit("添加失败！");
        }
        else
        {
            if($objQuarterlyTaskBLL->updateByID($objQuarterlyTaskInfo) <= 0)
                exit("编辑失败！");
        }
        
        exit("0");
        
    }
    
    
    /**
     * @functional 取得已签约的代理商
    */
    public function AutoAgentJson()
    {
        $text = Utility::GetForm('q',$_GET);
        $objAgentBLL = new AgentBLL();
        $strJson = $objAgentBLL->AutoAgentJson($text);
        exit($strJson);
    }
    
    
    /**
     * @functional 取得代理商当前有效签约的产品（数据用于：代理商改变后产品的下拉列表数据也改变）
    */
    public function GetAgentPactProduct()
    {
        $agentID = Utility::GetFormInt('agentID',$_POST);
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayData = $objProductTypeBLL->GetAgentSignedProductType($agentID,true);
        $strJson = "[";
        if (isset($arrayData) && count($arrayData) > 0)
	    {
	       $arrayLength = count($arrayData);
           for($i= 0 ;$i<$arrayLength;$i++)
           {
               $strJson .= "{'id':'".$arrayData[$i]["aid"]."','name':'".$arrayData[$i]["product_type_name"]."'}";
               if($i != $arrayLength-1) 
                    $strJson .= ",";
           }
        }
        $strJson .= "]";
        exit($strJson);
    }
    
    
    /**
     * @functional 季度任务删除
    */
    protected function DelQuarterlyTask()
    {          
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("{'success':false,'msg':'未找到此季度任务！'}");        
        
        $objQuarterlyTaskBLL = new QuarterlyTaskBLL();            
        if($objQuarterlyTaskBLL->CanDel($id) == false)
            exit("{'success':false,'msg':'该季度任务不能被删除！'}");
             
        if($objQuarterlyTaskBLL->deleteByID($id,$this->getUserId()) > 0)
            exit("{'success':true,'msg':'删除成功'}");            
        else
            exit("{'success':false,'msg':'删除失败！'}");
    }
    
    
    
}

?>