<?php
$this->breadcrumbs=array(
	'Operaciones Cheques'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Nueva Operacion', 'url'=>array('nuevaOperacion')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('operaciones-cheques-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $.datepicker.setDefaults( $.datepicker.regional[ 'es' ] );
    $('#datepicker_for_due_date').datepicker();
}
");
?>


<h1>Listado de Operaciones de Compra Cheques</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'operaciones-cheques-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
	'columns'=>array(
		array(
                'name' => 'clienteId',
                'header' => 'Cliente',
                'value' => '$data->productoCtaCte->cliente->razonSocial',
                'filter'=>  CHtml::listData(Clientes::model()->findAll(array('order'=>'razonSocial')), 'id', 'razonSocial'),
        ),
		array(
                'name' => 'montoNetoTotal',
                'header' => 'Neto',
                'value' => 'Utilities::MoneyFormat($data->montoNetoTotal)',
        ),
        array(
            'name' => 'fecha',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model, 
                'attribute'=>'fecha', 
                'language' => 'es',
                //'i18nScriptFile' => 'jquery.ui.datepicker-es.js', // (#2)
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'size' => '10',
                ),
                'defaultOptions' => array(  // (#3)
                    'showOn' => 'focus', 
                    'dateFormat' => 'dd/mm/yy',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
            ), 
            true), // (#4)
        ),
		array(
			'class'=>'CButtonColumn',
			'header' => 'Acciones',
			'template'=>'{finalizar} {anular} {imprimir}',
                    'buttons'=>array
                    (
                        'finalizar' => array
                        (
                            'label'=>'Crear Orden de Pago',
                            'visible'=>'$data->estado == OperacionesCheques::ESTADO_A_PAGAR',
                            'url'=>'Yii::app()->createUrl("ordenesPago/create", array("operacionChequeId"=>$data->id))',
                        ),
                        'anular' => array
                        (
                            'label'=>'Anular',
                            'visible'=>'$data->estado == OperacionesCheques::ESTADO_A_PAGAR',
                            'click' =>"function(){ return confirm('Esta seguro que desea anular la operacion?')}",
                            'url'=>'Yii::app()->createUrl("operacionesCheques/anularOperacion", array("operacionChequeId"=>$data->id))',
                        ),
                        'imprimir' => array
                        (
                            'label'=>'Imprimir',
                            'visible'=>'$data->estado == OperacionesCheques::ESTADO_COMPRADO',
                            'url'=>'Yii::app()->createUrl("operacionesCheques/imprimirPDF", array("id"=>$data->id))',
                        ),
                    ),
		),
	),
)); ?>
