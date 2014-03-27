<?php
/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */

namespace jb\Form;


class Form extends \Nette\Application\UI\Form {
    
    protected $bootstrapRendering = true;
    
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
    
    public function setBootstrapRendering($val = true) {
        $this->bootstrapRendering = $val;
    }
    
        public function addClass($class) {
        $this->getElementPrototype()->class .= " $class";
    }
    
    public function render() {
        if (!$this->bootstrapRendering) {
            parent::render();
        }
        else {
            $renderer = new BootstrapRenderer();
            $this->setRenderer($renderer);
            $renderer->wrappers['controls']['container'] = NULL;
            $renderer->wrappers['pair']['container'] = 'div class=form-group';
            $renderer->wrappers['pair']['.error'] = 'has-error';
            $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
            $renderer->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
            $renderer->wrappers['control']['description'] = 'span class=help-block';
            $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';
            
            $renderer->wrappers['error']['container'] = 'div class=has-error';
            $renderer->wrappers['error']['item'] = 'span class=help-block';

            // make form and controls compatible with Twitter Bootstrap
            $this->addClass('form-horizontal');

            foreach ($this->getControls() as $control) {
                    if ($control instanceof \Nette\Forms\Controls\Button) {
                            $control->setAttribute('class', empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                            $usedPrimary = TRUE;

                    } elseif ($control instanceof \Nette\Forms\Controls\TextBase || $control instanceof \Nette\Forms\Controls\SelectBox || $control instanceof \Nette\Forms\Controls\MultiSelectBox) {
                            $control->setAttribute('class', 'form-control');

                    } elseif ($control instanceof \Nette\Forms\Controls\Checkbox || $control instanceof \Nette\Forms\Controls\CheckboxList || $control instanceof \Nette\Forms\Controls\RadioList) {
                            $control->getSeparatorPrototype()->setName('div')->class($control->getControlPrototype()->type);
                    }
            }
            parent::render();
        }
    }
    
}

?>
