<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：拜访统计
 * 创建人：xdd
 * 添加时间：2011-11-24 12:38:34
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/VisitAppointBLL.php';
require_once __DIR__.'/../../Class/Model/VisitAppointInfo.php';
require_once __DIR__.'/../../Class/BLL/VisitNoteBLL.php';
require_once __DIR__.'/../../Class/Model/VisitNoteInfo.php';

require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../../Class/Model/AgentContactInfo.php';

require_once __DIR__ . '/../Common/PHPExcel.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel2007.php';
require_once __DIR__ . '/../Common/PHPExcel/Writer/Excel5.php';


class VisitCountAction extends ActionBase
{
    
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->AppointList();
    }
        
    /**
     * @functional 拜访统计列表
    */
    public function VisitCountList()
    {
        $this->PageRightValidate("VisitCount",RightValue::view);
        $id = $this->getUserId();
        
        $this->smarty->assign('id',$id);
        $create_timee = date("Y-m-d",time());
        $create_timeb = substr($create_timee,0,8);
        if($create_timeb != "")
            $create_timeb .= "01";
        //=====================================
        $uid = $this->getUserId();
        $sWhere = "";
        $objVisitNoteBLL = new VisitNoteBLL();
        $sOrder = Utility::GetForm("sortField", $_GET);
        $u_name = Utility::GetForm("u_name", $_GET);
        $set_create_timeb = Utility::GetForm("create_timeb", $_GET);
        $set_create_timee = Utility::GetForm("create_timee", $_GET);
        
        $arrCompos = $objVisitNoteBLL->VisitCountList($set_create_timeb,$set_create_timee,$u_name);
        $this->smarty->assign('uid',$uid);
        
        //==========================================
        
        $this->smarty->assign('arrayData',$arrCompos);
        $this->smarty->assign('u_name',$u_name);
        $this->displayPage('Agent/WorkManagement/VisitCountList.tpl');
    }
   
}