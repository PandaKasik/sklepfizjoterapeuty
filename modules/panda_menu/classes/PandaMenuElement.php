<?php

class PandaMenuElement extends ObjectModel
{
    public $id;
    public $menu_id;
    public $parent_id;
    public $order_num;
    public $title;
    public $submenu;
    public $submenu_title;
    public $url_type;
    public $url;
    public $image_desktop;
    public $image_mobile;
    public $target;
    public $column_number;
    public $active;
    public $menu_level;
    public $class;
    public $column_width;
    public $hook;
    public $date_add;
    public $date_upd;


   

    const URL_TYPES = [
        'url' => 'własny link',
        'category' => 'Kategoria',
    ];

    public static $definition = array(
        'table' => 'panda_menu_elements',
        'primary' => 'id',
        'fields' => array(
            'menu_id' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => false),
            'parent_id' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => false),
            'order_num' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => false),
            'title' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 255, 'required' => false),
            'submenu' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'submenu_title' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 200, 'required' => false),
            'url_type' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 20, 'required' => false),
            'url' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 245, 'required' => false),
            'image_desktop' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 245, 'required' => false),
            'image_mobile' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 245, 'required' => false),
            'target' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 245, 'required' => false),
            'column_number' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => false, 'default' => 0),
            'active' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 1, 'required' => false),
            'menu_level' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => false),
            'class' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 100, 'required' => false),
            'column_width' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 10, 'required' => false),
            'hook' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 100, 'required' => false),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => false),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => false),
        ),
    );

    public static function getTableName()
    {
        return self::$definition['table'];
    }
    public function update($null_values = false)
    {
        $this->updateColumnNumber();
        $this->date_upd = date('Y-m-d H:i:s');
         $this->deleteCache();
        return parent::update($null_values);
    }
    public function add($autodate = true, $null_values = false)
    {
        if (!$this->date_add) {
            $this->date_add = date('Y-m-d H:i:s');
        }
        if (!$this->parent_id) {
            $this->parent_id = Tools::getValue('parent_id', 0);
        }
        if (!$this->menu_id) {
            $this->setMenuIdByParentId();
        }
        $this->date_upd = date('Y-m-d H:i:s');

        $this->deleteCache();
        return parent::add($autodate, $null_values);
    }

    public function updateColumnNumber()
    {
        $this->column_number = (int) Db::getInstance()->getValue('SELECT COUNT(*) FROM ' . _DB_PREFIX_ . 'pandamenu_elements WHERE parent_id = ' . (int) $this->id);
    }
    public function setMenuIdByParentId()
    {
        if ($this->parent_id) {
            $sql = new DbQuery();
            $sql->select('menu_id');
            $sql->from('pandamenu_elements');
            $sql->where('id = ' . (int) $this->parent_id);
            $result = Db::getInstance()->getValue($sql);
            if ($result) {
                $this->menu_id = $result['menu_id'];

            }
        } else if ($this->parent_id == 0) {
            $this->menu_id = Tools::getValue('menu_id', 0);
        }
    }

    public function setHideParamByParent()
    {
        $sql = new DbQuery();
        $sql->select('id, menu_id,menu_level');
        $sql->from('pandamenu_elements');
        $sql->where('id = ' . (int) $this->parent_id);
        $result = Db::getInstance()->getRow($sql);

        if ($result) {
            $this->menu_id = $result['menu_id'];
            $this->menu_level = $result['menu_level'] + 1;
        }
        $this->updateColumnNumber();
        $order_num = (int) Db::getInstance()->getValue('SELECT MAX(order_num) FROM ' . _DB_PREFIX_ . 'pandamenu_elements WHERE menu_id = ' . (int) $this->menu_id . ' AND parent_id = 0');
        $this->order_num = $order_num + 1;

    }

    public function getFullPath()
    {
        $path = [];
        // Get menu name
        if ($this->menu_id) {
            $menu = Db::getInstance()->getRow('SELECT name FROM ' . _DB_PREFIX_ . 'pandamenu WHERE id = ' . (int) $this->menu_id);
            if ($menu && isset($menu['name'])) {
                $path[] = [
                    'name' => $menu['name'],
                    'url' => Context::getContext()->link->getAdminLink('AdminPandaMenuElement', true, [], ['menu_id' => $this->menu_id])
                ];
            }
        }
        if ($this->parent_id) {
            $parent = new PandaMenuElement($this->parent_id);
            $parentPath = $parent->getFullPath();

            if (!empty($parentPath) && isset($path[0]) && $parentPath[0] === $path[0]) {
                array_shift($parentPath);
            }
            $path = array_merge($path, $parentPath);
        }
        $path[] = [
            'name' => $this->title,
            'url' => Context::getContext()->link->getAdminLink('AdminPandaMenuElement', true, [], ['parent_id' => $this->id])
        ];
        return $path;
    }

   

    public static function getUrlTypes()
    {
        $res = [];
        foreach (self::URL_TYPES as $key => $value) {
            $res[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return $res;
    }

   
  
    public function getName()
    {
        return $this->title;
    }

    public function updatePosition($position)
    {
        $this->position = (int) $position;
        return $this->update();
    }

    public static function getImgsNames($id)
    {
        $sql = new DbQuery();
        $sql->select('image_desktop, image_mobile');
        $sql->from('pandamenu_elements');
        $sql->where('id = ' . (int) $id);
        $result = Db::getInstance()->getRow($sql);
        if ($result) {
            return [$result['image_desktop'] ?? null, $result['image_mobile'] ?? null];
        }
        return [null, null];
    }


    public static function getElementsMenu($menu_id)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('pandamenu_elements');
        $sql->where('menu_id = ' . (int) $menu_id . ' AND parent_id = 0 and active = 1');
        $sql->orderBy('order_num ASC');
        $result = Db::getInstance()->executeS($sql);

        $elements = [];
        if ($result) {
            foreach ($result as $row) {
                $obj = new self($row['id']);
                $elements[] = $obj->present();
            }
        }
        return $elements;
    }


    public function present()
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'parent_id' => $this->parent_id,
            'menu_id' => $this->menu_id,
            'menu_level' => $this->menu_level,
            'order_num' => $this->order_num,
            'submenu' => $this->submenu,
            'submenu_title' => $this->submenu_title,
            'url_type' => $this->url_type,
            'target' => $this->target,
            'hook' => $this->hook,
            'column_number' => $this->column_number,
            'active' => $this->active,
            'class' => $this->class,
            'column_width' => $this->column_width,
            'date_add' => $this->date_add,
            'date_upd' => $this->date_upd,
        ];
        $data['url'] = $this->getUrl();
        $data['image_desktop'] = $this->getDesptopImage();
        $data['image_mobile'] = $this->getMobileImage();
        $data['icon'] = $this->getIcon();
        $data['childs'] = $this->getChilds();
        return $data;
    }

    public function getUrl()
    {
        $link = Context::getContext()->link;
        switch ($this->url_type) {
            case 'url':
                return $this->url;
            case 'category':
                $category = $link->getCategoryLink($this->url);
                return $category;
            default:
                return '';
        }
    }
    public function getIcon()
    {

        if (!$this->icon) {
            return false;
        }
        return 'https://' . Tools::getMediaServer($this->id) . '/modules/pandamenu/views/img/' . $this->icon . '.png';
    }
    public function getDesptopImage()
    {
        return $this->getUploadedImage('image_desktop');
    }
    public function getMobileImage()
    {
        return $this->getUploadedImage('image_mobile');
    }
    public function getUploadedImage($field)
    {
        if ($this->{$field}) {
            $path = _PS_MODULE_DIR_ . 'pandamenu/uploads/' . $this->{$field};
            if (file_exists($path)) {
                return 'https://' . Tools::getMediaServer($this->id) . '/modules/pandamenu/uploads/' . $this->{$field};
            }
        }
        return false;
    }


    public function getChilds()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('pandamenu_elements');
        $sql->where('parent_id = ' . (int) $this->id);
        $sql->orderBy('order_num ASC');
        $result = Db::getInstance()->executeS($sql);
        $elements = [];
        if ($result) {
            foreach ($result as $row) {
                $obj = new self($row['id']);
                $elements[] = $obj->present();
            }
        }
        return $elements;
    }


    public function deleteCache()
    {
        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $file1 = _PS_MODULE_DIR_ . 'pandamenu/cache/menu_' . (int) $this->menu_id . '_lang_' . (int) $lang['id_lang'] . '.txt';
            if (file_exists($file1)) {
                unlink($file1);
            }
            $file2 = _PS_MODULE_DIR_ . 'pandamenu/cache/menu_' . (int) $this->menu_id . '_lang_' . (int) $lang['id_lang'] . '_mobile.txt';
            if (file_exists($file2)) {
                unlink($file2);
            }
            $file3 = _PS_MODULE_DIR_ . 'pandamenu/cache/menu_' . (int) $this->menu_id . '_lang_' . (int) $lang['id_lang'] . '_desktop.txt';
            if (file_exists($file3)) {
                unlink($file3);
            }
           
        }
    }
}