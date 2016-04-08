<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：模块组管理
 * 创建人：wzx
 * 添加时间：2011-7-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ModelGroupBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelBLL.php';

class ModelGroupAction extends ActionBase
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
     * @functional 模块列表
    */
    public function Index()
    {
        return $this->ModelGroupList(); 
    }
    
    /**
     * @functional 显示模块组列表
    */
    public function ModelGroupList()
    {
        $this->PageRightValidate("ModelGroupList",RightValue::view);
        $this->smarty->assign('strTitle','模块组列表');
        
        $iIsAgent = Utility::GetFormInt('isAgent',$_GET);//是否为前台权限
            
        $objModelGroupBLL = new ModelGroupBLL();
        $arryRootModelGroup = $objModelGroupBLL->GetRootModelGroup($iIsAgent);
            
        $this->smarty->assign('isDepEvn',$this->isDepEvn);
        
        $this->smarty->assign('iIsAgent',$iIsAgent); 
        $this->smarty->assign('arryRootModelGroup',$arryRootModelGroup); 
        $this->displayPage('System/ModelManager/ModelGroupList.tpl');         
    }
    
    public function ModelGroupListBody()
    {        
        $iIsAgent = Utility::GetFormInt('isAgent',$_POST);//是否为前台权限

        $rootModelGroupNo = Utility::GetForm('modelGroup',$_POST);         
        if($rootModelGroupNo  == 0)
            $rootModelGroupNo = '-100';
              
        $sWhere = "is_agent=".$iIsAgent;
        if($rootModelGroupNo != '-100')
            $sWhere .= " and mgroup_no like '".$rootModelGroupNo."%'";
            
        $objModelGroupBLL = new ModelGroupBLL();    
        $arrayModelGroup = $objModelGroupBLL->ModelList($sWhere);
        
        $this->smarty->assign('isDepEvn',$this->isDepEvn);
        $this->smarty->assign('iIsAgent',$iIsAgent);
        $this->smarty->assign('arrayModelGroup',$arrayModelGroup);
        $this->smarty->display('System/ModelManager/ModelGroupListBody.tpl');      
    }
    /**
     * @functional 删除模块组
    */
    public function ModelGroupDel()
    {        
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->ExitWhenNoRight("ModelGroupList",RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id != 0)
        {
            $mgroupNo = Utility::GetForm('mgroupNo',$_GET);
            $objModelGroupBLL = new ModelGroupBLL();
            
            if(strlen($mgroupNo) == 2)
            {
                if(count($objModelGroupBLL->select("1", " mgroup_no like '$mgroupNo%' and length(mgroup_no)>length('$mgroupNo') ", ""))>0)
                    exit("{'success':false,'msg':'有下级模块，请先删除下级模块！'}");
            }
            else
            {
                $objModelBLL = new ModelBLL();
                if(count($objModelBLL->select("1", "mgroup_id=$id", ""))>0)
                    exit("{'success':false,'msg':'有下级模块，请先删除下级模块！'}");
            }
            
            if($objModelGroupBLL->deleteByID($id,$this->getUserId()) > 0)
               exit("{'success':true}");
            else
               exit("{'success':false,'msg':'删除出错！'}");
        }
    }
    
    /**
     * @functional 显示添加模块组
    */
    public function ModelGroupModify()
    {        
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->PageRightValidate("ModelGroupList",RightValue::add);
        $this->smarty->assign('strTitle','添加模块组');
        
        $rootModelGroupNo = Utility::GetFormInt('pno',$_GET);
        $id = Utility::GetFormInt('id',$_GET);
        $iIsAgent = Utility::GetFormInt('isAgent',$_GET);
        $objModelGroup = new ModelGroupInfo();
        $objModelGroupBLL = new ModelGroupBLL();  
        
        if($id > 0)
        {          
            $objModelGroup = $objModelGroupBLL->getModelByID($id);
            
            if(isset($objModelGroup))
            {                
                $rootModelGroupNo = substr($objModelGroup->strMgroupNo,0,2);
            }
        }
        
        $arrayProductTypes = $objModelGroupBLL->GetProductTypes($objModelGroup->strProductTypeIds);//此菜单关联的签约产品
        $arryModelGroup = $objModelGroupBLL->GetRootModelGroup($iIsAgent);
        
        $this->smarty->assign('id',$id);
        $this->smarty->assign('arrayProductTypes',$arrayProductTypes);
        $this->smarty->assign('isAgent',$iIsAgent);
        $this->smarty->assign('arryModelGroup',$arryModelGroup);
        $this->smarty->assign('objModelGroup',$objModelGroup);        
        $this->smarty->assign('rootModelGroupNo',$rootModelGroupNo);
        
        $this->displayPage('System/ModelManager/ModelGroupModify.tpl'); 
        
    }
        
    /**
     * @functional 新模块组的编号
     * @param string $strSupModelNo 上级模块组编号
     * @param int $iIsAgent 是否属于代理商模块
    */
    private function f_GetSubModelGroupNo($strSupModelNo,$iIsAgent)
    {        
        $strNewNo = $strSupModelNo.'01';
        
        $objModelGroupBLL = new ModelGroupBLL();
        $arrayModelGroup = $objModelGroupBLL->select("distinct mgroup_no",
        " mgroup_no like '".$strSupModelNo."%' and length(mgroup_no)=".(strlen($strSupModelNo)+2)." and is_agent=".$iIsAgent,"mgroup_no");        
        
        if(isset($arrayModelGroup) && count($arrayModelGroup)>0)
        {
            $strTempNewNo = $arrayModelGroup[0]['mgroup_no'];
            //exit($strTempNewNo);
            if(!empty($strTempNewNo))
            {
                $arrayLength =  count($arrayModelGroup);
                $strOldNo = substr($strTempNewNo,strlen($strTempNewNo)-2,2);
                settype($strOldNo,"integer");
                if($strOldNo == 1)
                {                    
                    $strNo = "";
                    for($i=1;$i<$arrayLength;$i++)
                    {
                        $strNo = $arrayModelGroup[$i]['mgroup_no'];
                        $strNo = substr($strNo,strlen($strNo)-2,2);
                        settype($strNo,"integer");
                        if($strOldNo+1 == $strNo)
                        {
                            $strOldNo = $strNo;
                        }
                        else
                        {
                            break;
                        }
                    }
                    
                    $strTempNewNo = $strOldNo + 1;
                    if($strTempNewNo > 99)
                        exit("上级的子账号超过99，请重新选择上级！");
                        
                    if($strTempNewNo < 10)
                        $strNewNo = $strSupModelNo.'0'.$strTempNewNo;
                    else
                        $strNewNo = $strSupModelNo.$strTempNewNo;   
                }            
            }            
        } 
        
        return $strNewNo;
    }
    
    
    /**
     * @functional 添加模块组数据提交
    */
    public function ModelGroupModifySubmit()
    {        
        if($this->isDepEvn != 1)
            exit("只能在开发环境编辑菜单！");
            
        $this->ExitWhenNoRight("ModelGroupList",RightValue::add);
        /*---------------输入数据验证---------begin--------------*/
        $strModelGroupName = Utility::GetForm('tbxModelGroupName',$_POST,16);         
        if($strModelGroupName == "")
            exit("请输入模块组名！");
            
        $strModelGroupCode = Utility::GetForm('tbxModelGroupCode',$_POST,32);
        if($strModelGroupCode == "")
            exit("请输入模块组代号！");
            
        //判断模块组代号是否重复
        $iIsAgent = Utility::GetFormInt('isAgent',$_POST);
        $id = Utility::GetFormInt('id',$_POST);
              
        $sWhere = "is_agent=".$iIsAgent." and mgroup_id<>".$id." and mgroup_code='".$strModelGroupCode."'";      
        $objModelGroupBLL = new ModelGroupBLL();
        $arrayModelGroup = $objModelGroupBLL->select("1",$sWhere,"");
                
        if(isset($arrayModelGroup) && count($arrayModelGroup)>0)
            exit("模块组代号已经存在，请重新输入");        
        
        /*---------------输入数据验证---------end--------------*/
        $objModelGroupInfo = new ModelGroupInfo();
                
        $objModelGroupInfo->iMgroupId = $id;
        $objModelGroupInfo->iIsLock = Utility::GetFormInt('chkIsLock',$_POST);  
        $objModelGroupInfo->strMgroupName = $strModelGroupName;
        $objModelGroupInfo->strMgroupCode = $strModelGroupCode;
        
        $objModelGroupInfo->iSortIndex = Utility::GetFormInt('tbxSortIndex',$_POST);        
        $objModelGroupInfo->strMgroupRemark = Utility::GetForm('tbxRemark',$_POST,32);
        $objModelGroupInfo->strProductTypeIds = Utility::GetForm('productTypes',$_POST,120);
        $strRootModelGroup = Utility::GetForm('cbRootModelGroup',$_POST); 
        $objModelGroupInfo->iIsAgent = $iIsAgent;
                
        if($objModelGroupInfo->iMgroupId <= 0)
        {
            $objModelGroupInfo->strMgroupNo = $this->f_GetSubModelGroupNo($strRootModelGroup,$iIsAgent);
            $objModelGroupInfo->iCreateUid = $this->getUserId();
            
            if($objModelGroupBLL->insert($objModelGroupInfo) > 0)
                exit('0');
            else
                exit("添加出错！");
        }
        else
        {            
            $objModelGroupInfo->iUpdateUid = $this->getUserId();
            //新的上级可能和原来的不一样
            $oldModelGroupNo = Utility::GetForm('tbxModelGroupNo',$_POST,32);
            $objModelGroupInfo->strMgroupNo = $oldModelGroupNo;
            
            $oldModelGroupNo = substr($oldModelGroupNo,0,strlen($oldModelGroupNo)-2);            
            if($strRootModelGroup != $oldModelGroupNo)
            {
                $objModelGroupInfo->strMgroupNo = $this->f_GetSubModelGroupNo($strRootModelGroup,$iIsAgent);
            }
            
            if($objModelGroupBLL->updateByID($objModelGroupInfo))
                exit('0');
            else
                exit("修改出错！");
        }
    }
    
    
    public function LockModel()
    {
        $id = Utility::GetFormInt('id',$_POST);
        
        $objModelGroupBLL = new ModelGroupBLL();
        if($objModelGroupBLL->LockModel($id,$this->getUserId()) > 0)
            exit('0');
        else
            exit("操作失败！");        
    }
    
    /**
     * @functional 权限数据同步
    */
    public function SynchronousGroup()
    {        
        $objModelGroupBLL = new ModelGroupBLL();
        if($objModelGroupBLL->SynchronousGroup($this->getUserId()) > 0)
            exit('0');
        else
            exit("操作失败！");  
    }
    
    
    /**
     * @functional 清除菜单的缓存
    */
    public function ClearModelPath()
    {                
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
        exit('0');
    }
} 
?>