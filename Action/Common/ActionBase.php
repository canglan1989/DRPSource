<?php

require_once __DIR__ . '/Smarty/Smarty.class.php';
require_once __DIR__ . '/../../Class/Common/DALCache.php';
require_once __DIR__ . '/../../Config/RightValue.php';
require_once __DIR__ . '/../../Class/BLL/OperateBLL.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__.'/../../Class/BLL/ModelCachedBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerAgentBLL.php';

class ActionBase
{
    //页面访问相关参数
    protected $strDirectoryName = 'Index';
    protected $strClassName = 'Index';
    protected $strActionName = 'index';
    //系统配置
    protected $arrSysConfig = '';
    //SESSION
    protected $strDefaultSessionName = '';
    protected $strNewSessionName = '';
    //模板对象
    protected $smarty = NULL;
    
    //展现ajax分页时的 smarty页面
    public function showPageSmarty($arrPageList, $pagePath)
    {
	$this->smarty->assign('arrayData', $arrPageList['list']);
	$this->smarty->display($pagePath);
    echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>");     
    }

    /**
     * @functional 设置系统配置
     * @param array $arrSysConfig	系统配置
     */
    public function setSysConfig($arrSysConfig)
    {
	$this->arrSysConfig = $arrSysConfig;
    }

    /**
     * @functional 设置目录名
     * @param string $strDirectoryName 目录名
     */
    public function setDirectoryName($strDirectoryName)
    {
	$this->strDirectoryName = $strDirectoryName;
    }

    /**
     * @functional 设置类名
     * @param string $strClassName 类名
     */
    public function setClassName($strClassName)
    {
	$this->strClassName = $strClassName;
    }

    /**
     * @functional 设置Action名
     * @param string $strActionName Action名
     */
    public function setActionName($strActionName)
    {
	   $this->strActionName = $strActionName;
    }
    
    /**
     * @functional 添加用户页面访问和操作日志
	 * @param string $strLogName 模块名
	 * @param int $iRightValue 权限值
     */
    protected function OpeateLog($strLogName,$iRightValue)
    {
    	   $objOperateBLL  = new OperateBLL();
           $objOperateInfo = new OperateInfo();
           
           $objOperateInfo->strLogIp    = Utility::getIP();
           $objOperateInfo->strCreateTime = Utility::Now();
           $objOperateInfo->iCreateUid  = $this->getUserId();
           $objOperateInfo->strLogPage  = Utility::curPageURL();
           $objOperateInfo->strLogName  = $strLogName;
           $objOperateInfo->iLogLevel = $iRightValue;
           $objOperateBLL->insert($objOperateInfo);
    }
    
    /**
     * @functional 是否具有权限
     * @param string $strModelName 模块名
     * @param int $iRightValue 权限值
     * @return bool true是 false 否
     */
    protected function HaveRight($strModelName, $iRightValue,$bRegPath = false)
    {        
    	if (!is_int($iRightValue) || $strModelName == "")
    	    return false;
                    
        $objSession = $this->getSessionContent();
    	$arrayRight = $objSession->get($this->arrSysConfig['SESSION_INFO']['USER_RIGHT']);   
            
    	if (array_key_exists($strModelName, $arrayRight))
    	{
    	    $iRight = $arrayRight[$strModelName];
    	    settype($iRight, "integer");
    	    settype($iRightValue, "integer");
    	    $iRight = $iRight & $iRightValue;
            
    	    settype($iRight, "integer");
    	    if ($iRight > 0)
            {                
                if($bRegPath == true)
                {
                    $strPath = "";
                    $strTitle = "";
                    $this->GetModelPathByModelCode($strModelName,$strPath,$strTitle);            
                    $this->smarty->assign('strTitle',$strTitle);
                    $this->smarty->assign('strPath',$strPath);
                }
                return true;
            }
    		  
    	}
        
    	return false;
    }
        
