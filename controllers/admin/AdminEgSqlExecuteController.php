<?php
/**
 * 2023 (c)  Egio digital
 *
 * MODULE EgMultidispatch
 *
 * @author    Egio digital
 * @copyright Copyright (c) , Egio digital
 * @license   Commercial
 * @version    1.0.0
 */

class AdminEgSqlExecuteController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }

    public function init()
    {
        parent::init();

        $databases = EgMultidispatchClass::getDataBases();
        $checkedDatabases = [];
        $selectedSites = json_decode($this->context->cookie->selectedIds, true);
        if ($selectedSites) {
            $checkedDatabases = EgMultidispatchClass::getCheckedDataBases($selectedSites);
        }
        // dump($checkedDatabases);dump($databases);die();

        Context::getContext()->smarty->assign(array(
            'databases' => $databases,
            'checkedDatabases' => $checkedDatabases,
        ));
        $this->setTemplate('sql_execute.tpl');
    }

    public function postProcess() {
        if (Tools::isSubmit('submitQuery')) {
            $selectedDatabases = Tools::getValue('databases', array());
            $sqlQuery = Tools::getValue('sql_request');

            $host = '127.0.0.1';
            $user = 'root';
            $password = '';

            if (!empty($sqlQuery)) {
                foreach ($selectedDatabases as $databaseName) {
                    EgMultidispatchClass::executeSqlQueryOnDatabase($host, $user, $password, $databaseName, $sqlQuery);
                }

                $this->confirmations[] = $this->l('SQL queries sent to selected databases.');
            } else {
                $this->errors[] = $this->l('SQL query is empty. Please provide a valid SQL query.');
            }
        }
    }




}
