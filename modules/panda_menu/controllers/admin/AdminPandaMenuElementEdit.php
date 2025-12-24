<?php


class AdminPandaMenuElementEditController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'panda_menu_elements';
        $this->identifier = 'id';
        $this->className = 'PandaMenuElement';
        $this->lang = false;

        $this->addRowAction('delete');




        $id_menu = Tools::getValue('menu_id');
        $parent_id = Tools::getValue('parent_id', 0);


        $this->toolbar_title = $this->getLabelForPage($id_menu, $parent_id);

        $this->fields_list = array(
            'id' => array(
                'title' => 'id',
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'title' => array(
                'title' => 'tytuł',
                'filter_key' => 'a!name'
            ),

        );

        $this->_defaultOrderBy = 'order_num';

        if ($parent_id) {
            $this->_where = 'AND a.parent_id = ' . $parent_id;
        } else {
            $this->_where = 'AND a.menu_id = ' . (int) $id_menu . ' AND a.parent_id = 0';
        }
    }

    private function getLabelForPage($id_menu, $parent_id)
    {

        if ($id_menu) {
            $menu = new PandaMenuObject((int) $id_menu);
            $label = $menu->getName();
        } else if ($parent_id) {
            $element = new PandaMenuElement($parent_id);
            $label = $element->title;
        } else {
            $label = 'Panda Menu';
        }
        return $label;
    }

    public function renderForm()
    {

        list($field_values, $cats, $img_desktop, $id_mobile) = $this->getFormVariables();

        $this->fields_form = [
            'legend' => [
                'title' => 'Edit PandaMenu Element',
            ],
            'input' => [
                [
                    'type' => 'hidden',
                    'name' => 'id',
                ],
                [
                    'type' => 'hidden',
                    'name' => 'parent_id',
                ],

                [
                    'type' => 'text',
                    'label' => 'Nazwa elementu',
                    'name' => 'title',
                    'required' => true,
                ],

                [
                    'type' => 'switch',
                    'label' => 'Jest Kolumną',
                    'name' => 'submenu',
                    'values' => [
                        ['id' => 'submenu_on', 'value' => '1', 'label' => 'Tak'],
                        ['id' => 'submenu_off', 'value' => '0', 'label' => 'Nie'],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => 'Tytuł kolumny',
                    'name' => 'submenu_title',

                ],
                [
                    'type' => 'select',
                    'label' => 'Szerokość kolumny',
                    'name' => 'column_width',
                    'options' => [
                        'query' => [
                            ['id' => 'col-12', 'name' => '100% (full width)'],
                            ['id' => 'col-6', 'name' => '50% (1/2)'],
                            ['id' => 'col-4', 'name' => '33% (1/3)'],
                            ['id' => 'col-3', 'name' => '25% (1/4)'],
                            ['id' => 'col-8', 'name' => '66% (2/3)'],
                            ['id' => 'col-9', 'name' => '75% (3/4)'],
                            ['id' => 'col-2(3)', 'name' => '20% (1/5)'],
                            ['id' => 'col-2', 'name' => '16.5% (1/6)'],
                        ],

                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'select',
                    'label' => 'Typ URL',
                    'name' => 'url_type',
                    'options' => [
                        'query' => PandaMenuElement::getUrlTypes(),
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => 'URL',
                    'name' => 'url_text',
                ],
                [
                    'type' => 'hidden',   
                    'name' => 'url_category_id',
                ],
                 [
                    'type' => 'text',
                    'label' => 'URL',
                    'name' => 'url_category',
                    'desc' => 'Zacznij wpisywać nazwe kategorii'
                ],
                [
                    'type' => 'select',
                    'label' => 'Target',
                    'name' => 'target',
                    'options' => [
                        'query' => [
                            ['id' => '', 'name' => ''],
                            ['id' => '_blank', 'name' => '_blank'],
                            ['id' => '_self', 'name' => '_self'],
                            ['id' => '_parent', 'name' => '_parent'],
                            ['id' => '_top', 'name' => '_top'],
                        ],
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],

                [
                    'type' => 'switch',
                    'label' => 'włączone',
                    'name' => 'active',
                    'values' => [
                        ['id' => 'active_on', 'value' => '1', 'label' => 'Tak'],
                        ['id' => 'active_off', 'value' => '0', 'label' => 'Nie'],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => 'Klasa CSS',
                    'name' => 'class',
                    'desc' => 'Możesz dodać klase css do kolumny/elementu',
                ],
                [
                    'type' => 'text',
                    'label' => 'Hook',
                    'name' => 'hook',
                    'desc' => 'Możesz dodać hook wpisująć np hookDisplayBanner',
                ],
                [
                    'type' => 'html',
                    'name' => 'image_desktop_display',
                    'label' => '',
                    'html_content' => !empty($img_desktop) ? '<img src="' . _MODULE_DIR_ . 'panda_menu/uploads/' . htmlspecialchars($img_desktop) . '" style="max-width:200px;max-height:100px;" />' : '',
                ],

                !empty($img_desktop) ?
                [
                    'type' => 'switch',
                    'label' => 'usuń zdjęcie desktop',
                    'name' => 'image_desktop_delete',
                    'values' => [
                        ['id' => 'image_desktop_delete_on', 'value' => '1', 'label' => 'Usuń'],
                        ['id' => 'image_desktop_delete_off', 'value' => '0', 'label' => 'Zostaw'],
                    ],
                ] : ['type' => 'hidden', 'name' => 'image_desktop_delete', 'value' => '0'],
                [
                    'type' => 'file',
                    'label' => 'Image Desktop',
                    'name' => 'image_desktop',
                    'display_image' => true,
                    'desc' => 'Allowed formats: JPG, PNG',
                    'accept' => 'image/jpeg,image/png',
                ],
                [
                    'type' => 'html',
                    'name' => 'image_mobile_display',
                    'label' => '',
                    'html_content' => !empty($img_mobile) ? '<img src="' . _MODULE_DIR_ . 'panda_menu/uploads/' . htmlspecialchars($img_mobile) . '" style="max-width:200px;max-height:100px;" />' : '',
                ],

                !empty($img_mobile) ?
                [
                    'type' => 'switch',
                    'label' => 'usuń zdjęcie mobilne',
                    'name' => 'image_mobile_delete',
                    'values' => [
                        ['id' => 'image_mobile_delete_on', 'value' => '1', 'label' => 'Usuń'],
                        ['id' => 'image_mobile_delete_off', 'value' => '0', 'label' => 'Zostaw'],
                    ],
                ] : ['type' => 'hidden', 'name' => 'image_mobile_delete', 'value' => '0'],
                [
                    'type' => 'file',
                    'label' => 'Image Mobile',
                    'name' => 'image_mobile',
                    'display_image' => true,
                    'desc' => 'Allowed formats: JPG, PNG',
                    'accept' => 'image/jpeg,image/png',
                ],
            ],
            'submit' => [
                'title' => 'Save',
            ],
        ];


        foreach ($field_values as $name => $value) {
            $this->fields_value[$name] = $value;
        }
       
        if(Tools::isSubmit('addpanda_menu_elements')){
            $this->fields_form['input'][] = [
                'type' => 'hidden',
                'value' => Tools::getValue('menu_id', 0),
                'name' => 'menu_id'
            ];
        }
        return parent::renderForm();
    }

        public function ajaxProcessSearchCategories()
    {
        $query = Tools::getValue('q');
        $sql = new DbQuery();
        $sql->select('c.id_category AS id, cl.name AS name');
        $sql->from('category', 'c');
        $sql->leftJoin('category_lang', 'cl', 'c.id_category = cl.id_category AND cl.id_lang = ' . (int) Context::getContext()->language->id);
        $sql->leftJoin('category_shop', 'cs', 'c.id_category = cs.id_category AND cs.id_shop = ' . (int) Context::getContext()->shop->id);
        $sql->groupBy('c.id_category');
        $sql->where('c.active = 1');
        $sql->where('(cl.name LIKE \'%' . pSQL($query) . '%\' OR c.id_category = ' . (int) pSQL($query) . ')');

        $cats = Db::getInstance()->executeS($sql);
        foreach ($cats as &$cat) {
            $cat['name'] = '(id: ' . $cat['id'] . ') ' . $cat['name'];
        }
        die(json_encode($cats));    
    }

    private function getCategory(int $id_cat){
        $sql = new DbQuery();
        $sql->select('c.id_category AS id, cl.name AS name');
        $sql->from('category', 'c');
        $sql->leftJoin('category_lang', 'cl', 'c.id_category = cl.id_category AND cl.id_lang = ' . (int) Context::getContext()->language->id);
        $sql->leftJoin('category_shop', 'cs', 'c.id_category = cs.id_category AND cs.id_shop = ' . (int) Context::getContext()->shop->id);
        $sql->groupBy('c.id_category');
        $sql->where('c.active = 1');
        $sql->where('c.id_category = ' . $id_cat);

        $cat = Db::getInstance()->getRow($sql);
        return $cat ? ['id' => $cat['id'],'name' => '(id: ' . $cat['id'] . ') ' . $cat['name']] : false;
    }
    private function getFormVariables()
    {
        $field_values = [];
        if($this->object->url_type == 'category' && !empty($this->object->url)) {
            $cat = $this->getCategory((int) $this->object->url);
            if($cat){
                $field_values['url_category'] = $cat['name'];
                $field_values['url_category_id'] = $cat['id'];

            }
        }
        $id_parent = Tools::getValue('parent_id', null);
        if ($id_parent != null) {
            $field_values['parent_id'] = $id_parent;
        }

        list($desktopImg, $mobileImg) = PandaMenuElement::getImgsNames($this->object->id);
        return [$field_values, false, $desktopImg, $mobileImg];
    }
    public function postProcess()
    {
        if (isset($this->context->cookie->success)) {
            $this->confirmations[] = $this->context->cookie->success;
            unset($this->context->cookie->success);
        }

        if (isset($this->context->cookie->error)) {
            $this->errors[] = $this->context->cookie->error;
            unset($this->context->cookie->error);
        }


        if (Tools::isSubmit('submitAddpanda_menu_elements')) {
            $this->handleFormSubmission();

        }
        if(Tools::getValue('ajax') && Tools::getValue('action') == 'searchCategory') {
            $this->ajaxProcessSearchCategories();
        }   

    }

    private function handleFormSubmission()
    {
        $id_element = (int) Tools::getValue($this->identifier, 0);
        $element = new PandaMenuElement($id_element);

        if (!$id_element) {
            $element->parent_id = Tools::getValue('parent_id', 0);
            if ($element->parent_id == 0){
                $element->menu_id = Tools::getValue('menu_id', 0);
                $element->menu_level = 1;
           
            } 
            $element->setHideParamByParent();

        }
        $data = [
            'title' => Tools::getValue('title'),
            'submenu' => Tools::getValue('submenu', 0),
            'url_type' => Tools::getValue('url_type'),
            'target' => Tools::getValue('target', ''),
            'active' => Tools::getValue('active', 0),
            'class' => Tools::getValue('class', ''),
            'hook' => Tools::getValue('hook', ''),
            'image_desktop' => Tools::getValue('image_desktop', ''),
            'image_mobile' => Tools::getValue('image_mobile', ''),
            'column_width' => Tools::getValue('column_width', 'col-12'),
        ];

        if ($data['url_type'] == 'category') {
            $data['url'] = Tools::getValue('url_category_id', 0);
        } elseif ($data['url_type'] == 'url') {
            $data['url'] = Tools::getValue('url_text', '');
        }

        if ($data['submenu']) {
            $submenu_title = Tools::getValue('submenu_title');
            if (!$submenu_title ) {
                $this->context->cookie->error = 'Submenu title must be filled when submenu is enabled.';
            }
            $data['submenu_title'] = $submenu_title;
        } else {
            $data['submenu_title'] = '';
        }


        $oldDesktopImage = $element->image_desktop;
        $oldMobileImage = $element->image_mobile;

        foreach (['image_desktop', 'image_mobile'] as $imgField) {
            if (
                isset($_FILES[$imgField]) &&
                $_FILES[$imgField]['error'] === UPLOAD_ERR_OK &&
                (!empty($_FILES[$imgField]['name']) || Tools::getValue($imgField . '_delete') == 1) // Allow deletion if checkbox is checked
            ) {
                $ext = strtolower(pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $uploadDir = _PS_MODULE_DIR_ . 'panda_menu/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $filename = $_FILES[$imgField]['name'];
                    $filename = pathinfo($filename, PATHINFO_FILENAME); // trim extension
                    $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $filename);
                    $filename = uniqid($filename . '__') . '.' . $ext;

                    $destPath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES[$imgField]['tmp_name'], $destPath)) {
                        $data[$imgField] = $filename;
                    }
                }
            } else {
                $data[$imgField] = $element->{$imgField};
            }
        }
        if (!isset($this->context->cookie->error) && empty($this->context->cookie->error)) {

            $element->hydrate($data);
            if ($element->save()) {

                if (($data['image_desktop'] && $oldDesktopImage && $data['image_desktop'] !== $oldDesktopImage) || Tools::getValue('image_desktop_delete')) {
                    $oldPath = _PS_MODULE_DIR_ . 'panda_menu/uploads/' . $oldDesktopImage;
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                if (($data['image_mobile'] && $oldMobileImage && $data['image_mobile'] !== $oldMobileImage) || Tools::getValue('image_mobile_delete')) {
                    $oldPath = _PS_MODULE_DIR_ . 'panda_menu/uploads/' . $oldMobileImage;
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
  
                $this->context->cookie->success = 'Element saved successfully.';
            } else {
                $this->context->cookie->error = 'Error saving element.';
            }

            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
                'menu_id' => $element->menu_id,
                'parent_id' => $element->id,
            ]);

            Tools::redirectAdmin($url);
            exit;
        } else {
            $id = Tools::getValue('id');
            $id_parent = Tools::getValue('parent_id');
            $url = '';
            if ($id) {
                $url = $this->context->link->getAdminLink('AdminPandaMenuElementEdit', true, [], [
                    'id' => $id,
                    'menu_id' => $element->menu_id,
                    'parent_id' =>  $element->parent_id,
                    'updatePandaMenu_elements' => 1
                ]);
            } else if ($id_parent) {
                $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
                    'parent_id' => $id_parent,
                    'updatePandaMenu_elements' => 1
                ]);
            }

            Tools::redirectAdmin($url);
            exit;
        }

    }
    public function renderList()
    {
        $url = '';
        if ($id = Tools::getValue('id')) {
            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [

                'parent_id' => $id
            ]);
        } else if ($parent_id = Tools::getValue('parent_id')) {
            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [

                'parent_id' => $parent_id
            ]);

        } else {
            $url = $this->context->link->getAdminLink('AdminPandaMenu', true, [], []);
        }
        Tools::redirectAdmin($url);
        exit;


        return parent::renderList();
    }



}
