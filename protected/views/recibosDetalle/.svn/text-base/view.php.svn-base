<?php
$this->breadcrumbs=array(
	'Recibos Detalles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RecibosDetalle', 'url'=>array('index')),
	array('label'=>'Create RecibosDetalle', 'url'=>array('create')),
	array('label'=>'Update RecibosDetalle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RecibosDetalle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RecibosDetalle', 'url'=>array('admin')),
);
?>

<h1>View RecibosDetalle #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reciboId',
		'tipoFondoId',
		'monto',
		'userStamp',
		'timeStamp',
	),
)); ?>
