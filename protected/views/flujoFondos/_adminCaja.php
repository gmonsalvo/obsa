<?php
Yii::import('application.components.SaldoColumnCaja');
$this->widget('GridViewStyle', array(
	'id'=>'caja-grid',
	'dataProvider'=>$dataProvider,
	'rowCssStyleExpression'=>'$data->tipoFlujoFondos == 0 ? "background-color: #9FF781" : "background-color:#F6CECE"',
	'columns'=>array(
		'id',
		array(
			'name'=>'conceptoId',
			'header'=>'Concepto',
			'value'=>'$data->concepto->nombre',
		),
		'descripcion',
		array(
			'name'=>'tipoFlujoFondos',
			'header'=>'Tipo Movimiento',
			'value'=>'$data->getTypeDescription()',
		),
		array(
			'name' => 'monto',
			'header' => 'Monto',
			'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->monto)',
			'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
			'header' => 'Saldo',
			'class'  => 'SaldoColumnCaja',
			'htmlOptions'=>array('style'=>'text-align: right'),
		),
		array(
			'name'=>'fecha',
			'header'=>'Fecha',
			'value'=>'$data->fecha',
		),
		'origen',
		'identificadorOrigen',
	),
));
?>

