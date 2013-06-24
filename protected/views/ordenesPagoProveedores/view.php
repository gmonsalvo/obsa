<?php
$this->breadcrumbs=array(
	'Ordenes Pago Proveedores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrdenesPagoProveedores', 'url'=>array('index')),
	array('label'=>'Create OrdenesPagoProveedores', 'url'=>array('create')),
	array('label'=>'Update OrdenesPagoProveedores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrdenesPagoProveedores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrdenesPagoProveedores', 'url'=>array('admin')),
);
?>

<h1>View OrdenesPagoProveedores #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'proveedorId',
		'fecha',
		'monto',
		'descripcion',
		'estado',
		'sucursalId',
		'userStamp',
		'timeStamp',
		'porcentajePesificacion',
	),
)); ?>
