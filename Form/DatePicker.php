<?php

/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */

namespace jb\Form;

use DateTime,
    Nette\Forms\Rules;

class DatePicker extends \Nette\Forms\Controls\TextInput {

    protected $format = "d.m.Y";
    protected $exampleDt;
    protected $class = "datepicker";
    protected $validDateMsg;

    const VALIDATOR = "jb\Form\DatePicker::dateTimeValidator";

    public static function dateTimeValidator(\Nette\Forms\Controls\TextInput $item) {
        return ($item->getValue() instanceof \DateTime);
    }

    public function __construct($label = NULL, $cols = NULL, $maxLength = NULL) {
        parent::__construct($label, $cols, $maxLength);
        $this->setAttribute("class", $this->class);
        $this->exampleDt = new DateTime("12.3.1985 12:50");
        $this->updateValidateMsg();

        $this->addCondition(Form::FILLED)->addRule(self::VALIDATOR, $this->validDateMsg);
    }

    protected function updateValidateMsg() {
        $this->validDateMsg = "Zadejte datum ve formátu $this->format, např. " . $this->exampleDt->format($this->format) . ".";
    }

    public function setValue($value) {
        if ($value instanceof \DateTime) {
            parent::setValue($value->format($this->format));
        } else {
            parent::setValue($value);
        }
        return $this;
    }

    public function getValue() {
        
        $dateTime = \DateTime::createFromFormat($this->format, parent::getValue());
        return $dateTime ? : null;
    }

    public function getFormat() {
        return $this->format;
    }

    public function setFormat($format) {
        $this->format = $format;
        $this->updateValidateMsg();
        if ($this->getRules !== null) {
            $this->updateRules($this->getRules());
        }
    }
    
    public function updateRules(Rules $rules) {
        $iterator = $rules->getIterator();
        foreach ($iterator as $rule) {
            if ($rule->operation == self::VALIDATOR) {
                $rule->message = $this->validDateMsg;
            }
            if ($rule->subRules !== null) {
                $this->updateRules($rule->subRules);
            }
        }
    }

    public function isFilled() {
        return trim($this->value) !== "";
    }

}

?>
