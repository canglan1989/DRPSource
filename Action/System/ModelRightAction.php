<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：模块权限管理
 * 创建人：wzx
 * 添加时间：2011-7-11 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ModelRightBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelBLL.php';

class ModelRightAction extends ActionBase
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
        return $this->ModelRightList(); 
    }
    
    /**
     * @functional 显示列表
    */
    public function ModelRightList()
    {
        $this->PageRightValidate("ModelGroupList",RightValue::view);
        
        $this->smarty->assign('strTitle','模块权限列表'); 
        $modelID = Utility::GetFormInt('mid',$_GET); 
        $modelName = "";
        $modelBLL = new ModelBLL();
        $objModelInfo = $modelBLL->getModelByID($modelID);
        /*$arrayModel = $modelBLL->select("model_name","model_id=".$modelID,"");
        if(isset($arrayModel) && count($arrayModel)>0)
        {
            $modelName = $arrayModel[0]["model_name"];
        }
        */
        $sWhere = " model_id=".$modelID;

        $objModelRightBLL = new ModelRightBLL();
        $arrayModelRight = $objModelRightBLL->select("*",$sWhere,"");
        //print_r($arrayModelRight);
        $this->smarty->assign('isDepEvn',$this->isDepEvn);
        $this->smarty->assign('arrayModelRight',$arrayModelRight);
        $this->smarty->assign('objModelInfo',$objModelInfo);
        //$this->smarty->assign('modelName',$modelName);
        $this->smarty->assign('modelID',$modelID);
        $this->displayPage('System/ModelManager/ModelRightList.tpl');         
    }
    
    /**
     * @functional 删除模块权限
    */
    public function ModelRightDel()
    {        
        $this->ExitWhenNoRight("ModelGroupList",RightValue::del);
        $id = Utility::GetFormInt('id',$_GET);
        if($id != 0)
        {
            $objModelRightBLL = new ModelRightBLL();
            if($objModelRightBLL->deleteByID($id,$this->getUserId()) > 0)
               exit('{"success":true,"msg":"删除成功！"}');
            else
               exit('{"success":false,"msg":"删除出错！"}');
        }
    }
    
    /**
     * @functional 显示添加
    */
    public function ModelRightModify()
    {
        $this->PageRightValidate("ModelGroupList",RightValue::add);
        
        $this->smarty->assign('strTitle','添加模块权限');
        
        $id = Utility::GetFormInt('id',$_GET);
        $modelID = Utility::GetFormInt('mid',$_GET);
        
        $objModelRight = new ModelRightInfo();
        $objModelRightBLL = new ModelRightBLL();
        if($id != 0)
        {
            $this->smarty->assign('strTitle','编辑模块权限');
            $objModelRight = $objModelRightBLL->getModelByID($id);
            $modelID = $objModelRight->iModelId;
        }
        
        $objModelBLL = new ModelBLL();
        $objModelInfo = $objModelBLL->getModelByID($modelID);
        /*------------------权限值-----------------begin-----------*/
        $arrayRight = array();
        
        for($i=0;$i<16;$i++)
        {
            $arrayRight[$i.""] = pow(2,$i+1); 
        }
        
        $arrayRight[0] = $arrayRight[0]."  view";
        $arrayRight[1] = $arrayRight[1]."  add";
        $arrayRight[2] = $arrayRight[2]."  del";
        $arrayRight[3] = $arrayRight[3]."  edit";        
        $arrayRight[4] = $arrayRight[4]."  check";
        
        $arrayRight[13] = $arrayRight[13]."  viewPersonal";
        $arrayRight[14] = $arrayRight[14]."  viewDept";
        $arrayRight[15] = $arrayRight[15]."  viewCompany";
        
        
        $arrayModelRight = $objModelRightBLL->select("right_value","model_id=$modelID and right_id<>$id and is_del = 0","");
       
        if(isset($arrayModelRight) && count($arrayModelRight)>0)
        {
            $iModelRightCount = count($arrayModelRight);
            $strRights = ",2,4,8,16,32,64,28,256,512,1024,2048,4096,8192,16384,32768,65536,";
            //
            for($i=0;$i<$iModelRightCount;$i++)
            {
                $iIndex = count($arrayRight);
                $strTemp = "";
                for($j=0;$j<$iIndex;$j++)
                {
                    $strTemp = explode(" ",$arrayRight[$j]);
                    $strTemp = $strTemp[0];
                    if($strTemp == $arrayModelRight[$i]["right_value"])
                    {
                        array_splice($arrayRight,$j,1);
                        break;
                    }
                }             
            }
        }
        /*------------------权限值-----------------end--------------*/
        $this->smarty->assign('id',$id); 
        $this->smarty->assign('modelID',$modelID); 
        $this->smarty->assign('arrayRight',$arrayRight); 
        $this->smarty->assign('objModelInfo',$objModelInfo); 
        $this->smarty->assign('objModelRight',$objModelRight);        
        $this->displayPage('System/ModelManager/ModelRightModify.tpl');
    }
        
    
    /**
     * @functional 添加数据提交
    */
    public function ModelRightModifySubmit()
    {        
        $this->ExitWhenNoRight("ModelGroupList",RightValue::add);
        /*---------------输入数据验证---------begin--------------*/
        $strRightName = Utility::GetForm('tbxRightName',$_POST,16);         
        $id = Utility::GetFormInt('id',$_POST);
        $modelID = Utility::GetFormInt('mid',$_GET);
        $iRightValue = Utility::GetFormInt('cbRightValue',$_POST);
        
        if($strRightName == "")
            exit("请输入权限名！");
        
        //模块权限值唯一性验证        
        $objModelRightBLL = new ModelRightBLL();
        if(count($objModelRightBLL->select("1","right_id <> $id and model_id=$modelID and right_value = $iRightValue ",""))>0)
            exit("该权限值已分配！");
        /*---------------输入数据验证---------end--------------*/

        $objModelRight = new ModelRightInfo();
        
        $objModelRight->iRightId = $id;        
        $objModelRight->strRightName = $strRightName;     
        $objModelRight->iRightValue  = $iRightValue;             
        $objModelRight->strRightRemark = Utility::GetForm('tbxRemark',$_POST,32);
        $objModelRight->iModelId = $modelID; 
        $objModelRight->iIsLock = Utility::GetFormInt('chkIsLock',$_POST); 
        
        
        if($objModelRight->iRightId <= 0)
        {
            $objModelRight->iCreateUid = $this->getUserId();            
            if($objModelRightBLL->insert($objModelRight) > 0)
                exit('0');
            else
                exit("添加出错！");
        }
        else
        {            
            $objModelRight->iUpdateUid = $this->getUserId();
            if($objModelRightBLL->updateByID($objModelRight))
                exit('0');
            else
                exit("修改出错！");
        }
    }
} 
?>