<?php
$this->breadcrumbs=array(
	'Operaciones Cheques'=>array('index'),
	$model->id,
);

?>

<h1>View OperacionesCheques #<?php echo $model->id; ?></h1>

<?php 

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'operadorId',
		'clienteId',
		'montoNetoTotal',
		'fecha',
		'userStamp',
		'timeStamp',
		'sucursalId',
	),
)); ?>
