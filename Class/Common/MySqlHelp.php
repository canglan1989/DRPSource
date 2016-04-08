<?php

/**
 * @functional 数据库操作类
 * @author     liujunchen
 * @access     public
 * @copyright  盘石
 */
class MySqlHelp
{
    /**
     * @var PDO 对象
     */
    private $objPdo = null;
    private $objConnConfig = null;
    private static $ObjInstance = null;

    /**
     * 私有化构造函数，防止外界实例化对象  
     */
    private function __construct(MySqlServerInfo $serverInfoObj)
    {
        if (!class_exists('PDO'))
            $this->errorMsg("不支持PDO");
        if (empty($serverInfoObj->strDBHost) || empty($serverInfoObj->strDBPort) || empty($serverInfoObj->strDBName) 
            || empty($serverInfoObj->strDBUser) || empty($serverInfoObj->strDBPwd) || empty($serverInfoObj->strDBCharset))
            $this->errorMsg("数据库配置文件错误！");
        $this->objConnConfig = &$serverInfoObj;
        if (empty($serverInfoObj->strDBPort))
            $this->objConnConfig->strDBPort = '3306';
        if (!isset($serverInfoObj->strDBCharset))
            $this->objConnConfig->strDBCharset = 'utf8';
        $this->connect();
    }
    
    /**
     * 私有化克隆函数，防止外界克隆对象    
     */
    private function __clone()
    {
    }

    /**
     *  静态方法, 单例统一访问入口  
     * 
     * @param mixed $dbConfig
     * @return
     */
    public static function getInstance(MySqlServerInfo $serverInfoObj)
    {
        if (!isset(self::$ObjInstance['U']) || self::$ObjInstance['U'] == null)
        {
            self::$ObjInstance['U'] = new MySqlHelp($serverInfoObj);
        }
        return self::$ObjInstance['U'];
    }

    /**
     *  静态方法, 单例统一访问入口  
     * 
     * @param mixed $dbConfig
     * @return
     */
    public static function getAdhaiInstance(MySqlServerInfo $serverInfoObj)
    {
        if (!isset(self::$ObjInstance['Adhai']) || self::$ObjInstance['Adhai'] == null)
        {
            self::$ObjInstance['Adhai'] = new MySqlHelp($serverInfoObj);
        }
        return self::$ObjInstance['Adhai'];
    }

    /**
     * 初始化数据库连接
     * @param array $dbConfig 数据库配置信息
     * @return void
     */
    public function connect()
    {
        if ($this->objPdo == null)
        {
            try
            {
                $dsn = "mysql:host={$this->objConnConfig->strDBHost};port={$this->objConnConfig->strDBPort};dbname={$this->objConnConfig->strDBName}";
                $this->objPdo = new PDO($dsn, $this->objConnConfig->strDBUser, $this->objConnConfig->strDBPwd, array(PDO::ATTR_PERSISTENT => false));
                //$this->objPdo->setAttribute(PDO::ATTR_TIMEOUT,1);
            }
            catch (PDOException $e)
            {
                $this->errorMsg('数据库连接失败: ' . $e->getMessage());
            }
            if ($this->getVersion() < 5)
            {
                $this->closeConnect();
                $this->errorMsg('数据库版本必须大于５.０');
            }
            $this->objPdo->exec("SET NAMES {$this->objConnConfig->strDBCharset}"); //设置连接字符集
        }
    }


    /**
     * 取mysql版本
     * @return string 
     */
    public function getVersion()
    {
        $mysqlVersion = $this->objPdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        return doubleval($mysqlVersion);
    }
    /**
     * @functional 取得上一次insert所长生的Id
     * @return int
    */
    public function lastInsertId()
    {
        return $this->objPdo->lastInsertId();
    }

    
    /**
     * 关闭数据库对象
     * @return void
     */
    public function closeConnect()
    {
        if ($this->objPdo != null)
        {
            $this->objPdo = null;
        }
        self::$ObjInstance = null;
    }
    
    /**
     * 返回当前链接的PDO对象
     * @return void
     */
    public function getPdo()
    {
        return $this->objPdo;
    }

