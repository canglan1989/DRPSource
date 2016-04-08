<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：角色管理
 * 创建人：wzx
 * 添加时间：2011-7-13 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/PositionBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelGroupBLL.php';

class PositionAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 列表
    */
    public function Index()
    {
        return $this->PositionList(); 
    }
    
    /**
     * @functional 列表显示
     */
    public function PositionList()
    {
        $this->PageRightValidate("PositionList",RightValue::view);
        $this->smarty->assign('strTitle','职位列表');
        //exit('职位列表');
        $strUrl = $this->getActionUrl('System','Position','PositionListBody'); 
        
        $this->smarty->assign('strUrl',$strUrl);
        $this->displayPage('System/ModelManager/PositionList.tpl');               
    }
    
    /**
     * @functional 列表表体数据显示
     */
    public function PositionListBody()
    {         
        $this->ExitWhenNoRight("PositionList",RightValue::view);
        
        $strCompanyNo = Utility::GetForm("cbCompanyName",$_GET);
        $iDeptID = Utility::GetFormInt("cbDeptName",$_GET);        
        $strPostName = Utility::GetForm("tbxPosionName",$_GET);
        
        $sWhere = "";
        if($strCompanyNo != "-100")
            $sWhere .= " and hr_company.dept_no ='$strCompanyNo'";
            
        if($iDeptID > 0)
            $sWhere .= " and hr_department.dept_id = $iDeptID";
            
        if($strPostName != "")
            $sWhere .= " and hr_position.post_name like '%$strPostName%'";
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        
        $objPositionBLL = new PositionBLL();
        $arrPageList = $this->getPageList($objPositionBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayPosition',$arrPageList['list']);
                
        $this->smarty->display('System/ModelManager/PositionListBody.tpl'); 
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    }
    
    /**
     * @functional 职位权限列表
     */
    public function PositionRightModify()
    { 
        $this->PageRightValidate("PositionRightList",RightValue::view);
        $this->smarty->assign('strTitle','职位权限');
        $id = Utility::GetFormInt('id',$_GET);
        
       
        if($id > 0)
        {
            $positionBLL = new PositionBLL();
            $arrayPosition = $positionBLL->getPositionInfo($id);//
            if(isset($arrayPosition)&& count($arrayPosition))
            {
                $this->smarty->assign('arrayPosition',$arrayPosition);
            }              
            $objModelGroupBLL = new ModelGroupBLL(); 
            $arryModelGroup = $objModelGroupBLL->GetRootModelGroup(0);//
        
            $this->smarty->assign('id',$id);
            $this->smarty->assign('arryModelGroup',$arryModelGroup);                             
        }
       
        $this->displayPage('System/ModelManager/PositionRightModify.tpl');  
    }
    public function PositionRightModifyBody()
    {
            $id = Utility::GetFormInt('id',$_POST);
            $rootModelGroupNo = Utility::GetForm('modelGroup',$_POST);
            $objModelGroupBLL = new ModelGroupBLL(); 
            $arryModelGroup = $objModelGroupBLL->GetRootModelGroup(0);//
            if($rootModelGroupNo == "")
                $rootModelGroupNo = $arryModelGroup[0]["mgroup_no"];
            
            $positionBLL = new PositionBLL();
            $arrayPositionRight = $positionBLL->selectPositionRight($rootModelGroupNo,$id);
            //重复的模块组名和模块名把它赋值为空 begein
            $iPositionRightCount = count($arrayPositionRight);
            $oldModelGroupName = "";
            $oldModelName = "";
            
            $newModelGroupName = "";
            $newModelName = "";
            
            for($i = 0;$i < $iPositionRightCount; $i++)
            {
                $newModelGroupName = $arrayPositionRight[$i]["mgroup_name"];
                $newModelName = $arrayPositionRight[$i]["model_name"];
                
                if($i == 0)
                {
                    $oldModelGroupName = $arrayPositionRight[$i]["mgroup_name"];
                    $oldModelName = $arrayPositionRight[$i]["model_name"];                    
                }
                else
                {
                    if($oldModelGroupName != $newModelGroupName)
                        $oldModelGroupName = $newModelGroupName;
                    else
                        $arrayPositionRight[$i]["mgroup_name"] = "";
                        
                    if($oldModelName != $newModelName)
                        $oldModelName = $newModelName;
                    else
                        $arrayPositionRight[$i]["model_name"] = "";                      
                }  
            } 
             
            $this->smarty->assign('arrayPositionRight',$arrayPositionRight);  
             $this->smarty->display('System/ModelManager/PositionRightModifyBody.tpl');         
    }
    
    /**
     * @functional 职位权限添加或删除
     */
    public function PositionRightClick()
    {
        $this->ExitWhenNoRight("PositionRightList",RightValue::v4);
        
        $positionID = Utility::GetFormInt('id',$_POST); 
        $rightID = Utility::GetFormInt('rightID',$_POST);  
            
        if($positionID <= 0)
            exit("未取得职位ID");
            
        if($rightID <= 0)
            exit("未取得权限ID");
        
        $bIsAdd = (strtolower(Utility::GetForm('add',$_POST)) == "true") ;       
        
        $positionBLL = new PositionBLL();
        
        if($positionBLL->AddRight($positionID,$rightID,$bIsAdd,$this->getUserId())>0)
            exit('0');
        else
            exit(($bIsAdd ? "添加":"修改")."出错！");
    }
    
    
    /**
     * @functional 职位权限批量添加
     */
    public function PositionRightSubmit()
    {
        $this->ExitWhenNoRight("PositionRightList",RightValue::v4);
        $positionID = Utility::GetFormInt('id',$_POST);
        if($positionID <= 0)
            exit("未取得职位ID！");
            
        $addRightIDs = Utility::GetForm('addRightIDs',$_POST);
      
        if(strlen($addRightIDs) == 0)
            exit('0');  
            
        $positionBLL = new PositionBLL();
        $iAddCount = $positionBLL->AddRights($positionID,$addRightIDs,$this->getUserId());

        if(strlen($addRightIDs)>0 && $iAddCount>0)
            exit('0');
        else
            exit("批量分配出错！");        
    }
    
    /**
     * @functional 职位权限批量删除
     */
    public function DelPostRight()
    {
        $this->ExitWhenNoRight("PositionRightList",RightValue::v4);
        $positionID = Utility::GetFormInt('id',$_POST);
        if($positionID <= 0)
            exit("未取得职位ID！");
            
        $delRightIDs = Utility::GetForm('delRightIDs',$_POST);
        if(strlen($delRightIDs) == 0)
            exit('0');  
            
        $positionBLL = new PositionBLL();
        $iDelCount = $positionBLL->DelRights($positionID,$delRightIDs,$this->getUserId());
        if(strlen($delRightIDs) >0 && $iDelCount>0)
            exit('0');
        else
            exit("批量取消分配出错！");       
    }
} 
?>