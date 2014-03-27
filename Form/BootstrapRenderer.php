<?php

namespace jb\Form;

/**
 * Description of BootstrapRenderer
 *
 * @author Jakub Barta <jakub.barta@gmail.com>
 */
class BootstrapRenderer extends \Nette\Forms\Rendering\DefaultFormRenderer {

    /**
     * Provides complete form rendering.
     * @param  Nette\Forms\Form
     * @param  string 'begin', 'errors', 'ownerrors', 'body', 'end' or empty to render all
     * @return string
     */
    public function render(\Nette\Forms\Form $form, $mode = NULL) {
        if ($this->form !== $form) {
            $this->form = $form;
            $this->init();
        }
        $s = '';
        if (!$mode || $mode === 'begin') {
            $s .= $this->renderBegin();
        }
        
        if (!$mode || $mode === 'body') {
            $s .= $this->renderBody();
        }
        if (!$mode || strtolower($mode) === 'ownerrors') {
            $s .= $this->renderErrors();
        } elseif ($mode === 'errors') {
            $s .= $this->renderErrors(NULL, FALSE);
        }
        if (!$mode || $mode === 'end') {
            $s .= $this->renderEnd();
        }
        return $s;
    }

}
