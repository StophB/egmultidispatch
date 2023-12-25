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
class EgMultiDispatchClass extends ObjectModel
{
    public $id_eg_multidispatch;
    public $adherant;
    public $host;
    public $login;
    public $pass;
    public $branch;
    public $database;
    public $position;
    public $active;


    public static $definition = [
        'table' => 'eg_multidispatch',
        'primary' => 'id_eg_multidispatch',
        'fields' => [
            'adherant' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'host' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'login' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'pass' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'branch' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'database' =>['type' => self::TYPE_STRING, 'validate' => 'isGenericName'],
            'position' =>['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'active' =>['type' => self::TYPE_BOOL],
        ]
    ];
    
    public static function getDataBases() {
        $mysqli = new mysqli('127.0.0.1', 'root', '');

        if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

        $result = $mysqli->query("SHOW DATABASES");
        $databases = [];

        while ($row = $result->fetch_assoc()) {
            $databases[] = $row['Database'];
        }

        $mysqli->close();

        return $databases;
    }



    public static function getCheckedDataBases($selectedSites) {
        $selectedSites = array_map('intval', $selectedSites);

        $query = new DbQuery();
        $query->select('`database`');
        $query->from('eg_multidispatch', 'eg');
        $query->where('`id_eg_multidispatch` IN (' . implode(',', $selectedSites) . ')');

        return Db::getInstance()->executeS($query);
    }

    public static function getListing()
    {
        $query = new DbQuery();
        $query->select('*');
        $query->from('eg_multidispatch');

        return Db::getInstance()->executeS($query);
    }

    public static function executeSqlQueryOnDatabase($host, $user, $password, $databaseName, $sqlQuery) {
        // Create a new mysqli connection
        $db = new mysqli($host, $user, $password);

        // Check for connection error
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Attempt to select the specified database
        if ($db->select_db($databaseName)) {
            // Execute the SQL query
            $db->query($sqlQuery);
        } else {
            die("Database selection failed: " . $db->error);
        }

        // Close the database connection
        $db->close();
    }

    public function add($autoDate = true, $nullValues = false)
    {
        $this->position = (int) $this->getMaxPosition() + 1;
        return parent::add($autoDate, $nullValues);
    }

    public static function getMaxPosition()
    {
        $query = new DbQuery();
        $query->select('MAX(position)');
        $query->from('eg_multidispatch', 'eg');

        $response = Db::getInstance()->getRow($query);

        if ($response['MAX(position)'] == null){
            return -1;
        }
        return $response['MAX(position)'];
    }

    public function updatePosition($way, $position)
    {
        $query = new DbQuery();
        $query->select('eg.`id_eg_multidispatch`, eg.`position`');
        $query->from('eg_multidispatch', 'eg');
        $query->orderBy('eg.`position` ASC');
        $tabs = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        if (!$tabs ) {
            return false;
        }

        foreach ($tabs as $tab) {
            if ((int) $tab['id_eg_multidispatch'] == (int) $this->id) {
                $moved_tab = $tab;
            }
        }

        if (!isset($moved_tab) || !isset($position)) {
            return false;
        }

        // < and > statements rather than BETWEEN operator
        // since BETWEEN is treated differently according to databases
        return (Db::getInstance()->execute('
            UPDATE `'._DB_PREFIX_.'eg_multidispatch`
            SET `position`= `position` '.($way ? '- 1' : '+ 1').'
            WHERE `position`
            '.($way
                    ? '> '.(int)$moved_tab['position'].' AND `position` <= '.(int)$position
                    : '< '.(int)$moved_tab['position'].' AND `position` >= '.(int)$position
                ))
            && Db::getInstance()->execute('
            UPDATE `'._DB_PREFIX_.'eg_multidispatch`
            SET `position` = '.(int)$position.'
            WHERE `id_eg_multidispatch` = '.(int)$moved_tab['id_eg_multidispatch']));
    }
}

