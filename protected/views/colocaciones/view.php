<?php
$this->breadcrumbs=array(
	'Colocaciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Colocaciones', 'url'=>array('index')),
	array('label'=>'Create Colocaciones', 'url'=>array('create')),
	array('label'=>'Update Colocaciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Colocaciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Colocaciones', 'url'=>array('admin')),
);
?>

<h1>View Colocaciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'chequeId',
		'montoTotal',
		'sucursalId',
		'userStamp',
		'timeStamp',
	),
)); ?>
