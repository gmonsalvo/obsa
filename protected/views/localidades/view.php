<?php
$this->breadcrumbs=array(
	'Localidades'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Nueva Localidad', 'url'=>array('create')),
	array('label'=>'Modificar Localidad', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Localidad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta Seguro?')),
	array('label'=>'Listar Localidades', 'url'=>array('admin')),
);
?>

<h1>Localidad #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'userStamp',
		'timeStamp',
	),
)); ?>
