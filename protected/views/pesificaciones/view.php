<?php
$this->breadcrumbs=array(
	'Pesificaciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pesificaciones', 'url'=>array('index')),
	array('label'=>'Create Pesificaciones', 'url'=>array('create')),
	array('label'=>'Update Pesificaciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pesificaciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pesificaciones', 'url'=>array('admin')),
);
?>

<h1>View Pesificaciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'pesificadorId',
		'sucursalId',
		'userStamp',
		'timeStamp',
	),
)); ?>
