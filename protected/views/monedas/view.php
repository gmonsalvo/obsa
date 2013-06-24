<?php
$this->breadcrumbs=array(
	'Monedases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Monedas', 'url'=>array('index')),
	array('label'=>'Create Monedas', 'url'=>array('create')),
	array('label'=>'Update Monedas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Monedas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Monedas', 'url'=>array('admin')),
);
?>

<h1>View Monedas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'denominacion',
		'tasaCambioPesos',
		'userStamp',
		'timeStamp',
		'sucursalId',
	),
)); ?>
