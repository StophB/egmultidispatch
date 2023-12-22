<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once(dirname(__FILE__) . '/classes/EgMultiDispatchClass.php');

class EgMultiDispatch extends Module
{
    public function __construct()
    {
        $this->name = 'egmultidispatch';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'EGIODIGITAL';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->domain = 'Modules.Egmultidispatch.Egmultidispatch';
        $this->displayName = $this->l('Eg Multi Dispatch');
        $this->description = $this->l('Module dispatche code & bdd to multi sites');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], $this->domain);
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
    }

    public function createTabs()
    {
        $idParent = (int) Tab::getIdFromClassName('AdminEgDigital');
        if (empty($idParent)) {
            $parent_tab = new Tab();
            $parent_tab->name = array();
            foreach (Language::getLanguages(true) as $lang) {
                $parent_tab->name[$lang['id_lang']] = $this->trans('Modules EGIO', array(), $this->domain);
            }
            $parent_tab->class_name = 'AdminEgDigital';
            $parent_tab->id_parent = 0;
            $parent_tab->module = $this->name;
            $parent_tab->icon = 'library_books';
            $parent_tab->add();
        }

        $tab = new Tab();
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Manage Eg Multidispatch', array(), $this->domain);
        }
        $tab->class_name = 'AdminEgMultiDispatchGeneral';
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminEgDigital');
        $tab->module = $this->name;
        $tab->icon = 'library_books';
        $tab->add();

        //  Crud adherant
        $tab = new Tab();
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Ajouter site adhérant', array(), $this->domain);
        }
        $tab->class_name = 'AdminEgMultidispatch';
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminEgMultiDispatchGeneral');
        $tab->module = $this->name;
        $tab->add();

        // listing site
        $tab = new Tab();
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('Gestion site adhérant', array(), $this->domain);
        }
        $tab->class_name = 'AdminEgListingSite';
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminEgMultiDispatchGeneral');
        $tab->module = $this->name;
        $tab->add();

        return true;
    }

    public function removeTabs($class_name)
    {
        if ($tab_id = (int)Tab::getIdFromClassName($class_name)) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }
        return true;
    }

    public function install()
    {
        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install()  &&
            $this->createTabs() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        include(dirname(__FILE__) . '/sql/uninstall.php');

        //$this->removeTabs('AdminEgDigital');
        $this->removeTabs('AdminEgMultiDispatchGeneral');
        $this->removeTabs('AdminEgCrudAdherant');
        $this->removeTabs('AdminEgListingSite');
        return parent::uninstall();
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/back.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');

    }
}
