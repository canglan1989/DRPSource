<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：区域组管理
 * 创建人：xdd
 * 添加时间：2011-8-13
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

 class AreaGroupSetAction extends ActionBase
{
    public function __construct()
    {
        
    }
     
    /**
     * @functional 显示区域组列表
    */
    public function Index()
    {
        $this->GroupList();
    }
    /**
     * @functional 显示区域组列表
    */
    public function GroupList()
    {
        $this->PageRightValidate("AreaGroupManagement",RightValue::view);
        $this->smarty->assign('groupListBody',"/?d=System&c=AreaGroupSet&a=GroupListBody");
        $this->smarty->display('System/AreaSet/AreaGroupList.tpl');
    }
    /**
     * @functional 显示区域组列表Body
    */
    public function GroupListBody()
    {
        $this->ExitWhenNoRight("AreaGroupManagement",RightValue::view);
        $area_name = Utility::GetForm('area_name',$_GET);
        $level     = Utility::GetFormInt('level',$_GET);
        $strWhere = "";
        if($area_name != "")
            $strWhere .= " and sys_area_group.agroup_name like '%".$area_name."%' ";
        if($level > 0)
            $strWhere .= " and length(sys_area_group.group_no)= $level ";
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objAreaGroupBLL = new AreaGroupBLL();
        $arrPageList = $this->getPageList($objAreaGroupBLL,"*",$strWhere,"",$iPageSize);
        $this->smarty->assign("arrayGroup",$arrPageList["list"]);
        
        $this->smarty->assign('recordCount',$arrPageList['recordCount']);
        $this->smarty->assign('pageSize',$iPageSize);
        
        $this->smarty->display('System/AreaSet/AreaGroupListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");
    }
    /**
     * @functional 显示添加区域组
    */
    public function AreaGroupModify()
    {
        $this->PageRightValidate("AreaGroupManagement",RightValue::add);
        $this->smarty->assign('strTitle','添加区域组');
        $id = Utility::GetFormInt('id',$_GET);
        $supid = Utility::GetFormInt('supid',$_GET);
        $group_no = Utility::GetForm('group_no',$_GET);
        $objAreaGroup    = new AreaGroupInfo();
        $objAreaGroupBLL = new AreaGroupBLL(); 
        $SupGroup = substr($group_no,0,strlen($group_no)-2);
        if($id>0)
        {
            $arrSupGroupId = $objAreaGroupBLL->select("agroup_id,agroup_name","group_no='$SupGroup'","");
            if(isset($arrSupGroupId)&&count($arrSupGroupId)>0)
            {
                $SupGroupId = $arrSupGroupId[0]["agroup_id"];
                $agroup_name = $arrSupGroupId[0]["agroup_name"];
                $areaHTML = $objAreaGroupBLL->GetSupCanAllotArea($SupGroupId);//有上级
                
                $this->smarty->assign('SupGroupId',$SupGroupId);  
                $this->smarty->assign('agroup_name',$agroup_name); 
            }
            else 
                $areaHTML = $objAreaGroupBLL->GetSupCanAllotArea(-100);
            
            $this->smarty->assign('areaHTML',$areaHTML);
            $this->smarty->assign('strTitle','编辑区域组信息');
            $objAreaGroup = $objAreaGroupBLL->getModelByID($id);
            $arryAreaGroup = $objAreaGroupBLL->select("agroup_id,group_no,agroup_name"," agroup_id<>$id and group_no not like '$group_no%' and length(group_no)<=length($group_no)");   
            
            $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
            $strAreaID = "";
            $groupAreaJson = $objAreaGroupDetailBLL->GetGroupAreaJson($id,$strAreaID);   //区域组已经关联区域的信息
            $groupAreaHTML = $objAreaGroupDetailBLL->GetGroupAreaHtml($id);   //区域组已经关联区域的信息html
            if(strlen($groupAreaJson) > 1)
                $this->smarty->assign('areaIDs',$strAreaID); 
            $this->smarty->assign('groupAreaHTML',$groupAreaHTML);  
        }
        else
        {
            //---------------------已选定上级的添加区域组begin--------------------------------//
            if($supid > 0)
            {
                $array_self = $objAreaGroupBLL->select("agroup_id,agroup_name","agroup_id='$supid'","");
                $self_name = $array_self[0]["agroup_name"];
                $haveSup_areaHTML = $this->GetSupGroupAreaHtml2($supid);
                $this->smarty->assign('haveSup_areaHTML',$haveSup_areaHTML);
                $this->smarty->assign('self_name',$self_name);
                $this->smarty->assign('supid',$supid);
            //---------------------已选定上级的添加区域组end---------------------------------//
            }
            else
            {
                $arryAreaGroup = $objAreaGroupBLL->select("agroup_id,group_no,agroup_name","");
                //$areaHTML = $objAreaGroupBLL->GetCanAllotArea();//快，错误
                $areaHTML = $objAreaGroupBLL->GetSupCanAllotArea(-100);
                $this->smarty->assign('areaHTML',$areaHTML);
                $this->smarty->assign('arryAreaGroup',$arryAreaGroup);//区域组，用于下拉列表,其中不包括自己和下级
            }
        }
       $this->smarty->assign('id',$id);                       //下拉列表绑定
       $this->smarty->assign('objAreaGroup',$objAreaGroup);
       $this->smarty->display('System/AreaSet/AddAreaGroup.tpl'); 
    }
    /**
     * @functional 提交区域组信息
    */
    public function AreaGroupModifySubmit()
    {
        $this->ExitWhenNoRight("AreaGroupManagement",RightValue::add);
        $agroup_id   = Utility::GetFormInt('id',$_POST);
        $groupname   = Utility::GetForm('tbxGroupName',$_POST); 
        $strRemark   = Utility::GetForm('tbxRemark',$_POST); 
        $strRegion   = Utility::GetForm('region',$_POST,-1); 
        $groupname = urldecode($groupname); 
        $strRegion = urldecode($strRegion); 
        $strRemark = urldecode($strRemark);
        
        if($groupname == "")
            exit("{'success':false,'msg':'请输入区域组名！'}"); 
        $objareaGroupBLL = new AreaGroupBLL();
        $objGroupInfo = new AreaGroupInfo();  
        if($agroup_id > 0)
            $havename  = $objareaGroupBLL->select("agroup_name"," agroup_name='$groupname' and agroup_id<>$agroup_id","");
        else
            $havename  = $objareaGroupBLL->select("agroup_name"," agroup_name='$groupname' ","");
       
        if(count($havename) > 0)
            exit("{'success':false,'msg':'该区域组名称已存在，请重新输入！'}");      
              
        
        $objGroupInfo->iAgroupId       = $agroup_id;
        $objGroupInfo->strAgroupName   = $groupname;
        $objGroupInfo->strAgroupRemark =  $strRemark;
        
        if($agroup_id>0)                                              
        {
            $objGroupInfo->iUpdateUid = $this->getUserId();
            
            $iUpdateCount    = $objareaGroupBLL->UpdateAreaGroup($objGroupInfo);
            if($iUpdateCount < 0)
                exit("{'success':false,'msg':'区域组修改出错！'}");      
        }
        else
        {
            $cbSupid  = Utility::GetFormInt('cbSupAreaGroup',$_POST);
            $arrData  =  $objareaGroupBLL->select("group_no","agroup_id=$cbSupid",""); 
            $strSupNo = "";
            if(isset($arrData)&&count($arrData)>0)
                $strSupNo = $arrData[0]["group_no"]; 
            if(strlen($strSupNo) > 4)
                    exit("{'success':false,'msg':'上级区域组超过二级，不可以添加下级区域组！'}");  
            $objGroupInfo->iCreateUid = $this->getUserId();
            $agroup_id = $objareaGroupBLL->AddAreaGroup($objGroupInfo,$strSupNo);
            
            if($agroup_id < 0)
                exit("{'success':false,'msg':'区域组添加出错！'}");  
        } 
        
        //---------------------------------------分配行政区域---begin----------------------------------------------------//
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
        if($agroup_id > 0)
            $objAreaGroupDetailBLL->DelAreas($agroup_id,$this->getUserId());
       
        $objAreaGroupDetailBLL->AddAreas($agroup_id,$strProvIDs,$strCityIDs,$strAreaIDs,$this->getUserId());        
        exit("{'success':true,'msg':'添加成功'}");  
        //-------------------------------------分配行政区域------end-----------------------------------------------//
    }
    /**
     * @functional 删除区域组
    */
    public function DelGroup()
    {
        $this->ExitWhenNoRight("AreaGroupManagement",RightValue::del);
        $id = Utility::GetFormInt("id",$_POST);
        if($id > 0)
        { 
            $objAreaGroupBLL= new AreaGroupBLL();
            if($objAreaGroupBLL->CanDelAreaGroup($id) > 0)
                exit("{'success':false,'msg':'该区域组有下级区域组，请先删除下级！'}");
            if($objAreaGroupBLL->HaveBind($id) > 0)    
                exit("{'success':false,'msg':'该区域组已被账号组绑定，请先删除绑定'}");
            
            $ide = $objAreaGroupBLL->deleteByID($id,$this->getUserId()); 
            $idLow = $objAreaGroupBLL->delBindArea($id,$this->getUserId());
            if($ide>0)
            {
                if($idLow>0)
                    exit("{'success':true,'msg':'删除成功'}");
                else
                    exit("{'success':false,'msg':'区域组删除成功，绑定的区域删除失败'}");
            }
            else
                exit("{'success':false,'msg':'删除失败'}");               
        }
    }
    
    /**
     * @functional 取得上级区域组下面的行政区域 JSON
    */
    public function GetGroupAreaJson()
    {
        $id = Utility::GetFormInt("agroup_id",$_POST);
        $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        $strAreaID = "";
        $groupAreaJson = $objAreaGroupDetailBLL->GetGroupAreaJson($id,$strAreaID);
        
        exit($groupAreaJson);
    }
    /**
     * @functional 取得上级区域组下面的行政区域 HTML格式，放在可选区域中
    */
    public function GetSupGroupAreaHtml()
    {
        $id = Utility::GetFormInt("agroup_id",$_GET);
        $objAreaGroupBLL = new AreaGroupBLL();
        $areaHTML = $objAreaGroupBLL->GetSupCanAllotArea($id);
        exit($areaHTML);
        
    }
    /**
     * @functional 取得上级区域组下面的行政区域 HTML格式，放在可选区域中
    */
    public function GetSupGroupAreaHtml2($id)
    {
        $objAreaGroupBLL = new AreaGroupBLL();
        return $areaHTML = $objAreaGroupBLL->GetSupCanAllotArea($id);
    }
    /*
    *
     * @functional 判断该区域中是否有分配给下级的区域
    
    public function CanDelArea()
    {
        $id = Utility::GetFormInt("agroup_id",$_POST);
        if($id == 0)
            exit("0");
        $strAreaId = Utility::GetForm("selectAreaId",$_POST);//p_,city_,area_  
        $objAreaGroupBLL = new AreaGroupBLL();
        
        if($objAreaGroupBLL->CanDelAreaGroup($id)<= 0)
            exit("0");
            
        if($objAreaGroupBLL->BeenDistr($strAreaId,$id) != 0)
            exit("1");
    }*/
    /**
     * @functional 关联区域的HTML
    */
    public function GetBindAreaHtml()
    {
        $id = Utility::GetFormInt("agroup_id",$_POST);
        $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        $groupAreaHTML = $objAreaGroupDetailBLL->GetGroupAreaHtml($id);   //区域组已经关联区域的信息html
        
        exit($groupAreaHTML);
    }
    /**
     * @functional 取得下级区域组——用于账号组绑定区域组时的下拉列表XX
    */
    public function GetLevelArray()
    {
        //$levelid1 = Utility::GetFormInt('id',$_POST);
        $objAreaGroupBLL = new AreaGroupBLL();
        $id = Utility::GetFormInt('id',$_POST);//区域组ID
        if($id >0 )
        {
           exit($objAreaGroupBLL->getAreaLevel2Json($id)); 
        }
        if($id <= 0)
            exit("[]");
            
    } 
    /**
     * @functional 区域组包含的地区范围
    */
    public function ShowAreaDetial()
    {
        $agroup_id = Utility::GetFormInt('id',$_GET);
        $objAreaGroupDetailBLL = new AreaGroupDetailBLL();
        $groupAreaHTML = $objAreaGroupDetailBLL->GetGroupAreaHtml($agroup_id);   //区域组已经关联区域的信息html
        $this->smarty->assign('groupAreaHTML',$groupAreaHTML);
        $this->smarty->display('System/AreaSet/ShowAreaDetial.tpl'); 
            
    } 
 }
 
 
 ?>