    /**
     * 返回一个数值表示此SqlCommand命令执行后影响的行数.注意不支持out类型参数的PROC
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数. @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return int 返回影响的行数.
     */
    public function executeNonQuery($isProc, $cmdText, array $commandParameters = null)
    {
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        return $com->rowCount();
    }
    
    /**
     * 分页代码
     */
    public function selectPage($sTableName,$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,&$iRecordCount, &$iPageCount)
    {
        
    }
    
    /**
     * 执行一个操作,并返回首行首列的内容.
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数. @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return mixed 并返回首行首列的内容.
     */
    public function executeAndReturn($isProc, $cmdText, array $commandParameters = null)
    {
        $columnValue = 0;
        //$this->objPdo->beginTransaction();
        try
        {
            $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
            $columnValue = $com->fetchColumn(0);
            //$this->objPdo->commit();
        }
        catch (exception $ex)
        {
            //$this->objPdo->rollBack();
            throw new Exception($ex);
        }
        return $columnValue;
    }
    
    
    /**
     * 返回结果集中每一行的数据,可以通过字段名和索引取值
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.@example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @param int $fetch_style=PDO::FETCH_BOTH
     * @return array
     */
    public function fetchBoth($isProc, $cmdText, array $commandParameters = null)
    {
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        //验证参数$fetch_style
        return $com->fetch(PDO::FETCH_BOTH);
    }

