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
require_once __DIR__.'/../../Class/BLL/RoleBLL.php';
require_once __DIR__.'/../../Class/BLL/UserRoleBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelGroupBLL.php';

class RoleAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 列表
    */
    public function Index()
    {
        return $this->RoleList(); 
    }
    
    /**
     * @functional 列表显示
     */
    public function RoleList()
    {        
        $this->PageRightValidate("RoleManager",RightValue::view);
        
        $this->smarty->assign('strTitle','角色管理'); 
        $iAgentID = $this->getAgentId(); 
        
        $objRoleBLL = new RoleBLL();
        $arrayRole = $objRoleBLL->AgentRoleList($iAgentID,$this->getFinanceNo());
        
        $this->smarty->assign('arrayRole',$arrayRole);
        $this->smarty->assign('iAgentID',$iAgentID);
        $this->displayPage('System/ModelManager/RoleList.tpl');         
    }
    
    /**
     * @functional 删除角色
    */
    public function RoleDel()
    {        
        $this->ExitWhenNoRight("RoleManager",RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id > 0)
        {
            //已有用户的不能删除
            $objUserRoleBLL = new UserRoleBLL();
            if($objUserRoleBLL->CanDel($id) == false)
                exit("此角色已使用，不能删除！");
                
            $objRoleBLL = new RoleBLL();
            if($objRoleBLL->deleteByID($id,$this->getUserId()) > 0)
               exit('{"success":true,"msg":"删除成功！"}');
            else
               exit('{"success":false,"msg":"删除出错！"}');
        }
    }
    
    /**
     * @functional 显示添加
    */
    public function RoleModify()
    {
        $this->PageRightValidate("RoleManager",RightValue::view);
        $this->smarty->assign('strTitle','添加角色');
        
        $id = Utility::GetFormInt('id',$_GET);
        $canChangeFinanceCheck = 1;
        $objRole = new RoleInfo();
        if($id > 0)
        {
            $this->smarty->assign('strTitle','角色信息');
            $objRoleBLL = new RoleBLL();            
            $objRole = $objRoleBLL->getModelByID($id);
            $objRole->strRoleRemark = str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"\r",$objRole->strRoleRemark);
            
            $objUserRoleBLL = new UserRoleBLL();
            if($objUserRoleBLL->CanDel($id)==false)
                $canChangeFinanceCheck = 0;
        }
        
        $strRight = "";
        //$strRight = $this->f_AgentRightJson($id);
        
        $this->smarty->assign('iRoleId',$id); 
        $this->smarty->assign('strRight',$strRight); 
        $this->smarty->assign('canChangeFinanceCheck',$canChangeFinanceCheck); 
        $this->smarty->assign('objRole',$objRole);        
        //exit($strRight);
        $this->smarty->display('System/ModelManager/RoleModify.tpl');         
    }
        
    
    /**
     * @functional 添加数据提交
    */
    public function RoleModifySubmit()
    {        
        $this->ExitWhenNoRight("RoleManager",RightValue::add);
        /*---------------输入数据验证---------begin--------------*/
        $strRoleName = Utility::GetForm('tbxRoleName',$_POST,8);    
        $id = Utility::GetFormInt('id',$_POST);     
        if($strRoleName == "")
            exit("请输入角色名！");
         
          //角色名唯一性验证
        $objRoleBLL = new RoleBLL();
        $sWhere = "role_id<>$id and role_name='".$strRoleName."' and (is_system=1 or agent_id=".$this->getAgentId().")";
        $arrayRole = $objRoleBLL->select("1",$sWhere,"");
       
        if(count($arrayRole)>0)
            exit("角色名已存在，请重新输入");
            
        $strRoleRemark = Utility::GetForm('tbxRemark',$_POST,128);            
        $strRoleRemark = str_replace(array("\r\n", "\n", "\r"),"<BR/>",$strRoleRemark);
        $strRoleRemark = str_replace("<BR/><BR/>","<br/>",$strRoleRemark);
        /*---------------输入数据验证---------end--------------*/
   
        $iSortIndex = Utility::GetFormInt('tbxSortIndex',$_POST);
        $objRoleInfo = new RoleInfo();
        
        $isFinance = Utility::GetFormInt('isFinance',$_POST);
        $objRoleInfo->iRoleId = $id;
        if($id > 0)
        {
            $objRoleInfo = $objRoleBLL->getModelByID($id,$this->getAgentId());            
            if($objRoleInfo == null)
                exit("未找到角色信息");
                
            $objUserRoleBLL = new UserRoleBLL(); 
            if($objUserRoleBLL->CanDel($id))//可以修改
                $objRoleInfo->iIsFinance = $isFinance;                
        }
        else
        {
            $objRoleInfo->iIsFinance = $isFinance;
        }
            
        $objRoleInfo->iAgentId = $this->getAgentId();
        $objRoleInfo->iSortIndex = $iSortIndex;
        $objRoleInfo->strRoleName = $strRoleName; 
        $objRoleInfo->strRoleRemark = $strRoleRemark;           
        $objRoleInfo->iIsLock = Utility::GetFormInt('chkIsLock',$_POST); 
                    
        $objRoleBLL = new RoleBLL(); 
        if($objRoleInfo->iRoleId <= 0)
        {
            $objRoleInfo->iFinanceUid = $this->getFinanceUid();
            $objRoleInfo->strFinanceNo = $this->getFinanceNo();
            $objRoleInfo->iCreateUid = $this->getUserId();   
            $id = $objRoleBLL->insert($objRoleInfo);
            if($id > 0)
            {
                exit('0');
            }
            else
                exit("添加出错！");
        }
        else
        {            
            $objRoleInfo->iUpdateUid = $this->getUserId();
            if($objRoleBLL->updateByID($objRoleInfo))
            {                
                exit('0');
            }
            else
                exit("修改出错！");
        }
    }
    
    /**
     * @functional 显示角色权限
     */
    public function RoleRightModify()
    {
        $this->PageRightValidate("RoleManager",RightValue::add);
        
        $this->smarty->assign('strTitle','角色权限');
        $id = Utility::GetFormInt('id',$_GET);
        $rootModelGroupNo = Utility::GetForm('modelGroup',$_GET);
       
        //$iIsAgent = 1;
        if($id > 0)
        {
            $roleBLL = new RoleBLL();
            $arrayRole = $roleBLL->select("role_name","role_id=".$id,"");
            if(isset($arrayRole)&& count($arrayRole))
            {
                $strRoleName = $arrayRole[0]["role_name"];
                $this->smarty->assign('strRoleName',$strRoleName);
            }  
                        
            $objModelGroupBLL = new ModelGroupBLL(); 
            $arryModelGroup = $objModelGroupBLL->GetRootModelGroup(1);
            
            $this->smarty->assign('id',$id);
            
            $this->smarty->assign('rootModelGroupNo',$rootModelGroupNo);
            $this->smarty->assign('arryModelGroup',$arryModelGroup);                             
        }
                
        $this->displayPage('System/ModelManager/RoleRightModify.tpl');  
    }
    
    public function RoleRightListBody()
    {
        $id = Utility::GetFormInt('id',$_POST);
        if($id <= 0)
            exit("");
        
        $rootModelGroupNo = Utility::GetForm('modelGroup',$_POST);
        if($rootModelGroupNo == "")
            $rootModelGroupNo = "10";
        
        $roleBLL = new RoleBLL();
        $objRoleInfo = $roleBLL->getModelByID($id);
        if($objRoleInfo == null)
            exit("");
            
        $arrayRoleRight = $roleBLL->selectRoleRight($rootModelGroupNo,$id,$this->getAgentId());
        
        //重复的模块组名和模块名把它赋值为空 begein
        $iRoleRightCount = count($arrayRoleRight);
        $oldModelGroupName = "";
        $oldModelName = "";
        
        $newModelGroupName = "";
        $newModelName = "";
        
        for($i = 0;$i < $iRoleRightCount; $i++)
        {
            $newModelGroupName = $arrayRoleRight[$i]["mgroup_name"];
            $newModelName = $arrayRoleRight[$i]["model_name"];
            
            if($i == 0)
            {
                $oldModelGroupName = $arrayRoleRight[$i]["mgroup_name"];
                $oldModelName = $arrayRoleRight[$i]["model_name"];                    
            }
            else
            {
                if($oldModelGroupName != $newModelGroupName)
                    $oldModelGroupName = $newModelGroupName;
                else
                    $arrayRoleRight[$i]["mgroup_name"] = "";
                    
                if($oldModelName != $newModelName)
                    $oldModelName = $newModelName;
                else
                    $arrayRoleRight[$i]["model_name"] = "";                      
            }             
        }
        //重复的模块组名和模块名把它赋值为空 end
        
        //print_r($arrayRoleRight);
        $this->smarty->assign('arrayRoleRight',$arrayRoleRight);
        $this->smarty->display('System/ModelManager/RoleRightModifyBody.tpl');  
    
    }
    
    /**
     * @functional 角色权限提交
     */
    public function RoleRightClick()
    {
        $this->ExitWhenNoRight("RoleManager",RightValue::add);
        $roleID = Utility::GetFormInt('id',$_POST);
        $rightID = Utility::GetFormInt('rightID',$_POST);
        if($roleID <= 0 || $rightID <= 0)
            exit("参数有误");  
        
        $bIsAdd = (strtolower(Utility::GetForm('add',$_POST)) == "true") ;     
        
        $objRoleBLL = new RoleBLL();        
        if($objRoleBLL->IsSystemRole($roleID) == true)
            exit("此角色为系统角色无法修改权限");  
              
        $roleRightBLL = new RoleRightBLL();        
        if($bIsAdd)
        {            
            if($roleRightBLL->insert($roleID,$rightID,$this->getUserId())>0)
                exit('0');
            else
                exit("分配出错！");    
        }
        else
        {
            if($roleRightBLL->delete($roleID,$rightID)>0)
                exit('0');
            else
                exit("取消出错！");    
        }
           
    }
        
    /**
     * @functional 角色权限分配
    */
    public function AddRoleRight()
    {
        $this->ExitWhenNoRight("RoleManager",RightValue::add);
        
        $roleID = Utility::GetFormInt('id',$_POST);
        if($roleID <= 0)
            exit("未取得角色ID！");
            
        $objRoleBLL = new RoleBLL();        
        if($objRoleBLL->IsSystemRole($roleID) == true)
            exit("此角色为系统角色无法修改权限");  
              
        $addRightIDs = Utility::GetForm('addRightIDs',$_POST);      
        if(strlen($addRightIDs) == 0)
            exit('0');  
            
        $roleRightBLL = new RoleRightBLL();
        $iAddCount = $roleRightBLL->AddRights($roleID,$addRightIDs,$this->getUserId());

        if(strlen($addRightIDs)>0 && $iAddCount>0)
            exit('0');
        else
            exit("批量分配出错！");
    }
    
    
    /**
     * @functional 角色权限取消
    */
    public function DelRoleRight()
    {
        $this->ExitWhenNoRight("RoleManager",RightValue::add);
        
        $roleID = Utility::GetFormInt('id',$_POST);
        if($roleID <= 0)
            exit("未取得角色ID！");
            
        $objRoleBLL = new RoleBLL();        
        if($objRoleBLL->IsSystemRole($roleID) == true)
            exit("此角色为系统角色无法修改权限");  
              
        $delRightIDs = Utility::GetForm('delRightIDs',$_POST);                   
        if(strlen($delRightIDs) == 0)
            exit('0');  
            
        $roleRightBLL = new RoleRightBLL();
        $iDelCount = $roleRightBLL->DelRights($roleID,$delRightIDs,$this->getUserId());
        if(strlen($delRightIDs) >0 && $iDelCount>0)
            exit('0');
        else
            exit("批量取消分配出错！");       
    }
    
    /**
     * @functional 角色权限Json
     */
    protected function f_AgentRightJson($id)
    {
        $roleBLL = new RoleBLL();
        $arrayRoleRight = $roleBLL->selectRoleRight("",$id,$this->getAgentId());
        
        $strJson = "[]";
        if(isset($arrayRoleRight) && count($arrayRoleRight))
        {            
            $strJson = "[";
            $oModelName = "";
            $nModelName = "";
            $strTemp = "";
            $iRightCount = count($arrayRoleRight);
            for($i=0;$i<$iRightCount;$i++)
            {
                $nModelName = $arrayRoleRight[$i]["model_name"];
                if($oModelName != $nModelName)
                {
                    $strJson .= "{modelName:'$nModelName',modelRight:[";
                    $oModelName = $nModelName;
                
                    while($i<$iRightCount && $oModelName == $arrayRoleRight[$i]['model_name'])
                    {                    
                        $strTemp .= "{rightName:'".$arrayRoleRight[$i]['right_name']."',rightID:'".$arrayRoleRight[$i]['right_id']."',is_check:'".$arrayRoleRight[$i]["is_check"]."'},";
                        
                        $i++;
                    }
                    
                    $strJson .= substr($strTemp,0,strlen($strTemp)-1)."]},";        
                    --$i;                
                    $strTemp = "";
                }
                
            }
            
            if($iRightCount>1)
                $strJson = substr($strJson,0,strlen($strJson)-1);
                
            $strJson .= ']';
        }
        
        return $strJson;//json_encode($arrayRoleRight);
    }
} 
?>