<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'flujo-fondos-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'fecha',
            'header' => 'Fecha',
            'value' => '$data->fecha',
        ),
        array(
            'name' => 'tipoFlujoFondos',
            'header' => 'Tipo Flujo Fondos',
            'value' => '$data->getTypeDescription()',
        ),
        array(
            'name' => 'conceptoId',
            'header' => 'Concepto',
            'value' => '$data->concepto->nombre',
        ),
        'descripcion',
        array(
            'name' => 'monto',
            'header' => 'Credito',
            'value' => 'Utilities::MoneyFormat($data->tipoFlujoFondos == 0 ? "$data->monto":"0")',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'monto',
            'header' => 'Debito',
            'value' => 'Utilities::MoneyFormat($data->tipoFlujoFondos == 1 ? "$data->monto":"0")',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'saldoAcumulado',
            'header' => 'Saldo',
            'value' => 'Utilities::MoneyFormat($data->saldoAcumulado)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
    ),
));
?>