    /**
     * 返回结果集中每一行的数据,可以通过字段名取值
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.@example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @param int $fetch_style=PDO::FETCH_BOTH
     * @return array
     */
    public function fetchAssoc($isProc, $cmdText, array $commandParameters = null)
    {
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        //验证参数$fetch_style
        return $com->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 返回结果集中每一行的数据,可以通过索引取值
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.@example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @param int $fetch_style=PDO::FETCH_BOTH
     * @return array
     */
    public function fetchIndex($isProc, $cmdText, array $commandParameters = null)
    {
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        //验证参数$fetch_style
        return $com->fetch(PDO::FETCH_NUM);
    }

    /**
     * 返回结果集中每一行的数据对象,可以通过对象->字段名取值.
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.
     * @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return object
     */
    public function fetchObject($isProc, $cmdText, array $commandParameters = null)
    {
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        //验证参数$fetch_style
        return $com->fetchObject();
    }

    /**
     * 返回一个数组集,如果有多个select也可以返回.可以通过字段下标和索引下标搜索
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.
     * @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return array;
     */
    public function fetchAllBoth($isProc, $cmdText, array $commandParameters = null)
    {
        return $this->fetchAll($isProc, $cmdText, PDO::FETCH_BOTH, $commandParameters);
    }

    /**
     * 返回一个数组集,如果有多个select也可以返回.只能通过索引下标搜索
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.
     * @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return array;
     */
    public function fetchAllIndex($isProc, $cmdText, array $commandParameters = null)
    {
        return $this->fetchAll($isProc, $cmdText, PDO::FETCH_NUM, $commandParameters);
    }

    /**
     * 返回一个数组集,如果有多个select也可以返回.只能通过字段下标搜索
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数.
     * @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return array;
     */
    public function fetchAllAssoc($isProc, $cmdText, array $commandParameters = null)
    {
        return $this->fetchAll($isProc, $cmdText, PDO::FETCH_ASSOC, $commandParameters);
    }

    /**
     * 返回每一行某列的一个值;
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数. @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @param $index 列索引
     * @return mixed;
     */
    public function fetchColumn($isProc, $cmdText, array $commandParameters = null, $index = 0)
    {
        if (!is_int($index))
            $this->errorMsg('索引参数必须为整数.');
        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        $res = null;
        try
        {
            $res = $com->fetchColumn($index);
        }
        catch (exception $ex)
        {
            $this->errorMsg($ex->getMessage());
        }
        return $res;
    }

    /**
     * 返回一个PDOStatement对象,可以执行PDOStatement的对象;
     * @param bool $isProc 是否存储过程.
     * @param string $cmdText 执行的命令字符串,是存储过程时不带参数,如果不是存储过程时sql语句里的变量用'?'或者':paramName'.
     * @param  
     * array(array( mixed $parameter, mixed &$variables[, int $data_type[, int $length[, mixed $driver_options ]]])) $commandParameters,
     * 同pdo->bindParam()里的参数. @example array(array(1|':parameterName',$colour, PDO::PARAM_STR, 12));
     * @return PDOStatement;
     */
    public function getPDOStatement($isProc, $cmdText, array $commandParameters = null)
    {
        //验证参数

        if (!is_bool($isProc))
            $this->errorMsg('$isProc 参数必须为bool类型.');
        if (!is_string($cmdText))
            $this->errorMsg('$cmdText 参数必须为string类型.');
        if (!is_array($commandParameters) && isset($commandParameters))
            $this->errorMsg('$commandParameters 参数必须为array类型.');
        $cmdText = $isProc ? $this->getProcText($cmdText, $commandParameters) : $cmdText;
        $com = $this->objPdo->prepare($cmdText);
        $this->bindValue($com, $commandParameters);
        $com->execute() or $this->errorMsg($com->errorInfo());
        return $com;
    }

    /**
     * 取数据
     * 
     * @param mixed $isProc
     * @param mixed $cmdText
     * @param mixed $fetchMode
     * @param mixed $commandParameters
     * @return
     */
    private function fetchAll($isProc, $cmdText, $fetchMode = PDO::FETCH_BOTH, array $commandParameters = null)
    {
        if (!is_int($fetchMode))
            $this->errorMsg('$fetchMode 参数必须为int类型.');

        $com = $this->getPDOStatement($isProc, $cmdText, $commandParameters);
        $com->setFetchMode($fetchMode);
        $resArr = array();
        do
        {
            $rowset = $com->fetchAll();
            if (!$rowset)
                $rowset = array();

            array_push($resArr, $rowset);
        } while ($com->nextRowset());
        return count($resArr) == 1 ? $resArr[0] : $resArr;
    }
    
    /**
     * 调用存储过程
     * 
     * @param mixed $cmdText
     * @param mixed $commandParameters
     * @return
     */
    private function getProcText($cmdText, array $commandParameters = null)
    {
        if (strpos($cmdText, '(') !== false)
            return $cmdText;
        $params = '';
        if (isset($commandParameters))
        {
            foreach ($commandParameters as $k => $v)
            {
                $params .= (is_int($v[0]) ? '?' : $v[0]) . ',';
            }
        }
        if (strlen($params) > 0)
            $params = substr($params, 0, strlen($params) - 1);
        return "call {$cmdText}({$params})";
    }

    /**
     * 绑定参数
     * 
     * @param mixed $com
     * @param mixed $commandParameters
     * @return
     */
    private function bindValue(PDOStatement $com, array $commandParameters = null)
    {
        if (!isset($commandParameters))
            return;
        foreach ($commandParameters as $k => $v)
        {
            if (!is_int($v[2]) && isset($v[2]))
                $this->errorMsg('绑定的参数类型必须为整型.');
            //效验参数类型
            //bindParam
            //if(isset($v[3]))
            //	$com ->bindValue($v[0],$v[1],$v[2],$v[3]);
            //else
            // mixed $parameter , mixed $value [, int $data_type ]
            $parameter = $v[0];
            $value = $v[1];
            $dataType = isset($v[2]) ? $v[2] : PDO::PARAM_STR;
            $com->bindValue($parameter, $value, $dataType);
        }
    }
    
    /**
     * 执行SQL出错时，调用此函数
     * @param string $msg
     */
    private function errorMsg($msg)
    {
        die(is_string($msg) ? $msg : $msg[2]);
    }

    function __destruct()
    {
        $this->closeConnect();
    }
}


class MySqlServerInfo
{
    public $strDBHost = '192.168.27.204';
    public $strDBPort = '3306';
    public $strDBUser = 'psdrp_guest';
    public $strDBPwd = '123456';
    public $strDBName = 'psdrp';
    public $strDBCharset = 'utf8';
}

?>