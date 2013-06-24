<?php
$this->breadcrumbs=array(
	'Forma Pago Orden Proveedores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FormaPagoOrdenProveedores', 'url'=>array('index')),
	array('label'=>'Create FormaPagoOrdenProveedores', 'url'=>array('create')),
	array('label'=>'Update FormaPagoOrdenProveedores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormaPagoOrdenProveedores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormaPagoOrdenProveedores', 'url'=>array('admin')),
);
?>

<h1>View FormaPagoOrdenProveedores #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ordenPagoId',
		'monto',
		'tipoFormaPago',
		'formaPagoId',
	),
)); ?>
