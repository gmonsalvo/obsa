<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'id' => 'portletCheques',
    'title' => '',
));
echo "<b>Listado de cheques colocados al inversor</b>";
$this->endWidget("portletCheques");
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cheques-grid',
    'dataProvider' => $dataProvider,
    'selectionChanged' => 'HabilitarRecolocacion',
    'columns' => array(
        array(
            'header' => 'Cheques seleccionados',
            'class' => 'CCheckBoxColumn',
        ),
        array(
            'name' => 'fechaPago',
            'header' => 'Fecha Vto',
            'value' => 'Utilities::ViewDateFormat($data->fechaPago)',
        ),
        'numeroCheque',
        array(
            'name' => 'montoOrigen',
            'header' => 'Monto Nominal',
            'value' => 'Utilities::MoneyFormat($data->montoOrigen)',
        ),
       array(
            'name' => 'id',
            'header' => '% Tenencia',
            'value' => 'Clientes::model()->getPorcentajeTenencia($data->id,'.$idCliente.')',
        ),
        array(
            'name' => 'tipoCheque',
            'header' => 'Tipo Cheque',
            'value' => '$data->getTypeDescription("tipoCheque")',
        ),
        array(
            'name' => 'estado',
            'header' => 'Estado',
            'value' => '$data->getTypeDescription("estado")',
        ),
//        array(
//            'class'=>'CButtonColumn',
//            'header'=>'Opciones',
//            'template'=>'{Eliminar}',
//            'buttons'=>array(
//                'Eliminar'=>array(
//                    'label'=>'Quitar inversor de la colocacion',
//                    'url'=>'Yii::app()->createUrl("/colocaciones/editarColocacion", array("id" => $data->id))',
//                    'options'=>array(  // this is the 'html' array but we specify the 'ajax' element
//			'class'=>'cssGridButton',
//                    ),
//            )),
//        )

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
