<?php

class PandaMenuObject extends ObjectModel
{
    public $id;
    public $name;
    public $active;

    public static $definition = array(
        'table' => 'pandamenu',
        'primary' => 'id',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 45),
            'active' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
        ),
    );

     public function getName(){
        return $this->name;
    }


    public function __construct($id = null)
    {
       parent::__construct($id);
       $this->childs = $this->getChilds();
    }

    public function getChilds()
    {
        return PandaMenuElement::getElementsMenu($this->id);
    }
}