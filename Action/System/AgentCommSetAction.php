<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：wzx
 * 添加时间：2011-11-7
 * 修改人：      修改时间：
 * 修改描述：系统通用设置
 **/

require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupBLL.php';

class AgentCommSetAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
    }
    
    /**
     * @functional 
    */
    public function AgentCommSetModify()
    {
        $this->PageRightValidate("AgentCommSetModify", RightValue::view);

        $objComSettingBLL = new ComSettingBLL();
        $arrayAgentCountLimit = $objComSettingBLL->selectByName(AgentCommSet::Agent_Count_Limit); 
        if(!(isset($arrayAgentCountLimit)&&count($arrayAgentCountLimit) > 0))
        {
            $agentCountLimitJson = "[";
            $objAccountGroupBLL = new AccountGroupBLL();
            $arrayData = $objAccountGroupBLL->select("account_no, account_name","account_no in('10','11','12')","account_no");
            foreach($arrayData as $v)
            {
                $agentCountLimitJson .= '{"data_type":"'.$v['account_no'].'","remark":"'.$v['account_name'].'","setting_value":"0"},';
            }
            
            $agentCountLimitJson = substr($agentCountLimitJson,0,strlen($agentCountLimitJson)-1);
            $agentCountLimitJson .= "]";
            $arrayAgentCountLimit = json_decode($agentCountLimitJson,true);  
        }      
        $this->smarty->assign('arrayAgentCountLimit',$arrayAgentCountLimit);
        $objConstDataBLL = new ConstDataBLL();
        $arrayAgentContactContent = $objConstDataBLL->select("*","data_type='".AgentCommSet::Agent_Contact_Content."'","");
        $this->smarty->assign('arrayAgentContactContent',$arrayAgentContactContent);
                
        $this->displayPage('System/ComSetting/AgentCommSetModify.tpl');
    }    
    
    /**
     * @functional 
    */
    public function AgentCountLimitSubmit()
    {
        $this->ExitWhenNoRight("AgentCommSetModify", RightValue::add);
        
        $no = Utility::GetFormInt('no',$_POST);
        $tbxCount = Utility::GetFormInt('tbxCount',$_POST);
        if($no != 11 && $no != 12 && $no != 10)
            exit("参数有误");
            
        $objComSettingBLL = new ComSettingBLL();        
        $objComSettingInfo = new ComSettingInfo();      
        $objComSettingInfo->iIsLock = 0;
        $objComSettingInfo->iCreateUid = $this->getUserId();
        $objComSettingInfo->strCreateUserName = $this->getUserCNName();
        $objComSettingInfo->iUpdateUid = $this->getUserId();
        $objComSettingInfo->strUpdateUserName = $this->getUserCNName();
        
        $objComSettingInfo->strSettingName = AgentCommSet::Agent_Count_Limit;  
        $objComSettingInfo->strDataType = $no;
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrayData = $objAccountGroupBLL->select("account_name","account_no='{$no}'");
        if(isset($arrayData)&&count($arrayData)>0)
            $objComSettingInfo->strRemark = $arrayData[0]["account_name"];
            
        $objComSettingInfo->strSettingValue = $tbxCount;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        exit("0");
    }    
    
    /**
     * @functional 
    */
    public function AgentContactContentSubmit()
    {        
        $this->ExitWhenNoRight("AgentCommSetModify", RightValue::add);
        
        $id = Utility::GetFormInt('id',$_POST);
        $tbxContent = Utility::GetForm('tbxContent',$_POST);
            
        $objConstDataBLL = new ConstDataBLL();
        $arrayData = $objConstDataBLL->select("1","data_type='".AgentCommSet::Agent_Contact_Content."' and c_value='{$tbxContent}' and c_id<>$id","");
        if(isset($arrayData)&&count($arrayData)>0)
            exit("相同内容的选项已存在！");
                
        $objConstDataInfo = null;
        if($id > 0)
            $objConstDataInfo = $objConstDataBLL->getModelByID($id, AgentCommSet::Agent_Contact_Content);
            
        if($objConstDataInfo == null) 
        {
            $id = 0;
            $objConstDataInfo = new ConstDataInfo(); 
        }
        
		$objConstDataInfo->strcValue = $tbxContent;
		$objConstDataInfo->iSortIndex = Utility::GetFormInt('tbxSortIndex',$_POST);
		$objConstDataInfo->iIsDel = 0;
        if($id <= 0)
        {
            $objConstDataInfo->strDataType = AgentCommSet::Agent_Contact_Content;
            $objConstDataInfo->iCreateUid = $this->getUserId();
            $objConstDataInfo->strCreateUserName = $this->getUserCNName();
            $id = $objConstDataBLL->insert($objConstDataInfo);
        }
        else
        {
            $objConstDataInfo->iUpdateUid = $this->getUserId();
            $objConstDataInfo->strUpdateUserName = $this->getUserCNName();
            $objConstDataBLL->updateByID($objConstDataInfo);
        }
        
        exit("0,$id");
    }
    
    
    /**
     * @functional 
    */
    public function AgentContactContentDel()
    {        
        $this->ExitWhenNoRight("AgentCommSetModify", RightValue::add);
        
        $id = Utility::GetFormInt('id',$_POST);
        if($id <= 0)   
            exit("参数有误！");
            
        $objConstDataBLL = new ConstDataBLL();       
        $objConstDataInfo = $objConstDataBLL->getModelByID($id, AgentCommSet::Agent_Contact_Content);            
        if($objConstDataInfo == null) 
            exit("未找到对应数据！");
        
		$objConstDataInfo->iIsDel = 1;
        $objConstDataInfo->iUpdateUid = $this->getUserId();
        $objConstDataInfo->strUpdateUserName = $this->getUserCNName();
        $objConstDataBLL->updateByID($objConstDataInfo);        
        
        exit("0");
    }
} 