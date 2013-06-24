<?php
$this->breadcrumbs=array(
	'Provinciases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Provincias', 'url'=>array('admin')),
	array('label'=>'Nueva Provincias', 'url'=>array('create')),
	array('label'=>'Modificar Provincia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Provincias', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	
);
?>

<h1>View Provincias #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'sucursalId',
		'userStamp',
		'timeStamp',
	),
)); ?>
