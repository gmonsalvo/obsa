<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cheques-grid',
    'dataProvider' => $dataProvider,
    'selectableRows' => -1,
    'selectionChanged' => 'AgregarImporteCheque',
    'columns' => array(
        array(
            'header' => 'Cheques seleccionados',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'fechaPago',
            'header' => 'Fecha Venc.',
            'value' => 'Utilities::ViewDateFormat($data->fechaPago)',
        ),
        'numeroCheque',
        array(
            'name' => 'libradorId',
            'header' => 'Librador',
            'value' => '$data->librador->denominacion',
        ),
        array(
            'name' => 'bancoId',
            'header' => 'Banco',
            'value' => '$data->banco->nombre',
        ),
        array(
            'name' => 'montoOrigen',
            'header' => 'Valor Nominal',
            'value' => 'Utilities::MoneyFormat($data->montoOrigen)',
        ),
    /*
      'libradorId',
      'bancoId',
      'fechaPago',
      'tipoCheque',
      'endosante',
      'montoNeto',
      'estado',
      'userStamp',
      'timeStamp',
      'sucursalId',
     */
    ),
));
?>
