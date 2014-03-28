<?php


namespace jb\Form;

use jb\Model\Facades\BaseFacade;
/**
 * Description of ClassSelect
 *
 * @author Jakub Barta <jakub.barta@gmail.com>
 */
class ClassSelect extends \Nette\Forms\Controls\SelectBox {
    
    /** @var BaseFacade */
    protected $facade;
    
    public function __construct($label = NULL, array $items = NULL, BaseFacade $facade) {
        parent::__construct($label, $items);
        $this->facade = $facade;
    }
    
    public function setItems(array $items, $useKeys = TRUE) {
        $res = array();
        foreach ($items as $item) {
            $res[$item->id] = (string) $item;
        }
        parent::setItems($res);
        return $this;
    }
    
    public function setValue($value) {
        if ($value !== NULL && !isset($this->items[$value->id])) {
                throw new Nette\InvalidArgumentException("Value '$value' is out of allowed range in field '{$this->name}'.");
        }
        if ($value === null) {
            $this->value = null;
        }
        else {
            $this->value = $value->id;
        }
        return $this;
    }
    
    public function getValue() {
        $val = parent::getValue();
        
        if ($val === null) {
            return $val;
        }
        else {
            return $this->facade->get($val);
        }
        
    }
}
