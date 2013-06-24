<?php
$this->menu=array(
	array('label'=>'Listado de Cheques', 'url'=>array('admin')),
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
			'value'=>Utilities::MoneyFormat($model->montoOrigen)
		),
            	array(
			'name'=>'fechaPago',
			'value'=>Utilities::ViewDateFormat($model->fechaPago)
		),
		array(
			'name'=>'tipoCheque',
			'value'=>$model->getTypeDescription('tipoCheque')
		),
		'endosante',
		'montoNeto',
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
