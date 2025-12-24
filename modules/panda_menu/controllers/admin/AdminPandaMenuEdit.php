<?php 

class AdminPandaMenuEditController extends ModuleAdminController{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->table = 'panda_menu';
        $this->identifier = 'id';
        $this->className = 'PandaMenuObject';
        $this->lang = false;
        


    }

    public function renderForm(){
       
        if(Tools::isSubmit('addpanda_menu') || Tools::isSubmit('updatepanda_menu')){
            $this->fields_form = array(
                'legend' => array(
                    'title' => $this->l('Dodaj menu'),
                    'icon' => 'icon-plus'
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'id',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Nazwa'),
                        'name' => 'name',
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Aktywne menu'),
                        'name' => 'active',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Tak')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Nie')
                            ),
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Zapisz'),
                    'class' => 'btn btn-default pull-right'
                ),
            );

            return parent::renderForm();
        }else{
            $id = Tools::getValue('id');
            if($id){
                $url = $this->context->link->getAdminLink('AdminPandaMenuElement', true,[], array('menu_id' => $id));
                Tools::redirectAdmin($url);
                exit;
            }else{
                $this->errors[] = Tools::displayError('Menu ID is required to view elements.');
                return false;
            }
        }

    }


    public function postProcess(){
        if (Tools::isSubmit('submitAddpanda_menu') || Tools::isSubmit('submitUpdatepanda_menu')) {
            parent::postProcess();


        }else if(Tools::isSubmit('updatepanda_menu') || Tools::isSubmit('addpanda_menu')){ 
            //nothing
        }else{
            $url = $this->context->link->getAdminLink('AdminPandaMenu', true,[],[]);
            Tools::redirectAdmin($url);
            exit;
        }
    }
    

    
}
   