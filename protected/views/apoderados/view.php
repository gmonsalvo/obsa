<?php
$this->breadcrumbs=array(
	'Cliente'=>array('clientes/view/'.$model->cliente->id),
	$model->id,
);

$this->menu=array(
	array('label'=>'Ver Cliente', 'url'=>array('clientes/view/'.$model->cliente->id)),
);
?>

<h1>Ver Apoderado #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clienteId',
		'documento',
		'apellidoNombre',
		'sucursalId',
	),
)); ?>
