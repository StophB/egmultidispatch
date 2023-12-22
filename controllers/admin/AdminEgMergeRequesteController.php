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

class AdminEgMergeRequesteController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
    }
    public function init()
    {
        parent::init();
        $ListingBranch = EgMultiDispatchClass::getListing();
        $selectedBranch = json_decode($this->context->cookie->selectedIds, true);

        $this->context->smarty->assign([
            'branchs' => $ListingBranch,
            'selectedBranch' => $selectedBranch,
        ]);
        $this->setTemplate('merge_request.tpl');

    }
}
