<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述： 代理商季度任务
 * 创建人：wzx
 * 添加时间：2011-10-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/QuarterlyTaskActionBase.php';

class QuarterlyTaskAction extends QuarterlyTaskActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->QuarterlyTaskList();
    }  
    
    /**
     * @functional 代理商季度任务管理
    */
    public function QuarterlyTaskList()
    {
        $this->PageRightValidate("AgentQuarterlyTaskList",Rightvalue::view);
        parent::QuarterlyTaskList();
        $this->smarty->assign('QuarterlyTaskListBody',"/?d=Agent&c=QuarterlyTask&a=QuarterlyTaskListBody");
        $this->smarty->display('Agent/QuarterlyTask/QuarterlyTaskList.tpl'); 
    }
    
    
    /**
     * @functional 代理商季度任务管理数据
    */
    public function QuarterlyTaskListBody()
    {
        $this->ExitWhenNoRight("AgentQuarterlyTaskList",Rightvalue::view);
        $dataDisplayPath = 'Agent/QuarterlyTask/QuarterlyTaskListBody.tpl';
        parent::f_QuarterlyTaskListBody($dataDisplayPath);
    }
    
    
    /**
     * @functional 显示季度任务添加
    */
    public function QuarterlyTaskModify()
    {        
        $this->PageRightValidate("AgentQuarterlyTaskList",Rightvalue::add);
        parent::QuarterlyTaskModify();
    }
       
    
    /**
     * @functional 季度任务添加数据提交
    */
    public function QuarterlyTaskModifySubmit()
    {
        $this->ExitWhenNoRight("AgentQuarterlyTaskList",Rightvalue::add);
        parent::QuarterlyTaskModifySubmit();        
    }
    
    /**
     * @functional 季度任务删除
    */
    public function DelQuarterlyTask()
    {        
        $this->ExitWhenNoRight("AgentQuarterlyTaskList",RightValue::del);  
        parent::DelQuarterlyTask(); 
    }
    
    
    
}

?>