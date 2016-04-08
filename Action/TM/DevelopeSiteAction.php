<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：jicongling@126.com
 * 添加时间：2012-1-4
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/TMEMailBLL.php';
require_once __DIR__ . '/../../Class/BLL/TMNetOpeBLL.php';

class DevelopeSiteAction extends ActionBase
{
    private $strTitle = ''; //设置网页标题

    public function __construct()
    {

    }
    //展现建站模块管理
    public function showDevelopeSite()
    {
        // $strUrl = $this->getActionUrl('TM', 'DevelopeSite', 'showDevelopeSiteBody');
        $this->PageRightValidate("DevelopeSite",RightValue::v2);
        $this->smarty->assign('strTitle','建站模块管理');
        $agent_id = parent::getAgentId();
        $work_id = parent::getUserId(); //当前操作用户user_id
        $tMNetOpeBLL = new TMNetOpeBLL();
        $boundUserArray = "";
        $historyBoundUserArray = "";
        $boundUserArray = $tMNetOpeBLL->selectBoundUserArray($agent_id,$this->getFinanceUid()); //当前绑定账户信息
        $historyBoundUserArray = $tMNetOpeBLL->selectHistoryBoundUserArray($agent_id,$this->getFinanceUid());
        if ($boundUserArray != "")
        {
            $this->smarty->assign('boundUserArray',$boundUserArray);
        }
        $this->smarty->assign('work_id',$work_id);
        $this->smarty->assign('historyBoundUserArray',$historyBoundUserArray);
        $this->displayPage("TM/DevelopeSite.tpl");
    }

    //登录网营门户建站模块 跳转
    public function getLinkUrlToWYMH()
    {
        $this->PageRightValidate("DevelopeSite",RightValue::v2);
        $account = Utility::GetForm('account',$_REQUEST);
        if ($account == "")
        {
            die("0");
        }
        $agent_id = parent::getAgentId();
        $tMNetOpeBLL = new TMNetOpeBLL();
        //更新最近登录时间
        $rtn = $tMNetOpeBLL->updateSubAcccountTime($agent_id);
        if ($rtn = 0)
        {
            die("0");
        }
        $url = $tMNetOpeBLL->GetModelManageUrl($agent_id,$account);
        exit($url);
    }

    //代理商分配帐号管理网营门户建站模块
    public function netModelManageUserSubmit()
    {
        $this->PageRightValidate("DevelopeSite",RightValue::v4);
        $agent_id = parent::getAgentId();
        $user_id = Utility::GetFormInt('userid',$_REQUEST); //被分配人user_id
        $creat_id = parent::getUserId();
        $WY_Uname = "";
        $tMNetOpeBLL = new TMNetOpeBLL();
        $account = $tMNetOpeBLL->selectAccount($agent_id);
        if ($account == array())
        { //[该代理商第一次绑定管理模板帐号]+增加历史记录
            $rtn = $tMNetOpeBLL->CreateSubAccount($agent_id);
            if ($rtn['success'] == 1)
            {
                $WY_Uname = $rtn['account'];
            }
            else
            {
                die("绑定失败");
            }
            $rtm = $tMNetOpeBLL->insertSubAccount($agent_id,$user_id,$WY_Uname,$creat_id);
            $rtmm = $tMNetOpeBLL->insertSubHistory($agent_id,$user_id,$creat_id);
            if ($rtm > 0 && $rtmm > 0)
            {
                exit("0");
            }
            else
            {
                exit("绑定失败");
            }
        }
        else
        { //[该代理商已经绑定管理模板帐号] 更新一下绑定user_id即可+增加历史记录
            $rut = $tMNetOpeBLL->updateSubAcccount($user_id,$creat_id,$agent_id);
            $rutt = $tMNetOpeBLL->insertSubHistory($agent_id,$user_id,$creat_id);
            if ($rut > 0 && $rutt > 0)
            {
                exit("0");
            }
            else
            {
                exit("绑定失败");
            }
        }
    }
}

?>