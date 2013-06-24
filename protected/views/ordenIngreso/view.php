<?php
$this->breadcrumbs=array(
	'Orden Ingresos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrdenIngreso', 'url'=>array('index')),
	array('label'=>'Create OrdenIngreso', 'url'=>array('create')),
	array('label'=>'Update OrdenIngreso', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrdenIngreso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrdenIngreso', 'url'=>array('admin')),
);
?>

<h1>View OrdenIngreso #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'clienteId',
		'monto',
		'descripcion',
		'productoId',
		'estado',
		'sucursalId',
		'userStamp',
		'timeStamp',
	),
)); ?>
