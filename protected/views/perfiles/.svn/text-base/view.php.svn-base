<?php
$this->breadcrumbs=array(
	'Perfiles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Perfiles', 'url'=>array('admin')),
	array('label'=>'Nuevo Perfil', 'url'=>array('create')),
	array('label'=>'Modificar Perfil Actual', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Perfil', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar el perfil?')),
);
?>

<h1>Ver Perfil #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descrpcion',
	),
)); ?>