    /**
     * @functional 是否具有权限
     * @param string $strModelName 模块名
     * @param int $iRightValue 权限值
     * @return bool true是 false 否
     */
    protected function ExitWhenNoRight($strModelName, $iRightValue)
    {   
        //添加操作日志  
        $this->OpeateLog($strModelName,$iRightValue); 
        
        if($this->HaveRight($strModelName, $iRightValue) == false)
            exit("您没有此操作权限！");
    }
    
    /**
     * @functional 出错 退出
     */
    protected function ExitByError($erroMsg)
    {
        $arrayData = array("success"=>false,"msg"=>"$erroMsg");
        exit(json_encode($arrayData));
    }


    /**
     * @functional 成功 退出
     */
    protected function ExitBySuccess($successMsg,$url='')
    {
        $arrayData = array("success"=>true,"msg"=>"$successMsg","url"=>$url);
        exit(json_encode($arrayData));
    }

    /**
     * @functional 当前页面的访问验证 无权访问将直接跳转
     * @param string $strModelName 模块名
     * @param int $iRightValue 权限值
     * @param bool $bRegPath 注册面包线路径 和标题
     */
    protected function PageRightValidate($strModelName, $iRightValue,$bRegPath = true)
    {       
        //添加操作日志  
        $this->OpeateLog($strModelName,$iRightValue); 
    	if (!$this->HaveRight($strModelName, $iRightValue,$bRegPath))
    	{
    	    $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
    	}        
    }
    
    /**
     * @functional 取当前页面的标题和面包线路径
     * @param string $strModelName 模块名
     * @param string $strPathName 面包线路径
     * @param string $strTitle 标题
     */
    protected function GetModelPathByModelCode($strModelName,&$strPath,&$strTitle)
    {
        $objModelCachedBLL = new ModelCachedBLL();
        $iIsAgent = $this->getAgentId() > 0 ? 1: 0;
        $objModelCachedBLL->GetModelPathByModelCode($strModelName,$iIsAgent,$strPath,$strTitle);
    }
    
    /**
     * @functional 是否有客户信息查看权限
     */
    protected function CanViewTheCustomerInfo($customerID)
    {        
        if($customerID <= 0)
            return ;
            
        if($this->isAgentUser())
        {
            $objCustomerAgentBLL = new CustomerAgentBLL();
            $arrayData = $objCustomerAgentBLL->select("customer_id","customer_id=$customerID and agent_id=".$this->getAgentId(),"");
            if(!(isset($arrayData)&& count($arrayData)>0))
                exit("您无权操作该客户信息");
        }        
    }
    
    /**
     * @functional Action初始化
     */
    final function init()
    {
        //print_r("init");
    	$this->strDefaultSessionName = $this->arrSysConfig['SESSION']['RAW_SESSION_NAME'];
    	$this->strNewSessionName = $this->arrSysConfig['SESSION']['NEW_SESSION_NAME'];
    
    	//初始化SMARTY
    	$this->smarty = new Smarty();
    	//判断是否WAP登陆
    	if (Utility::checkWapLogin())
    	{
    		$this->smarty->template_dir = $this->arrSysConfig['WAPTEMPLATE']['TEMPLATE_DIR'];
    		$this->smarty->compile_dir = $this->arrSysConfig['WAPTEMPLATE']['COMPILE_DIR'];			
    	}
    	else
        {
        	$this->smarty->template_dir = $this->arrSysConfig['TEMPLATE']['TEMPLATE_DIR'];
        	$this->smarty->compile_dir = $this->arrSysConfig['TEMPLATE']['COMPILE_DIR'];
        }
    	$this->smarty->caching = false;
        
    	$this->smarty->assign('CSS', $this->arrSysConfig['RESOURCE_PATH']['CSS_PATH']);
    	$this->smarty->assign('img', $this->arrSysConfig['RESOURCE_PATH']['IMAGE_PATH']);
    	$this->smarty->assign('JS', $this->arrSysConfig['RESOURCE_PATH']['JS_PATH']);
    	$this->smarty->assign('UPLOAD', $this->arrSysConfig['RESOURCE_PATH']['UPLOAD_PATH']);
    	$this->smarty->assign('CURRENTCLASS', strtolower(str_replace('Action', '', $this->strClassName)));
    	$this->smarty->assign('CURRENTACTION', strtolower($this->strActionName));
    
    
    	//注册SMARTY方法
    	$this->smarty->register_function('au', 'getSmartyActionUrl');
    	$this->smarty->register_function('sdrclass', 'SetSingleDoubleRowClass');
    	$this->smarty->register_function('pv', 'getParamValidateKey');
    	$this->smarty->register_function('get_wy_url', 'getWYURL');
    }

