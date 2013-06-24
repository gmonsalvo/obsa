<?php
$this->breadcrumbs=array(
	'Forma Pago Ordens'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FormaPagoOrden', 'url'=>array('index')),
	array('label'=>'Create FormaPagoOrden', 'url'=>array('create')),
	array('label'=>'Update FormaPagoOrden', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormaPagoOrden', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormaPagoOrden', 'url'=>array('admin')),
);
?>

<h1>View FormaPagoOrden #<?php echo $model->id; ?></h1>

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
