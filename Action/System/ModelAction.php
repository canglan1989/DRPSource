<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：模块管理
 * 创建人：wzx
 * 添加时间：2011-7-11 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ModelGroupBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelBLL.php';

class ModelAction extends ActionBase
{
    private $isDepEvn = 0;
    public function __construct()
    {        
        //取配置
        $arrSysConfig = unserialize(SYS_CONFIG);
        $sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        if($sys_evn == 0)
            $this->isDepEvn = 1;
    }
     
    /**
     * @functional 列表
    */
    public function Index()
    {
        return $this->ModelList(); 
    }
    
    /**
    * functional 取得模块组
    */
    public function f_GetModelGroup($isAgent)
    {
       $objModelGroup = new ModelGroupBLL();
       return $objModelGroup->select(T_ModelGroup::mgroup_id.",".T_ModelGroup::mgroup_no.",".T_ModelGroup::mgroup_name,"length(mgroup_no)>2 and is_agent=".$isAgent,"");
    }
    
    /**
     * @functional 显示列表
    */
    public function ModelList()
    {
        $this->PageRightValidate("ModelGroupList",RightValue::view);
        $this->smarty->assign('strTitle','模块列表');
        $iIsAgent = Utility::GetFormInt('isAgent',$_GET);//是否为前台权限    
        $arryModelGroup = $this->f_GetModelGroup($iIsAgent);    
        $pModelID = Utility::GetFormInt('pid',$_GET); 
        
        $sWhere = "is_agent=".$iIsAgent." and mgroup_id=".$pModelID;

        $objModelBLL = new ModelBLL();
        $arrayModel = $objModelBLL->select("*",$sWhere,"");
        
        /*---------------取根模块组信息--------b-----*/
        $arrayRootModelGroup = null;        
        $objModelGroupBLL = new ModelGroupBLL();
        $arrayTempModelGroup = $objModelGroupBLL->select("mgroup_no","mgroup_id=".$pModelID,"");
        if(isset($arrayTempModelGroup) && count($arrayTempModelGroup)>0)
        {
            $sWhere = "is_agent=".$iIsAgent." and mgroup_no='".substr($arrayTempModelGroup[0]["mgroup_no"],0,strlen($arrayTempModelGroup[0]["mgroup_no"])-2)."'";
            $arrayRootModelGroup = $objModelGroupBLL->select("*",$sWhere,"");
        }
        /*---------------取根模块组信息--------e-----*/
            
        $this->smarty->assign('isDepEvn',$this->isDepEvn);
        //print_r($arrayRootModelGroup);
        $this->smarty->assign('iIsAgent',$iIsAgent);
        $this->smarty->assign('arrayModel',$arrayModel);
        $this->smarty->assign('arrayRootModelGroup',$arrayRootModelGroup);
        $this->smarty->assign('arryModelGroup',$arryModelGroup);
        $this->smarty->assign('pModelID',$pModelID); 
        $this->displayPage('System/ModelManager/ModelList.tpl');         
    }
    
    /**
     * @functional 删除模块
    */
    public function ModelDel()
    {        
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->ExitWhenNoRight("ModelGroupList",RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id != 0)
        {
            $objModelRightBLL = new ModelRightBLL();
            if(count($objModelRightBLL->select("1","model_id=$id","")) > 0)
                exit("请先删除模块权限！");
                
            $objModelBLL = new ModelBLL();            
            if($objModelBLL->deleteByID($id,$this->getUserId()) > 0)
               exit('{"success":true,"msg":"删除成功！"}');
            else
               exit('{"success":false,"msg":"删除出错！"}');
        }
    }
    
