<?php
/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */

namespace jb\Form;


class Form extends \Nette\Application\UI\Form {
    
    public function __construct(\Nette\ComponentModel\IContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);
        $this->addProtection();
    }
    
    public function removeProtection() {
        unset($this[self::PROTECTOR_ID]);
    }

    public function addDatePicker($name, $label = NULL, $cols = NULL, $maxLength = NULL) {
	return $this[$name] = new DatePicker($label, $cols, $maxLength);
    }
    
    public function addDateTimePicker($name, $label = NULL, $cols = NULL, $maxLength = NULL) {
	return $this[$name] = new DateTimePicker($label, $cols, $maxLength);
    }
    
    
    public function addEmail($name, $label = NULL, $cols = NULL, $maxLength = NULL) {
	return $this[$name] = new EmailInput($label, $cols, $maxLength);
    }
}

?>
