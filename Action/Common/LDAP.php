<?php
/**
 * 
 * LDAP操作类
 * @author wangkai
 *
 */
class LDAP
{
	//LDAP地址
	private $strLDAPHost = '127.0.0.1';
	//LDAP端口
	private $strLDAPPort = '389';
	//LDAP连接资源
	private $resLDAPConn = FALSE;
	//LDAP用户dn名
	private $strLDAPUserDNName = 'uid';
	//LDAP域名dn名
	private $strLDAPDomainDNName = 'pd';
	//LDAP管理员DN
	private $strLDAPAdminDN = 'cn=admin,dc=pyroot';
	//LDAP管理员密码
	private $strLDAPAdminPWD = 'mailsecret';
	//LDAP顶级唯一识别名DC
	public $strLDAPDC = 'dc=pyRoot';
	
	function __construct($strLDAPHost='127.0.0.1',$strLDAPPort='389',$strLDAPAdminDN='cn=admin,dc=pyroot',
					$strLDAPAdminPWD='mailsecret',$strLDAPUserDNName='uid',$strLDAPDomainDNName='pd')
	{
		$this->strLDAPHost = $strLDAPHost;
		$this->strLDAPPort = $strLDAPPort;
		$this->strLDAPUserDNName = $strLDAPUserDNName;
		$this->strLDAPDomainDNName = $strLDAPDomainDNName;
		$this->strLDAPAdminDN = $strLDAPAdminDN;
		$this->strLDAPAdminPWD = $strLDAPAdminPWD;
	}
	
	/**
	 * 连接到LDAP服务器
	 * @return bool 成功则返回TRUE,失败则返回FALSE
	 */
	public function connect()
	{
		//建立与LDAP服务器的连接
		$this->resLDAPConn = ldap_connect($this->strLDAPHost, $this->strLDAPPort);
		if($this->resLDAPConn == FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	
	/**
	 * 绑定要一个结点（认证）
	 * @param string $strDN
	 * @param string $strPWD
	 * @return bool	true:认证成功	false:认证失败
	 */
	public function bind($strDN,$strPWD)
	{
		if(!$this->resLDAPConn)
		{
			trigger_error('没有连接到LDAP',E_USER_ERROR);
			return FALSE;
		}
		if(@ldap_bind($this->resLDAPConn, $strDN, $strPWD))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * 关闭LDAP连接
	 */
	public function unbind()
	{
		return @ldap_unbind($this->resLDAPConn);
	}
	
	/**
	 * 插入一个新结点到LDAP
	 * @param string $strDN
	 * @param array $arrInfo
	 * @return bool 成功返回true,失败返回false
	 */
	public function insert($strDN,$arrInfo)
	{
		return @ldap_add($this->resLDAPConn,$strDN, $arrInfo);
	}
	
	/**
	 * 更新密码
	 * @param string $strDN	用户DN
	 * @param string $strPWD	用户密码
	 * @return bool 成功返回true,失败返回false
	 */
	public function updatePWD($strDN,$strPWD)
	{
		$arrInfo = array();
		$arrInfo["userPassword"]=$strPWD;
		return @ldap_modify($this->resLDAPConn,$strDN,$arrInfo);
	}
	
	/**
	 * 删除一个LDAP结点
	 * @param string $strDN	结点DN
	 * @return bool 成功返回true,失败返回false
	 */
	public function deleteUser($strDN)
	{
		return @ldap_delete($this->resLDAPConn,$strDN);
	}
	
	/**
	 * 删除域名结点
	 * @param string $strDomainDN	域名结点DN
	 */
	public function deleteDomain($strDomainDN)
	{
		$resResult = ldap_search($this->resLDAPConn,$strDomainDN,'uid=*');
		$arrEntry = ldap_get_entries($this->resLDAPConn,$resResult);
		for($i=0;$i<$arrEntry['count'];$i++)
		{
		    $delFlag = @ldap_delete($this->resLDAPConn, $arrEntry[$i]['dn']);
		    if(!$delFlag)
		    {
		        return FALSE;
		    }
		}
		return @ldap_delete($this->resLDAPConn,$strDomainDN);
	}
	
	/**
	 * 得到管理员的DN
	 * @return string 管理员的DN
	 */
	public function getAdminDN()
	{
		return $this->strLDAPAdminDN;
	}
	
	/**
	 * 得到管理员有密码
	 * @return string 管理员的密码
	 */
	public function getAdminPWD()
	{
		return $this->strLDAPAdminPWD;
	}
	
	/**
	 * 得到用户DN
	 * @param string $iUserID	用户ID
	 * @param string $strDomain	域名
	 * @return string 用户DN
	 */
	public function getUserDN($iUserID,$strDomain)
	{
		return $this->strLDAPUserDNName.'='.$iUserID.','.$this->strLDAPDomainDNName.'='.$strDomain.','.$this->strLDAPDC;
	}
	
	/**
	 * 得到域名DN
	 * @param string $strDomain	域名
	 */
	public function getDomainDN($strDomain)
	{
		return $this->strLDAPDomainDNName.'='.$strDomain;
	}
	
	/**
	 * 根据$Email查询ldap实体
	 * @param string $strDomainDN
	 * @param string $strFilter
	 */
	public function searchEmail($strDomainDN,$strFilter)
	{
		return ldap_search($this->resLDAPConn,$strDomainDN,$strFilter);
	}
	
	/**
	 * 得到查询到的节点资源的属性
	 * @param array $searchResult,$entryKey
	 */
	public function getEntryValue($resResult,$key)
	{
		$entry=ldap_first_entry($this->resLDAPConn, $resResult);
		if(gettype($entry)==gettype($resResult)){
			return ldap_get_values($this->resLDAPConn, $entry, $key);
		}
		else{
			return array();
		}
	} 
	
	/**
	 * 查询ldap实体
	 * @param int $iUserID
	 * @param string $strDomain
	 * @param string $strFilter
	 */
	public function search($iUserID,$strDomain,$strFilter)
	{
		return ldap_search($this->resLDAPConn,$this->getUserDN($iUserID,$strDomain),$strFilter);
	}
	
	/**
	 * 获取第一个实体
	 * @param array $searchResult
	 */
	public function getFirstEntry($searchResult)
	{
		return ldap_get_attributes($this->resLDAPConn,ldap_first_entry($this->resLDAPConn, $searchResult));
	} 
	
	public function getError(){
		$errorNo=intval(ldap_errno($this->resLDAPConn));
		return ldap_err2str($errorNo);
//		return ldap_error($this->resLDAPConn);
	}
    
    public function getErrorNum()
    {
        return ldap_errno($this->resLDAPConn);
    }
}