<?php
$this->breadcrumbs=array(
	'Cuentas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Cuentas', 'url'=>array('admin')),
	array('label'=>'Nueva Cuenta', 'url'=>array('create')),
	array('label'=>'Modificar Cuenta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Cuenta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
);
?>

<h1>Detalle de la Cuenta Nro: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
