<?php
$this->breadcrumbs=array(
	'Comisiones Operadores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ComisionesOperadores', 'url'=>array('index')),
	array('label'=>'Create ComisionesOperadores', 'url'=>array('create')),
	array('label'=>'Update ComisionesOperadores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ComisionesOperadores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ComisionesOperadores', 'url'=>array('admin')),
);
?>

<h1>View ComisionesOperadores #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'detalleColocacionId',
		'operadorId',
		'porcentaje',
		'monto',
		'estado',
		'userStamp',
		'timeStamp',
	),
)); ?>
