<?php
$this->breadcrumbs=array(
	'Sucursales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Sucursales', 'url'=>array('admin')),
	array('label'=>'Nueva Sucursal', 'url'=>array('create')),
	array('label'=>'Modificar Sucursal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar esta Sucursal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este item?')),
	
);
?>

<h1>Detalle de la Sucursal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'direccion',
		'email',
		'comisionGeneral',
		'tasaDescuentoGeneral',
		'tasaInversores',
		'tasaPesificacion',
		'diasClearing',
		'userStamp',
		'timeStamp',
	),
)); ?>
