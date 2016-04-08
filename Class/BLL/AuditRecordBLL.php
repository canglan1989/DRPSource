<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表com_audit_record的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-20 17:00:08
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AuditRecordInfo.php';

class AuditRecordBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @return 
     */
    public function insert($strTableName,$iTid,$iAuditUid,$iStepIndex,$bIsPass,$remark)
    {
        $sql = "SELECT count(1) FROM `com_audit_record` where t_name='".$strTableName."' and t_id=".$iTid;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sql,null);
		$iRecordCount += 1;
        
        $iAuditStatus = 0;
        if($bIsPass == true)
        {
            $iAuditStatus = $iStepIndex;
        }
        else
        {
            $iAuditStatus = $iStepIndex."".($iStepIndex-1);
        }
		$sql = "INSERT INTO `com_audit_record`(`t_name`,`t_id`,`step_index`,`audit_index`,`audit_uid`,`audit_time`,`audit_status`,`is_pass`,`status_text`,`audit_remark`)"
		." values('".$strTableName."',".$iTid.",".$iStepIndex.",".$iRecordCount.",".$iAuditUid.",now(),".$iAuditStatus.",".($bIsPass == true ? "1" : "0").",'','".$remark."')";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }

	/**
     * @functional 根据ID更新一条记录
     * @param AuditRecordInfo $objAuditRecordInfo  AuditRecord实例
     * @return
     */
	public function updateByID(AuditRecordInfo $objAuditRecordInfo)
	{
		$sql = "update `com_audit_record` set `t_name`='".$objAuditRecordInfo->strtName."',`t_id`=".$objAuditRecordInfo->itId.",`step_index`=".$objAuditRecordInfo->iStepIndex.",`audit_index`=".$objAuditRecordInfo->iAuditIndex.",`audit_uid`=".$objAuditRecordInfo->iAuditUid.",`audit_time`='".$objAuditRecordInfo->strAuditTime."',`audit_status`=".$objAuditRecordInfo->iAuditStatus.",`is_pass`=".$objAuditRecordInfo->iIsPass.",`status_text`='".$objAuditRecordInfo->strStatusText."',`audit_remark`='".$objAuditRecordInfo->strAuditRemark."' where record_id=".$objAuditRecordInfo->iRecordId;
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
			$sField = T_AuditRecord::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `com_audit_record` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个com_audit_record对象
	 * @param int $id 
     * @return com_audit_record对象
     */
	public function getModelByID($id)
	{
		$objAuditRecordInfo = null;
		$arrayInfo = $this->select("*","record_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAuditRecordInfo = new AuditRecordInfo();
			$objAuditRecordInfo->iRecordId = $arrayInfo[0]['record_id'];
			$objAuditRecordInfo->strtName = $arrayInfo[0]['t_name'];
			$objAuditRecordInfo->itId = $arrayInfo[0]['t_id'];
			$objAuditRecordInfo->iStepIndex = $arrayInfo[0]['step_index'];
			$objAuditRecordInfo->iAuditIndex = $arrayInfo[0]['audit_index'];
			$objAuditRecordInfo->iAuditUid = $arrayInfo[0]['audit_uid'];
			$objAuditRecordInfo->strAuditTime = $arrayInfo[0]['audit_time'];
			$objAuditRecordInfo->iAuditStatus = $arrayInfo[0]['audit_status'];
			$objAuditRecordInfo->iIsPass = $arrayInfo[0]['is_pass'];
			$objAuditRecordInfo->strStatusText = $arrayInfo[0]['status_text'];
			$objAuditRecordInfo->strAuditRemark = $arrayInfo[0]['audit_remark'];
		
			settype($objAuditRecordInfo->iRecordId,"integer");
			settype($objAuditRecordInfo->itId,"integer");
			settype($objAuditRecordInfo->iStepIndex,"integer");
			settype($objAuditRecordInfo->iAuditIndex,"integer");
			settype($objAuditRecordInfo->iAuditUid,"integer");			
			settype($objAuditRecordInfo->iAuditStatus,"integer");
			settype($objAuditRecordInfo->iIsPass,"integer");	
			
		}
		
		return $objAuditRecordInfo;
	}
	
	    public function AuditInfoHTML($tableName,$id)
    {       
        $sql = "SELECT `com_audit_record`.`audit_time`, `com_audit_record`.`is_pass`,
              `com_audit_record`.`status_text`, `com_audit_record`.`audit_remark`,
              `sys_user`.`e_name`, `sys_user`.`user_name` 
            FROM
              `com_audit_record` INNER JOIN
              `sys_user` ON `com_audit_record`.`audit_uid` = `sys_user`.`user_id`              
            where `t_name` = '$tableName' and t_id = $id 
            order by `com_audit_record`.`step_index`,com_audit_record.`audit_index`";
       	
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        { 
            $strHTML = "<div class=\"list_table_head\">
                <div class=\"list_table_head_right\">
                    <div class=\"list_table_head_mid\">
                        <h4 class=\"list_table_title\"><span class=\"ui_icon list_table_title_icon\"></span> 审核信息</h4>
                    </div>
                </div>			           
            </div>
			<div class=\"list_table_main\">
				<div id=\"J_ui_table\" class=\"ui_table\">
				<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
		            <thead class=\"ui_table_hd\">
		            <tr>
		                <th style=\"width:120px\" title=\"审核人\">
		                	<div class=\"ui_table_thcntr \">
		                    	<div class=\"ui_table_thtext\">审核人</div>
		                    </div>
		                </th>
		                <th style=\"width:130px\" title=\"审核时间\">
		                	<div class=\"ui_table_thcntr \">
		                    	<div class=\"ui_table_thtext\">审核时间</div>
		                    </div>
		                </th>
		                <th style=\"width:100px\" title=\"审核状态\">
		                	<div class=\"ui_table_thcntr \">
		                    	<div class=\"ui_table_thtext\">审核状态</div>
		                    </div>
		                </th>
		                <th title=\"审核备注\">
		                	<div class=\"ui_table_thcntr \">
		                    	<div class=\"ui_table_thtext\">审核备注</div>
		                    </div>
		                </th>
		            </tr>
		            </thead>
            <tbody class=\"ui_table_bd\">";            
            $eName = "";
            $strState = "";
            $auditDate = "";
            $arrayLength = count($arrayInfo);
            for($i = 0;$i < $arrayLength; $i++)
            {
                $eName = $arrayInfo[$i]["e_name"]." ".$arrayInfo[$i]["user_name"]." ";
                $strState = $arrayInfo[$i]["is_pass"] == 1 ? "审核通过" : "审核不通过";
                $auditDate = date('y-m-d', strtotime($arrayInfo[$i]["audit_time"]));
                
                $strHTML .= "<tr><td title=\"".$eName."\"><div class=\"ui_table_tdcntr\">".$eName."</div></td>";
                $strHTML .= "<td title=\"".$auditDate."\"><div class=\"ui_table_tdcntr\">".$auditDate."</div></td>";
                $strHTML .= "<td title=\"".$strState."\"><div class=\"ui_table_tdcntr\">".$strState."</div></td>";
                $strHTML .= "<td title=\"".$arrayInfo[$i]["audit_remark"]."\"><div class=\"ui_table_tdcntr\">".$arrayInfo[$i]["audit_remark"]."</div></td></tr>";
            }
            
            $strHTML .= "</tbody> </table> </div></div>";
            return $strHTML;
        }
        
        return "";
    }
    
}
?>
