<?php

/**
 * @functional 业务逻辑类的基类
 * @author     liujunchen
 * @date       2011-07-06
 * @copyright  盘石
 */
require_once __DIR__ . '/MySqlHelp.php';
require_once __DIR__ . '/DALCache.php';

class BLLBase
{
    protected $objMysqlDB = null;
    protected $objAdhaisqlDB = null;
    protected $objMemcache = null;
    protected $strSelectKey = "SelectKey_";
    protected $strSelectAllKey = "SelectAllKey_";
    protected $strSelectPageKey = "SelectPageKey_";

    public function __construct()
    {
        $this->objMysqlDB = $this->getMysqlDBObj();
        $this->objMemcache = $this->getMemcacheObj();
    }
    //获取排序后的sql语句
    public function getOrderBySQl($sql, $sortField)
    {
        if ($_GET["sortField"] <> "") { //如果在页面指定排序字段
            $sortField = Utility::GetForm('sortField', $_GET);
        }
        if ($sortField <> "") {
            $sql .= " order by " . $sortField;
        }
        return $sql;
    }
    //获取分页数据
    public function getPageData($sql,$bExportExcel=false,$sqlCount = '')
    {        
        if($bExportExcel == false)
        {
            $iPageIndex = Utility::GetFormInt('page', $_GET);
            if($iPageIndex <= 0)
                $iPageIndex = 1;
                
            $iPageSize = Utility::GetFormInt('pageSize', $_GET);
            $iPageSize = (intval($iPageSize) <= 0) ? 15 : intval($iPageSize);
            $iRecordCount = 0;
            $offset = ($iPageIndex - 1) * $iPageSize;
            //$countSql = "{$sql}"; 
            if(empty ($sqlCount)){
                $iRecordCount = $this->objMysqlDB->executeNonQuery(false, $sql, null);//获取总记录数
            }else{
                $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);//获取总记录数
            }
            
            $pageSql = $sql . " LIMIT $offset,$iPageSize"; //获取分页数据            
            $arrPageData = $this->objMysqlDB->fetchAllAssoc(false, $pageSql, null);
            $iTotalPage = ceil($iRecordCount / $iPageSize);
            if ($iTotalPage == 0)
                $iTotalPage = 1;
            return array('list' => $arrPageData, 'pageSize' => $iPageSize, 'recordCount' =>
                $iRecordCount, 'totalPage' => $iTotalPage);            
        }
        else
        {                      
            $arrPageData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            return array('list' => $arrPageData);
        }        
    }

    /**
     * 数据库操作类
     */
    private function getMysqlDBObj()
    {
        //取配置
        $arrSysConfig = unserialize(SYS_CONFIG);
        $objServerInfo = new MySqlServerInfo();
        $sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        
        $DbConfigName = "DBCONFIG".$sys_evn;
        $DBCONFIG = $arrSysConfig["$DbConfigName"];
            
        $objServerInfo->strDBHost = $DBCONFIG['DBHOST'];
        $objServerInfo->strDBPort = $DBCONFIG['DBPORT'];
        $objServerInfo->strDBUser = $DBCONFIG['DBUSER'];
        $objServerInfo->strDBPwd = $DBCONFIG['DBPWD'];
        $objServerInfo->strDBName = $DBCONFIG['DBNAME'];
        $objServerInfo->strDBCharset = $DBCONFIG['DBCHARSET'];
        //返回数据操作对象
        return MySqlHelp::getInstance($objServerInfo);
    }

    /**
     * 数据库操作类
     */
    private function getAdhaiSqlDBObj()
    {
        //取配置
        $arrSysConfig = unserialize(SYS_CONFIG);
        $objServerInfo = new MySqlServerInfo();
        $sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        settype($sys_evn,"integer");
        
        $DbConfigName = "Adhai".$sys_evn;
        $DBCONFIG = $arrSysConfig[$DbConfigName]["DBCONFIG"];
            
        $objServerInfo->strDBHost = $DBCONFIG['DBHOST'];
        $objServerInfo->strDBPort = $DBCONFIG['DBPORT'];
        $objServerInfo->strDBUser = $DBCONFIG['DBUSER'];
        $objServerInfo->strDBPwd = $DBCONFIG['DBPWD'];
        $objServerInfo->strDBName = $DBCONFIG['DBNAME'];
        $objServerInfo->strDBCharset = $DBCONFIG['DBCHARSET'];
        //返回数据操作对象
        return MySqlHelp::getAdhaiInstance($objServerInfo);
    }

    /**
     * 得到缓存操作类
     */
    public function getMemcacheObj()
    {
        $arrSysConfig = unserialize(SYS_CONFIG);

        $objServerInfos = new MemcacheServerInfo();
        foreach ($arrSysConfig['MEMCACHED'] as $memCacheds) {
            $objServerInfos->addServer(key($memCacheds), current($memCacheds));
        }
        return DALCache::getInstance($objServerInfos);
    }

    /**
     * 添加分页数据到缓存     
     */
    public function setPageData2Cache($strKeyMain, $strKeySlave, $arrValue, $iCompress =
        0, $iExpire = 0)
    {
        $arrKeys = $this->objMemcache->get($strKeyMain);
        if ($arrKeys) {
            //加入新的key
            $arrKeys[] = $strKeySlave;
            $this->objMemcache->set($strKeyMain, $arrKeys, $iCompress, $iExpire);
        } else {
            //加入新的key
            $this->objMemcache->set($strKeyMain, array($strKeySlave), $iCompress, $iExpire);
        }
        //加入新的缓存
        $this->objMemcache->set($strKeySlave, $arrValue, $iCompress, $iExpire);
    }

    /**
     * 删除当前所有分页缓存
     * 
     * @param mixed $strKeyMain
     * @return
     */
    public function delPageDataFromCache($strKeyMain)
    {
        $arrKeys = $this->objMemcache->get($strKeyMain);
        if ($arrKeys) {
            foreach ($arrKeys as $strKey) {
                $this->objMemcache->delete($strKey);
            }
        }
        return $this->objMemcache->delete($strKeyMain);
    }

    public function GetAdaiData($sql)
    {
        if($this->objAdhaisqlDB == null)
        {
            $this->objAdhaisqlDB = $this->getAdhaiSqlDBObj();        
        }
        
        return $this->objAdhaisqlDB->fetchAllAssoc(false,$sql,null); 
    }
}
