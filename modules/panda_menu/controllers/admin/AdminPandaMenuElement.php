<?php


class AdminPandaMenuElementController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'panda_menu_elements';
        $this->identifier = 'id';
        $this->className = 'PandaMenuElement';
        $this->lang = false;
        $this->show_toolbar = true;
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->position = true;
        $this->_defaultOrderBy = 'position';
        $this->_defaultOrderWay = 'ASC';
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
                'filter_key' => 'a!title'
            ),

            'position' => array(
                'title' => $this->trans('Position', [], 'Admin.Global'),
                'filter_key' => 'position',
                'position' => 'position',
                'align' => 'center',
                'orderby' => true
            )
        );

        $this->_select .= ' a.order_num as position ';

        if ($parent_id) {
            $this->_where = 'AND a.parent_id = ' . $parent_id;
        } else {
            $this->_where = 'AND a.menu_id = ' . (int) $id_menu . ' AND a.parent_id = 0';
        }
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJquery();
        $this->addJqueryUI(['ui.sortable']);

         
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
            $label = 'Super Menu';
        }
        return $label;
    }

    public function renderForm()
    {

        if (Tools::isSubmit('update' . $this->table)) {
            $id_element = (int) Tools::getValue($this->identifier);


            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
                'parent_id' => $id_element
            ]);

            Tools::redirectAdmin($url);
            exit;
        }

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


        if (Tools::getValue('resetCache') == 1) {
            PandaCache::delete(PandaCache::CACHE_MENU);
            $this->context->cookie->success = $this->l('Menu cache has been successfully cleared.');
             Tools::redirectAdmin($this->context->link->getAdminLink('AdminPandaMenu'));
            exit;
        }
        if (Tools::isSubmit('update' . $this->table)) {
            $id_element = (int) Tools::getValue($this->identifier);
            $id_menu = Tools::getValue('menu_id');

            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
                'menu_id' => $id_menu,
                'parent_id' => $id_element
            ]);

            Tools::redirectAdmin($url);
            exit;
        }

        // Handle AJAX drag-and-drop reorder
        if (Tools::getIsset('ajax') && Tools::getValue('action') == 'updatePositions') {
           $order = Tools::getValue('order');

            if (is_array($order)) {
                foreach ($order as $position => $raw) {
                    // $raw ma postać np. "td_2_3"
                    $parts = explode('_', $raw);
                    $id = (int) array_pop($parts); // ostatni element, czyli "3"

                    Db::getInstance()->update(
                        'panda_menu_elements',
                        [
                            'order_num' => (int) $position,
                        ],
                        'id = ' . (int) $id
                    );
                }
            }

            die('OK');
        }
        if (Tools::isSubmit('deletepanda_menu_elements')) {
            $id_element = (int) Tools::getValue('id');
            $obj = new PandaMenuElement($id_element);
            $parent_id = $obj->parent_id;
            $id_menu = $obj->menu_id;
            if ($obj->delete()) {

                $this->context->cookie->success = 'Element deleted successfully.';
            } else {
                $this->context->cookie->error = 'Error deleting element.';
            }
            $this->redirect_after = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
                'menu_id' => $id_menu,
                'parent_id' => $parent_id
            ]);
            
            return;
        }

        parent::postProcess();
    }

    public function renderList()
    {
        $id_parent = Tools::getValue('parent_id', 0);
        $id_menu = Tools::getValue('menu_id');
        $path = [];
        if ($id_parent) {
            $element = new PandaMenuElement($id_parent);
            $path = $element->getFullPath();
        }

        $addNewUrl = '';
        if ($id_menu) {
            $addNewUrl = $this->context->link->getAdminLink('AdminPandaMenuElementEdit', true, [], ['addpanda_menu_elements' => '', 'parent_id' => $id_parent, 'menu_id' => $id_menu]);
        } else {
            $addNewUrl = $this->context->link->getAdminLink('AdminPandaMenuElementEdit', true, [], ['addpanda_menu_elements' => '', 'parent_id' => $id_parent,]);
        }

        $editUrl = '';
        if ($id_parent) {
            $editUrl = $this->context->link->getAdminLink('AdminPandaMenuElementEdit', true, [], ['id' => $id_parent,'updatepanda_menu_elements' => 1]);
        }else{
            $editUrl = $this->context->link->getAdminLink('AdminPandaMenuEdit', true, [], ['id' => $id_menu,'updatepanda_menu' => 1]);
        }
        $urlAjax = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], [
            'action' => 'updatePositions',
            'ajax' => 1,
        ]);


        $breadcrumbs = '';
        foreach ($path as $item) {
            $breadcrumbs .= '<a href="' . $item['url'] . '">' . $item['name'] . '</a> > ';
        }   
        $customHtml = '<div class="panel">
            <h3>Jesteś w ' . $this->getLabelForPage($id_menu, $id_parent) . '</h3>
            <div style="display: flex; gap: 30px; align-items: center; margin-bottom: 20px;">
                <p>' . rtrim($breadcrumbs, ' > ') . '</p>
                ' . ($editUrl ? '<a class="btn btn-primary" href="' . $editUrl . '">Edytuj</a>' : '') . '
            </div>
            <div><a class="btn btn-primary" href="' . $addNewUrl . '">Dodaj nowy</a> </div>
            <div id="ajaxUpdatePositions" data-url="' . $urlAjax . '" ></div>
        </div>';



        return $customHtml . parent::renderList();
    }

    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }


      public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();

        $this->page_header_toolbar_btn['my_button'] = [
            'href' => self::$currentIndex . '&resetCache=1&token=' . $this->token,
            'desc' => $this->l('Wyczyść Cache'),
            'icon' => 'process-icon-delete'
        ];
    }
}
