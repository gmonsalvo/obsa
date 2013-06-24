<?php
$this->breadcrumbs=array(
	'Operadores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Operadores', 'url'=>array('admin')),
	array('label'=>'Nuevo Operador', 'url'=>array('create')),
	array('label'=>'Modificar este Operador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Operadores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta seguro que desea eliminar este operador?')),
);
?>

<h1>Detalle del Operador <?php echo $model->apynom; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'apynom',
		'direccion',
		'celular',
		'fijo',
		'documento',
		'email',
		'comision',
		array(
			'name'=>'usuarioId',
			'value'=>$model->getUser(),
		),
		array(
			'name'=>'sucursalId',
			'value'=>$model->sucursal->nombre,
		),
		'userStamp',
		'timeStamp',
	),
)); ?>
