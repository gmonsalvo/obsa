<?php

$this->menu=array(
	array('label'=>'Movimiento Manual', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('flujo-fondos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Mayor de cuentas de flujo de fondos</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'flujo-fondos-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'name' => 'fecha',
            'header' => 'Fecha',
            'value' => '$data->timeStamp',
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
)); ?>
