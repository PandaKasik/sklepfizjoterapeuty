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
    die('niezdefiniowana wersja');
    exit;
}

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;


class Panda_Menu extends Module
{
    protected $config_form = false;
    const FILE_EXTENSION = '.html';
    public static $folder = _PS_ROOT_DIR_ . '/var/cache/' . (_PS_MODE_DEV_ ? 'dev' : 'prod') . '/panda/';

    public function __construct()
    {
        $this->name = 'panda_menu';
        $this->tab = 'administration';
        $this->version = '1.0.5';
        $this->author = 'Panda Coders';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Panda Menu');
        $this->description = $this->l('Moduł do zarządzania menu');
    }


    public function install()
    {
        if (!$this->installDB()) {
            return false;
        }

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayNavPandaMenu') &&
            $this->registerHook('displayNavPandaMenuMobile') &&

            $this->installTabs();
    }

    public function installDB()
    {
        $engine = 'InnoDB';
        $table1 = _DB_PREFIX_ . PandaMenuObject::getTableName();
        $table2 = _DB_PREFIX_ . PandaMenuElement::getTableName();

        $sqls[] = "CREATE TABLE IF NOT EXISTS `$table1` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `active` TINYINT(1) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
        ) ENGINE=$engine DEFAULT CHARSET=utf8;";

