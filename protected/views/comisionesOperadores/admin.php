<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('comisiones-operadores-grid', {
		data: $(this).serialize()
	});
	$('#comisiones-grid').show();
    $('#operadorId').val($('#ComisionesOperadores_operadorId').val());
	return false;
});
");
?>

<h1>Comisiones Operadores</h1>


<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div id="comisiones-grid" style="display:none">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comisiones-operadores-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array(
            'name' => 'porcentaje',
            'header' => '%',
            'value' => '$data->porcentaje',
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
	    array(
            'name' => 'monto',
            'header' => 'Monto',
            'value' => 'Utilities::MoneyFormat($data->monto)',
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
       	array(
            'name' => 'estado',
            'header' => 'Estado',
            'value' => '$data->getEstadoDescripcion($data->estado)',
        ),
        array(
            'name' => 'detalleColocacion',
            'header' => 'Librador',
            'value' => '$data->detalleColocacion->colocacion->cheque->librador->denominacion',
        ),
        array(
            'name' => 'detalleColocacion',
            'header' => 'Monto Nominal',
            'value' => 'Utilities::MoneyFormat($data->detalleColocacion->colocacion->cheque->montoOrigen)',
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
            'name' => 'detalleColocacion',
            'header' => 'Banco',
            'value' => '$data->detalleColocacion->colocacion->cheque->banco->nombre',
        ),
        array(
            'name' => 'detalleColocacion',
            'header' => 'Fecha Vto.',
            'value' => '$data->detalleColocacion->colocacion->cheque->fechaPago',
        ),
        array(
            'name' => 'detalleColocacion',
            'header' => 'Razon Social',
            'value' => '$data->detalleColocacion->colocacion->cheque->operacionCheque->cliente->razonSocial',
        ),


	),
)); ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comisiones-operadores-form',
    'enableAjaxValidation'=>false,
)); ?>
    <?php echo CHtml::hiddenField("operadorId","",array("id"=>'operadorId'));?>
    <div class="row buttons">
        <?php echo CHtml::submitButton("Acreditar Pendientes"); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