    /**
     * @functional 显示页面
     * @param $strTplPath		要显示的模板的地址
     * @param $arrAssigns		给要显示的模板赋值,eg: array('key'=>'value')
     * @param $strMasterName	母板的地址，默认为Master.tpl
     */
    protected function displayPage($strTplPath, array $arrAssigns =null, $strMasterName='Master.tpl')
    {
    	//$this->smarty->assign('strContentTPL', $strTplPath);
    
    	//判断是否有类别参数
    	$bHasCateParam = false;
    	if (isset($arrAssigns))
    	{
    	    foreach ($arrAssigns as $strSmartName => $mixAssignValue)
    	    {
        		if ($strSmartName == 'strCate')
        		{
        		    //已经设置了类别参数
        		    $bHasCateParam = true;
        		}
        		$this->smarty->assign($strSmartName, $mixAssignValue);
    	    }
    	}
    	//如果没有设置类别参数，根据目录加不同的类别参数
    	if (!$bHasCateParam)
    	{
    	    $this->smarty->assign('strCate', $this->strDirectoryName);
    	    $this->smarty->assign('strClass', $this->strClassName);
    	    $this->smarty->assign('strAction', $this->strActionName);
    	}
    
    	$this->smarty->display($strTplPath);
    }
    
    /**
     * @functional 读取分页数据
     * @param mixed $objBll 类对象
     * @param string $fields 字段
     * @param string $where 条件
     * @param string $strOrder 排序
     * @param integer $iPageSize 一页几条
     * @return array 结果集,页数,总记录数
     */
    protected function getPageList($objBll, $strFields='*', $strWhere='', $strOrder='', $iPageSize=15, $strParam='')
    {
    	$iPageIndex = Utility::GetFormInt('page',$_GET);
        if($iPageIndex <= 0)
            $iPageIndex = 1;
            
    	$iPageSize = (intval($iPageSize) <= 0) ? 15 : intval($iPageSize);
        if($strOrder == "" && !empty($_REQUEST['sortField']))
        {
            $strOrder = Utility::GetForm('sortField',$_GET);
        }
        
    	$iRecordCount = 0;
    	if ($strParam == '')
    	{
    	    $arrPageData = $objBll->selectPaged($iPageIndex, $iPageSize, $strFields, $strWhere, $strOrder, $iRecordCount);
    	}
    	else
    	{
    	    $arrPageData = $objBll->selectPaged($iPageIndex, $iPageSize, $strFields, $strWhere, $strOrder, $iRecordCount, $strParam);
    	}
    
    	//$this->smarty->assign('record_count',    $iCount);
    	//$this->smarty->assign('page_size',      $iPageSize);
    	$iTotalPage = ceil($iRecordCount / $iPageSize);
    	if ($iTotalPage == 0)
    	    $iTotalPage = 1;
    	// $this->smarty->assign('curPage',$iPageIndex);
    	$this->smarty->assign('totalPage', $iTotalPage);
    
    	return array('list' => $arrPageData, 'pageSize' => $iPageSize, 'recordCount' => $iRecordCount, 'totalPage' => $iTotalPage);
    }
    
