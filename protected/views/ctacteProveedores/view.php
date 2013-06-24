<?php
$this->breadcrumbs=array(
	'Ctacte Proveedores'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Movimientos', 'url'=>array('admin')),
	array('label'=>'Nuevo Movimiento', 'url'=>array('create')),
	array('label'=>'Modificar Movimiento', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Movimiento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
);
?>

<h1>Detalle del Movimiento Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'proveedorId',
			'value'=>$model->proveedor->denominacion,
		),
		array(
			'name'=>'tipoMov',
			'value'=>$model->getTypeDescription(),
		),
		'descripcion',
		array(
			'name'=>'monto',
			'value'=>Yii::app()->numberFormatter->format("#,##0.00", $model->monto),
		),
		'fecha',
	),
)); ?>