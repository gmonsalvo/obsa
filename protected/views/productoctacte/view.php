<?php
$this->breadcrumbs=array(
	'Productoctactes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Productoctacte', 'url'=>array('index')),
	array('label'=>'Create Productoctacte', 'url'=>array('create')),
	array('label'=>'Update Productoctacte', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Productoctacte', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productoctacte', 'url'=>array('admin')),
);
?>

<h1>View Productoctacte #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombreModelo',
		'pkModeloRelacionado',
		'productoId',
		'userStamp',
		'timeStamp',
	),
)); ?>
