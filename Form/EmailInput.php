<?php

/**
 * 
 *
 * @author Jakub Bárta <jakub.barta@gmail.com>
 */
namespace jb\Form;


class EmailInput extends \Nette\Forms\Controls\TextInput {
    const VALID_EMAIL = "Zadejte platnou e-mailovou adresu.";
    
    public function __construct($label = NULL, $cols = NULL, $maxLength = NULL) {
	parent::__construct($label, $cols, $maxLength);
	$this->addCondition(Form::FILLED)->addRule(Form::EMAIL, self::VALID_EMAIL);
    }
}

?>