        $sqls[] = "CREATE TABLE IF NOT EXISTS `$table2` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `menu_id` INT UNSIGNED DEFAULT NULL,
            `parent_id` INT UNSIGNED DEFAULT NULL,
            `order_num` INT UNSIGNED DEFAULT NULL,
            `title` VARCHAR(255) DEFAULT NULL,
            `submenu` TINYINT(1) DEFAULT NULL,
            `submenu_title` VARCHAR(200) DEFAULT NULL,
            `url_type` VARCHAR(20) DEFAULT NULL,
            `url` VARCHAR(245) DEFAULT NULL,
            `image_desktop` VARCHAR(245) DEFAULT NULL,
            `image_mobile` VARCHAR(245) DEFAULT NULL,
            `target` VARCHAR(245) DEFAULT NULL,
            `column_number` INT DEFAULT 0,
            `active` VARCHAR(1) DEFAULT NULL,
            `menu_level` INT DEFAULT NULL,
            `class` VARCHAR(100) DEFAULT NULL,
            `column_width` VARCHAR(10) DEFAULT NULL,
            `hook` VARCHAR(100) DEFAULT NULL,
            `date_add` DATETIME DEFAULT NULL,
            `date_upd` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            INDEX (`menu_id`),
            INDEX (`parent_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


        foreach ($sqls as $sql) {
            if (!Db::getInstance()->execute($sql)) {
                throw new PrestashopException('Failed to install Panda Menu table: ' . $sql);
                exit;
            }
        }

        return true;
    }
    public function uninstall()
    {
        return parent::uninstall();
    }


    public function hookDisplayBackOfficeHeader()
    {

        $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        $this->context->controller->addJS($this->_path . 'views/js/back.js');
        $controller = Tools::getValue('controller');
        if ($controller === 'AdminPandaMenuElementEdit') {
            Media::addJsDef([
                'PANDACODERS_AJAX_URL' => $this->context->link->getAdminLink('AdminPandaMenuElementEdit', true, [], ['ajax' => 1, 'action' => 'searchCategory']),
            ]);
            $this->context->controller->addJS($this->_path . 'views/js/category_autocomplete.js');
            $this->context->controller->addJqueryUI('ui.autocomplete');
        }


    }

    public function hookDisplayHeader()
    {

        $this->context->controller->addJS($this->_path . 'views/js/front.js');
        $this->context->controller->addJS($this->_path . 'views/js/menuMobile.js');
        $this->context->controller->addJS($this->_path . 'views/js/menuDesktop.js');

      

    }

    protected function getScreenWidthFromCookie(): bool|int
    {
        $cookieName = 'panda_screen_width';

        if (!isset($_COOKIE[$cookieName])) {
            return false; 
        }

        $width = (int) $_COOKIE[$cookieName];
        
        if ($width <= 0) {
            return false;
        }

        return $width;
    }
    public function hookDisplayNavPandaMenu($params)
    {
        $screenWidth = $this->getScreenWidthFromCookie();

        if ($screenWidth !== false && $screenWidth <= 1200) {
            return '';
        }
        $menu_id = $params['menu'] ?? false;

        if (!$menu_id) {
            return;
        }

        $cacheKey = (int) $menu_id . '_desktop_lang_' . (int) $this->context->language->id;

        $cache = PandaCache::get(PandaCache::CACHE_MENU, $cacheKey);
        if ($cache !== false) {
            return $cache;
        }

        $menu = new PandaMenuObject($menu_id);
        $menu_elements = $menu->getChilds();

        $this->context->smarty->assign([
            'menu_elements' => $menu_elements,
            'module_assets' => __PS_BASE_URI__ . 'modules/panda_menu/views'
        ]);

        $output = $this->display(__FILE__, 'views/templates/hook/menu-desktop.tpl');

        if (!empty($output)) {
            PandaCache::set(PandaCache::CACHE_MENU, $cacheKey, $output);
        }

        return $output;
    }




    public function hookDisplayNavPandaMenuMobile($params)
    {   
         $screenWidth = $this->getScreenWidthFromCookie();

        if ($screenWidth !== false && $screenWidth > 1200) {
            return '';
        }
        $menu_id = $params['menu'] ?? false;

        if (!$menu_id) {
            return;
        }

        $cacheKey = (int) $menu_id . '_mobile_lang_' . (int) $this->context->language->id;

        $cache = PandaCache::get(PandaCache::CACHE_MENU, $cacheKey);
        if ($cache !== false) {
            return $cache;
        }

        $menu = new PandaMenuObject($menu_id);
        $menu_elements = $menu->getChilds();

        $this->context->smarty->assign([
            'menu_elements' => $menu_elements,
            'module_assets' => __PS_BASE_URI__ . 'modules/panda_menu/views'
        ]);

        $output = $this->display(__FILE__, 'views/templates/hook/menu-mobile.tpl');

        if (!empty($output)) {
            PandaCache::set(PandaCache::CACHE_MENU, 'mobile_lang_' . $this->context->language->id, $output);
        }

        return $output;

    }


    public function installTabs()
    {

        $class1 = 'AdminPandaMenu';
        $name1 = 'Panda Menu';
        $parentClass1 = 'AdminPandafeaturesManagement';
        $class2 = 'AdminPandaMenuElement';
        $name2 = 'Panda Menu Element';
        $parentClass2 = '';
        $class3 = 'AdminPandaMenuElementEdit';
        $name3 = 'Panda Menu Element Edit';

        $class4 = 'AdminPandaMenuEdit';
        $name4 = 'Panda Menu Edit';

        if (!Tab::getIdFromClassName($parentClass1)) {
            if (!$this->addTab($parentClass1, 'PANDACODERS', 'SELL', $this->name)) {
                return false;
            } else {
                $id_tab = Tab::getIdFromClassName($parentClass1);
                Tab::initAccess($id_tab);
            }
        }

        if (!Tab::getIdFromClassName($class1)) {
            if (!$this->addTab($class1, $name1, $parentClass1, $this->name)) {
                return false;
            } else {
                $id_tab = Tab::getIdFromClassName($class1);
                Tab::initAccess($id_tab);
            }
        }
        if (!Tab::getIdFromClassName($class2)) {
            if (!$this->addTab($class2, $name2, $parentClass2, $this->name)) {
                return false;
            } else {
                $id_tab = Tab::getIdFromClassName($class2);
                Tab::initAccess($id_tab);
            }
        }
        if (!Tab::getIdFromClassName($class3)) {
            if (!$this->addTab($class3, $name3, $parentClass2, $this->name)) {
                return false;
            } else {
                $id_tab = Tab::getIdFromClassName($class3);
                Tab::initAccess($id_tab);
            }
        }
        if (!Tab::getIdFromClassName($class4)) {
            if (!$this->addTab($class4, $name4, $parentClass2, $this->name)) {
                return false;
            } else {
                $id_tab = Tab::getIdFromClassName($class4);
                Tab::initAccess($id_tab);
            }
        }

        return (Tab::getIdFromClassName($class1) && Tab::getIdFromClassName($class2) && Tab::getIdFromClassName($class3) && Tab::getIdFromClassName($class4)) ? true : false;


    }

    public function addTab($class, $name, $parentClass, $module)
    {
        $id_parent = Tab::getIdFromClassName($parentClass);
        if (!$id_parent) {
            $id_parent = -1; //hidden controller
        }
        $tab1 = new Tab();
        $tab1->class_name = $class;
        $tab1->module = $module;
        $tab1->id_parent = $id_parent;
        $langs = Language::getLanguages(false);
        foreach ($langs as $l) {
            $tab1->name[$l['id_lang']] = $this->l($name);
        }
        return $tab1->add();
    }


   

}