    /**
     * @functional 显示添加
    */
    public function ModelModify()
    {
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->PageRightValidate("ModelGroupList",RightValue::add);
        $this->smarty->assign('strTitle','添加模块');
        
        $iIsAgent = Utility::GetFormInt('isAgent',$_GET);//是否为前台权限   
        $id = Utility::GetFormInt('id',$_GET);
        $pModelID = Utility::GetFormInt('pid',$_GET);
        $objModel = new ModelInfo();
        $objModel->strModelPage = "/?d=&c=&a=";
        
        $objModelGroupBLL = new ModelGroupBLL();
        if($id > 0)
        {
            $objModelBLL = new ModelBLL();            
            $objModel = $objModelBLL->getModelByID($id); 
            $pModelID = $objModel->iMgroupId;
            $iIsAgent = $objModel->iIsAgent;
        }
        else
        {
            $objModelGroupInfo = $objModelGroupBLL->getModelByID($pModelID); 
            if($objModelGroupInfo != null)
                $objModel->strProductTypeIds = $objModelGroupInfo->strProductTypeIds;
        }
        
        $arryModelGroup = $this->f_GetModelGroup($iIsAgent);       
        $arrayProductTypes = $objModelGroupBLL->GetProductTypes($objModel->strProductTypeIds);//此菜单关联的签约产品
        
        $this->smarty->assign('id',$id);
        $this->smarty->assign('isAgent',$iIsAgent);
        $this->smarty->assign('pModelID',$pModelID);
        $this->smarty->assign('arryModelGroup',$arryModelGroup);
        $this->smarty->assign('objModel',$objModel);        
        $this->smarty->assign('arrayProductTypes',$arrayProductTypes);
        
        $this->displayPage('System/ModelManager/ModelModify.tpl');
    }
        
    
    /**
     * @functional 添加数据提交
    */
    public function ModelModifySubmit()
    {        
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->ExitWhenNoRight("ModelGroupList",RightValue::add);
        /*---------------输入数据验证---------begin--------------*/
        $strModelName = Utility::GetForm('tbxModelName',$_POST,16);         
        if($strModelName == "")
            exit("请输入模块名！");
            
        $strModelCode = Utility::GetForm('tbxModelCode',$_POST,32);
        if($strModelCode == "")
            exit("请输入模块代号！");
            
        $strModelShowName = Utility::GetForm('tbxModelShowName',$_POST,16);
        if($strModelShowName == "")
            exit("请输入模块显示名！");
                     
        $strModelPage = Utility::GetForm('tbxModelPage',$_POST,256);
        if($strModelPage == "")
            exit("请输入模块页面！");
        
        $id = Utility::GetFormInt('id',$_POST);
        $iIsAgent = Utility::GetFormInt('isAgent',$_POST);
        
        //模块权限名唯一性验证
        $objModelBLL = new ModelBLL();
        $sWhere = "is_agent=".$iIsAgent." and model_id<>".$id." and model_code='".$strModelCode."'";
        
        //exit($sWhere);
        $arrayModel = $objModelBLL->select("1",$sWhere,"");
        if(count($arrayModel)>0)
            exit("模块代号已存在，请重新输入");
        
        /*---------------输入数据验证---------end--------------*/

        $objModelInfo = new ModelInfo();
        $objModelInfo->iModelId = $id;
        
        $objModelInfo->strModelName = $strModelName;
        $objModelInfo->strModelCode = $strModelCode;
        $objModelInfo->strShowName = $strModelShowName;
        $objModelInfo->strModelPage = $strModelPage;
        
        $objModelInfo->iIsAgent = $iIsAgent;
        $objModelInfo->iIsMenu = Utility::GetFormInt('chkIsMenu',$_POST);
        $objModelInfo->iSortIndex = Utility::GetFormInt('tbxSortIndex',$_POST);        
        $objModelInfo->strModelRemark = Utility::GetForm('tbxRemark',$_POST,32);
        $objModelInfo->iMgroupId = Utility::GetFormInt('cbModelGroup',$_POST); 
        $objModelInfo->iIsLock = Utility::GetFormInt('chkIsLock',$_POST); 
        $objModelInfo->strProductTypeIds = Utility::GetForm('productTypes',$_POST,128);
                
        if($objModelInfo->iModelId <= 0)
        {
            $objModelInfo->iCreateUid = $this->getUserId();
            
            if($objModelBLL->insert($objModelInfo) > 0)
                exit('0');
            else
                exit("添加出错！");
        }
        else
        {            
            $objModelInfo->iUpdateUid = $this->getUserId();
            if($objModelBLL->updateByID($objModelInfo))
                exit('0');
            else
                exit("修改出错！");
        }
    }
    
    public function LockModel()
    {
        $id = Utility::GetFormInt('id',$_POST);
        
        $objModelBLL = new ModelBLL();
        if($objModelBLL->LockModel($id,$this->getUserId()) > 0)
            exit('0');
        else
            exit("操作失败！");
        
    }
    
    
    /**
     * @functional 权限对应职位
    */
    public function ModelRightPosition()
    {
        $this->ExitWhenNoRight("PositionRightList",RightValue::view);    
        $this->smarty->assign('strTitle',"权限对应职位管理");   
        $modelID = Utility::GetFormInt('id',$_GET);
        if($modelID <= 0)
            exit("未取得ID！");
            
        $objModelBLL = new ModelBLL();
        $arrayRightPositionList = $objModelBLL->GetModelRightPositionList($modelID);
        $this->smarty->assign('id',$modelID); 
        $this->smarty->assign('arrayRightPositionList',$arrayRightPositionList); 
        $this->displayPage('System/ModelManager/ModelRightPositionList.tpl');
    }
    
    /**
     * @functional 权限对应人员
    */
    public function ModelRightUser()
    {
        $this->ExitWhenNoRight("UserRightList",RightValue::view);  
        $this->smarty->assign('strTitle',"权限对应人员管理");    
        $modelID = Utility::GetFormInt('id',$_GET);
        if($modelID <= 0)
            exit("未取得ID！");
            
        $objModelBLL = new ModelBLL();
        $arrayRightUserList = $objModelBLL->GetModelRightUserList($modelID);
        $this->smarty->assign('id',$modelID); 
        $this->smarty->assign('arrayRightUserList',$arrayRightUserList); 
        $this->displayPage('System/ModelManager/ModelRightUserList.tpl');
    }
    
} 
?>