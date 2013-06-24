<?php
$this->menu=array(
	array('label'=>'Listado de Cheques', 'url'=>array('adminCheques')),
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tasaDescuento',
		'clearing',
		'pesificacion',
		'numeroCheque',
		array(
			'name'=>'libradorId',
			'value'=>$model->librador->denominacion
		),
		array(
			'name'=>'banco',
			'value'=>$model->banco->nombre
		),
		array(
			'name'=>'montoOrigen',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->montoOrigen),
		),
		array(
			'name'=>'fechaPago',
			'value'=>date("d/m/Y", strToTime($model->fechaPago)),
		),
		array(
			'name'=>'tipoCheque',
			'value'=>$model->getTypeDescription('tipoCheque')
		),
		'endosante',
		array(
			'name'=>'montoNeto',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->montoNeto),
		),
		array(
			'name'=>'tipoCheque',
			'value'=>$model->getTypeDescription('estado')
		),
		array(
			'name'=>'montoGastos',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->montoGastos),
		)
	),
)); ?>
