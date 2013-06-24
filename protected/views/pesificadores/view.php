<?php
$this->breadcrumbs=array(
	'Pesificadores'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Pesificadores', 'url'=>array('admin')),
	array('label'=>'Nuevo Pesificador', 'url'=>array('create')),
	array('label'=>'Modificar este Pesificador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar este Pesificador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro de eliminar este pesificador?')),
);
?>

<h1>Detalle del Pesificador <?php echo $model->denominacion; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'denominacion',
		'tasaDescuento',
		'direccion',
		'personaContacto',
		'telefono',
		array(
			'name'=>'sucursalId',
			'value'=>$model->sucursal->nombre,
		),
		'userStamp',
		'timeStamp',
	),
)); ?>
