<?php
$this->breadcrumbs=array(
	'Operaciones Cambios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OperacionesCambio', 'url'=>array('index')),
	array('label'=>'Create OperacionesCambio', 'url'=>array('create')),
	array('label'=>'Update OperacionesCambio', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OperacionesCambio', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OperacionesCambio', 'url'=>array('admin')),
);
?>

<h1>View OperacionesCambio #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clienteId',
		'monedaId',
		'monto',
		'tipoOperacion',
		'userStamp',
		'timeStamp',
		'sucursalId',
	),
)); ?>
