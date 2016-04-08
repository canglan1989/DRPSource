<?php
/**
 * @functinal: 盘石渠道系统工具类
 * @author:    wangkai liujunchen
 * @copyright  盘石 
 */
class Utility
{
    public static function getIP()
    {
        if (isset($_SERVER))
        {
            if (isset($_SERVER["HTTP_CLIENT_IP"])) 
                return $_SERVER["HTTP_CLIENT_IP"]; 
                                
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
                return $_SERVER["HTTP_X_FORWARDED_FOR"]; 
                        
            return $_SERVER["REMOTE_ADDR"]; 
        } 
                
        if (getenv('HTTP_CLIENT_IP')) 
            return getenv('HTTP_CLIENT_IP'); 
        
        if (getenv('HTTP_X_FORWARDED_FOR')) 
            return getenv('HTTP_X_FORWARDED_FOR');
                         
        return getenv('REMOTE_ADDR');
        
    }
    
    /**
     * 验证参数合法性
     * @param array $arrParam		要验证的参数数组
     * @param string $strKey		验证参数的码
     */
    public static function validateParam(array $arrParam,$strKey)
    {
        if(self::getValidateKey($arrParam)==$strKey && $strKey!='')
            return true;
        else
            return false;
    }
    
    /**
     * 产生验证码
     * @param array $arrParam	要验证的参数数组
     */
    public static function getValidateKey(array $arrParam)
    {
        $arrSysConfig = self::getSysConfig();
        $strPrefix = $arrSysConfig['SECURE']['PREFIX'];
        $strParams = implode($strPrefix, $arrParam);
        return md5($strParams.$arrSysConfig['SECURE']['SUFFIX']);
    }
    
    /**
     * 获取系统配置
     */
    public static function getSysConfig()
    {
        return unserialize(SYS_CONFIG);
    }
    
    /**
     * 对参数进行Null和空判断
     * @param string $key	要判断的key
     * @param string $obj	要判断的类型对象,$_GET,$_POST
     */
    public static function isNullOrEmpty($key,$obj)
    {
        if(isset($obj[$key]) && !empty($obj[$key]))
        {
            return self::GetForm($key,$obj);
        }
        return FALSE;
    }
    
    /**
     * 取参数，如果为NULL则变成空串
     * @param string $key	要判断的key
     * @param string $obj	要判断的类型对象,$_GET,$_POST
     */
    public static function getValueNull2Empty($key,$obj)
    {
        return self::GetForm($key,$obj);
    }
    
    /**
     * 返回格式化后的字节大小字符串
     * @param int $iSize	字节大小
     */
    public static function getByteFormatString($iSize)
    {
        $iLevel = 0;
    	while($iSize>=1000){
    		if($iLevel<3){
    			$iLevel++;
    			$iSize = $iSize/1000;
    		}else{
    			break;
    		}
    	}
    	$iSize = round($iSize,1);    //保留一位小数
    	switch($iLevel){
    		case 0:
    			return $iSize.'B';
    		case 1:
    			return $iSize.'K';
    		case 2:
    			return $iSize.'M';
    		case 3:
    			return $iSize.'G';
    		default:
    			return '0B';
    	}
    }
    
	/**
     * 返回格式化后的字节大小字符串(单位为M)
     * @param int $iSize	字节大小
     */
    public static function getByteFormat2MString($iSize)
    {
        $iSize = $iSize / (1000*1000);
        $iSize = round($iSize,2);    //保留两位小数
        
        return $iSize.'M';
    }
    
