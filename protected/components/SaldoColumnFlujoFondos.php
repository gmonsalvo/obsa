<?php

// este codigo sirve para mostrar el saldo en el grid, se usa la clase CGridColumn
Yii::import('zii.widgets.grid.CGridColumn');

class SaldoColumnFlujoFondos extends CGridColumn {

    private $_acum;
    private $_saldo;
    
    public function renderDataCellContent($row, $data) {
        if ($data->tipoFlujoFondos == 0) {
            $this->_saldo = $this->_acum + $data->monto;
        } else {
            $this->_saldo = $this->_acum - $data->monto;
        }
        $this->_acum = $this->_saldo;
        echo Utilities::MoneyFormat($this->_saldo);
    }

}

