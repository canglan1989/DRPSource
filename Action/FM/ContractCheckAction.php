<?php

/**
 * @functional 财务端合同部审核审核签约合同
 * @author liujunchen
 * @copyright 盘石
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentPactInfo.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../Class/Model/ProductTypeInfo.php';

require_once __DIR__ . '/../Common/ExportExcel.php';

class ContractCheckAction extends ActionBase
{

    private $strWhere = '';
    private $strTitle = '';
    private $objAgentPactBLL = '';
    private $objProductTypeBLL = '';

    public function __construct()
    {
        $this->objAgentPactBLL = new AgentPactBLL();
        $this->objProductTypeBLL = new ProductTypeBLL();
    }

    /**
     * @functional 显示合同部签约审核记录分页
     * @author liujunchen
     */
    public function ContractCheckPager()
    {
        //获取产品
        $this->PageRightValidate("ContractCheck", RightValue::view);
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);
        $strUrl = $this->getActionUrl('FM', 'ContractCheck', 'ContractCheckList');
        $unCheckNum = $this->objAgentPactBLL->getSignUnCheckNum();
        $arrAssign = array(
            'strTitle' => '合同部签约审核',
            'strUrl' => $strUrl,
            'arrProductType' => $arrJsonType,
            'unCheckNum' => $unCheckNum
        );
        $this->displayPage('FM/Backend/ContractCheckPager.tpl', $arrAssign);
    }

    /**
     * @functional 显示合同部签约审核列表
     * @author liujunchen
     */
    public function ContractCheckList()
    {
        $arrPageList = $this->getContractCheckList(FALSE);
        $this->showPageSmarty($arrPageList, 'FM/Backend/ContractCheckList.tpl');
    }

    public function ExportContractCheckList()
    {
        $objDataToExcel = new DataToExcel();
        $data = $this->getContractCheckList(true);
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商编号", "agent_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "cur_agent_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("注册地区", "area_fullname"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("虚拟合同号", "pact_number"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("签约类型", "pact_stage"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品等级", "level_stat"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品", "product_type_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人", "e_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间", "create_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("审核状态", "check_stat"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("保证金", "cash_deposit"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款", "pre_deposit"));
        $objDataToExcel->Init("代理商列表", $data, null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }

    public function getContractCheckList($isDownload)
    {
        $sOrder = Utility::GetForm("sortField", $_GET);
        $agent_name = isset($_GET['agentName']) ? trim($_GET['agentName']) : '';
        if ($agent_name != '')
        {
            if ($this->inject_check($agent_name))
            {
                $this->echoJS2Page('请重新输入搜索条件！', 'S_FAIL');
            }
            else
            {
                $this->strWhere .= " AND (A.`cur_agent_name` LIKE '%" . $agent_name . "%' OR A.`company_name` like '%{$agent_name}%') ";
            }
        }
        $provinceId = isset($_GET['provinceId']) ? intval($_GET['provinceId']) : 0;
        if ($provinceId > 0)
        {
            $this->strWhere .= " AND E.`reg_province_id` = " . $provinceId . "";
        }
        $cityId = isset($_GET['cityId']) ? intval($_GET['cityId']) : '';
        if ($cityId > 0)
        {
            $this->strWhere .= " AND E.reg_city_id = " . $cityId . "";
        }
        $areaId = isset($_GET['areaId']) ? intval($_GET['areaId']) : 0;
        if ($areaId > 0)
        {
            $this->strWhere .= " AND E.reg_area_id = " . $areaId . "";
        }
        $pactType = isset($_GET['pactType']) ? $_GET['pactType'] : 0;
        if ($pactType > 0)
        {
            $this->strWhere .= " AND A.pact_type = " . $pactType . "";
        }
        $checkStatus = isset($_GET['checkStatus']) ? $_GET['checkStatus'] : '';
        if ($checkStatus > '-1')
        {
            $this->strWhere .= " AND A.contract_check = " . $checkStatus . "";
        }
        $agentLevel = isset($_GET['agentLevel']) ? $_GET['agentLevel'] : '';
        if ($agentLevel > '-1')
        {
            $this->strWhere .= " AND A.agent_level = '" . $agentLevel . "'";
        }
        $startDate = isset($_GET['J_cTimeS']) ? Utility::getValueNull2Empty('J_cTimeS', $_GET) : '';
        $endDate = isset($_GET['J_cTimeE']) ? Utility::getValueNull2Empty('J_cTimeE', $_GET) : '';
        if ($startDate != '')
        {
            $this->strWhere .= " AND A.`create_time` >= '" . $startDate . "'";
        }
        if ($endDate != '')
        {
            $this->strWhere .= " AND A.`create_time` < date_add('" . $endDate . "',interval 1 day)";
        }
        $createName = isset($_GET['createName']) ? Utility::getValueNull2Empty('createName', $_GET) : '';
        if ($createName != '')
        {
            $this->strWhere .= " AND C.`e_name` LIKE '%" . $createName . "%'";
        }
        $productType = isset($_GET['productType']) ? trim($_GET['productType']) : '';
        if ($productType != '')
        {
            $this->strWhere .= " AND A.product_id IN ($productType)";
        }

        return $arrPageList = $this->objAgentPactBLL->getContractListData($this->strWhere, $sOrder, $isDownload);
    }

}