    /**
     * 转换字符串到HTML格式,eg:空格===>&nbsp;
     * @param string $strContent
     */
    public static function getHTMLFormatString($strContent)
    {
        return str_replace(" ","&nbsp;",htmlspecialchars($strContent));
    }
    
    
    /**
     * 返回URL
     * 
     * @param string $d 目录名
     * @param string $c 类名
     * @param string $a 方法名
     * @param string $p 其它参数
     * @return string URL
     */
    public static function getActionUrl($d,$c,$a,$p = '')
    {
        $params = array('d'=>$d,'c'=>$c,'a'=>$a,'p'=>$p);
        
        $strUrl = '/?'; 
        if(isset($params['d']) && !empty($params['d']))
        {
            $strUrl .= "d={$params['d']}&";
        }
        if(isset($params['c']) && !empty($params['c']))
        {
            $strUrl .= "c={$params['c']}&";
        }
        if(isset($params['a']) && !empty($params['a']))
        {
            $strUrl .= "a={$params['a']}&";
        }
        if($strUrl == '/?')
        {
            $strUrl = '?sid='.Utility::GetForm('sid',$_GET);
        }
        else
        {
            $strUrl .= 'sid='.Utility::GetForm('sid',$_GET);
        }
        if(!empty($params['p']))
        {
            $strUrl .='&'.$params['p'];
        }       
        return $strUrl;
    }
    
	/**
     * 对脚本的运行计时
     */
	public static function microtime_float(){
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}
	
	/**
	 * 转utf8字符到gbk字符
	 * @param unknown_type $strUTF8
	 */
	public static function utf8ToGb2312($strUTF8){
	    //return iconv("UTF-8", "GB2312//IGNORE", $strUTF8);
	    return mb_convert_encoding($strUTF8,'gbk','UTF-8');
	}
	
	/**
	 * 转gbk字符到utf8字符
	 * @param unknown_type $strGBK
	 */
	public static function gb2312ToUtf8($strGBK){
	    //return iconv("GB2312", "UTF-8//IGNORE", $strGBK);
	    return mb_convert_encoding($strGBK,'UTF-8','gbk');
	}
    
    /**
     * 生成全局唯一ID
    */
    public static function generateUid()
    {
    	$host   = 'panshi.com';
    	$date   = date('Ymd\THisT');
    	$unique = substr(microtime(), 2, 4);
    	$base   = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPrRsStTuUvVxXuUvVwWzZ1234567890';
    	$start  = 0;
    	$end    = strlen( $base ) - 1;
    	$length = 6;
    	$str    = null;
    	for( $p = 0; $p < $length; $p++ )
    	  $unique .= $base{mt_rand( $start, $end )};
    	$UidStr = $date.'-'.$unique.'@'.$host;
    	return $UidStr;
    }
    
    /**
     * @functional 判断url是否合法的正则表达式
     * @author liujunchen
     * 
    */
    public static function validateUrl($url)
    {
        if(strlen($url)>0)
        {
            return preg_match('/^([a-zA-Z0-9]+\.)?([a-zA-Z0-9]+\.[a-zA-Z0-9]+)+/',$url);
            //return preg_match('/^(http|https)\:\/\/([a-zA-Z0-9]+\.)?([a-zA-Z0-9]+\.[a-zA-Z0-9]+)+/',$url);
        }
    }
    
    /**
    * 过滤HTML
    * @param $text
    * @return string
    */
    public static function filterHTML(&$text){
        $rules = array();
        array_push($rules,"/<script[^>]*?>.*?<\/script>/is");
        array_push($rules,"/<style[^>]*?>.*?<\/style>/is");
        array_push($rules, "/<!--.*?-->/is");
        //array_push($rules,"/<\/?(?!img|p|br|strong|font|table|tr|td|th|h1|h2|h3|h4|h5|h6|h7|title|embed|\/img|\/p|\/br|\/strong|\/font|\/table|\/tr|\/td|\/th|\/h1|\/h2|\/h3|\/h4|\/h5|\/h6|\/h7\/title|\/embed)[^>]*>/iUs");
        array_push($rules,"/<\/?.*?>/is");
        $strResult = preg_replace($rules,'',$text);
        
        $strResult = preg_replace("/&#34;/is", '"', $strResult);
        $strResult = preg_replace("/&#39;/is", "'", $strResult);
        $strResult = preg_replace("/&#38;/is", '&', $strResult);
        $strResult = preg_replace("/&nbsp;/is", ' ', $strResult);
        $strResult = preg_replace("/&quot;/is", '"', $strResult);
        $strResult = preg_replace("/&gt;/is", '>', $strResult);
        $strResult = preg_replace("/&lt;/is", '<', $strResult);
        $strResult = preg_replace("/&amp;/is", '&', $strResult);
        
        return preg_replace("/\s{2,}/", ' ', $strResult);
    }
    