    /**
     * @functional 读取分页数据
     * @param mixed $objBll 类对象
     * @param mixed $objMethod 类对象方法
     * @param string $fields 字段
     * @param string $where 条件
     * @param string $strOrder 排序
     * @param integer $iPageSize 一页几条
     * @return array 结果集,页数,总记录数
     */
    protected function getPageList2($objBll, $objMethod, $strFields='*', $strWhere='', $strOrder='', $iPageSize=15, $strParam='')
    {
    	$iPageIndex = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
    	$iPageSize = (intval($iPageSize) <= 0) ? 15 : intval($iPageSize);
         
        if($strOrder == "" && !empty($_REQUEST['sortField']))
        {
            $strOrder = $_REQUEST['sortField'];
        }
        
    	$iRecordCount = 0;
    	if ($strParam == '')
    	{
    	    $arrPageData = $objBll->$objMethod($iPageIndex, $iPageSize, $strFields, $strWhere, $strOrder, $iRecordCount);
    	}
    	else
    	{
    	    $arrPageData = $objBll->$objMethod($iPageIndex, $iPageSize, $strFields, $strWhere, $strOrder, $iRecordCount, $strParam);
    	}
        if(empty($iRecordCount))
            $iRecordCount = 0;
    	//$this->smarty->assign('record_count',    $iCount);
    	//$this->smarty->assign('page_size',      $iPageSize);
    	$iTotalPage = ceil($iRecordCount / $iPageSize);
    	if ($iTotalPage == 0)
    	    $iTotalPage = 1;
    	// $this->smarty->assign('curPage',$iPageIndex);
    	$this->smarty->assign('totalPage', $iTotalPage);
    
    	return array('list' => $arrPageData, 'pageSize' => $iPageSize, 'recordCount' => $iRecordCount, 'totalPage' => $iTotalPage);
    }

    /**
     * @functional 输出JS内容到页面
     * @param string $strMsg		要输出的JSON数据
     * @param string $strStatus		输出的状态("S_FAIL":失败，"S_OK":成功)
     */
    protected function echoJS2Page($strMsg, $strStatus='S_OK')
    {
    	header('Content-Type: application/json;charset=UTF-8');
        exit('{"stat":"' . $strStatus . '","rst":' . $strMsg . '}');
    }


    /**
     * @functional 对参数特殊字符过滤
     * @param mixed $str
     * @return
     */
    public function encodePara($str)
    {
	   return htmlspecialchars($str, ENT_QUOTES);
    }

    /**
     * @functional 返回URL
     * @param string $d 目录名
     * @param string $c 类名
     * @param string $a 方法名
     * @param string $p 其它参数
     * @return string URL
     */
    public function getActionUrl($d, $c, $a, $p = '')
    {
	   return getSmartyActionUrl(array('d' => $d, 'c' => $c, 'a' => $a, 'p' => $p));
    }

    /**
     * @functional 返回当前时间，或格式化时间
     * @param $timestamp int 时间戳
     * @return string
     */
    public function getDateTime($format='Y-m-d H:i:s', $timestamp='')
    {
    	if ($timestamp == '')
    	    $timestamp = time();
    	return date($format, $timestamp);
    }

    /**
     * @functional 取用户ID
     * 
     * @return string
     */
    public function getUserId()
    {
	   $objSession = $this->getSessionContent();
	   return $objSession->get($this->arrSysConfig['SESSION_INFO']['USER_ID']);
    }
    
    /**
     * 获取后台部门路径
     * @return type 
     */
    public function getDeptNoBack(){
        include_once __DIR__ . '/../../Class/BLL/DepartmentBLL.php';
        $objDepartmentBLL = new DepartmentBLL();
        $arrUserInfo = $objDepartmentBLL->getDeptNoByUserId($this->getUserId());
        if($arrUserInfo){
            if($arrUserInfo[0]['agent_id'] == 0){
                return $arrUserInfo[0]['dept_no'];
            }
        }
        return false;
    }

