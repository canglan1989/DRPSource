<?php
/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_upload_doc 的类业务逻辑层
 * 表描述：文档上传表 
 * 创建人：温智星
 * 添加时间：2013-01-06 16:51:09
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UploadDocInfo.php';

class UploadDocObjctType
{
    /**
     * 1 代理商
    */
    const Agent = 1;
    /**
     * 2 客户
    */
    const Customer = 2;
}

class AgentDocType
{
    /**
     * 1 培训课件
    */
    const Courseware = 1;
    /**
     * 1 促单工具
    */        
    const Tool = 2;
    
    /**
     * 3 资质类
    */
    const Qualification = 3;
    /**
     * 10 其它
    */
    const Other = 10;
    
    
    /**
     * @functional 类型文字备注   
    */ 
    public static function GetText($value)
    {        
        $data = self::GetData();
        if(array_key_exists($value, $data))
            return $data[$value];
            
        return "未知";
    }
    
    public static function GetData()
    {
        return array(AgentDocType::Courseware=>"培训课件",AgentDocType::Tool=>"促单工具",AgentDocType::Qualification=>"资质",AgentDocType::Other=>"其它");
    }
    
    /**
     * @functional 将数组中的类型值替换成文字备注   
    */ 
    public static function ReplaceArrayText(&$arrayData,$fileName,$appendFileName="")
    {
        if($appendFileName == "")
            $appendFileName = $fileName;
            
        $arrayLength = count($arrayData);
        for($i= 0 ;$i<$arrayLength;$i++)
        {
            $arrayData[$i][$appendFileName] = self::GetText($arrayData[$i][$fileName]);
        }
    }

}

class UploadDocBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objUploadDocInfo  UploadDocInfo 实例
     * @return 
     */
	public function insert(UploadDocInfo $objUploadDocInfo)
	{
		$sql = "INSERT INTO `sys_upload_doc`(`object_type`,`object_id`,`object_no`,`object_name`,`file_name`,`file_path`,`author`,`file_type`,`create_time`,`create_uid`,`create_user_name`,`update_time`,`update_uid`,`update_user_name`,`is_del`) 
        values(".$objUploadDocInfo->iObjectType.",".$objUploadDocInfo->iObjectId.",'".$objUploadDocInfo->strObjectNo."','".$objUploadDocInfo->strObjectName."','".$objUploadDocInfo->strFileName."','".$objUploadDocInfo->strFilePath."','".$objUploadDocInfo->strAuthor."',".$objUploadDocInfo->iFileType.",now(),".$objUploadDocInfo->iCreateUid.",'".$objUploadDocInfo->strCreateUserName."',now(),".$objUploadDocInfo->iUpdateUid.",'".$objUploadDocInfo->strUpdateUserName."',".$objUploadDocInfo->iIsDel.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objUploadDocInfo  UploadDocInfo 实例
     * @return
     */
	public function updateByID(UploadDocInfo $objUploadDocInfo)
	{
	   $sql = "update `sys_upload_doc` set `object_type`=".$objUploadDocInfo->iObjectType.",`object_id`=".$objUploadDocInfo->iObjectId.",`object_no`='".$objUploadDocInfo->strObjectNo."',`object_name`='".$objUploadDocInfo->strObjectName."',`file_name`='".$objUploadDocInfo->strFileName."',`file_path`='".$objUploadDocInfo->strFilePath."',`author`='".$objUploadDocInfo->strAuthor."',`file_type`=".$objUploadDocInfo->iFileType.",`create_user_name`='".$objUploadDocInfo->strCreateUserName."',`update_time`= now(),`update_uid`=".$objUploadDocInfo->iUpdateUid.",`update_user_name`='".$objUploadDocInfo->strUpdateUserName."',`is_del`=".$objUploadDocInfo->iIsDel." where doc_id=".$objUploadDocInfo->iDocId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID,$userName)
    {
		$sql = "update `sys_upload_doc` set is_del=1,update_uid=".$userID.",update_user_name='".$userName."',update_time=now() where doc_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	/**
     * @functional 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
	
				
	/**
     * @functional 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_UploadDoc::AllFields;
		
        if ($sWhere != "")
            $sWhere = " where is_del=0 and ".$sWhere;
        else
            $sWhere = " where is_del=0";
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_upload_doc` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 UploadDocInfo 对象
	 * @param int $id 
     * @return UploadDocInfo 对象
     */
	public function getModelByID($id)
	{
		$objUploadDocInfo = null;
		$arrayInfo = $this->select("*","doc_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUploadDocInfo = new UploadDocInfo();
            		        
            $objUploadDocInfo->iDocId = $arrayInfo[0]['doc_id'];
            $objUploadDocInfo->iObjectType = $arrayInfo[0]['object_type'];
            $objUploadDocInfo->iObjectId = $arrayInfo[0]['object_id'];
            $objUploadDocInfo->strObjectNo = $arrayInfo[0]['object_no'];
            $objUploadDocInfo->strObjectName = $arrayInfo[0]['object_name'];
            $objUploadDocInfo->strFileName = $arrayInfo[0]['file_name'];
            $objUploadDocInfo->strFilePath = $arrayInfo[0]['file_path'];
            $objUploadDocInfo->strAuthor = $arrayInfo[0]['author'];
            $objUploadDocInfo->iFileType = $arrayInfo[0]['file_type'];
            $objUploadDocInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objUploadDocInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objUploadDocInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objUploadDocInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objUploadDocInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objUploadDocInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objUploadDocInfo->iIsDel = $arrayInfo[0]['is_del'];
            settype($objUploadDocInfo->iDocId,"integer");
            settype($objUploadDocInfo->iObjectType,"integer");
            settype($objUploadDocInfo->iObjectId,"integer");
            settype($objUploadDocInfo->iFileType,"integer");
            settype($objUploadDocInfo->iCreateUid,"integer");
            settype($objUploadDocInfo->iUpdateUid,"integer");
            settype($objUploadDocInfo->iIsDel,"integer");
            
        }
		return $objUploadDocInfo;
       
	}
    
	/**
     * @functional 文件名重复判断
	 * @param int $object_type 
	 * @param int $file_type 
	 * @param int $object_id 
	 * @param string $file_name 
     * @return docID
     */
    public function ExistFile($object_type,$file_type,$object_id,$file_name)
    {
        $sql = "SELECT doc_id FROM sys_upload_doc where object_type=$object_type and file_type=$file_type 
            and object_id=$object_id and file_name = '{$file_name}' and is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if (isset($arrayData)&& count($arrayData)>0)
            return $arrayData[0]["doc_id"];
            
        return -1;
    }
    
    
    /**
     * @functional 分页数据
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
     */
    public function selectAgentDocPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount,$bExportExcel = false)
    {
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex - 1) * $iPageSize;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;
        else
            $strOrder = " ORDER BY `sys_upload_doc`.create_time desc,`sys_upload_doc`.object_no";
            
        if($bExportExcel == false)
        {            
            $sqlCount = "SELECT COUNT(*) AS `recordCount` from (
                        SELECT am_agent_permit.aid as doc_id,
                        ".UploadDocObjctType::Agent." as object_type,
                        am_agent_permit.agent_id as object_id,
                        am_agent_source.agent_no as object_no,
                        am_agent_source.agent_name as object_name,
                        CONCAT(am_agent_permit.permit_name,'.',am_agent_permit.file_ext) as file_name,
                        CONCAT(am_agent_permit.file_path,'.',am_agent_permit.file_ext) as file_path,
                        '--' as author,".AgentDocType::Qualification." as file_type,
                        am_agent_permit.create_time,
                        am_agent_permit.create_uid,
                        CONCAT(add_user.user_name,add_user.e_name) as create_user_name,
                        am_agent_permit.update_time,
                        am_agent_permit.update_uid,
                        CONCAT(update_user.user_name,update_user.e_name) as update_user_name 
                        FROM am_agent_permit 
                        INNER JOIN am_agent_source on am_agent_source.agent_id = am_agent_permit.agent_id 
                        left JOIN sys_user AS add_user ON add_user.user_id = am_agent_permit.create_uid
                        left JOIN sys_user AS update_user ON update_user.user_id = am_agent_permit.update_uid 
                        union all 
                        SELECT
                        sys_upload_doc.doc_id,
                        sys_upload_doc.object_type,
                        sys_upload_doc.object_id,
                        sys_upload_doc.object_no,
                        sys_upload_doc.object_name,
                        sys_upload_doc.file_name,
                        sys_upload_doc.file_path,
                        sys_upload_doc.author,
                        sys_upload_doc.file_type,
                        sys_upload_doc.create_time,
                        sys_upload_doc.create_uid,
                        sys_upload_doc.create_user_name,
                        sys_upload_doc.update_time,
                        sys_upload_doc.update_uid,
                        sys_upload_doc.update_user_name 
                        FROM
                        sys_upload_doc 
                        where sys_upload_doc.is_del=0 and sys_upload_doc.object_type=".UploadDocObjctType::Agent."  
                        ) as sys_upload_doc 
                    INNER JOIN am_agent_source ON sys_upload_doc.object_id = am_agent_source.agent_id 
                    Left JOIN `am_agent_share` ON am_agent_share.agent_id = am_agent_source.agent_id and am_agent_share.is_del=0 
                    where am_agent_source.is_del <> 2 $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        }
        
        $sqlData = "SELECT sys_upload_doc.doc_id,
                sys_upload_doc.object_type,
                sys_upload_doc.file_name,
                sys_upload_doc.file_path,
                sys_upload_doc.author,
                sys_upload_doc.file_type,
                sys_upload_doc.create_time,
                sys_upload_doc.create_uid,
                sys_upload_doc.create_user_name,
                sys_upload_doc.update_time,
                sys_upload_doc.update_uid,
                sys_upload_doc.update_user_name,
                am_agent_source.agent_id,
                am_agent_source.agent_no,
                am_agent_source.agent_name,
                am_agent_source.channel_uid 
                FROM (
                        SELECT am_agent_permit.aid as doc_id,
                        ".UploadDocObjctType::Agent." as object_type,
                        am_agent_permit.agent_id as object_id,
                        am_agent_source.agent_no as object_no,
                        am_agent_source.agent_name as object_name,
                        CONCAT(am_agent_permit.permit_name,'.',am_agent_permit.file_ext) as file_name,
                        CONCAT(am_agent_permit.file_path,'.',am_agent_permit.file_ext) as file_path,
                        '--' as author,".AgentDocType::Qualification." as file_type,
                        am_agent_permit.create_time,
                        am_agent_permit.create_uid,
                        CONCAT(add_user.user_name,add_user.e_name) as create_user_name,
                        am_agent_permit.update_time,
                        am_agent_permit.update_uid,
                        CONCAT(update_user.user_name,update_user.e_name) as update_user_name 
                        FROM am_agent_permit 
                        INNER JOIN am_agent_source on am_agent_source.agent_id = am_agent_permit.agent_id 
                        left JOIN sys_user AS add_user ON add_user.user_id = am_agent_permit.create_uid
                        left JOIN sys_user AS update_user ON update_user.user_id = am_agent_permit.update_uid 
                        union all 
                        SELECT
                        sys_upload_doc.doc_id,
                        sys_upload_doc.object_type,
                        sys_upload_doc.object_id,
                        sys_upload_doc.object_no,
                        sys_upload_doc.object_name,
                        sys_upload_doc.file_name,
                        sys_upload_doc.file_path,
                        sys_upload_doc.author,
                        sys_upload_doc.file_type,
                        sys_upload_doc.create_time,
                        sys_upload_doc.create_uid,
                        sys_upload_doc.create_user_name,
                        sys_upload_doc.update_time,
                        sys_upload_doc.update_uid,
                        sys_upload_doc.update_user_name 
                        FROM
                        sys_upload_doc 
                        where sys_upload_doc.is_del=0 and sys_upload_doc.object_type=".UploadDocObjctType::Agent."  
                        ) as sys_upload_doc  
                INNER JOIN am_agent_source ON sys_upload_doc.object_id = am_agent_source.agent_id 
                Left JOIN `am_agent_share` ON am_agent_share.agent_id = am_agent_source.agent_id and am_agent_share.is_del=0  
                where 
                am_agent_source.is_del <> 2 $strWhere $strOrder LIMIT $offset,$iPageSize";
        
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

}
		 