    /**
     * 判断wap登陆方式
     */
    public static function checkWapLogin(){
        $result=false;
        if (isset($_SERVER['HTTP_VIA']))
        {
        	if (stristr($_SERVER['HTTP_VIA'],'wap'))
        	{
        		return true;
        	}
        }
        else 
        {
        	if (isset($_SERVER['HTTP_ACCEPT']) && stristr($_SERVER['HTTP_ACCEPT'],'wap'))
        	{
        		return true;
        	}
        	else 
        	{
				if(isset($_SERVER['HTTP_USER_AGENT']))
				{
					$user_agent=$_SERVER['HTTP_USER_AGENT'];
					switch (true)
					{
						case (preg_match('/ipad/i',$user_agent)):
							$result=true;
							break;
						case (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent)):
							$result=true;
							break;	
						case (preg_match('/android/i',$user_agent)):
							$result=true;
							break;
						case (preg_match('/symbian/i',$user_agent)):
							$result=true;
							break;										
						case (preg_match('/opera mini/i',$user_agent)):
							$result=true;
							break;		
						case (preg_match('/blackberry/i',$user_agent)):
							$result=true;
							break;	
						case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent)):
							$result=true;
							break;
						case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent)):
							$result=true;
							break;	
						case (preg_match('/(compal|ahong|wireless|novarra|sanyo|mtk|foma|samsu|htc\/|htc_touch|ktouch|kddi|phone|lg |sonyericsson|samsung|nokia|sony cmd|motorola|mmp|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i',$user_agent)):
							$result=true;
							break;
						/*			
						case (preg_match('/oper/i',$user_agent)):
							$result=true;
							break;			*///TODO:oper测试需要
					}
				}    		
        	}
        }
        return $result;
    }

    /**
     * 得到附件的后缀名
     * @param string $strName
     */
    public static function getSuffix($strName)
    {
        $arrMatches = array();
        if(preg_match("/.*?\.([^.]{1,7})$/i",$strName, $arrMatches))
        {
            return $arrMatches[1];
        }
        return "UnrecognizedScheme";
    }

    /**
    * 过滤文本编辑框HTML
    * @param $text
    * @return string
    */
    public static function filterTextAreaHTML(&$text){
        
        $rules = array();
        array_push($rules,"/<script[^>]*?>/is");
        array_push($rules,"/<script[^>]*?>.*?<\/script>/is");
        array_push($rules,"/<style[^>]*?>.*?<\/style>/is");
        array_push($rules, "/<!--/is");
        array_push($rules, "/<!--.*?-->/is");
        array_push($rules,"/<\/?.*?>/is");
        $strResult = addslashes($text);
        $strResult = preg_replace('/<([^>\/]*?@.*?)>/is','&lt;\\1&gt;',$strResult);
		$strResult = nl2br($strResult);  
		$strResult = preg_replace('/<br[^>]*>/is',"\r\n",$strResult);       
        $strResult = preg_replace($rules,'',$strResult);
        $strResult = preg_replace("/[\t]/i", '', $strResult);
		$strResult = preg_replace('/\'/is',"‘",$strResult);
		$strResult = preg_replace('/　/is','',$strResult);
        
        return preg_replace("/(\r\n)+/i", "\r\n", $strResult);
    }
        
    
    /**
     * 得到邮件里body之间的内容
     * @param string $content
     */

    public static function getBodyHtml($content)
    {
        $arrMatches = array();
        $strhtml=$content;
        if(preg_match("/<body[^>]*>(.*?)<\/body>/is",$content, $arrMatches)) 
        {
            $strhtml=$arrMatches[1];
        }  
        return $strhtml; 
    }
    
    /**
     * @functional: 验证邮件地址是否合法
     * @param:      string $addr  邮件地址
     */
    public static function validAddr($addr)
    {
        if(preg_match('/^([a-zA-Z0-9_\-\.]{1,30}@\w*\.?\w+(\.\w{2,4}){1,3})+$/i',$addr)
           || preg_match('/^".+"\<[a-zA-Z0-9_\-\.]{1,30}@\w*\.?\w+(\.\w{2,4}){1,3}\>$/i',$addr))
        {
            return true;
        }
        return false;
    }  

    /**
     * @functional: 获取日期2011/5/24 从2011-05-24 10:07:19
     * @param:      string $strDate  邮件日期
     */
    public static function getShortDate($strDate)
    {
		$strReturn='';
		$dt_elements = explode(" " ,$strDate); 
		$date_elements = explode("-" ,$dt_elements[0]);
		$strReturn= sprintf('%s-%s-%s',$date_elements[0],$date_elements[1],$date_elements[2]);
		return $strReturn;
    }
   	/**
	 * @functional: 对MYSQL LIKE的内容进行转义
	 * @return:     string
	 */
	public static function mysql_like_quote($str)
	{
		return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
	}
    
   	/**
	* @functional: 检测邮政编码
    * @return bool
	*/
	public static function checkZipCode($str)
	{
		$strlen=strlen($str);
		if($strlen!=6)
		{
			return false;
		}
		else
		{
			return preg_match("/^\d{6}$/",$str);
		}
	} 
    /**
     * @functional:检测手机号码是否合法
     * @return bool
    */
    public static function checkCellPhone($str)
    {
        $pattern = "/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
        $strlen = strlen($str);
        if($strlen!=11)
        {
            return false;
        }
        else
        {
            return preg_match($pattern,$str);
        }
    }
    
    /**
     * @functional: 检测固定电话是否合法
     * @return bool
    */
    public static function checkTel($str)
    {
        $pattern = '/^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/';
        return preg_match($pattern,$str);
    }
    
	/**
	 * @functional: 检查是否为一个合法的时间格式
	 * @return:     bool
	 */
	public static function is_time($time)
	{
		$pattern = '/^[\d]{4}-[\d]{1,2}-[\d]{1,2}\s{1}[\d]{1,2}:[\d]{1,2}:[\d]{1,2}$/';
		return preg_match($pattern, $time);
	}
    
    
    /**
     * @functional 检测 08-07-07 格式的时间
     * @return int
    */
    public static function isTime($parameName)
    {
        return preg_match('/^\d{1,2}:\d{2}:\d{2}$/',$parameName);
    }
    
    /**
     * @functional 检测2011-07-07格式的时间
     * @return int
    */
    public static function isShortTime($parameName)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/',$parameName);
    }
    
      
    /**
     * @functional 比较起始日期
     * @return int >0 则 $eDate > $sDate
    */
    public static function compareSEDate($sDate,$eDate)
    {
        $sDate = mktime(0,0,0,date("m",strtotime($sDate)),date("d",strtotime($sDate)),date("Y",strtotime($sDate)));
        $eDate = mktime(0,0,0,date("m",strtotime($eDate)),date("d",strtotime($eDate)),date("Y",strtotime($eDate)));
        $iDate = ($eDate - $sDate)/(3600*24);
        return $iDate;
    }
    
    
   	/**
	 * @functional: 接取值并过滤字符串
     * @param:      string $obj	要判断的类型对象,$_GET,$_POST
     * @param: int $iLength 字数限制
	 * @return:     string
	 */
    public static function GetForm($parameName,$obj,$iLength=800)
    {
        if(isset($obj[$parameName]))
        {
        	$strTemp = ltrim($obj[$parameName]);
        	$strTemp = rtrim($strTemp);
            //return $strTemp;
            if("" != $strTemp)
                $strTemp = self::filterTextAreaHTML($strTemp);
                
            if($iLength>0 && mb_strlen($strTemp,'UTF8') > $iLength)
                $strTemp = self::utf_substr($strTemp,$iLength);
            
            return $strTemp;
        }
        
        return '';            
    }
    
    public static function GetRemarkForm($parameName,$obj,$iLength=520)
    {
        $strTemp = self::GetForm($parameName,$obj,$iLength);
        $strTemp = str_replace(array("\r\n", "\n", "\r"),"<BR/>",$strTemp);
        $strTemp = str_replace("<BR/><BR/>","<br/>",$strTemp);
        return $strTemp;
    }
    
    public static function utf_substr($str,$len)
    {
        if($len>0 && mb_strlen($str,'UTF8') > $len)
        {
            for($i=0;$i<$len;$i++)
            {
                $temp_str=substr($str,0,1);
                if(ord($temp_str) > 127)
                {
                    $i++;
                    if($i<$len)
                    {
                        $new_str[]=substr($str,0,3);
                        $str=substr($str,3);
                    }
                }
                else
                {
                    $new_str[]=substr($str,0,1);
                    $str=substr($str,1);
                }
            }
            return join($new_str);
        }
        
        return $str;
    }
    
   	/**
	 * @functional: 获取参数$parameName的int值,如果不是int类型返回0
     * @param:      string $obj	要判断的类型对象,$_GET,$_POST
	 * @return:     int
	 */
	public static function GetFormInt($parameName,$obj,$defValue = 0)
	{
		if(isset($obj[$parameName]))
		{
			return (int)trim($obj[$parameName]);
		}
		else
		{
			return $defValue;
		}
	}
    
	/**
	 * @functional: 参数$parameName的float值,如果不是float类型返回0
     * @param:      string $obj	要判断的类型对象,$_GET,$_POST
	 * @return:     float
	 */
	public static function GetFormFloat($parameName,$obj,$defValue = 0)
	{
		$val='0';
		if(isset($obj[$parameName]))
		{
			$val=$obj[$parameName];
		}
		if(is_numeric($val))
		{
			return (float)$val;
		}
		else
		{
			return $defValue;
		}
	}
	/**
	 * @functional: 参数$parameName的double值,如果不是double类型返回0
	 * @return:  double
	 */
	public static function GetFormDouble($parameName,$obj,$defValue = 0)
	{
		$val='0';
		if(isset($obj[$parameName]))
		{
			$val=$obj[$parameName];
		}
		if(is_numeric($val))
		{
			return (double)$val;
		}
		else
		{
			return $defValue;
		}
	}
    
    /**
     * 获取 _SERVER['REQUEST_URI'] 值的通用解决方案
     */
    public static function request_uri()
    {
        $uri = "";
        if (isset($_SERVER['REQUEST_URI']))
        {
            $uri = $_SERVER['REQUEST_URI']; 
        }
        else
        {
            if (isset($_SERVER['argv']))
            {
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
            }
            else
            {
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
            }
        }
        return $uri;
    }
    
    /**
     * 获取当前页面完整URL
    */
    public static function curPageURL() 
    {
        $pageURL = 'http';    
        if(isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") 
        {
            $pageURL .= "s";
        }
        
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") 
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . self::request_uri();
        } 
        else 
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . self::request_uri();
        }
        return $pageURL;
    }
    
    /**
     * @functional 金额格式化
    */
    public static function FormatMoney($number)
    {
        $strPrice = number_format($number, 2, '.', ',');
        return "￥".$strPrice;
    }
        
    /**
     * @functional 数组列金额格式化
    */
    public static function FormatArrayMoney(&$arrayData,$indexNames)
    {
        if($indexNames == "")
            return ;
        
        $indexName = explode(",",$indexNames);
        $indexCount = count($indexName);

        $arrayLength = count($arrayData); 
        for($i = 0;$i<$arrayLength;$i++)
        {            
            for($j = 0;$j<$indexCount;$j++)
            { 
                $arrayData[$i]["$indexName[$j]"] = number_format($arrayData[$i]["$indexName[$j]"], 2, '.', ',');
            }
        }
    }
    
        
    /**
     * @functional 多选查询
    */
    public static function SQLMultiSelect($fileName,$IDs,$bIsNumber = true)
    {
        if($IDs == "")
            return "";
        
        $arrayIDs = explode(",",$IDs);
        $arrayLength = count($arrayIDs);
        $returnStr = "";
        $iFlag = 0;       
        for($i = 0;$i < $arrayLength; $i++)
        {  
           //if($arrayIDs[$i] > 0)
           //{
            if($bIsNumber)
            {
                settype($arrayIDs[$i],"integer");
                if($iFlag == 0)
                    $returnStr = " and (".$fileName."=".$arrayIDs[$i];
                else
                    $returnStr .= " or ".$fileName."=".$arrayIDs[$i];
            }
            else
            {
                if($iFlag == 0)
                    $returnStr = " and (".$fileName."='".$arrayIDs[$i]."'";
                else
                    $returnStr .= " or ".$fileName."='".$arrayIDs[$i]."'";
            }
            $iFlag++;
           //}           
        }
        
        if($iFlag > 0)
            $returnStr .=") ";
        
        return $returnStr;
    }
    
    
    /**
     * @functional 当前时间
    */
    public static function Now()
    {
        return date("Y-m-d H:i:s",time());
    }
    
    /**
     * @functional 当前时间
    */
    public static function Today()
    {
        return date("Y-m-d",time());
    }
    
    
    /**
     * @functional 加日期
     * @return $date 原日期
     * @return $count 加的天数，负数为减
     * @return $sortDate 是否返回短日期形式
     * @return date
    */
    public static function addDay($date,$count,$sortDate = true)
    {
        if($count == 0)
        {
            return $date;
        }
        
        $strCount = "";
        $strCount = "".$count;
            
        return date(($sortDate ? "Y-m-d" : "Y-m-d H:i:s"),strtotime("{$strCount} day", strtotime($date)));
    }
    
    /**
     * @functional 加月份
     * @return $date 原日期
     * @return $count 加的月数，负数为减
     * @return $sortDate 是否返回短日期形式
     * @return date
    */
    public static function addMonth($date,$count,$sortDate = true)
    { 
        if($count == 0)
        {
            return $date;
        }
        
        $strCount = "";
        $strCount = "".$count;
            
        return date(($sortDate ? "Y-m-d" : "Y-m-d H:i:s"),strtotime("{$strCount} month", strtotime($date)));
    }
    
    /**
     * @functional 加星期
     * @return $date 原日期
     * @return $count 加的星期数，负数为减
     * @return $sortDate 是否返回短日期形式
     * @return date
    */
    public static function addWeek($date,$count,$sortDate = true)
    { 
        if($count == 0)
        {
            return $date;
        }
        
        $strCount = "";
        $strCount = "".$count;
            
        return date(($sortDate ? "Y-m-d" : "Y-m-d H:i:s"),strtotime("{$strCount} week", strtotime($date)));
    }
    
    /**
     * @functional 查询中使用的结束日期  只用于小于 < $date
    */
    public static function SQLEndDate($date)
    {
        return "'".date("Y-m-d",strtotime("+1 day", strtotime($date)))."'";
    }
    
    public function SeeJsonEncode($str)
    {
        return preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $str);
    }
    
    /**
     * 发送消息
     * @param type $msg
     * @param type $success
     * @param type $url 
     */
    public static function Msg($msg,$success = false,$url = ''){
        exit (json_encode(array(
            'msg'=>$msg,
            'success'=>$success,
            'url'=>$url
        )));
    }
}