    /**
     * @functional 是否为代理商用户
     * 
     * @return bool
     */
    public function isAgentUser()
    {
	   return $this->getAgentID() > 0 ? true : false;
    }

    /**
     * @functional 代理商ID
     * 
     * @return int
     */
    public function getAgentId()
    {
    	$objSession = $this->getSessionContent();
        $userID = (int)$objSession->get($this->arrSysConfig['SESSION_INFO']['USER_ID']);;
        if($userID <= 0)
            exit("未法请求！");
            
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['AGENT_ID']);
    }

    /**
     * @functional 取用户权限
     *
     * @return string
     */
    public function getSelfUserRight()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['USER_RIGHT']);
    }

    /**
     * @functional 代理商用户编号
     * 
     * @return string
     */
    public function getUserNo()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['USER_NO']);
    }

    /**
     * @functional 取用登陆户名
     */
    public function getUserName()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['USER_NAME']);
    }
    
   /**
     * @functional 代理商编号
     * 
     * @return string
     */
    public function getAgentNo()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['AGENT_NO']);
    }

    /**
     * @functional 代理商名称
     */
    public function getAgentName()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['AGENT_NAME']);
    }

    /**
     * @functional 取员工ID
     */
    public function getEmployeeId()
    {
	$objSession = $this->getSessionContent();
	return $objSession->get($this->arrSysConfig['SESSION_INFO']['E_ID']);
    }

    /**
     * @functional 取用户中文名 即 员工名
     */
    public function getUserCNName()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['E_NAME']);
    }


    public function getIsFinance()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['IS_FINANACE']);
    }
    
    public function getFinanceUid()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['FINANCE_UID']);
    }
    
    public function getFinanceNo()
    {
    	$objSession = $this->getSessionContent();
    	return $objSession->get($this->arrSysConfig['SESSION_INFO']['FINANCE_NO']);
    }
    
    /**
     * @functional 取得session内容
     */
    public function getSessionContent()
    {
        if($this->arrSysConfig == "")
        {
            $arrSysConfig = unserialize(SYS_CONFIG);
            $this->arrSysConfig = $arrSysConfig;
        }
    	
    	$objSession = new Session($this->strDefaultSessionName);
    	return $objSession;
    }

    /**
     * @functional 防止sql注入
     * @param $sql_str
     */
    public function inject_check($sql_str)
    {
	return preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|order|by|and 1\=|union|into|load_file|outfile/i', $sql_str);
    }
}

/**
 * @functional smarty注册方法,设置URL
 * 
 * @param mixed $params
 * @return
 */
function getSmartyActionUrl($params)
{
    $strUrl = '/?';
    if (isset($params['d']) && !empty($params['d']))
    {
	$strUrl .= "d={$params['d']}&";
    }
    if (isset($params['c']) && !empty($params['c']))
    {
	$strUrl .= "c={$params['c']}&";
    }
    if (isset($params['a']) && !empty($params['a']))
    {
	$strUrl .= "a={$params['a']}";
    }
    /* if ($strUrl == '/?')
      {
      $strUrl = '?sid=' . $_GET['sid'];
      }
      else
      {
      $strUrl .= 'sid=' . $_GET['sid'];
      } */
    if (!empty($params['p']))
    {
	$strUrl .='&' . $params['p'];
    }
    return $strUrl;
}
/**
 * @functional smarty注册方法，得到验证参数
 * @param $params
 */
function getParamValidateKey($params)
{
    $arrParames = array_values($params);
    return Utility::getValidateKey($arrParames);
}

/**
 * @functional smarty注册方法，设置单双行的样式
 * @param $rIndex 行号 从0开始
 */
function SetSingleDoubleRowClass($rIndex)
{
    $r = (int)$rIndex['rIndex'];
    if (($r+1)%2 == 1)
        return "even";
   
   return "odd";
}
?>