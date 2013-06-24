<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Usuarios', 'url'=>array('admin')),
	array('label'=>'Nuevo Usuarios User', 'url'=>array('create')),
	array('label'=>'Modificar Usuario Actual', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Usuario Actual', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'AEsta seguro que desea eliminar el usuario actual?')),
);
?>

<h1>Informacion del usuario #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'sucursalId',
		'perfilId',
	),
)); ?>
