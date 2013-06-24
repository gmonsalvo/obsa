<?php

Yii::import('application.extensions.EJuiAutoCompleteFkField');

class CustomEJuiAutoCompleteFkField extends EJuiAutoCompleteFkField {

    ##codigo javascript que es ejecutado en el evento onblur
    public $select = "";

    public function init() {
        parent::init();
        //$this->htmlOptions['onblur'].=$this->onblur;
        $this->options['select']=substr($this->options['select'], 0, count($this->options['select'])-2).$this->select."}";
    }

    public function run() {
        parent::run();
    }
}
?>
