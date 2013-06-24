<?php
$this->breadcrumbs=array(
	'Detalle Pesificaciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DetallePesificaciones', 'url'=>array('index')),
	array('label'=>'Create DetallePesificaciones', 'url'=>array('create')),
	array('label'=>'Update DetallePesificaciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DetallePesificaciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DetallePesificaciones', 'url'=>array('admin')),
);
?>

<h1>View DetallePesificaciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pesificacionId',
		'chequeId',
	),
)); ?>
