<?php
$this->breadcrumbs=array(
	'Flujo de Fondos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Flujo de Fondos', 'url'=>array('admin')),
	array('label'=>'Nuevo Flujo de Fondos', 'url'=>array('create')),
	array('label'=>'Modificar Flujo de Fondos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Flujo de Fondos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
);
?>

<h1>Detalle del Flujo de Fondos Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'cuentaId',
			'value'=>$model->cuenta->nombre,
		),
		array(
			'name'=>'concepto',
			'value'=>$model->concepto->nombre,
		),
		'descripcion',
		array(
			'name'=>'flujoFondos',
			'value'=>$model->getTypeDescription(),
		),
		array(
			'label' => 'Monto',
			'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->monto)
		),
		array(
			'label'=>'Fecha',
			//'value'=>Yii::app()->dateFormatter->formatDateTime("dd/mm/yy", $model->fecha),
			'value'=>$model->fecha
		),
		'origen',
		'identificadorOrigen',
	),
)); ?>
