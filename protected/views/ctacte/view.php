<?php
$this->breadcrumbs=array(
	'Ctactes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ctacte', 'url'=>array('index')),
	array('label'=>'Create Ctacte', 'url'=>array('create')),
	array('label'=>'Update Ctacte', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ctacte', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ctacte', 'url'=>array('admin')),
);
?>

<h1>View Ctacte #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tipoMov',
		'productoCtaCteId',
		'conceptoId',
		'descripcion',
		'monto',
		'saldoAcumulado',
		'fecha',
		'origen',
		'identificadorOrigen',
		'estado',
		'userStamp',
		'timeStamp',
		'sucursalId',
	),
)); ?>
