<?php
/**
 * 2020  (c)  Egio digital
 *
 * MODULE EgMultidispatch
 *
 * @author    Egio digital
 * @copyright Copyright (c) , Egio digital
 * @license   Commercial
 * @version    1.0.0
 */

class AdminEgMultidispatchController extends ModuleAdminController
{
    protected $position_identifier = 'id_eg_multidispatch';
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'eg_multidispatch';
        $this->className = 'EgMultidispatchClass';
        $this->identifier = 'id_eg_multidispatch';
        $this->_defaultOrderBy = 'position';
        $this->_defaultOrderWay = 'ASC';
        $this->toolbar_btn = null;
        $this->list_no_link = true;
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        parent::__construct();

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            )
        );

        $this->fields_list = array(
            'id_eg_multidispatch' => array(
                'title' => $this->l('Id')
            ),
            'adherant' => array(
                'title' => $this->l('Adherant'),
                'filter_key' => 'b!adherant',
            ),
            'host' => array(
                'title' => $this->l('Host FTP'),
                'filter_key' => 'b!host',
            ),
            'login' => array(
                'title' => $this->l('Login FTP'),
                'filter_key' => 'b!login',
            ),
            'pass' => array(
                'title' => $this->l('Pass FTP'),
                'filter_key' => 'b!pass',
            ),
            'branch' => array(
                'title' => $this->l('Branch'),
                'filter_key' => 'b!branch',
            ),
            'database' => array(
                'title' => $this->l('Base de donne'),
                'filter_key' => 'b!Base de donne',
            ),
            'active' => array(
                'title' => $this->l('Displayed'),
                'align' => 'center',
                'active' => 'status',
                'class' => 'fixed-width-sm',
                'type' => 'bool',
                'orderby' => false
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'filter_key' => 'a!position',
                'position' => 'position',
                'align' => 'center',
                'class' => 'fixed-width-md',
            ),
        );
    }

    /**
     * @see AdminController::initPageHeaderToolbar()
     */
    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_multidispatch'] = array(
                'href' => self::$currentIndex.'&addeg_multidispatch&token='.$this->token,
                'desc' => $this->l('Add new'),
                'icon' => 'process-icon-new'
            );
        }
        parent::initPageHeaderToolbar();
    }


    public function renderForm()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $databases = EgMultidispatchClass::getDataBases();

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Page'),
                'icon' => 'icon-folder-close'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Adherent:'),
                    'name' => 'adherant',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Host FTP:'),
                    'name' => 'host',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Login FTP:'),
                    'name' => 'login',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Pass FTP:'),
                    'name' => 'pass',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Branch:'),
                    'name' => 'branch',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Database:'),
                    'name' => 'database',
                    'options' => array(
                        'query' => array_map(function($db) {
                            return array(
                                'id' => $db,
                                'name' => $db
                            );
                        }, $databases),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        return parent::renderForm();
    }

    /**
     * Update Positions Multidispatch
     */
    public function ajaxProcessUpdatePositions()
    {
        $way = (int)(Tools::getValue('way'));
        $idEgMultidispatch = (int)(Tools::getValue('id'));
        $positions = Tools::getValue($this->table);

        foreach ($positions as $position => $value){
            $pos = explode('_', $value);

            if (isset($pos[2]) && (int)$pos[2] === $idEgMultidispatch){
                if ($Multidispatch = new EgMultidispatchClass((int)$pos[2])){
                    if (isset($position) && $Multidispatch->updatePosition($way, $position)){
                        echo 'ok position '.(int)$position.' for tab '.(int)$pos[1].'\r\n';
                    } else {
                        echo '{"hasError" : true, "errors" : "Can not update tab '
                            .(int)$idEgMultidispatch.' to position '.(int)$position.' "}';
                    }
                } else {
                    echo '{"hasError" : true, "errors" : "This tab ('.(int)$idEgMultidispatch.') can t be loaded"}';
                }
                break;
            }
        }
    }
}
