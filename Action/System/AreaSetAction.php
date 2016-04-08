<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：wzx
 * 添加时间：2011-7-22 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/AreaGroupBLL.php';
require_once __DIR__.'/../../Class/BLL/AreaGroupDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AreaBLL.php';
require_once __DIR__.'/../../Class/BLL/AgroupManagerBLL.php';
require_once __DIR__.'/../../Class/BLL/AgroupManagerDetailBLL.php';

class AreaSetAction extends ActionBase
{
    public function __construct()
    {
        
    }
     
    /**
     * @functional 显示区域划分列表
    */
    public function Index()
    {
        $this->GroupList();
    }
    
    
    /**
     * @functional 显示区域划分列表
    */
    public function GroupList()
    {
        $this->PageRightValidate("AreaGroupList",RightValue::view);
        
        $this->smarty->assign('strTitle','区域划分列表');
        
        $this->smarty->assign('groupListBody',"/?d=System&c=AreaSet&a=GroupListBody");
        $this->smarty->display('System/AreaSet/GroupList.tpl');
    }
    
          
    /**
     * @functional 显示区域划分列表
    */
    public function GroupListBody()
    {
        $this->ExitWhenNoRight("AreaGroupList",RightValue::view);
        
        $strAreaName = Utility::GetForm("tbxAreaName",$_GET);
        
        $sWhere = "";
        if($strAreaName != "")
            $sWhere .= " sys_area_group.agroup_name like '%$strAreaName%'";
                    
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $objAreaGroupBLL = new AreaGroupBLL();
        $arrPageList = $this->getPageList($objAreaGroupBLL,"*",$sWhere,"",$iPageSize);
        //print_r($arrPageList['list']);
        
        $this->smarty->assign('arrayGroup',$arrPageList['list']);
        $this->smarty->assign('recordCount',$arrPageList['recordCount']);
        $this->smarty->assign('pageSize',$iPageSize);
        //
        
        $this->smarty->display('System/AreaSet/GroupListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");

    }
    
    
    /**
     * @functional 显示区域划分信息
    */
    public function GroupModify()
    {        
        $this->PageRightValidate("AreaGroupList",RightValue::add);
        
        $this->smarty->assign('strTitle','区域划分');
        $objAreaGroupBLL = new AreaGroupBLL();
        
        $areaHTML = $objAreaGroupBLL->GetCanAllotArea();
        
        $objAreaGroupInfo = new AreaGroupInfo();
        
        $id = Utility::GetFormInt("id",$_GET);
        if($id > 0)
        {
            $objAreaGroupInfo = $objAreaGroupBLL->getModelByID($id);
            $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
            $groupAreaJson = $objAreaGroupDetailBLL->GetGroupAreaJson($id);
            $this->smarty->assign('groupAreaJson',$groupAreaJson);
        }
               
        
        $this->smarty->assign('iAgroupID',$id);
        $this->smarty->assign('objAreaGroupInfo',$objAreaGroupInfo);
        $this->smarty->assign('areaHTML',$areaHTML);
        $this->smarty->display('System/AreaSet/GroupModify.tpl');
    }
    
    
    /**
     * @functional 区域划分信息提交
    */
    public function GroupModifySubmit()
    {
        $this->ExitWhenNoRight("AreaGroupList",RightValue::add);
        
        $id = Utility::GetFormInt("id",$_POST);
        $strAreaGroupName = Utility::GetForm("tbxGroupName",$_POST,48);
        $strRemark = Utility::GetForm("tbxRemark",$_POST,256);
        $strRegion = Utility::GetForm("region",$_POST);
        
        if($strAreaGroupName == "")
            exit("请输入区域名称！");
            
        if($strRegion == "")
             exit("请选择区域！");
             
        $objAreaGroupBLL = new AreaGroupBLL();
        //名称不能重复
        if(count($objAreaGroupBLL->select("1","agroup_id<>$id and agroup_name='$strAreaGroupName'"))>0)
            exit("此区域名称已存在！");
        
        $objAreaGroupInfo = new AreaGroupInfo();
            
        if($id > 0)
        {
            $objAreaGroupInfo = $objAreaGroupBLL->getModelByID($id);
            $objAreaGroupInfo->iUpdateUid = $this->getUserId();            
        }
        else
        {
            $objAreaGroupInfo->iCreateUid = $this->getUserId();
        }
        
        $objAreaGroupInfo->strAgroupName = $strAreaGroupName;
        $objAreaGroupInfo->strAgroupRemark = $strRemark;
        
        if($id > 0)
            $objAreaGroupBLL->updateByID($objAreaGroupInfo);
        else
            $id = $objAreaGroupBLL->insert($objAreaGroupInfo);
            
        $strProvIDs = "";
        $strCityIDs = "";
        $strAreaIDs = "";
        $arrayRegion = explode(",",$strRegion);
        $iRegionCount = count($arrayRegion);
        
        $strFlag = "";
        $strID = "";
        for($i=0;$i<$iRegionCount;$i++)
        {
            $arrayRegion[$i] = trim($arrayRegion[$i]);
            
            $strFlag = substr($arrayRegion[$i],0,1);
            if($strFlag != "p" && $strFlag != "c" && $strFlag != "a" )
                continue;
                
            $strID = explode("_",$arrayRegion[$i]);
            if(count($strID)!=2)
                continue;
                       
            $strID = $strID[1];
                            
            if($strFlag == "p")
                $strProvIDs .= ",".$strID;
            else if($strFlag == "c")
                $strCityIDs .= ",".$strID;
            else
                $strAreaIDs .= ",".$strID;
        }
        
        if(strlen($strProvIDs) > 0)
            $strProvIDs = substr($strProvIDs,1);
            
        if(strlen($strCityIDs) > 0)
            $strCityIDs = substr($strCityIDs,1);
            
        if(strlen($strAreaIDs) > 0)
            $strAreaIDs = substr($strAreaIDs,1);
            
        $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        if($id > 0)
            $objAreaGroupDetailBLL->DelAreas($id,$this->getUserId());
            
        $objAreaGroupDetailBLL->AddAreas($id,$strProvIDs,$strCityIDs,$strAreaIDs,$this->getUserId());
                
        exit("0"); 
    }
    
    /**
     * @functional 删除区域划分信息
    */
    public function DelGroup()
    {        
        $this->ExitWhenNoRight("AreaGroupList",RightValue::del);
        $id = Utility::GetFormInt("id",$_POST);
        if($id > 0)
        { 
            $objAgroupManagerDetailBLL= new AgroupManagerDetailBLL();
            if(count($objAgroupManagerDetailBLL->select("1","agroup_id=$id")) > 0)
                exit("{'success':false,'msg':'该区域已使用不能删除！'}");
                
            $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
            $objAreaGroupDetailBLL->DelAreas($id,$this->getUserId());
            $objAreaGroupBLL = new AreaGroupBLL();
            $objAreaGroupBLL->deleteByID($id,$this->getUserId());            
        }
        exit("{'success':true,'msg':'区域删除成功！'}"); 
    }
    
    /*===============================================================================================*/
    /*           ↑ 区域划分              ↖我是一条华丽的分割线↗       ↓    账号区域绑定            */
    /*===============================================================================================*/
     
    
    /**
     * @functional 显示账号区域绑定信息
    */
    public function ManagerModify()
    {
        $this->PageRightValidate("AreaManagerList",RightValue::add);
        $this->smarty->assign('strTitle','账号区域绑定');
        
        //$objAgroupManagerInfo = new AgroupManagerInfo();
        $managerID = "-100";
        $managerName = "";
        
        $id = Utility::GetFormInt("id",$_GET);
        if($id > 0)
        {
            
            $objAgroupManagerBLL = new AgroupManagerBLL();
            $arrayAreaGroupManager =  $objAgroupManagerBLL->GetAreaGroupManagerInfo($id);
            
            if(isset($arrayAreaGroupManager)&& count($arrayAreaGroupManager)>0)
            {
               $managerID = $arrayAreaGroupManager[0]["user_id"];
               $managerName = $arrayAreaGroupManager[0]["user_name"];
            }
        }
        
        $objAreaGroupBLL = new AreaGroupBLL();            
        $arrayAreaGroup = $objAreaGroupBLL->GetAreaGroup($id);
        $this->smarty->assign('arrayAreaGroup',$arrayAreaGroup);
        
        $this->smarty->assign('managerID',$managerID);
        $this->smarty->assign('managerName',$managerName);
               
        $this->smarty->assign('iAgroupManagerID',$id);
        //$this->smarty->assign('objAgroupManagerInfo',$objAgroupManagerInfo);

        $this->smarty->display('System/AreaSet/ManagerModify.tpl');
    }
   
    
    /**
     * @functional 账号区域绑定数据提交
     */
    public function ManagerModifySubmit()
    {         
        $this->ExitWhenNoRight("AreaManagerList",RightValue::add);
        
        $id = Utility::GetFormInt("id",$_POST);
        $idTemp=$id;
        $managerID = Utility::GetFormInt("tbxAccountID",$_POST);
        if($managerID <= 0)
            exit("{'success':false,'msg':'请输入有效账号！'}");
            
        $strGroupIDs = Utility::GetForm("groupIDs",$_POST);

        if(strlen($strGroupIDs) == 0)
            exit("{'success':false,'msg':'请选择区域！'}");
            
        $objAgroupManagerBLL = new AgroupManagerBLL();        
        if(count($objAgroupManagerBLL->select("1","agroup_manager_id<>$id and user_id=$managerID")) > 0)
            exit("{'success':false,'msg':'该账号已分配区域！'}");
            
            
        $objAgroupManagerInfo = new AgroupManagerInfo();
        if($id > 0)
        {
            $objAgroupManagerInfo = $objAgroupManagerBLL->getModelByID($id);
            $objAgroupManagerInfo->iUserId = $managerID;
            $objAgroupManagerInfo->iUpdateUid = $this->getUserId();
            $objAgroupManagerBLL->updateByID($objAgroupManagerInfo);
            
            $objAgroupManagerBLL->DelGroups($id,$this->getUserId());
        }
        else
        {
            $objAgroupManagerInfo->iUserId = $managerID;
            $objAgroupManagerInfo->iCreateUid = $this->getUserId();
            
            $id = $objAgroupManagerBLL->insert($objAgroupManagerInfo);
        }
        
        if($objAgroupManagerBLL->AddGroups($id,$strGroupIDs,$this->getUserId()) > 0){ 
        	if($idTemp > 0)
                exit("{'success':true,'msg':'修改成功！'}");
            else
                exit("{'success':true,'msg':'添加成功！'}");   
        }else{
            if($id > 0)
                exit("{'success':false,'msg':'修改出错！'}");
            else
                exit("{'success':false,'msg':'添加出错！'}");
        }
    }
    
    /**
     * @functional 公司用户自动匹配
     */
    public function AutoUser()
    {
        $strUserName =  Utility::GetForm("q",$_GET);
        $objAgroupManagerBLL = new AgroupManagerBLL();
        $userJson = $objAgroupManagerBLL->AutoUserForBindAreaJson($strUserName);
        exit($userJson);
    }
    
    
    
    /**
     * @functional 显示账号区域绑定列表
    */
    public function ManagerList()
    {
        $this->PageRightValidate("AreaManagerList",RightValue::view);
        $this->smarty->assign('strTitle','账号区域组绑定列表');
        
        $this->smarty->assign('groupListBody',"/?d=System&c=AreaSet&a=ManagerListBody");
        $this->displayPage('System/AreaSet/ManagerList.tpl');
    }
    
          
    /**
     * @functional 显示账号区域绑定列表
    */
    public function ManagerListBody()
    {
        $this->ExitWhenNoRight("AreaManagerList",RightValue::view);
        
        $strAccountName = Utility::GetForm("accountName",$_GET);
        //省市区
        $iProvinceId = Utility::GetFormInt('pri',$_GET);
        $iCityId = Utility::GetFormInt('city',$_GET);
        $iAreaId = Utility::GetFormInt('area',$_GET);
        
        $sWhere = "";
        if($strAccountName != "")
            $sWhere .= " and (sys_user.user_name like '%$strAccountName%' or `sys_user`.e_name like '%".$strAccountName."%')";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        $strAreaId = "".$iProvinceId.",".$iCityId.",".$iAreaId;
        $objAgroupManagerBLL = new AgroupManagerBLL();
        $arrPageList = $this->getPageList($objAgroupManagerBLL,$strAreaId,$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayManager',$arrPageList['list']);
        //$this->smarty->assign('recordCount',$arrPageList['recordCount']);
        //$this->smarty->assign('pageSize',$iPageSize);
        $this->smarty->display('System/AreaSet/ManagerListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 

    }
    
    /**
     * @functional 
    */
    public function DelManagers()
    {
       if(!$this->HaveRight("AreaManagerList",RightValue::del))
       {
            $arrayMsg = array('success'=>false,'msg'=>'您没有此操作权限！');
            exit(json_encode($arrayMsg)) ;           
       }
        /*---------------------------------------------------------------------*/
        $ids = Utility::GetForm('listid',$_POST);
        if(strlen($ids) == 0)
        {
            $arrayMsg = array('success'=>false,'msg'=>'请选择账号！');
            exit(json_encode($arrayMsg)) ;            
        }
        
        $objAgroupManagerBLL = new AgroupManagerBLL();        
        $objAgroupManagerInfo = new AgroupManagerInfo();
        
        $arrayID = explode(",",$ids);
        $arrayLength = count($arrayID);
        $id = 0;
        for($i = 0;$i < $arrayLength; $i++)
        {    
            $id = $arrayID[$i];
            settype($id,"integer");
            if($id > 0)
            {
                if($objAgroupManagerBLL->deleteByID($id,$this->getUserId()) > 0)
                    $objAgroupManagerBLL->DelGroups($id,$this->getUserId());
            }
        }            
            
        $arrayMsg = array('success'=>true,'msg'=>'成功！');
        exit(json_encode($arrayMsg)) ;  
         
    }
} 
?>