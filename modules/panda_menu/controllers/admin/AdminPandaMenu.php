<?php

class AdminPandaMenuController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'panda_menu';
        $this->identifier = 'id';
        $this->className = 'PandaMenuObject';
        $this->lang = false;
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id' => array(
                'title' => 'id',
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ),
            'name' => array(
                'title' => 'nazwa',
                'filter_key' => 'a!name'
            ),
            'active' => array(
                'title' => 'Aktywne menu',
                'active' => 'status',
                'type' => 'bool',
                'align' => 'center',
                'class' => 'fixed-width-xs'
            )
        );

        $this->_defaultOrderBy = 'id';
    }

    public function renderForm()
    {
        $id = Tools::getValue('id');
        if ($id) {
            $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true, [], array('menu_id' => $id));
            Tools::redirectAdmin($url);
            exit;

        } else if (Tools::isSubmit('addpanda_menu')) {
            $url = $this->context->link->getAdminLink('AdminPandaMenuEdit', true, [], array('addpanda_menu' => 1));
            Tools::redirectAdmin($url);
            exit;
        } else {
            $this->errors[] = Tools::displayError('Menu ID is required to view elements.');
            return false;
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
        parent::postProcess();
        if (Tools::getValue('resetCache') == 1) {
            PandaCache::delete(PandaCache::CACHE_MENU);
            $this->confirmations[] = $this->l('Menu cache has been successfully cleared.');
        }
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
