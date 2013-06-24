<?php
$this->breadcrumbs=array(
	'Actividades'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Actividades', 'url'=>array('admin')),
	array('label'=>'Nueva Actividad', 'url'=>array('create')),
	array('label'=>'Modificar Actividad', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Actividad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta Seguro?')),
	
);
?>

<h1>Detalle de la Actividad Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
	),
)); ?>
